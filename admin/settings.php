<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../config/csrf.php'; ?>
<?php require_once __DIR__ . '/../includes/logger.php'; ?>
<?php require_login(['SuperAdmin']); ?>
<?php include __DIR__ . '/includes/admin-header.php'; ?>
<?php
$message = '';
$error = '';

// Helper: safe string for PHP define
function php_const_str($v) {
  $v = (string)$v;
  return str_replace(['\\', "'"], ['\\\\', "\\'"], $v);
}

// Existing values from constants (may be overridden by config.local.php)
$curr = [
  'PAYPAL_BUSINESS_EMAIL' => defined('PAYPAL_BUSINESS_EMAIL') ? PAYPAL_BUSINESS_EMAIL : '',
  'PAYPAL_RETURN_URL' => defined('PAYPAL_RETURN_URL') ? PAYPAL_RETURN_URL : (defined('BASE_PATH') ? BASE_PATH . 'thank-you' : '/thank-you'),
  'PAYPAL_CANCEL_URL' => defined('PAYPAL_CANCEL_URL') ? PAYPAL_CANCEL_URL : (defined('BASE_PATH') ? BASE_PATH . 'partners' : '/partners'),
  'PAYPAL_HOSTED_BUTTON_ID' => defined('PAYPAL_HOSTED_BUTTON_ID') ? PAYPAL_HOSTED_BUTTON_ID : '',
  'PAYPAL_USE_SANDBOX' => defined('PAYPAL_USE_SANDBOX') ? (bool)PAYPAL_USE_SANDBOX : false,
  'PAYSTACK_PUBLIC_KEY' => defined('PAYSTACK_PUBLIC_KEY') ? PAYSTACK_PUBLIC_KEY : '',
  'PAYSTACK_SECRET_KEY' => defined('PAYSTACK_SECRET_KEY') ? PAYSTACK_SECRET_KEY : '',
  'PAYSTACK_PLAN_CODE_NGN_MONTHLY' => defined('PAYSTACK_PLAN_CODE_NGN_MONTHLY') ? PAYSTACK_PLAN_CODE_NGN_MONTHLY : '',
  'PAYSTACK_CALLBACK_URL' => defined('PAYSTACK_CALLBACK_URL') ? PAYSTACK_CALLBACK_URL : '',
  'SMTP_HOST' => defined('SMTP_HOST') ? SMTP_HOST : '',
  'SMTP_PORT' => defined('SMTP_PORT') ? SMTP_PORT : 587,
  'SMTP_USER' => defined('SMTP_USER') ? SMTP_USER : '',
  'SMTP_PASS' => defined('SMTP_PASS') ? SMTP_PASS : '',
  // Dedicated contact recipient (optional)
  'CONTACT_RECIPIENT' => defined('CONTACT_RECIPIENT') ? CONTACT_RECIPIENT : '',
  'RECAPTCHA_SITE_KEY' => defined('RECAPTCHA_SITE_KEY') ? RECAPTCHA_SITE_KEY : '',
  'RECAPTCHA_SECRET_KEY' => defined('RECAPTCHA_SECRET_KEY') ? RECAPTCHA_SECRET_KEY : '',
  'TINYMCE_API_KEY' => defined('TINYMCE_API_KEY') ? TINYMCE_API_KEY : '',
  // Queue settings
  'QUEUE_PAUSE_SENDING' => defined('QUEUE_PAUSE_SENDING') ? (bool)QUEUE_PAUSE_SENDING : false,
  'QUEUE_MAX_ATTEMPTS_NEWSLETTER' => defined('QUEUE_MAX_ATTEMPTS_NEWSLETTER') ? (int)QUEUE_MAX_ATTEMPTS_NEWSLETTER : 5,
  'QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST' => defined('QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST') ? (int)QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST : 5,
  'QUEUE_MAX_ATTEMPTS_CONTACT' => defined('QUEUE_MAX_ATTEMPTS_CONTACT') ? (int)QUEUE_MAX_ATTEMPTS_CONTACT : 5,
  // Logging rotation settings
  'LOG_MAX_BYTES' => defined('LOG_MAX_BYTES') ? (int)LOG_MAX_BYTES : 2097152,
  'LOG_MAX_FILES' => defined('LOG_MAX_FILES') ? (int)LOG_MAX_FILES : 5,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = $_POST['csrf_token'] ?? '';
  if (!csrf_validate($token)) {
    $error = 'Invalid request.';
  } else {
    // Collect inputs
    $paypal_email = trim($_POST['PAYPAL_BUSINESS_EMAIL'] ?? $curr['PAYPAL_BUSINESS_EMAIL']);
    $paypal_return = trim($_POST['PAYPAL_RETURN_URL'] ?? $curr['PAYPAL_RETURN_URL']);
    $paypal_cancel = trim($_POST['PAYPAL_CANCEL_URL'] ?? $curr['PAYPAL_CANCEL_URL']);
    $paypal_button = trim($_POST['PAYPAL_HOSTED_BUTTON_ID'] ?? $curr['PAYPAL_HOSTED_BUTTON_ID']);
    $paypal_sandbox = isset($_POST['PAYPAL_USE_SANDBOX']) && $_POST['PAYPAL_USE_SANDBOX'] === '1';

    $paystack_pub = trim($_POST['PAYSTACK_PUBLIC_KEY'] ?? $curr['PAYSTACK_PUBLIC_KEY']);
    $paystack_sec = trim($_POST['PAYSTACK_SECRET_KEY'] ?? $curr['PAYSTACK_SECRET_KEY']);
    $paystack_plan = trim($_POST['PAYSTACK_PLAN_CODE_NGN_MONTHLY'] ?? $curr['PAYSTACK_PLAN_CODE_NGN_MONTHLY']);
    $paystack_cb = trim($_POST['PAYSTACK_CALLBACK_URL'] ?? $curr['PAYSTACK_CALLBACK_URL']);

    $smtp_provider = $_POST['SMTP_PROVIDER'] ?? '';
    $smtp_host = trim($_POST['SMTP_HOST'] ?? $curr['SMTP_HOST']);
    $smtp_port = (int)($_POST['SMTP_PORT'] ?? $curr['SMTP_PORT']);
    $smtp_user = trim($_POST['SMTP_USER'] ?? $curr['SMTP_USER']);
    $smtp_pass = $_POST['SMTP_PASS'] ?? '';
    $smtp_pass = ($smtp_pass === '') ? $curr['SMTP_PASS'] : $smtp_pass; // keep current if blank

    // Optional dedicated contact recipient (email or blank to fallback to SMTP_USER)
    $contact_recipient = trim($_POST['CONTACT_RECIPIENT'] ?? $curr['CONTACT_RECIPIENT']);
    if ($contact_recipient !== '' && !filter_var($contact_recipient, FILTER_VALIDATE_EMAIL)) {
      $error = 'CONTACT_RECIPIENT must be a valid email address or left blank.';
    }

    $recaptcha_site = trim($_POST['RECAPTCHA_SITE_KEY'] ?? $curr['RECAPTCHA_SITE_KEY']);
    $recaptcha_secret = trim($_POST['RECAPTCHA_SECRET_KEY'] ?? $curr['RECAPTCHA_SECRET_KEY']);
    $tinymce_key = trim($_POST['TINYMCE_API_KEY'] ?? $curr['TINYMCE_API_KEY']);

    // Queue settings
    $queue_pause = isset($_POST['QUEUE_PAUSE_SENDING']) && $_POST['QUEUE_PAUSE_SENDING'] === '1';
    $max_newsletter = (int)($_POST['QUEUE_MAX_ATTEMPTS_NEWSLETTER'] ?? $curr['QUEUE_MAX_ATTEMPTS_NEWSLETTER']);
    $max_newsletter_test = (int)($_POST['QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST'] ?? $curr['QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST']);
    $max_contact = (int)($_POST['QUEUE_MAX_ATTEMPTS_CONTACT'] ?? $curr['QUEUE_MAX_ATTEMPTS_CONTACT']);
    // Logging rotation settings
    $log_max_bytes = (int)($_POST['LOG_MAX_BYTES'] ?? $curr['LOG_MAX_BYTES']);
    $log_max_files = (int)($_POST['LOG_MAX_FILES'] ?? $curr['LOG_MAX_FILES']);

    // Sanitize logging values
    $log_max_bytes = max(10240, min(104857600, $log_max_bytes)); // 10KB .. 100MB
    $log_max_files = max(1, min(50, $log_max_files));

    // Apply provider defaults if host not specified
    if ($smtp_host === '' && $smtp_provider) {
      if ($smtp_provider === 'gmail') { $smtp_host = 'smtp.gmail.com'; $smtp_port = 587; }
      elseif ($smtp_provider === 'zoho') { $smtp_host = 'smtp.zoho.com'; $smtp_port = 587; }
      elseif ($smtp_provider === 'mailtrap') { $smtp_host = 'smtp.mailtrap.io'; $smtp_port = 2525; }
      elseif ($smtp_provider === 'sendgrid') { $smtp_host = 'smtp.sendgrid.net'; $smtp_port = 587; }
    }

    // Basic validations
    if ($paypal_email && !filter_var($paypal_email, FILTER_VALIDATE_EMAIL)) {
      $error = 'PayPal business email is invalid.';
    } elseif ($paystack_cb && !filter_var($paystack_cb, FILTER_VALIDATE_URL)) {
      $error = 'Paystack callback URL is invalid.';
    } elseif ($paypal_return && !preg_match('/^\/?[A-Za-z0-9_\-\/.]+$/', $paypal_return) && !filter_var($paypal_return, FILTER_VALIDATE_URL)) {
      $error = 'PayPal return URL must be a relative path or full URL.';
    } elseif ($paypal_cancel && !preg_match('/^\/?[A-Za-z0-9_\-\/.]+$/', $paypal_cancel) && !filter_var($paypal_cancel, FILTER_VALIDATE_URL)) {
      $error = 'PayPal cancel URL must be a relative path or full URL.';
    } else {
      // Generate config.local.php
      $lines = [];
      $lines[] = '<?php';
      $lines[] = '// Auto-generated by Admin Settings on ' . date('c');
      $lines[] = "define('PAYPAL_BUSINESS_EMAIL','" . php_const_str($paypal_email) . "');";
      $lines[] = "define('PAYPAL_RETURN_URL','" . php_const_str($paypal_return) . "');";
      $lines[] = "define('PAYPAL_CANCEL_URL','" . php_const_str($paypal_cancel) . "');";
      $lines[] = "define('PAYPAL_HOSTED_BUTTON_ID','" . php_const_str($paypal_button) . "');";
      $lines[] = 'define(\'PAYPAL_USE_SANDBOX\',' . ($paypal_sandbox ? 'true' : 'false') . ');';
      $lines[] = "define('PAYSTACK_PUBLIC_KEY','" . php_const_str($paystack_pub) . "');";
      $lines[] = "define('PAYSTACK_SECRET_KEY','" . php_const_str($paystack_sec) . "');";
      $lines[] = "define('PAYSTACK_PLAN_CODE_NGN_MONTHLY','" . php_const_str($paystack_plan) . "');";
      $lines[] = "define('PAYSTACK_CALLBACK_URL','" . php_const_str($paystack_cb) . "');";
      $lines[] = "define('SMTP_HOST','" . php_const_str($smtp_host) . "');";
      $lines[] = "define('SMTP_PORT'," . (int)$smtp_port . ");";
      $lines[] = "define('SMTP_USER','" . php_const_str($smtp_user) . "');";
      $lines[] = "define('SMTP_PASS','" . php_const_str($smtp_pass) . "');";
      // Contact recipient override (blank allowed to fall back to SMTP_USER)
      $lines[] = "define('CONTACT_RECIPIENT','" . php_const_str($contact_recipient) . "');";
      // Email Queue Settings
      $lines[] = 'define(\'QUEUE_PAUSE_SENDING\',' . ($queue_pause ? 'true' : 'false') . ');';
      $lines[] = "define('QUEUE_MAX_ATTEMPTS_NEWSLETTER'," . max(1, $max_newsletter) . ");";
      $lines[] = "define('QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST'," . max(1, $max_newsletter_test) . ");";
      $lines[] = "define('QUEUE_MAX_ATTEMPTS_CONTACT'," . max(1, $max_contact) . ");";
      // Logging rotation settings
      $lines[] = "define('LOG_MAX_BYTES'," . (int)$log_max_bytes . ");";
      $lines[] = "define('LOG_MAX_FILES'," . (int)$log_max_files . ");";
      // Optional integrations are developer-managed; not saved via admin UI
      $content = implode("\n", $lines) . "\n";

      try {
        $target = __DIR__ . '/../includes/config.local.php';
        if (file_put_contents($target, $content) === false) {
          $error = 'Failed to write configuration file.';
        } else {
          audit_log((current_user()['id'] ?? null), 'settings_updated');
          log_info('admin_settings', 'Settings updated', [
            'paypal_sandbox' => (bool)$paypal_sandbox,
            'paystack_public_key_set' => (bool)$paystack_pub,
            'contact_recipient_set' => (bool)$contact_recipient,
            'queue_pause' => (bool)$queue_pause,
            'log_max_bytes' => (int)$log_max_bytes,
            'log_max_files' => (int)$log_max_files,
          ]);
          $message = 'Settings saved successfully.';
          // Update in-memory values for display
          $curr['PAYPAL_BUSINESS_EMAIL'] = $paypal_email;
          $curr['PAYPAL_RETURN_URL'] = $paypal_return;
          $curr['PAYPAL_CANCEL_URL'] = $paypal_cancel;
          $curr['PAYPAL_HOSTED_BUTTON_ID'] = $paypal_button;
          $curr['PAYPAL_USE_SANDBOX'] = $paypal_sandbox;
          $curr['PAYSTACK_PUBLIC_KEY'] = $paystack_pub;
          $curr['PAYSTACK_SECRET_KEY'] = $paystack_sec;
          $curr['PAYSTACK_PLAN_CODE_NGN_MONTHLY'] = $paystack_plan;
          $curr['PAYSTACK_CALLBACK_URL'] = $paystack_cb;
          $curr['SMTP_HOST'] = $smtp_host;
          $curr['SMTP_PORT'] = $smtp_port;
          $curr['SMTP_USER'] = $smtp_user;
          $curr['SMTP_PASS'] = $smtp_pass;
          $curr['CONTACT_RECIPIENT'] = $contact_recipient;
          $curr['QUEUE_PAUSE_SENDING'] = $queue_pause;
          $curr['QUEUE_MAX_ATTEMPTS_NEWSLETTER'] = max(1, $max_newsletter);
          $curr['QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST'] = max(1, $max_newsletter_test);
          $curr['QUEUE_MAX_ATTEMPTS_CONTACT'] = max(1, $max_contact);
          $curr['LOG_MAX_BYTES'] = (int)$log_max_bytes;
          $curr['LOG_MAX_FILES'] = (int)$log_max_files;
          // Keep optional integrations unchanged (developer-managed)

          // Persist settings to DB (new structured settings table)
          try {
            $pdo = db();
            if ($pdo) {
              $stmt = $pdo->prepare("INSERT INTO settings (name, value, is_secret, updated_by) VALUES (:name, :value, :is_secret, :updated_by) ON DUPLICATE KEY UPDATE value = VALUES(value), is_secret = VALUES(is_secret), updated_by = VALUES(updated_by)");
              $updated_by = current_user()['id'] ?? null;
              $entries = [
                ['PAYPAL_BUSINESS_EMAIL', $paypal_email, 0],
                ['PAYPAL_RETURN_URL', $paypal_return, 0],
                ['PAYPAL_CANCEL_URL', $paypal_cancel, 0],
                ['PAYPAL_HOSTED_BUTTON_ID', $paypal_button, 0],
                ['PAYPAL_USE_SANDBOX', $paypal_sandbox ? 'true' : 'false', 0],
                ['PAYSTACK_PUBLIC_KEY', $paystack_pub, 0],
                ['PAYSTACK_SECRET_KEY', $paystack_sec, 1],
                ['PAYSTACK_PLAN_CODE_NGN_MONTHLY', $paystack_plan, 0],
                ['PAYSTACK_CALLBACK_URL', $paystack_cb, 0],
                ['SMTP_HOST', $smtp_host, 0],
                ['SMTP_PORT', (string)$smtp_port, 0],
                ['SMTP_USER', $smtp_user, 0],
                ['SMTP_PASS', $smtp_pass, 1],
                ['CONTACT_RECIPIENT', $contact_recipient, 0],
                ['QUEUE_PAUSE_SENDING', $queue_pause ? 'true' : 'false', 0],
                ['QUEUE_MAX_ATTEMPTS_NEWSLETTER', (string)max(1, $max_newsletter), 0],
                ['QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST', (string)max(1, $max_newsletter_test), 0],
                ['QUEUE_MAX_ATTEMPTS_CONTACT', (string)max(1, $max_contact), 0],
                ['LOG_MAX_BYTES', (string)(int)$log_max_bytes, 0],
                ['LOG_MAX_FILES', (string)(int)$log_max_files, 0],
              ];
              foreach ($entries as $e) {
                $stmt->execute([
                  ':name' => $e[0],
                  ':value' => $e[1],
                  ':is_secret' => $e[2],
                  ':updated_by' => $updated_by,
                ]);
              }
            }
          } catch (Throwable $dbErr) {
            // Silently ignore DB errors here; file-based overrides remain intact
          }
        }
      } catch (Throwable $e) {
        $error = 'Error saving settings.';
      }
    }
  }
}
?>

