<?php
require_once __DIR__ . '/../config/security.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../includes/logger.php';

require_login(['SuperAdmin', 'Admin']);

header('Content-Type: application/json');

$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$body = isset($_POST['body']) ? trim($_POST['body']) : '';
$recipient = isset($_POST['recipient']) ? trim($_POST['recipient']) : '';

if ($subject === '' || $body === '' || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
  echo json_encode(['ok' => false, 'message' => 'Subject, body, and a valid recipient email are required.']);
  exit;
}

try {
  $pdo = db();
  $meta = json_encode(['test' => true], JSON_UNESCAPED_SLASHES);
  $ins = $pdo->prepare('INSERT INTO email_queue (type, recipient, subject, body, meta) VALUES (?,?,?,?,?)');
  $ins->execute(['newsletter_test', $recipient, $subject, $body, $meta]);
  log_info('newsletter', 'Test email queued', [
    'recipient' => $recipient,
    'subject' => $subject,
  ]);
  echo json_encode(['ok' => true, 'message' => 'Test email queued.', 'queued' => 1]);
} catch (Throwable $e) {
  log_error('newsletter', 'Test queueing failed', ['error' => $e->getMessage()]);
  echo json_encode(['ok' => false, 'message' => $e->getMessage()]);
}