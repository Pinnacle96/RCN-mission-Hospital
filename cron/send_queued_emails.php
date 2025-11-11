<?php
// Cron script: send queued emails in batches
// Run every 5 minutes via Windows Task Scheduler or cron

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/logger.php';

// Autoload PHPMailer if available
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
  require_once __DIR__ . '/../vendor/autoload.php';
}

// Basic lock to prevent concurrent runs
$lockFile = __DIR__ . '/.send_queued_emails.lock';
$lock = fopen($lockFile, 'c');
if (!$lock || !flock($lock, LOCK_EX | LOCK_NB)) {
  // Another process is running
  log_info('cron_job', 'Skipped run due to lock');
  exit(0);
}
log_info('cron_job', 'Cron started');

// Global pause switch
if (defined('QUEUE_PAUSE_SENDING') && QUEUE_PAUSE_SENDING) {
  log_info('cron_job', 'Cron paused by settings');
  if ($lock) { flock($lock, LOCK_UN); fclose($lock); }
  @unlink($lockFile);
  exit(0);
}

// Configuration
// Type-specific processing configuration
$TYPE_CONFIG = [
  'newsletter' => ['limit' => 100, 'throttle_us' => 200000],
  'newsletter_test' => ['limit' => 10, 'throttle_us' => 0],
  'contact' => ['limit' => 50, 'throttle_us' => 0],
];
// Per-type max attempts (overrides via Admin Settings -> config.local.php)
$TYPE_MAX_ATTEMPTS = [
  'newsletter' => defined('QUEUE_MAX_ATTEMPTS_NEWSLETTER') ? (int)QUEUE_MAX_ATTEMPTS_NEWSLETTER : 5,
  'newsletter_test' => defined('QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST') ? (int)QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST : 5,
  'contact' => defined('QUEUE_MAX_ATTEMPTS_CONTACT') ? (int)QUEUE_MAX_ATTEMPTS_CONTACT : 5,
];

// Determine base URL for links (unsubscribe, logo)
$baseUrl = getenv('SITE_URL') ?: (defined('SITE_URL') ? SITE_URL : 'http://127.0.0.1:8000');

function makeMailer(): ?PHPMailer {
  if (!class_exists(PHPMailer::class)) return null;
  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->Host = SMTP_HOST;
  $mail->SMTPAuth = defined('SMTP_AUTH') ? (bool)SMTP_AUTH : true;
  $mail->Username = SMTP_USER;
  $mail->Password = SMTP_PASS;
  // Map SMTP_SECURE to PHPMailer values: 'tls', 'ssl', or 'none'
  $secure = defined('SMTP_SECURE') ? strtolower((string)SMTP_SECURE) : 'tls';
  if ($secure === 'ssl' || $secure === 'smtps') {
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  } elseif ($secure === 'tls' || $secure === 'starttls') {
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  } else {
    $mail->SMTPSecure = '';
    // Avoid auto-upgrading to TLS when explicitly configured as none
    $mail->SMTPAutoTLS = false;
  }
  $mail->Port = SMTP_PORT;
  $mail->setFrom(SMTP_USER ?: 'no-reply@example.com', APP_NAME);
  $mail->isHTML(true);
  $mail->CharSet = 'UTF-8';
  return $mail;
}

function renderNewsletterHtml(string $subject, string $contentHtml, array $meta, string $baseUrl, ?string $recipientEmail = null): string {
  $token = $meta['unsubscribe_token'] ?? null;
  $unsubscribeUrl = rtrim($baseUrl, '/');
  if ($token) {
    if ($recipientEmail) {
      $unsubscribeUrl = rtrim($baseUrl, '/') . '/api/newsletter/unsubscribe.php?email=' . urlencode($recipientEmail) . '&token=' . urlencode($token);
    } else {
      // Fallback to token-only link (may show error page if email missing)
      $unsubscribeUrl = rtrim($baseUrl, '/') . '/api/newsletter/unsubscribe.php?token=' . urlencode($token);
    }
  }
  $logoUrl = rtrim($baseUrl, '/') . '/assets/images/logo.png';
  $safeContent = $contentHtml; // assume already sanitized/controlled from admin compose
  return '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width">'
    . '<title>' . htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') . '</title>'
    . '<style>body{margin:0;background:#f4f5f7;font-family:Arial,Helvetica,sans-serif;color:#222} .container{max-width:640px;margin:0 auto;padding:24px} .card{background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);overflow:hidden} .header{padding:20px 24px;border-bottom:1px solid #eee;display:flex;align-items:center} .header img{height:40px;margin-right:12px} .content{padding:24px} .footer{padding:16px 24px;border-top:1px solid #eee;font-size:12px;color:#666} .btn{display:inline-block;background:#E36414;color:#fff;text-decoration:none;padding:10px 16px;border-radius:8px} a{color:#0A1A3B}</style></head><body>'
    . '<div class="container"><div class="card">'
    . '<div class="header"><img src="' . htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8') . '" alt="RCN Logo"><div><div style="font-size:14px;color:#555">' . APP_NAME . '</div><div style="font-weight:bold">' . htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') . '</div></div></div>'
    . '<div class="content">' . $safeContent . '</div>'
    . '<div class="footer">'
    . 'You received this email because you subscribed to updates from ' . APP_NAME . '. '
    . ($token ? ('<br>If you no longer wish to receive these emails, <a href="' . htmlspecialchars($unsubscribeUrl, ENT_QUOTES, 'UTF-8') . '">unsubscribe here</a>.') : '')
    . '</div>'
    . '</div></div></body></html>';
}

