<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../config/csrf.php'; ?>
<?php require_login(['SuperAdmin','Admin','Editor']); ?>
<?php include __DIR__ . '/includes/admin-header.php'; ?>
<?php
$user = current_user();
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = $_POST['csrf_token'] ?? '';
  if (!csrf_validate($token)) {
    $error = 'Invalid request.';
  } else {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if ($new !== $confirm) {
      $error = 'New passwords do not match.';
    } elseif (strlen($new) < 8) {
      $error = 'New password must be at least 8 characters.';
    } else {
      try {
        $pdo = db();
        $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([(int)$user['id']]);
        $row = $stmt->fetch();
        if (!$row || !password_verify_secure($current, $row['password_hash'])) {
          $error = 'Current password is incorrect.';
        } else {
          $hash = password_hash_secure($new);
          $up = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
          $up->execute([$hash, (int)$user['id']]);
          audit_log((int)$user['id'], 'password_changed');
          $message = 'Password updated successfully.';
        }
      } catch (Throwable $e) {
        $error = 'Could not update password.';
      }
    }
  }
}
?>
<section class="max-w-2xl mx-auto px-4 py-8">
  <div class="mb-6">
    <h1 class="text-2xl font-semibold">Change Password</h1>
    <p class="text-sm text-midnight/70">Update your account password securely.</p>
  </div>
  <?php if ($message): ?>
    <div class="p-3 bg-green-100 text-green-800 rounded mb-4"><?php echo esc_html($message); ?></div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="p-3 bg-red-100 text-red-800 rounded mb-4"><?php echo esc_html($error); ?></div>
  <?php endif; ?>
  <form method="post" class="bg-white p-6 rounded shadow space-y-4">
    <?php echo csrf_field(); ?>
    <div>
      <label class="block text-sm mb-1">Current Password</label>
      <input name="current_password" type="password" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm mb-1">New Password</label>
        <input name="new_password" type="password" class="w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="block text-sm mb-1">Confirm New Password</label>
        <input name="confirm_password" type="password" class="w-full border rounded px-3 py-2" required>
      </div>
    </div>
    <button class="px-5 py-2 rounded btn-primary" type="submit">Update Password</button>
  </form>
</section>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>