<main class="flex-1">
  <div class="px-6 py-6">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Site Settings</h1>
        <p class="text-gray-600">Configure payments and email without editing code</p>
      </div>
    </div>

    <?php if ($message): ?>
      <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700"><?php echo esc_html($message); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700"><?php echo esc_html($error); ?></div>
    <?php endif; ?>

    <form method="post" class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-8">
      <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

      <!-- PayPal Settings -->
      <section>
        <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-3">PayPal <button type="button" id="paypalHelpToggle" class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs">Show help</button></h2>
        <div id="paypalHelp" class="rounded-xl border border-blue-200 bg-blue-50 text-blue-800 px-4 py-3 mb-3 hidden">
          <p class="font-medium">How to get PayPal credentials:</p>
          <p>Business Email: your PayPal merchant email.</p>
          <p>Hosted Button ID: create a hosted button in PayPal and copy its ID.</p>
          <p>Return/Cancel URLs: use full URLs, e.g., <code>https://yourdomain.com/partners.php</code>.</p>
          <p>IPN: enable IPN with notify URL pointing to <code>api/paypal/ipn.php</code>.</p>
          <p>Sandbox: enable for testing; use sandbox email and button.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Business Email</label>
            <input name="PAYPAL_BUSINESS_EMAIL" type="email" value="<?php echo esc_attr($curr['PAYPAL_BUSINESS_EMAIL']); ?>" placeholder="merchant@yourdomain.com" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div class="flex items-center gap-3">
            <input id="ppSandbox" name="PAYPAL_USE_SANDBOX" type="checkbox" value="1" <?php echo $curr['PAYPAL_USE_SANDBOX'] ? 'checked' : ''; ?>>
            <label for="ppSandbox" class="text-sm font-medium text-gray-700">Use Sandbox (testing)</label>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Return URL</label>
            <input name="PAYPAL_RETURN_URL" type="text" value="<?php echo esc_attr($curr['PAYPAL_RETURN_URL']); ?>" placeholder="/thank-you or full URL" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cancel URL</label>
            <input name="PAYPAL_CANCEL_URL" type="text" value="<?php echo esc_attr($curr['PAYPAL_CANCEL_URL']); ?>" placeholder="/partners or full URL" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Hosted Button ID (one-time donations)</label>
            <input name="PAYPAL_HOSTED_BUTTON_ID" type="text" value="<?php echo esc_attr($curr['PAYPAL_HOSTED_BUTTON_ID']); ?>" placeholder="e.g. HJ7ABCDE12345" class="w-full px-4 py-3 rounded-xl border">
          </div>
        </div>
      </section>

      <!-- Paystack Settings -->
      <section>
        <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-3">Paystack <button type="button" id="paystackHelpToggle" class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs">Show help</button></h2>
        <div id="paystackHelp" class="rounded-xl border border-blue-200 bg-blue-50 text-blue-800 px-4 py-3 mb-3 hidden">
          <p class="font-medium">How to get Paystack credentials:</p>
          <p>Public/Secret Keys: copy from Dashboard → Settings → API Keys.</p>
          <p>Plan Code: create a Plan for recurring, then copy the code.</p>
          <p>Callback URL: use <code>https://yourdomain.com/api/paystack/init_once.php</code> or your handler; ensure it’s reachable.</p>
          <p>Webhooks: configure if you consume server-side events.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Public Key</label>
            <input name="PAYSTACK_PUBLIC_KEY" type="text" value="<?php echo esc_attr($curr['PAYSTACK_PUBLIC_KEY']); ?>" placeholder="pk_live_xxx or pk_test_xxx" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Secret Key</label>
            <input name="PAYSTACK_SECRET_KEY" type="text" value="<?php echo esc_attr($curr['PAYSTACK_SECRET_KEY']); ?>" placeholder="sk_live_xxx or sk_test_xxx" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Plan Code (optional)</label>
            <input name="PAYSTACK_PLAN_CODE_NGN_MONTHLY" type="text" value="<?php echo esc_attr($curr['PAYSTACK_PLAN_CODE_NGN_MONTHLY']); ?>" placeholder="PLN_abcdefghi12345" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Callback URL</label>
            <input name="PAYSTACK_CALLBACK_URL" type="url" value="<?php echo esc_attr($curr['PAYSTACK_CALLBACK_URL']); ?>" placeholder="https://yourdomain.com/api/paystack/init_once.php" class="w-full px-4 py-3 rounded-xl border">
          </div>
        </div>
      </section>

      <!-- Email / SMTP Settings -->
      <section>
        <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-3">Email (SMTP) <button type="button" id="smtpHelpToggle" class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs">Show help</button></h2>
        <div id="smtpHelp" class="rounded-xl border border-blue-200 bg-blue-50 text-blue-800 px-4 py-3 mb-3 hidden">
          <p class="font-medium">How to get SMTP credentials:</p>
          <p>Gmail: enable 2FA, create an App Password; host <code>smtp.gmail.com</code>, port <code>587</code> (TLS) or <code>465</code> (SSL), user is your Gmail address, password is the App Password.</p>
          <p>Zoho: create an App Password in Security; host <code>smtp.zoho.com</code>, port <code>587</code>.</p>
          <p>Mailtrap: copy credentials from your inbox; host like <code>smtp.mailtrap.io</code>, port typically <code>2525</code>.</p>
          <p>SendGrid: create an API Key; host <code>smtp.sendgrid.net</code>, port <code>587</code>; user must be <code>apikey</code>, password is your API Key.</p>
          <p class="text-xs">Tip: Use the provider’s recommended TLS port (usually 587).</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Provider</label>
            <select name="SMTP_PROVIDER" id="smtpProvider" class="w-full px-4 py-3 rounded-xl border">
              <option value="">Custom</option>
              <option value="gmail">Gmail</option>
              <option value="zoho">Zoho</option>
              <option value="mailtrap">Mailtrap</option>
              <option value="sendgrid">SendGrid</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Host</label>
            <input name="SMTP_HOST" id="smtpHost" type="text" value="<?php echo esc_attr($curr['SMTP_HOST']); ?>" placeholder="smtp.gmail.com | smtp.zoho.com | smtp.sendgrid.net | smtp.mailtrap.io" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Port</label>
            <input name="SMTP_PORT" id="smtpPort" type="number" value="<?php echo (int)$curr['SMTP_PORT']; ?>" placeholder="587 (TLS) or 465 (SSL)" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Username</label>
            <input name="SMTP_USER" id="smtpUser" type="text" value="<?php echo esc_attr($curr['SMTP_USER']); ?>" placeholder="your@email.com | apikey (SendGrid)" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Password</label>
            <input name="SMTP_PASS" id="smtpPass" type="password" value="" placeholder="<?php echo $curr['SMTP_PASS'] ? '•••••••• (unchanged) | ' : ''; ?>App Password / API Key" class="w-full px-4 py-3 rounded-xl border">
            <p class="text-xs text-gray-500 mt-2">Leave blank to keep existing password.</p>
          </div>
        </div>
      </section>

      <!-- Optional APIs -->
      <section>
        <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-3">Optional Integrations <button type="button" id="optHelpToggle" class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs">Show help</button></h2>
        <div class="rounded-xl border border-amber-200 bg-amber-50 text-amber-800 px-4 py-3 mb-3">
          <p class="font-medium">Read-only: managed by developer</p>
          <p class="text-sm">These credentials are controlled in the code base. Admins should not edit them here. Contact your developer to update.</p>
        </div>
        <div id="optHelp" class="rounded-xl border border-blue-200 bg-blue-50 text-blue-800 px-4 py-3 mb-3 hidden">
          <p class="font-medium">What are these?</p>
          <p>reCAPTCHA: Site and Secret keys protect forms from spam.</p>
          <p>TinyMCE: API key enables rich text editing features.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">reCAPTCHA Site Key</label>
            <input name="RECAPTCHA_SITE_KEY" type="text" value="<?php echo esc_attr($curr['RECAPTCHA_SITE_KEY']); ?>" placeholder="Managed by developer" class="w-full px-4 py-3 rounded-xl border bg-gray-50 text-gray-600" readonly disabled title="Read-only">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">reCAPTCHA Secret Key</label>
            <input name="RECAPTCHA_SECRET_KEY" type="text" value="<?php echo esc_attr($curr['RECAPTCHA_SECRET_KEY']); ?>" placeholder="Managed by developer" class="w-full px-4 py-3 rounded-xl border bg-gray-50 text-gray-600" readonly disabled title="Read-only">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">TinyMCE API Key</label>
            <input name="TINYMCE_API_KEY" type="text" value="<?php echo esc_attr($curr['TINYMCE_API_KEY']); ?>" placeholder="Managed by developer" class="w-full px-4 py-3 rounded-xl border bg-gray-50 text-gray-600" readonly disabled title="Read-only">
          </div>
        </div>
      </section>

      <!-- Email Queue Settings -->
      <section>
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Email Queue</h2>
        <div class="grid md:grid-cols-2 gap-4">
          <div class="flex items-center gap-3">
            <input id="queuePause" name="QUEUE_PAUSE_SENDING" type="checkbox" value="1" <?php echo $curr['QUEUE_PAUSE_SENDING'] ? 'checked' : ''; ?>>
            <label for="queuePause" class="text-sm font-medium text-gray-700">Pause sending (global)</label>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Max attempts — Newsletter</label>
            <input name="QUEUE_MAX_ATTEMPTS_NEWSLETTER" type="number" min="1" value="<?php echo (int)$curr['QUEUE_MAX_ATTEMPTS_NEWSLETTER']; ?>" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Max attempts — Test Emails</label>
            <input name="QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST" type="number" min="1" value="<?php echo (int)$curr['QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST']; ?>" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Max attempts — Contact</label>
            <input name="QUEUE_MAX_ATTEMPTS_CONTACT" type="number" min="1" value="<?php echo (int)$curr['QUEUE_MAX_ATTEMPTS_CONTACT']; ?>" class="w-full px-4 py-3 rounded-xl border">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Contact recipient (optional)</label>
            <input name="CONTACT_RECIPIENT" type="email" value="<?php echo esc_attr($curr['CONTACT_RECIPIENT']); ?>" placeholder="Leave blank to use SMTP_USER" class="w-full px-4 py-3 rounded-xl border">
            <p class="text-xs text-gray-500 mt-2">If left blank, contact emails are sent to <code>SMTP_USER</code>. If set, contact emails will be sent to this address.</p>
          </div>
        </div>
      </section>

      <!-- Logging Settings -->
      <section>
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Logging</h2>
        <div class="rounded-xl border border-blue-200 bg-blue-50 text-blue-800 px-4 py-3 mb-3">
          <p class="text-sm">Rotate logs automatically when they reach the max size. Defaults are conservative; increase if your logs are chatty.</p>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Log max size (bytes)</label>
            <input name="LOG_MAX_BYTES" type="number" min="10240" max="104857600" value="<?php echo (int)$curr['LOG_MAX_BYTES']; ?>" class="w-full px-4 py-3 rounded-xl border">
            <p class="text-xs text-gray-500 mt-2">Example: 2097152 for ~2 MB (default)</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Log files to keep</label>
            <input name="LOG_MAX_FILES" type="number" min="1" max="50" value="<?php echo (int)$curr['LOG_MAX_FILES']; ?>" class="w-full px-4 py-3 rounded-xl border">
            <p class="text-xs text-gray-500 mt-2">Older files beyond this count will be deleted on rotation.</p>
          </div>
        </div>
      </section>

      <div class="flex justify-end">
        <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700">Save Settings</button>
      </div>
    </form>
  </div>