function renderContactHtml(string $subject, string $bodyHtml, array $meta, string $baseUrl): string {
  $logoUrl = rtrim($baseUrl, '/') . '/assets/images/logo.png';
  $fromName = htmlspecialchars($meta['from_name'] ?? 'Website Visitor', ENT_QUOTES, 'UTF-8');
  $fromEmail = htmlspecialchars($meta['from_email'] ?? '', ENT_QUOTES, 'UTF-8');
  return '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width">'
    . '<title>' . htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') . '</title>'
    . '<style>body{margin:0;background:#f6f7f9;font-family:Arial,Helvetica,sans-serif;color:#222} .container{max-width:640px;margin:0 auto;padding:24px} .card{background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.06);overflow:hidden} .header{padding:18px 24px;border-bottom:1px solid #eee;display:flex;align-items:center} .header img{height:36px;margin-right:12px} .content{padding:24px} .meta{background:#fafafa;border:1px solid #eee;border-radius:8px;padding:12px;margin-bottom:12px} a{color:#0A1A3B}</style></head><body>'
    . '<div class="container"><div class="card">'
    . '<div class="header"><img src="' . htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8') . '" alt="RCN Logo"><div style="font-weight:bold">' . APP_NAME . ' — Contact Message</div></div>'
    . '<div class="content">'
    . '<div class="meta"><strong>From:</strong> ' . $fromName . ' &lt;' . $fromEmail . '&gt;</div>'
    . $bodyHtml
    . '</div>'
    . '</div></div></body></html>';
}

// Generate a readable plain-text version from HTML content
function htmlToText(string $html): string {
  // Convert common block elements to newlines
  $text = preg_replace('/\s*<\/(p|div|h[1-6])>\s*/i', "\n\n", $html);
  // Convert line breaks
  $text = preg_replace('/<(br|BR)\s*\/>/i', "\n", $text);
  // Convert list items
  $text = preg_replace('/<li[^>]*>/i', "- ", $text);
  $text = preg_replace('/<\/(ul|ol)>/i', "\n", $text);
  // Convert links to 'text (url)'
  $text = preg_replace_callback('/<a\s+[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', function($m) {
    $anchor = trim(html_entity_decode(strip_tags($m[2]), ENT_QUOTES, 'UTF-8'));
    $href = $m[1];
    return $anchor . ' (' . $href . ')';
  }, $text);
  // Strip remaining tags and decode entities
  $text = strip_tags($text);
  $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
  // Normalize whitespace
  $text = preg_replace('/[ \t]+/', ' ', $text);
  $text = preg_replace('/\n{3,}/', "\n\n", $text);
  return trim($text);
}

function backoffMinutes(int $attempts): int {
  // Progressive backoff: 0, 5, 15, 60, 1440 minutes
  if ($attempts <= 0) return 0;
  if ($attempts === 1) return 5;
  if ($attempts === 2) return 15;
  if ($attempts === 3) return 60;
  return 1440; // 24h for 4+ attempts
}

