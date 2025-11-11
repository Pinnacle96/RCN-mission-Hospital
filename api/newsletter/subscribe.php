<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/constants.php';

// Load PHPMailer if available via Composer
$autoload = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Method not allowed']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$source = trim($_POST['source'] ?? '');
if ($source !== '') {
    $source = substr($source, 0, 100);
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

try {
    $pdo = db();
    $ip = $_SERVER['REMOTE_ADDR'] ?? null;

    // Fetch existing subscriber if any
    $stmt = $pdo->prepare('SELECT id, confirmed_at, unsubscribed_at FROM newsletter_subscribers WHERE email = ?');
    $stmt->execute([$email]);
    $existing = $stmt->fetch();

    if ($existing) {
        // Update source/ip; if previously unsubscribed, clear unsubscribed flag
        $sql = 'UPDATE newsletter_subscribers SET source = ?, ip_address = ?, unsubscribed_at = NULL WHERE email = ?';
        $upd = $pdo->prepare($sql);
        $upd->execute([$source ?: null, $ip, $email]);
    } else {
        // Insert new subscriber row
        $ins = $pdo->prepare('INSERT INTO newsletter_subscribers (email, source, ip_address) VALUES (?, ?, ?)');
        $ins->execute([$email, $source ?: null, $ip]);
    }

    // Double opt-in: send confirmation link if enabled or not yet confirmed
    $needsConfirm = NEWSLETTER_DOUBLE_OPT_IN === true;
    $alreadyConfirmed = $existing && !empty($existing['confirmed_at']) && empty($existing['unsubscribed_at']);

    // Lightweight audit log (no user context for public action)
    audit_log(null, 'newsletter_subscribe:' . $email);

    if ($needsConfirm && !$alreadyConfirmed) {
        // Remove existing tokens for this email
        $pdo->prepare('DELETE FROM newsletter_confirmations WHERE email = ?')->execute([$email]);
        // Create new confirmation token
        $token = bin2hex(random_bytes(24));
        $days = (int)NEWSLETTER_CONFIRM_EXPIRES_DAYS;
        $pdo->prepare('INSERT INTO newsletter_confirmations (email, token, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL ? DAY))')
            ->execute([$email, $token, $days]);

        // Build confirmation link
        $confirmUrl = url('api/newsletter/confirm.php?token=' . urlencode($token));

        // Try sending email if PHPMailer is available
        try {
            if (class_exists('PHPMailer\\PHPMailer\\PHPMailer') && !empty(SMTP_HOST) && !empty(SMTP_USER)) {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = SMTP_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = SMTP_USER;
                $mail->Password = SMTP_PASS;
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = SMTP_PORT;
                $mail->setFrom(SMTP_USER, APP_NAME);
                $mail->addAddress($email);
                $mail->Subject = 'Confirm your subscription to ' . APP_NAME;
                $mail->Body = "Thanks for subscribing to " . APP_NAME . "!\n\nPlease confirm your email by clicking the link below:\n" . $confirmUrl . "\n\nIf you did not request this, you can ignore this message.";
                $mail->send();
            } else {
                // If mailer isn't available, just proceed silently
            }
        } catch (Throwable $e) {
            // Suppress email errors to avoid blocking subscriptions
        }

        echo json_encode(['ok' => true, 'message' => 'Please check your email to confirm your subscription.']);
        exit;
    }

    // Already confirmed or double opt-in disabled
    echo json_encode(['ok' => true, 'message' => 'You are subscribed. Thank you!']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Subscription failed. Please try again later.']);
}