</main>

<script>
// Help toggles
document.getElementById('paypalHelpToggle')?.addEventListener('click', () => {
  document.getElementById('paypalHelp')?.classList.toggle('hidden');
});
document.getElementById('paystackHelpToggle')?.addEventListener('click', () => {
  document.getElementById('paystackHelp')?.classList.toggle('hidden');
});
document.getElementById('smtpHelpToggle')?.addEventListener('click', () => {
  document.getElementById('smtpHelp')?.classList.toggle('hidden');
});
document.getElementById('optHelpToggle')?.addEventListener('click', () => {
  document.getElementById('optHelp')?.classList.toggle('hidden');
});

// SMTP provider reactive defaults
const providerDefaults = {
  gmail: { host: 'smtp.gmail.com', port: 587, userPlaceholder: 'your@gmail.com', passPlaceholder: 'Gmail App Password' },
  zoho: { host: 'smtp.zoho.com', port: 587, userPlaceholder: 'your@zoho.com', passPlaceholder: 'Zoho App Password' },
  mailtrap: { host: 'smtp.mailtrap.io', port: 2525, userPlaceholder: 'Mailtrap Username', passPlaceholder: 'Mailtrap Password' },
  sendgrid: { host: 'smtp.sendgrid.net', port: 587, userPlaceholder: 'apikey', passPlaceholder: 'SendGrid API Key' }
};

const smtpProvider = document.getElementById('smtpProvider');
const smtpHost = document.getElementById('smtpHost');
const smtpPort = document.getElementById('smtpPort');
const smtpUser = document.getElementById('smtpUser');
const smtpPass = document.getElementById('smtpPass');

function applyProviderDefaults(){
  const val = smtpProvider?.value || '';
  const d = providerDefaults[val];
  if(!d) return;
  if(!smtpHost.value || Object.values(providerDefaults).some(x => x.host === smtpHost.value)){
    smtpHost.value = d.host;
  }
  if(!smtpPort.value || Object.values(providerDefaults).some(x => String(x.port) === String(smtpPort.value))){
    smtpPort.value = d.port;
  }
  if(smtpUser) smtpUser.placeholder = d.userPlaceholder;
  if(smtpPass) smtpPass.placeholder = (smtpPass.placeholder?.includes('unchanged') ? smtpPass.placeholder + ' | ' : '') + d.passPlaceholder;
}

smtpProvider?.addEventListener('change', applyProviderDefaults);
// Apply once on load
applyProviderDefaults();
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>