try {
  $pdo = db();
  $mailer = makeMailer();
  if (!$mailer) {
    // If PHPMailer is not available, mark as failed with a clear error
    $stmt = $pdo->query("SELECT * FROM email_queue WHERE status='pending' ORDER BY created_at ASC LIMIT 50");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
      $attempts = (int)$row['attempts'] + 1;
      $typeKey = $row['type'] ?? 'newsletter';
      $maxForType = $TYPE_MAX_ATTEMPTS[$typeKey] ?? 5;
      $status = ($attempts >= $maxForType) ? 'failed' : 'pending';
      $upd = $pdo->prepare('UPDATE email_queue SET attempts = ?, last_attempt_at = NOW(), status = ?, error = ? WHERE id = ?');
      $upd->execute([$attempts, $status, 'PHPMailer not available', $row['id']]);
    }
  log_error('cron_job', 'PHPMailer not available; marked batch items accordingly');
    exit(1);
  }

  // Process per type according to TYPE_CONFIG
  foreach ($TYPE_CONFIG as $type => $cfg) {
    $limit = max(1, (int)($cfg['limit'] ?? 50));
    $throttleUs = (int)($cfg['throttle_us'] ?? 0);
    $sql = "SELECT * FROM email_queue WHERE status = 'pending' AND type = :type ORDER BY created_at ASC LIMIT $limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':type', $type, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  log_info('cron_job', 'Processing type batch', ['type' => $type, 'count' => count($rows), 'limit' => $limit]);

    foreach ($rows as $row) {
      $id = (int)$row['id'];
      $rowType = $row['type'];
      $recipient = $row['recipient'];
      $subject = $row['subject'];
      $body = $row['body'];
      $meta = [];
      if (!empty($row['meta'])) {
        $decoded = json_decode($row['meta'], true);
        if (is_array($decoded)) $meta = $decoded;
      }

      // Backoff check
      $attempts = (int)$row['attempts'];
      $last = $row['last_attempt_at'] ? strtotime($row['last_attempt_at']) : null;
      $delayMin = backoffMinutes($attempts);
      if ($delayMin > 0 && $last) {
        $nextTime = $last + ($delayMin * 60);
        if (time() < $nextTime) {
          // Skip until backoff window passes
      log_info('cron_job', 'Skipping due to backoff', ['id' => $id, 'attempts' => $attempts, 'wait_min' => $delayMin]);
          continue;
        }
      }

      try {
        // Prepare mail content by type
      if ($rowType === 'newsletter') {
        $html = renderNewsletterHtml($subject, $body, $meta, $baseUrl, $recipient);
        $mailer->clearAllRecipients();
        $mailer->clearReplyTos();
        $mailer->addAddress($recipient);
        $mailer->Subject = $subject;
        $mailer->Body = $html;
        $mailer->AltBody = htmlToText($body);
      } elseif ($rowType === 'newsletter_test') {
        $html = renderNewsletterHtml($subject, $body, $meta, $baseUrl, $recipient);
        $mailer->clearAllRecipients();
        $mailer->clearReplyTos();
        $mailer->addAddress($recipient);
        $mailer->Subject = '[TEST] ' . $subject;
        $mailer->Body = $html;
        $mailer->AltBody = htmlToText($body);
      } elseif ($rowType === 'contact') {
        $html = renderContactHtml($subject, $body, $meta, $baseUrl);
        $mailer->clearAllRecipients();
        $mailer->clearReplyTos();
        $sendTo = (defined('CONTACT_RECIPIENT') && CONTACT_RECIPIENT) ? CONTACT_RECIPIENT : (SMTP_USER ?: $recipient);
        // Validate recipient to avoid PHPMailer errors
        if (!$sendTo || !filter_var($sendTo, FILTER_VALIDATE_EMAIL)) {
          // Mark as failed with explicit error
          $attemptsNext = (int)$row['attempts'] + 1;
          $maxForType = $TYPE_MAX_ATTEMPTS[$rowType] ?? 5;
          $statusBad = ($attemptsNext >= $maxForType) ? 'failed' : 'pending';
          $updBad = $pdo->prepare('UPDATE email_queue SET attempts = ?, last_attempt_at = NOW(), status = ?, error = ? WHERE id = ?');
          $updBad->execute([$attemptsNext, $statusBad, 'Invalid contact recipient configuration', $id]);
      log_error('cron_job', 'Invalid contact recipient', ['id' => $id, 'recipient' => $sendTo]);
          continue;
        }
        $mailer->addAddress($sendTo);
        $mailer->Subject = $subject;
        $mailer->Body = $html;
        $mailer->AltBody = htmlToText($body);
        // Set Reply-To to the original sender if available
        if (!empty($meta['from_email'])) {
          $mailer->addReplyTo($meta['from_email'], $meta['from_name'] ?? '');
        }
      } else {
        // Generic fallback
        $mailer->clearAllRecipients();
        $mailer->clearReplyTos();
        $mailer->addAddress($recipient);
        $mailer->Subject = $subject;
        $mailer->Body = $body;
        $mailer->AltBody = htmlToText($body);
      }

      $mailer->send();

      $upd = $pdo->prepare('UPDATE email_queue SET status = "sent", sent_at = NOW(), attempts = attempts + 1, last_attempt_at = NOW(), error = NULL WHERE id = ?');
      $upd->execute([$id]);
      log_info('cron_job', 'Sent email', ['id' => $id, 'type' => $rowType, 'recipient' => $recipient]);
    } catch (Throwable $e) {
      $attemptsNext = (int)$row['attempts'] + 1;
      $maxForType = $TYPE_MAX_ATTEMPTS[$rowType] ?? 5;
      $status = ($attemptsNext >= $maxForType) ? 'failed' : 'pending';
      $err = (method_exists($e, 'getMessage') ? $e->getMessage() : 'send failed');
      $upd = $pdo->prepare('UPDATE email_queue SET attempts = ?, last_attempt_at = NOW(), status = ?, error = ? WHERE id = ?');
      $upd->execute([$attemptsNext, $status, $err, $id]);
      log_error('cron_job', 'Send failed', ['id' => $id, 'type' => $rowType, 'error' => $err, 'attempts' => $attemptsNext]);
    }

      // throttle between sends per type
      if ($throttleUs > 0) {
        usleep($throttleUs);
      }
    }
  }
} catch (Throwable $e) {
  // swallow errors so scheduler doesn't spam logs; could log to file if desired
  log_error('cron_job', 'Fatal error', ['error' => $e->getMessage()]);
}

// Release lock
if ($lock) {
  flock($lock, LOCK_UN);
  fclose($lock);
}
@unlink($lockFile);
log_info('cron_job', 'Cron finished');

// End of script