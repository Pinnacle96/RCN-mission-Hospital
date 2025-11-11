<?php
require_once __DIR__ . '/../config/security.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../includes/logger.php';

require_login(['SuperAdmin', 'Admin']);

header('Content-Type: application/json');

$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$body = isset($_POST['body']) ? trim($_POST['body']) : '';
$preview = isset($_POST['preview']) ? (bool)$_POST['preview'] : false;

if ($subject === '' || $body === '') {
  echo json_encode(['ok' => false, 'message' => 'Subject and body are required.']);
  exit;
}

try {
  $pdo = db();
  $stmt = $pdo->query("SELECT id, email, unsubscribe_token FROM newsletter_subscribers WHERE confirmed_at IS NOT NULL AND unsubscribed_at IS NULL");
  $recipients = $stmt->fetchAll();

  if ($preview) {
    echo json_encode(['ok' => true, 'message' => 'Preview generated.', 'count' => count($recipients)]);
    exit;
  }

  // Enqueue one item per recipient for cron-based sending
  $queued = 0;
  $ins = $pdo->prepare('INSERT INTO email_queue (type, recipient, subject, body, meta) VALUES (?,?,?,?,?)');
  foreach ($recipients as $r) {
    $email = $r['email'];
    $meta = json_encode(['unsubscribe_token' => $r['unsubscribe_token'], 'subscriber_id' => $r['id']], JSON_UNESCAPED_SLASHES);
    $ins->execute(['newsletter', $email, $subject, $body, $meta]);
    $queued++;
  }

  log_info('newsletter', 'Bulk newsletter queued', [
    'queued' => $queued,
    'total' => count($recipients),
    'subject' => $subject,
  ]);

  echo json_encode(['ok' => true, 'message' => 'Newsletter queued for delivery.', 'queued' => $queued, 'total' => count($recipients)]);
} catch (Throwable $e) {
  log_error('newsletter', 'Queueing failed', ['error' => $e->getMessage()]);
  echo json_encode(['ok' => false, 'message' => $e->getMessage()]);
}