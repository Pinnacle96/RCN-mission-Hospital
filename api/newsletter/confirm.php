<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/security.php';
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../../includes/logger.php';

$token = $_GET['token'] ?? '';
$token = is_string($token) ? trim($token) : '';

$title = 'Newsletter Confirmation';
$message = '';
$ok = false;

try {
  $pdo = db();
  if ($token === '') {
    throw new Exception('Invalid confirmation token.');
  }

  // Lookup token
  $stmt = $pdo->prepare('SELECT email, expires_at FROM newsletter_confirmations WHERE token = ?');
  $stmt->execute([$token]);
  $row = $stmt->fetch();
  if (!$row) {
    throw new Exception('Confirmation token not found.');
  }
  if (new DateTime($row['expires_at']) < new DateTime()) {
    // Expired token
    // Clean up
    $pdo->prepare('DELETE FROM newsletter_confirmations WHERE token = ?')->execute([$token]);
    throw new Exception('Confirmation token has expired. Please subscribe again.');
  }

  $email = $row['email'];

  // Mark subscriber confirmed and generate unsubscribe token if missing
  $unsubscribeToken = bin2hex(random_bytes(24));
  $upd = $pdo->prepare('UPDATE newsletter_subscribers SET confirmed_at = NOW(), unsubscribed_at = NULL, unsubscribe_token = IFNULL(unsubscribe_token, ?) WHERE email = ?');
  $upd->execute([$unsubscribeToken, $email]);

  // Remove token after successful confirmation
  $pdo->prepare('DELETE FROM newsletter_confirmations WHERE token = ?')->execute([$token]);

  $ok = true;
  log_info('newsletter', 'Subscription confirmed', ['email' => $email]);
  $message = 'Your email has been confirmed. Thank you for subscribing!';
} catch (Throwable $e) {
  log_error('newsletter', 'Subscription confirmation failed', ['token' => $token, 'error' => $e->getMessage()]);
  $message = $e->getMessage();
}

// Render a minimal page using site header/footer so it feels native
$page_title = $title;
include __DIR__ . '/../../includes/header.php';
?>
<section class="max-w-3xl mx-auto px-4 py-16">
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8 text-center">
    <div class="mb-4">
      <?php if ($ok): ?>
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 text-green-600">
          ✓
        </div>
      <?php else: ?>
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-100 text-red-600">
          !
        </div>
      <?php endif; ?>
    </div>
    <h1 class="text-2xl font-bold mb-2"><?php echo esc_html($title); ?></h1>
    <p class="text-gray-700 mb-6"><?php echo esc_html($message); ?></p>
    <a href="<?php echo url(''); ?>" class="inline-block px-4 py-2 rounded-lg text-white" style="background: <?php echo RCN_GRADIENT; ?>;">Go to Homepage</a>
  </div>
</section>
<script>
  // Show toast
  (function(){
    var msg = <?php echo json_encode($message ?? '', JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT); ?>;
    var type = <?php echo json_encode($ok ? 'success' : 'error'); ?>;
    if (window.notify) {
      window.notify(msg, type);
    }
  })();
</script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>