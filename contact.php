<?php
$page_title = 'Contact RCN Mission Hospital';
$page_description = 'We\'re here to help — reach out for missions, partnerships, or care.';
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/config/csrf.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>
<?php require_once __DIR__ . '/includes/logger.php'; ?>
<?php
$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  log_info('contact', 'Submit received', [
    'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
    'ua' => $_SERVER['HTTP_USER_AGENT'] ?? null,
  ]);
  $token = $_POST['csrf_token'] ?? '';
  $recaptchaToken = $_POST['recaptcha_token'] ?? null;
  if (!csrf_validate($token)) {
    $error = 'Invalid request.';
    log_error('contact', 'CSRF validation failed');
  } elseif (!verify_recaptcha($recaptchaToken)) {
    $error = 'reCAPTCHA failed.';
    log_error('contact', 'reCAPTCHA validation failed');
  } else {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $message) {
      // Queue contact email for cron-based sending
      try {
        $pdo = db();
        $subjectLine = 'Contact Form: ' . $name;
        $bodyHtml = '<div style="font-family:Arial,sans-serif;line-height:1.6;color:#111">'
          . '<h2 style="margin:0 0 8px">New Contact Message</h2>'
          . '<p style="margin:0 0 12px"><strong>Name:</strong> ' . esc_html($name) . '<br>'
          . '<strong>Email:</strong> ' . esc_html($email) . '</p>'
          . '<div style="padding:12px;border:1px solid #eee;border-radius:8px;background:#fafafa"><pre style="white-space:pre-wrap;margin:0">'
          . esc_html($message)
          . '</pre></div>'
          . '</div>';
        $meta = json_encode(['from_name' => $name, 'from_email' => $email], JSON_UNESCAPED_SLASHES);
        // Choose dedicated recipient if configured; otherwise fall back to SMTP_USER
        $targetRecipient = (defined('CONTACT_RECIPIENT') && CONTACT_RECIPIENT) ? CONTACT_RECIPIENT : (SMTP_USER ?: '');
        if ($targetRecipient === '' || !filter_var($targetRecipient, FILTER_VALIDATE_EMAIL)) {
          throw new Exception('Contact recipient not configured.');
        }
        $stmt = $pdo->prepare('INSERT INTO email_queue (type, recipient, subject, body, meta) VALUES (?,?,?,?,?)');
        $stmt->execute(['contact', $targetRecipient, $subjectLine, $bodyHtml, $meta]);
        $qid = $pdo->lastInsertId();
        log_info('contact', 'Queued contact email', [
          'queue_id' => $qid,
          'recipient' => $targetRecipient,
          'from_email' => $email,
        ]);
        $success = true;
      } catch (Throwable $e) {
        $error = 'Could not submit message at this time.';
        log_error('contact', 'Queue insert failed', [
          'error' => $e->getMessage(),
        ]);
      }
    } else {
      $error = 'Please fill in all fields correctly.';
      log_error('contact', 'Validation failed', [
        'name' => $name,
        'email' => $email,
      ]);
    }
  }
}
?>

