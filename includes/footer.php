<?php require_once __DIR__ . '/../includes/constants.php'; ?>
</main>

<footer class="bg-gray-900 text-white">
  <!-- Main Footer -->
  <div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid md:grid-cols-4 gap-8">
      <!-- Brand Column -->
      <div class="md:col-span-1">
        <div class="flex items-center gap-3 mb-4">
          <img src="<?php echo url('assets/images/logo.png'); ?>" alt="RCN Mission Hospital Logo"
            class="h-12 w-auto rounded-lg">
          <div>
            <h3 class="font-bold text-xl" style="font-family: Poppins, sans-serif;">
              <?php echo esc_html(APP_NAME); ?></h3>
            <p class="text-sm text-gray-400">Medical Missions & Healthcare</p>
          </div>
        </div>
        <p class="text-gray-300 text-sm leading-relaxed mb-4">
          Bringing life-saving medical care and the hope of the Gospel to underserved communities worldwide.
        </p>
        <div class="flex items-center gap-3">
          <a href="https://facebook.com"
            class="p-2 bg-gray-800 rounded-lg hover:bg-gray-700 transition-colors duration-200"
            aria-label="Facebook">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
            </svg>
          </a>
          <a href="https://twitter.com"
            class="p-2 bg-gray-800 rounded-lg hover:bg-gray-700 transition-colors duration-200"
            aria-label="Twitter">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
            </svg>
          </a>
          <a href="https://instagram.com"
            class="p-2 bg-gray-800 rounded-lg hover:bg-gray-700 transition-colors duration-200"
            aria-label="Instagram">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.014 5.367 18.647.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.611-3.188-1.551-.74-.94-1.051-2.13-.803-3.38.248-1.25 1.061-2.289 2.191-2.882 1.13-.593 2.495-.67 3.693-.215 1.198.456 2.121 1.444 2.526 2.645.405 1.2.245 2.529-.424 3.56-.669 1.032-1.816 1.67-3.043 1.67-.093.001-.186-.002-.278-.009zm9.645-5.424c-.601 1.11-1.656 1.906-2.896 2.193-1.24.287-2.526.041-3.579-.685-1.052-.726-1.754-1.87-1.945-3.121-.191-1.251.144-2.515.94-3.499.796-.984 1.968-1.59 3.259-1.666 1.291-.076 2.542.373 3.461 1.239.919.866 1.417 2.058 1.378 3.3-.039 1.242-.609 2.399-1.548 3.199-.313.266-.67.48-1.054.634l-.016.006zm1.465 4.245a1.28 1.28 0 01-1.28 1.28H7.611a1.28 1.28 0 01-1.28-1.28V7.611a1.28 1.28 0 011.28-1.28h8.668a1.28 1.28 0 011.28 1.28v8.668z" />
            </svg>
          </a>
        </div>
      </div>

      <!-- Quick Links -->
      <div>
        <h4 class="font-semibold text-lg mb-4 text-white" style="font-family: Poppins, sans-serif;">Quick Links
        </h4>
        <ul class="space-y-3">
          <li><a href="<?php echo url('about'); ?>"
              class="text-gray-300 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
              <svg class="h-4 w-4 text-gray-500 group-hover:text-orange-500 transition-colors duration-200"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              About Us
            </a></li>
          <li><a href="<?php echo url('trips/upcoming'); ?>"
              class="text-gray-300 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
              <svg class="h-4 w-4 text-gray-500 group-hover:text-orange-500 transition-colors duration-200"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Mission Trips
            </a></li>
          <li><a href="<?php echo url('get-involved'); ?>"
              class="text-gray-300 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
              <svg class="h-4 w-4 text-gray-500 group-hover:text-orange-500 transition-colors duration-200"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Get Involved
            </a></li>
          <li><a href="<?php echo url('blog'); ?>"
              class="text-gray-300 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
              <svg class="h-4 w-4 text-gray-500 group-hover:text-orange-500 transition-colors duration-200"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Blog & Stories
            </a></li>
        </ul>
      </div>

      <!-- Programs -->
      <div>
        <h4 class="font-semibold text-lg mb-4 text-white" style="font-family: Poppins, sans-serif;">Programs
        </h4>
        <ul class="space-y-3">
          <li><a href="<?php echo url('doc-care'); ?>"
              class="text-gray-300 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
              <svg class="h-4 w-4 text-gray-500 group-hover:text-orange-500 transition-colors duration-200"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Doc Care
            </a></li>
          <li><a href="<?php echo url('dinna-care'); ?>"
              class="text-gray-300 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
              <svg class="h-4 w-4 text-gray-500 group-hover:text-orange-500 transition-colors duration-200"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Dinna Care
            </a></li>
          <li><a href="<?php echo url('arome-care'); ?>"
              class="text-gray-300 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
              <svg class="h-4 w-4 text-gray-500 group-hover:text-orange-500 transition-colors duration-200"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Arome Care
            </a></li>
          <li><a href="<?php echo url('future-programs'); ?>"
              class="text-gray-300 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
              <svg class="h-4 w-4 text-gray-500 group-hover:text-orange-500 transition-colors duration-200"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Future Programs
            </a></li>
        </ul>
      </div>

      <!-- Contact & Support -->
      <div>
        <h4 class="font-semibold text-lg mb-4 text-white" style="font-family: Poppins, sans-serif;">Contact</h4>
        <div class="space-y-3 text-sm text-gray-300">
          <div class="flex items-start gap-3">
            <svg class="h-5 w-5 text-orange-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                class="icon-stroke" stroke="currentColor" stroke-width="2" />
              <polyline points="22,6 12,13 2,6" class="icon-stroke" stroke="currentColor"
                stroke-width="2" />
            </svg>
            <div>
              <p class="font-medium text-white">Email</p>
              <a href="mailto:info@rcnmissionhospital.org"
                class="hover:text-white transition-colors duration-200">info@rcnmissionhospital.org</a>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <svg class="h-5 w-5 text-orange-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"
                class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            <div>
              <p class="font-medium text-white">Phone</p>
              <a href="tel:+1234567890" class="hover:text-white transition-colors duration-200">+1 (234)
                567-890</a>
            </div>
          </div>
        </div>

        <div class="mt-6">
          <a href="<?php echo url('contact'); ?>"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-500 text-white font-medium hover:bg-orange-600 transition-colors duration-200 text-sm">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"
                class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            Contact Us
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-400">
        <div class="flex items-center gap-4">
          <span>&copy; <?php echo date('Y'); ?> <?php echo esc_html(APP_NAME); ?>. All rights reserved.</span>
          <div class="hidden md:flex items-center gap-4">
            <a href="<?php echo url('privacy-policy'); ?>"
              class="hover:text-white transition-colors duration-200">Privacy Policy</a>
            <a href="<?php echo url('terms'); ?>"
              class="hover:text-white transition-colors duration-200">Terms of Service</a>
            <a href="<?php echo url('admin/login.php'); ?>"
              class="hover:text-white transition-colors duration-200">Admin Login</a>
          </div>
        </div>

        <!-- Pinnacle Tech Hub Credit -->
        <div class="flex items-center gap-2">
          <span class="text-gray-500">Designed & Developed by</span>
          <a href="https://wa.me/+2347032078859" target="_blank" rel="noopener"
            class="flex items-center gap-2 px-3 py-1 bg-gray-800 rounded-lg hover:bg-gray-700 transition-colors duration-200 group">
            <svg class="h-4 w-4 text-green-500" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893-.001-3.189-1.262-6.209-3.553-8.485" />
            </svg>
            <span
              class="text-white font-medium group-hover:text-green-400 transition-colors duration-200">Pinnacle
              Tech Hub</span>
          </a>
        </div>
      </div>

      <!-- Mobile Links -->
      <div class="flex items-center justify-center gap-4 mt-4 md:hidden text-xs">
        <a href="<?php echo url('privacy-policy'); ?>"
          class="hover:text-white transition-colors duration-200">Privacy</a>
        <a href="<?php echo url('terms'); ?>" class="hover:text-white transition-colors duration-200">Terms</a>
        <a href="<?php echo url('admin/login.php'); ?>"
          class="hover:text-white transition-colors duration-200">Admin</a>
      </div>
    </div>
  </div>
