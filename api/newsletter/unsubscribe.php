<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../config/security.php';
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../../includes/logger.php';

$email = isset($_GET['email']) ? trim($_GET['email']) : '';
$token = isset($_GET['token']) ? trim($_GET['token']) : '';

$title = 'Unsubscribe';
$message = '';
$ok = false;

try {
  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $token === '') {
    throw new Exception('Invalid unsubscribe link.');
  }

  $pdo = db();
  $stmt = $pdo->prepare('SELECT id FROM newsletter_subscribers WHERE email = ? AND unsubscribe_token = ?');
  $stmt->execute([$email, $token]);
  $row = $stmt->fetch();
  if (!$row) {
    throw new Exception('Unsubscribe token not found or already used.');
  }

  // Mark as unsubscribed
  $upd = $pdo->prepare('UPDATE newsletter_subscribers SET unsubscribed_at = NOW() WHERE id = ?');
  $upd->execute([$row['id']]);

  $ok = true;
  $message = 'You have been unsubscribed successfully.';
  log_info('newsletter', 'Unsubscribed', ['email' => $email]);
} catch (Throwable $e) {
  log_error('newsletter', 'Unsubscribe failed', ['email' => $email, 'error' => $e->getMessage()]);
  $message = $e->getMessage();
}

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
  (function(){
    var msg = <?php echo json_encode($message ?? '', JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT); ?>;
    var type = <?php echo json_encode($ok ? 'success' : 'error'); ?>;
    if (window.notify) {
      window.notify(msg, type);
    }
  })();
</script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>