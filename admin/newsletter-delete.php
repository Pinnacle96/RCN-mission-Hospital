<?php
require_once __DIR__ . '/../config/security.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../includes/logger.php';

require_login(['SuperAdmin', 'Admin']);

header('Content-Type: application/json');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
  log_error('newsletter', 'Delete invalid id', ['id' => $id, 'actor_id' => (function_exists('current_user') ? (current_user()['id'] ?? null) : null)]);
  echo json_encode(['ok' => false, 'message' => 'Invalid subscriber id.']);
  exit;
}

try {
  $pdo = db();
  // Get email first to cleanup confirmations
  $stmt = $pdo->prepare('SELECT email FROM newsletter_subscribers WHERE id = ?');
  $stmt->execute([$id]);
  $row = $stmt->fetch();
  if (!$row) {
    log_error('newsletter', 'Subscriber not found', ['id' => $id, 'actor_id' => (function_exists('current_user') ? (current_user()['id'] ?? null) : null)]);
    echo json_encode(['ok' => false, 'message' => 'Subscriber not found.']);
    exit;
  }
  $email = $row['email'];

  // Delete subscriber
  $pdo->prepare('DELETE FROM newsletter_subscribers WHERE id = ?')->execute([$id]);
  // Delete any pending confirmations
  $pdo->prepare('DELETE FROM newsletter_confirmations WHERE email = ?')->execute([$email]);
  log_info('newsletter', 'Subscriber deleted', ['id' => $id, 'email' => $email, 'actor_id' => (function_exists('current_user') ? (current_user()['id'] ?? null) : null)]);
  echo json_encode(['ok' => true, 'message' => 'Subscriber deleted.']);
} catch (Throwable $e) {
  log_error('newsletter', 'Delete subscriber failed', ['id' => $id, 'error' => $e->getMessage(), 'actor_id' => (function_exists('current_user') ? (current_user()['id'] ?? null) : null)]);
  echo json_encode(['ok' => false, 'message' => $e->getMessage()]);
}