</footer>

<?php require_once __DIR__ . '/../config/csrf.php'; ?>

<!-- Enhanced Engagement Panel (renamed to avoid ad-blockers) -->
<div id="engagePanel" role="dialog" aria-modal="true" aria-labelledby="promoTitle"
  class="fixed bottom-6 right-6 z-40 max-w-sm w-80 bg-white border border-gray-200 rounded-2xl shadow-2xl p-6 transition-all duration-300 transform translate-y-6 opacity-0 pointer-events-auto hidden">
  <div class="flex items-start gap-4">
    <img src="<?php echo url('assets/images/hero1.jpg'); ?>" alt="Outreach Mission"
      class="w-16 h-16 object-cover rounded-xl shadow-sm">
    <div class="flex-1">
      <h3 id="promoTitle" class="font-semibold text-gray-900 text-lg mb-1">Get Outreach Resources</h3>
      <p class="text-sm text-gray-600 mb-4">Download our latest mission kit or send us a quick message.</p>
      <div class="flex items-center gap-2 mb-4">
        <a href="<?php echo url('resources'); ?>"
          class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-white text-sm font-medium shadow-sm hover:shadow-md transition-all duration-200"
          style="background: <?php echo RCN_GRADIENT; ?>;">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" class="icon-stroke"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Download
        </a>
        <button type="button" data-engage-close
          class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm transition-colors duration-200">Later</button>
      </div>
      <form method="post" action="<?php echo url('contact'); ?>" class="space-y-3">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="recaptcha_token" id="recaptcha_token_quick">
        <div class="grid grid-cols-2 gap-2">
          <input name="name"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent"
            placeholder="Name" required>
          <input name="email" type="email"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent"
            placeholder="Email" required>
        </div>
        <textarea name="message"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent"
          rows="2" placeholder="Your message..." required></textarea>
        <button
          class="w-full px-3 py-2 rounded-lg text-white text-sm font-medium shadow-sm hover:shadow-md transition-all duration-200"
          style="background: <?php echo RCN_GRADIENT; ?>;" type="submit">
          Send Message
        </button>
      </form>
    </div>
    <button type="button" data-engage-close class="p-1 rounded-lg hover:bg-gray-100 transition-colors duration-200"
      aria-label="Close promo panel">
      <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6 6l12 12M18 6L6 18" class="icon-stroke" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" />
      </svg>
    </button>
  </div>
</div>

<script src="<?php echo url('assets/js/app.js'); ?>"></script>
<?php if (!empty(RECAPTCHA_SITE_KEY)): ?>
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>"></script>
  <script>
    // Populate reCAPTCHA token for quick contact form in engagement panel
    (function(){
      try {
        if (window.grecaptcha && typeof grecaptcha.ready === 'function') {
          grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo esc_attr(RECAPTCHA_SITE_KEY); ?>', { action: 'contact_quick' })
              .then(function(token) {
                var el = document.getElementById('recaptcha_token_quick');
                if (el) el.value = token;
              });
          });
        }
      } catch (e) { /* silently ignore */ }
    })();
  </script>
<?php endif; ?>
</body>

</html>