<!-- Modern Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
  <!-- Background Pattern Image -->
  <div class="absolute inset-0 opacity-20 pointer-events-none">
    <div class="absolute inset-0"
      style="background-image: url('<?php echo url('assets/images/hero4.jpg'); ?>'); background-size: cover; background-position: center;">
    </div>
  </div>

  <!-- Decorative Grid Overlay -->
  <div class="absolute top-0 left-0 right-0 bottom-0 opacity-10 pointer-events-none">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <pattern id="grid-contact" width="60" height="60" patternUnits="userSpaceOnUse">
          <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1.5" />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#grid-contact)" />
    </svg>
  </div>

  <div class="relative z-10 max-w-7xl mx-auto px-4 py-24">
    <div class="max-w-3xl">
      <div
        class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        We respond within 24 hours
      </div>

      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight" style="font-family: Poppins, sans-serif;">
        Contact <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">RCN
          Mission Hospital</span>
      </h1>

      <p class="text-xl text-white/90 mb-8 leading-relaxed">
        Have questions about medical missions, partnerships, or patient care?
      </p>

      <div class="flex flex-wrap gap-4">
        <a href="mailto:info@rcnmissionhospital.org"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium text-white transition-all duration-300 transform hover:scale-105 shadow-lg"
          style="background: <?php echo RCN_GRADIENT; ?>">
          Email Us
        </a>

        <a href="tel:+2347032078859"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white/30 text-white hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
          Call Us
        </a>
      </div>
    </div>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">
  <!-- Page Content -->

  <div class="grid lg:grid-cols-2 gap-12">
    <!-- Contact Information & Map -->
    <div class="space-y-8">
      <!-- Contact Info Cards -->
      <div class="grid md:grid-cols-2 gap-6">
        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-md transition-all duration-300">
          <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-4">
            <svg class="h-6 w-6 text-orange-600" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                class="icon-stroke" stroke="currentColor" stroke-width="2" />
              <polyline points="22,6 12,13 2,6" class="icon-stroke" stroke="currentColor"
                stroke-width="2" />
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">Email Us</h3>
          <p class="text-gray-600 text-sm">info@rcnmissionhospital.org</p>
          <a href="mailto:info@rcnmissionhospital.org"
            class="inline-block mt-3 text-orange-600 hover:text-orange-700 text-sm font-medium transition-colors duration-200">
            Send Email
          </a>
        </div>

        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-md transition-all duration-300">
          <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
            <svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"
                class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">Call Us</h3>
          <p class="text-gray-600 text-sm">+234 703 207 8859</p>
          <a href="tel:+2347032078859"
            class="inline-block mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium transition-colors duration-200">
            Call Now
          </a>
        </div>
      </div>

      <!-- Address Section -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-start gap-4 mb-6">
          <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
            <svg class="h-5 w-5 text-green-600" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                class="icon-stroke" stroke="currentColor" stroke-width="2" />
              <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" class="icon-stroke" stroke="currentColor"
                stroke-width="2" />
            </svg>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900 text-lg mb-2">Visit Our Office</h3>
            <p class="text-gray-600 leading-relaxed">
              RCN Embassy, George Akume Way<br>
              Beside International Market<br>
              Makurdi, Benue State<br>
              Nigeria
            </p>
          </div>
        </div>

        <!-- Map Container -->
        <div class="bg-gray-100 rounded-xl overflow-hidden h-64 relative">
          <div
            class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
            <div class="text-center text-white p-6">
              <svg class="h-12 w-12 mx-auto mb-3 opacity-80" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                  class="icon-stroke" stroke="currentColor" stroke-width="2" />
                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" class="icon-stroke" stroke="currentColor"
                  stroke-width="2" />
              </svg>
              <p class="font-semibold mb-2">RCN Embassy Location</p>
              <p class="text-sm opacity-90">George Akume Way, Makurdi</p>
              <a href="https://maps.google.com/?q=RCN+Embassy,+George+Akume+Way,+Makurdi,+Benue+State,+Nigeria"
                target="_blank" rel="noopener"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-900 rounded-lg text-sm font-medium mt-3 hover:bg-gray-50 transition-colors duration-200">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" class="icon-stroke"
                    stroke="currentColor" stroke-width="2" />
                  <circle cx="12" cy="10" r="3" class="icon-stroke" stroke="currentColor"
                    stroke-width="2" />
                </svg>
                Open in Maps
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Info -->
      <div class="bg-orange-50 border border-orange-200 rounded-2xl p-6">
        <div class="flex items-start gap-3">
          <svg class="h-6 w-6 text-orange-600 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" class="icon-stroke"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <div>
            <h4 class="font-semibold text-orange-900 mb-2">Response Time</h4>
            <p class="text-orange-800 text-sm leading-relaxed">
              We typically respond to all inquiries within 24 hours. For urgent matters related to medical
              missions or partnerships, please call us directly.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
      <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Send us a Message</h2>
        <p class="text-gray-600">Fill out the form below and we'll get back to you soon.</p>
      </div>

      <?php if ($success): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
          <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
          <div class="text-green-700 font-medium">Your message has been sent successfully. We'll get back to you
            soon!</div>
        </div>
      <?php elseif ($error): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
          <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
          <div class="text-red-700 font-medium"><?php echo esc_html($error); ?></div>
        </div>
      <?php endif; ?>

      <form method="post" action="<?php echo url('contact'); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="recaptcha_token" id="recaptcha_token">

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
          <input name="name"
            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
            placeholder="Enter your full name" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
          <input name="email" type="email"
            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
            placeholder="your.email@example.com" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
          <textarea name="message"
            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
            rows="6" placeholder="Tell us about your inquiry, partnership interest, or how we can help..."
            required></textarea>
        </div>

        <button
          class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-white font-semibold shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105 disabled:opacity-60 disabled:cursor-not-allowed"
          style="background: <?php echo RCN_GRADIENT; ?>;" type="submit" id="submitBtn">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" class="icon-stroke" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Send Message
        </button>

        <p class="text-xs text-gray-500 text-center mt-4">
          By submitting this form, you agree to our privacy policy and terms of service.
        </p>
      </form>
    </div>
  </div>
</section>

<script>
  // Form submission loading state
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');

    if (form && submitBtn) {
      form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-60', 'cursor-not-allowed');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML =
          '<svg class="h-5 w-5 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending...';
      });
    }
  });
</script>

<?php if (!empty(RECAPTCHA_SITE_KEY)): ?>
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>"></script>
  <script>
    grecaptcha.ready(function() {
      grecaptcha.execute('<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>', {
        action: 'contact'
      }).then(function(token) {
        document.getElementById('recaptcha_token').value = token;
      });
    });
  </script>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>