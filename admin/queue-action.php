<?php
require_once __DIR__ . '/../config/security.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../includes/logger.php';

require_login(['SuperAdmin', 'Admin']);

header('Content-Type: application/json');

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'message' => 'Invalid request method']);
    exit;
  }

  $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
  $action = isset($_POST['action']) ? trim($_POST['action']) : '';
  $validActions = ['retry', 'cancel', 'delete', 'resend', 'get_payload', 'bulk_retry_failed', 'bulk_cancel_pending'];
  if (!$action || !in_array($action, $validActions, true)) {
    echo json_encode(['ok' => false, 'message' => 'Invalid parameters']);
    exit;
  }

  $pdo = db();
  if (in_array($action, ['retry','cancel','delete','resend','get_payload'], true)) {
    if ($id <= 0) {
      echo json_encode(['ok' => false, 'message' => 'Missing id']);
      exit;
    }
    $stmt = $pdo->prepare('SELECT * FROM email_queue WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      echo json_encode(['ok' => false, 'message' => 'Queue item not found']);
      exit;
    }
  }

  if ($action === 'retry') {
    // Reset item for immediate retry
    $upd = $pdo->prepare('UPDATE email_queue SET status = "pending", error = NULL, attempts = 0, last_attempt_at = NULL WHERE id = ? AND status = "failed"');
    $upd->execute([$id]);
    if ($upd->rowCount() > 0) {
      log_info('queue', 'Admin retried item', ['id' => $id, 'type' => $row['type']]);
      echo json_encode(['ok' => true, 'message' => 'Item set to retry']);
    } else {
      echo json_encode(['ok' => false, 'message' => 'Only failed items can be retried']);
    }
    exit;
  }

  if ($action === 'cancel') {
    // Mark item as failed with explicit cancel note (skip for already sent)
    if ($row['status'] === 'sent') {
      echo json_encode(['ok' => false, 'message' => 'Cannot cancel a sent item']);
      exit;
    }
    $upd = $pdo->prepare('UPDATE email_queue SET status = "cancelled", error = "Cancelled by admin", last_attempt_at = NOW() WHERE id = ?');
    $upd->execute([$id]);
    log_info('queue', 'Admin cancelled item', ['id' => $id, 'type' => $row['type']]);
    echo json_encode(['ok' => true, 'message' => 'Item cancelled']);
    exit;
  }

  if ($action === 'delete') {
    // Allow deletion of non-sent items (pending/failed/cancelled)
    if ($row['status'] === 'sent') {
      echo json_encode(['ok' => false, 'message' => 'Cannot delete a sent item']);
      exit;
    }
    $del = $pdo->prepare('DELETE FROM email_queue WHERE id = ?');
    $del->execute([$id]);
    if ($del->rowCount() > 0) {
      log_info('queue', 'Admin deleted item', ['id' => $id, 'type' => $row['type'], 'status' => $row['status']]);
      echo json_encode(['ok' => true, 'message' => 'Item deleted']);
    } else {
      echo json_encode(['ok' => false, 'message' => 'Delete failed']);
    }
    exit;
  }

  if ($action === 'resend') {
    // Clone a previously sent item back into pending
    if ($row['status'] !== 'sent') {
      echo json_encode(['ok' => false, 'message' => 'Only sent items can be resent']);
      exit;
    }
    $ins = $pdo->prepare('INSERT INTO email_queue (type, recipient, subject, body, meta, status) VALUES (?,?,?,?,?,"pending")');
    $ins->execute([$row['type'], $row['recipient'], $row['subject'], $row['body'], $row['meta']]);
    $newId = (int)$pdo->lastInsertId();
    if ($newId > 0) {
      log_info('queue', 'Admin resent item (cloned)', ['old_id' => $row['id'], 'new_id' => $newId, 'type' => $row['type']]);
      echo json_encode(['ok' => true, 'message' => 'Resend queued', 'new_id' => $newId]);
    } else {
      echo json_encode(['ok' => false, 'message' => 'Resend failed']);
    }
    exit;
  }

  if ($action === 'get_payload') {
    // Return payload for viewing/debugging
    $metaDecoded = [];
    if (!empty($row['meta'])) {
      $decoded = json_decode($row['meta'], true);
      if (is_array($decoded)) $metaDecoded = $decoded;
    }
    echo json_encode([
      'ok' => true,
      'item' => [
        'id' => (int)$row['id'],
        'type' => $row['type'],
        'recipient' => $row['recipient'],
        'subject' => $row['subject'],
        'status' => $row['status'],
        'attempts' => (int)$row['attempts'],
        'created_at' => $row['created_at'],
        'last_attempt_at' => $row['last_attempt_at'],
        'sent_at' => $row['sent_at'],
        'error' => $row['error'],
        'body' => $row['body'],
        'meta' => $metaDecoded,
        'meta_raw' => $row['meta'],
      ]
    ]);
    exit;
  }

  if ($action === 'bulk_retry_failed') {
    // Confirmation and limits
    $confirm = isset($_POST['confirm']) ? trim($_POST['confirm']) : '';
    if ($confirm !== 'yes') { echo json_encode(['ok' => false, 'message' => 'Confirmation required']); exit; }
    $limit = isset($_POST['limit']) ? max(1, min(1000, (int)$_POST['limit'])) : 200;
    $type = isset($_POST['type']) ? trim($_POST['type']) : '';
    $where = 'status = "failed"';
    $params = [];
    if ($type && in_array($type, ['newsletter','newsletter_test','contact'], true)) { $where .= ' AND type = ?'; $params[] = $type; }
    $sel = $pdo->prepare('SELECT id FROM email_queue WHERE ' . $where . ' ORDER BY id DESC LIMIT ' . (int)$limit);
    $sel->execute($params);
    $ids = $sel->fetchAll(PDO::FETCH_COLUMN);
    if (!$ids) { echo json_encode(['ok' => true, 'message' => 'No failed items to retry']); exit; }
    $upd = $pdo->prepare('UPDATE email_queue SET status = "pending", error = NULL, attempts = 0, last_attempt_at = NULL WHERE id = ?');
    $count = 0;
    foreach ($ids as $iid) { $upd->execute([(int)$iid]); $count += $upd->rowCount(); }
    log_info('queue', 'Admin bulk retried failed items', ['count' => $count, 'type' => $type ?: 'all']);
    echo json_encode(['ok' => true, 'message' => 'Retried ' . $count . ' failed items']);
    exit;
  }

  if ($action === 'bulk_cancel_pending') {
    // Confirmation and limits
    $confirm = isset($_POST['confirm']) ? trim($_POST['confirm']) : '';
    if ($confirm !== 'yes') { echo json_encode(['ok' => false, 'message' => 'Confirmation required']); exit; }
    $limit = isset($_POST['limit']) ? max(1, min(1000, (int)$_POST['limit'])) : 200;
    $type = isset($_POST['type']) ? trim($_POST['type']) : '';
    $where = 'status = "pending"';
    $params = [];
    if ($type && in_array($type, ['newsletter','newsletter_test','contact'], true)) { $where .= ' AND type = ?'; $params[] = $type; }
    $sel = $pdo->prepare('SELECT id FROM email_queue WHERE ' . $where . ' ORDER BY id DESC LIMIT ' . (int)$limit);
    $sel->execute($params);
    $ids = $sel->fetchAll(PDO::FETCH_COLUMN);
    if (!$ids) { echo json_encode(['ok' => true, 'message' => 'No pending items to cancel']); exit; }
    $upd = $pdo->prepare('UPDATE email_queue SET status = "cancelled", error = "Cancelled by admin", last_attempt_at = NOW() WHERE id = ?');
    $count = 0;
    foreach ($ids as $iid) { $upd->execute([(int)$iid]); $count += $upd->rowCount(); }
    log_info('queue', 'Admin bulk cancelled pending items', ['count' => $count, 'type' => $type ?: 'all']);
    echo json_encode(['ok' => true, 'message' => 'Cancelled ' . $count . ' pending items']);
    exit;
  }
} catch (Throwable $e) {
  log_error('queue', 'Queue action error', ['error' => $e->getMessage()]);
  echo json_encode(['ok' => false, 'message' => 'Server error']);
}