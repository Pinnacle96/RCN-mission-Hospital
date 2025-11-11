<?php
$page_title = 'Partner With Us - Support Our Mission';
$page_description = 'Join our mission through financial partnership. Support medical missions and transform lives through healthcare and the Gospel.';
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Modern Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-20">
    <div class="absolute inset-0"
      style="background-image: url('<?php echo url('assets/images/hero4.jpg'); ?>'); background-size: cover; background-position: center;">
    </div>
  </div>

  <div class="absolute top-0 left-0 right-0 bottom-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse">
          <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1.5" />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#grid)" />
    </svg>
  </div>

  <div class="relative max-w-7xl mx-auto px-4 py-24">
    <div class="max-w-3xl">
      <div
        class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        Partner in Transforming Lives
      </div>

      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight" style="font-family: Poppins, sans-serif;">
        Partner <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">With
          Us</span>
      </h1>

      <p class="text-xl text-white/90 mb-8 leading-relaxed">
        Your financial partnership enables us to provide medical care, share the Gospel, and transform
        communities through sustainable mission work.
      </p>

      <div class="flex flex-wrap gap-4">
        <a href="#donate-options"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium text-white transition-all duration-300 transform hover:scale-105 shadow-lg"
          style="background: <?php echo RCN_GRADIENT; ?>">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
            </path>
          </svg>
          Donate Now
        </a>

        <a href="#impact"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white/30 text-white hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
            </path>
          </svg>
          See Impact
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Impact Stats Section -->
<section id="impact" class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Your Partnership Makes This Possible</h2>
      <p class="text-xl text-gray-600 leading-relaxed">Every donation directly supports our medical missions and
        community transformation work.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="50">0</div>
        <div class="text-gray-600">Medical Missions</div>
      </div>
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="10000">0</div>
        <div class="text-gray-600">Patients Treated</div>
      </div>
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="500">0</div>
        <div class="text-gray-600">Volunteers Supported</div>
      </div>
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="15">0</div>
        <div class="text-gray-600">Countries Reached</div>
      </div>
    </div>
  </div>
</section>

<!-- Donation Options Section -->
<section id="donate-options" class="bg-gradient-to-br from-gray-50 to-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Ways to Give</h2>
      <p class="text-xl text-gray-600 leading-relaxed">Choose the donation method that works best for you. Every
        gift makes a difference.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Online Payments -->
      <div
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 group hover:shadow-xl transition-all duration-500 flex flex-col">
        <div
          class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mb-6">
          <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
            </path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Online Payments</h3>
        <p class="text-gray-600 mb-6 flex-grow">Secure online donations via PayPal or Paystack with instant
          confirmation.</p>

        <div class="space-y-4">
          <!-- PayPal Button -->
          <form action="https://www.paypal.com/donate" method="post" target="_top" class="w-full">
            <input type="hidden" name="hosted_button_id" value="<?php echo htmlspecialchars(PAYPAL_HOSTED_BUTTON_ID); ?>">
            <input type="hidden" name="notify_url" value="<?php echo htmlspecialchars(($origin ?? (($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'))) . url('api/paypal/ipn.php')); ?>">
            <button type="submit"
              class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path
                  d="M7.5 14.25c-1.5 0-2.25-.75-2.25-2.25s.75-2.25 2.25-2.25h3.75c.75 0 1.5.75 1.5 1.5s-.75 1.5-1.5 1.5H9c-.75 0-1.5.75-1.5 1.5s.75 1.5 1.5 1.5h2.25c.75 0 1.5.75 1.5 1.5s-.75 1.5-1.5 1.5H7.5z" />
                <path
                  d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z" />
              </svg>
              Donate with PayPal
            </button>
          </form>

          <!-- Paystack Button -->
          <button onclick="openPaystack()"
            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
            </svg>
            Donate with Paystack
          </button>
        </div>
      </div>

      <!-- Bank Transfer -->
      <div
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 group hover:shadow-xl transition-all duration-500 flex flex-col">
        <div
          class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center mb-6">
          <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Bank Transfer</h3>
        <p class="text-gray-600 mb-6 flex-grow">Direct bank transfer to our mission account. For international
          transfers, use International Options to view USD/GBP details.</p>

        <!-- Quick Account Info -->
        <div class="space-y-4 bg-gray-50 rounded-lg p-4 mb-4">
          <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-semibold text-gray-700">NGN Account</span>
            <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">Local</span>
          </div>
          <div class="grid grid-cols-2 gap-2 text-sm">
            <div class="text-gray-600">Bank:</div>
            <div class="font-medium text-gray-900">First Bank</div>
            <div class="text-gray-600">Account:</div>
            <div class="font-mono text-gray-900">3123456789</div>
          </div>
        </div>

        <div class="space-y-3">
          <button onclick="copyAccountNumber('NGN Account','3123456789')"
            class="w-full bg-gray-200 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-300 transition-colors flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
              </path>
            </svg>
            Copy NGN Details
          </button>

          <button onclick="showInternationalOptions()"
            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064">
              </path>
            </svg>
            International Options
          </button>
        </div>
      </div>

      <!-- Mobile Money -->
      <div
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 group hover:shadow-xl transition-all duration-500 flex flex-col">
        <div
          class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-100 to-purple-50 flex items-center justify-center mb-6">
          <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile Money</h3>
        <p class="text-gray-600 mb-6 flex-grow">Quick and convenient mobile payments available in supported
          regions across Africa.</p>

        <div class="space-y-4">
          <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
              <span class="font-medium text-gray-700">MTN Mobile Money</span>
              <span class="text-xs px-2 py-1 rounded bg-purple-100 text-purple-700">Ghana</span>
            </div>
            <div class="font-mono text-gray-900 text-sm">055 123 4567</div>
          </div>

          <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
              <span class="font-medium text-gray-700">Airtel Money</span>
              <span class="text-xs px-2 py-1 rounded bg-red-100 text-red-700">Kenya</span>
            </div>
            <div class="font-mono text-gray-900 text-sm">073 123 4567</div>
          </div>

          <button onclick="showMoreOptions()"
            class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-purple-700 transition-colors flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
              </path>
            </svg>
            More Options
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Recurring Donation Section -->
<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <div>
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Sustain Our Mission</h2>
        <p class="text-xl text-gray-600 leading-relaxed mb-8">
          Become a monthly partner and provide consistent support for our ongoing medical missions and
          community programs.
        </p>

        <div class="space-y-6">
          <div class="flex items-start gap-4">
            <div
              class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-100 to-orange-50 flex items-center justify-center flex-shrink-0">
              <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                </path>
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Consistent Impact</h3>
              <p class="text-gray-600">Monthly giving allows us to plan ahead and respond quickly to
                urgent medical needs.</p>
            </div>
          </div>

          <div class="flex items-start gap-4">
            <div
              class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center flex-shrink-0">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Long-term Transformation</h3>
              <p class="text-gray-600">Support sustainable community health programs and local healthcare
                worker training.</p>
            </div>
          </div>
        </div>

        <div class="mt-8">
          <button onclick="setupRecurringDonation()"
            class="inline-flex items-center px-8 py-4 rounded-xl text-white font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300"
            style="background: <?php echo RCN_GRADIENT; ?>">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
              </path>
            </svg>
            Setup Monthly Giving
          </button>
        </div>
      </div>

      <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">What Your Monthly Gift Provides</h3>
        <div class="space-y-4">
          <div class="flex items-center justify-between p-4 bg-white rounded-lg">
            <span class="text-gray-700">$25/month</span>
            <span class="text-blue-600 font-semibold">Medical supplies for 50 patients</span>
          </div>
          <div class="flex items-center justify-between p-4 bg-white rounded-lg">
            <span class="text-gray-700">$50/month</span>
            <span class="text-blue-600 font-semibold">Support one local healthcare worker</span>
          </div>
          <div class="flex items-center justify-between p-4 bg-white rounded-lg">
            <span class="text-gray-700">$100/month</span>
            <span class="text-blue-600 font-semibold">Fund a mobile clinic for a day</span>
          </div>
          <div class="flex items-center justify-between p-4 bg-white rounded-lg">
            <span class="text-gray-700">$250/month</span>
            <span class="text-blue-600 font-semibold">Sponsor a medical mission volunteer</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="bg-gradient-to-br from-gray-50 to-white py-20">
  <div class="max-w-4xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
      <p class="text-xl text-gray-600 leading-relaxed">Get answers to common questions about supporting our
        mission.</p>
    </div>

    <div class="space-y-6">
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Is my donation tax-deductible?</h3>
        <p class="text-gray-600 leading-relaxed">Yes, RCN Mission Hospital is a registered 501(c)(3) non-profit
          organization. All donations are tax-deductible to the extent allowed by law. You will receive a
          receipt for your records.</p>
      </div>

      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">How are my funds used?</h3>
        <p class="text-gray-600 leading-relaxed">85% of all donations go directly to program expenses including
          medical supplies, mission trips, and community health programs. 15% supports administrative costs
          and fundraising efforts.</p>
      </div>

      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Can I designate my gift to a specific program?</h3>
        <p class="text-gray-600 leading-relaxed">Yes, you can specify if you'd like your donation to support
          general operations, specific mission trips, medical supplies, or community health education
          programs.</p>
      </div>

      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">How do I update my recurring donation?</h3>
        <p class="text-gray-600 leading-relaxed">Contact our support team at info@rcnmissionhospital.org or call +1
          (555) 123-4567 to make changes to your recurring donation plan.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-900 to-indigo-800 text-white py-20">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Make a Difference?</h2>
    <p class="text-xl text-white/90 max-w-3xl mx-auto mb-8 leading-relaxed">
      Your partnership enables us to bring healing and hope to communities in need. Choose your preferred payment
      method and start transforming lives today.
    </p>
    <div class="flex flex-wrap justify-center gap-6">
      <a href="#donate-options"
        class="inline-flex items-center px-8 py-4 rounded-xl bg-white text-gray-900 font-bold text-lg shadow-2xl hover:shadow-xl hover:scale-105 transition-all duration-300">
        Donate Now
      </a>
      <a href="<?php echo url('contact'); ?>"
        class="inline-flex items-center px-8 py-4 rounded-xl border-2 border-white text-white font-bold text-lg hover:bg-white/10 transition-all duration-300">
        Have Questions?
      </a>
    </div>
  </div>
</section>

<script>
  // SweetAlert2
  // Load SweetAlert2 from CDN if not present
  if (typeof window.Swal === 'undefined') {
    var s = document.createElement('script');
    s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    document.head.appendChild(s);
  }

  function showToast(message, type) {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2500,
      timerProgressBar: true,
    });
    Toast.fire({
      icon: type || 'info',
      title: message
    });
  }

  // Animated counter for stats
  document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('[data-count]');

    counters.forEach(counter => {
      const updateCount = () => {
        const target = +counter.getAttribute('data-count');
        const count = +counter.innerText;
        const increment = target / 200;

        if (count < target) {
          counter.innerText = Math.ceil(count + increment);
          setTimeout(updateCount, 1);
        } else {
          counter.innerText = target;
        }
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            updateCount();
            observer.unobserve(entry.target);
          }
        });
      });

      observer.observe(counter);
    });
  });

  // Copy account number functionality
  function copyAccountNumber(label, accountNumber) {
    label = label || 'Bank Account';
    if (!accountNumber) {
      Swal.fire({
        icon: 'info',
        title: label,
        html: '<div class="text-left">Please request the account details for ' + label +
          ' using the button, or contact us at <a class="underline" href="mailto:info@rcnmissionhospital.org">info@rcnmissionhospital.org</a>.</div>',
        confirmButtonText: 'OK',
      });
      return;
    }
    navigator.clipboard.writeText(accountNumber).then(() => {
      Swal.fire({
        icon: 'success',
        title: label + ' copied',
        html: '<div style="font-family: monospace; font-size: 1rem;">' + accountNumber + '</div>',
        confirmButtonText: 'OK',
      });
    });
  }

  // Payment integration functions (placeholder - integrate with your actual payment systems)
  function openPaystack() {
    if (!window.Swal) { return; }
    Swal.fire({
      title: 'Donate with Paystack',
      html: '<div class="space-y-3 text-left">' +
        '<label class="block text-sm font-medium text-gray-700">Amount (NGN)</label>' +
        '<input id="paystackAmount" type="number" min="100" step="50" class="swal2-input" placeholder="1000">' +
        '<label class="block text-sm font-medium text-gray-700">Email</label>' +
        '<input id="paystackEmail" type="email" class="swal2-input" placeholder="you@example.com">' +
        '</div>',
      focusConfirm: false,
      confirmButtonText: 'Continue',
      showCancelButton: true,
      preConfirm: () => {
        const amount = parseInt(document.getElementById('paystackAmount').value, 10);
        const email = (document.getElementById('paystackEmail').value || '').trim();
        if (!amount || amount < 100) { Swal.showValidationMessage('Please enter a valid amount (minimum NGN 100).'); return false; }
        if (!email || !/.+@.+\..+/.test(email)) { Swal.showValidationMessage('Please enter a valid email.'); return false; }
        return { amount, email };
      }
    }).then((result) => {
      if (!result.isConfirmed || !result.value) return;
      showToast('Initializing Paystack...', 'info');
      fetch('<?php echo url('api/paystack/init_once.php'); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ amount: result.value.amount, email: result.value.email })
      })
      .then(r => r.json())
      .then(json => {
        if (json && json.ok && json.data && json.data.authorization_url) {
          window.location.href = json.data.authorization_url;
        } else {
          Swal.fire({ icon: 'error', title: 'Paystack Error', text: (json && json.data && json.data.error) || 'Unable to initialize payment.' });
        }
      })
      .catch(() => Swal.fire({ icon: 'error', title: 'Network Error', text: 'Failed to contact Paystack. Please try again.' }));
    });
  }

  function showMoreOptions() {
    if (!window.Swal) {
      return;
    }
    Swal.fire({
      title: 'Mobile Money Options',
      html: '<div class="text-left space-y-2">' +
        '<div><strong>MPesa (Kenya):</strong> 074 123 4567</div>' +
        '<div><strong>Orange Money (Cameroon):</strong> 677 123 456</div>' +
        '<div><strong>Vodafone Cash (Ghana):</strong> 020 123 4567</div>' +
        '<div class="text-gray-600 mt-3">Contact us for other mobile money options.</div>' +
        '</div>',
      confirmButtonText: 'OK'
    });
  }

  function setupRecurringDonation() {
    if (!window.Swal) { return; }
    Swal.fire({
      title: 'Setup Monthly Giving',
      html: '<div class="text-left space-y-3">' +
        '<label class="block text-sm font-medium text-gray-700">Platform</label>' +
        '<div class="flex items-center gap-4">' +
          '<label class="inline-flex items-center gap-2"><input type="radio" name="recPlatform" value="paypal" checked> <span>PayPal (USD)</span></label>' +
          '<label class="inline-flex items-center gap-2"><input type="radio" name="recPlatform" value="paystack"> <span>Paystack (NGN)</span></label>' +
        '</div>' +
        '<label class="block text-sm font-medium text-gray-700">Monthly Amount (<span id="recCurrencyLabel">USD</span>)</label>' +
        '<input id="recAmount" type="number" min="5" step="5" class="swal2-input" placeholder="25">' +
        '<label class="block text-sm font-medium text-gray-700">Email</label>' +
        '<input id="recEmail" type="email" class="swal2-input" placeholder="you@example.com">' +
        '<div class="text-sm text-gray-600">We will redirect you to a secure payment page.</div>' +
        '</div>',
      didOpen: () => {
        const radios = document.querySelectorAll('input[name="recPlatform"]');
        const currencyLabel = document.getElementById('recCurrencyLabel');
        const updateLabel = () => {
          const selected = document.querySelector('input[name="recPlatform"]:checked');
          currencyLabel.textContent = selected && selected.value === 'paystack' ? 'NGN' : 'USD';
        };
        radios.forEach(r => r.addEventListener('change', updateLabel));
        updateLabel();
      },
      focusConfirm: false,
      confirmButtonText: 'Continue',
      showCancelButton: true,
      preConfirm: () => {
        const amount = parseFloat(document.getElementById('recAmount').value);
        const email = (document.getElementById('recEmail').value || '').trim();
        const platformEl = document.querySelector('input[name="recPlatform"]:checked');
        const platform = platformEl ? platformEl.value : '';
        if (!platform) { Swal.showValidationMessage('Please select a platform.'); return false; }
        if (!amount || amount < 5) { Swal.showValidationMessage('Please enter a valid monthly amount (minimum 5).'); return false; }
        if (!email || !/.+@.+\..+/.test(email)) { Swal.showValidationMessage('Please enter a valid email.'); return false; }
        return { amount, email, platform };
      }
    }).then((result) => {
      if (!result.isConfirmed || !result.value) return;
      var platform = result.value.platform;
      if (platform === 'paypal') {
        // Build and submit a PayPal subscription form (USD)
        var form = document.createElement('form');
        form.method = 'post';
        form.action = 'https://www.paypal.com/cgi-bin/webscr';
        var fields = {
          cmd: '_xclick-subscriptions',
          business: '<?php echo PAYPAL_BUSINESS_EMAIL; ?>',
          item_name: 'Monthly Donation',
          currency_code: 'USD',
          a3: String(result.value.amount),
          p3: '1',
          t3: 'M',
          src: '1',
          sra: '1',
          no_note: '1',
          return: '<?php echo PAYPAL_RETURN_URL; ?>',
          cancel_return: '<?php echo PAYPAL_CANCEL_URL; ?>',
          notify_url: '<?php echo ($origin ?? (($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'))) . url('api/paypal/ipn.php'); ?>',
        };
        Object.keys(fields).forEach(function(key) {
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = key;
          input.value = fields[key];
          form.appendChild(input);
        });
        document.body.appendChild(form);
        showToast('Redirecting to PayPal...', 'info');
        form.submit();
      } else if (platform === 'paystack') {
        // Initialize Paystack recurring (NGN)
        showToast('Initializing Paystack...', 'info');
        var params = new URLSearchParams({
          amount: result.value.amount,
          email: result.value.email,
          plan: '<?php echo PAYSTACK_PLAN_CODE_NGN_MONTHLY; ?>'
        });
        fetch('<?php echo url('api/paystack/init_recurring.php'); ?>', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: params
        })
        .then(r => r.json())
        .then(json => {
          if (json && json.ok && json.data && json.data.authorization_url) {
            window.location.href = json.data.authorization_url;
          } else {
            Swal.fire({ icon: 'error', title: 'Paystack Error', text: (json && json.data && json.data.error) || 'Unable to initialize recurring payment.' });
          }
        })
        .catch(() => Swal.fire({ icon: 'error', title: 'Network Error', text: 'Failed to contact Paystack. Please try again.' }));
      }
    });
  }

  function requestAccountDetails(currency) {
    if (!window.Swal) {
      return;
    }
    var label = (currency || '').toUpperCase();
    Swal.fire({
      title: 'Request ' + (label || 'Account') + ' Details',
      html: '<div class="text-left space-y-2">' +
        '<p>For international transfers (' + (label || 'USD/GBP') +
        '), please contact our donations team to receive the domiciliary account details and SWIFT codes.</p>' +
        '<p>Email: <a class="underline" href="mailto:info@rcnmissionhospital.org">info@rcnmissionhospital.org</a></p>' +
        '<p>Or send us a message via the <a class="underline" href="' + (window.location.origin +
          '/contact') + '">contact page</a>.</p>' +
        '</div>',
      confirmButtonText: 'Got it'
    });
  }

  // Add this new function for international options
  function showInternationalOptions() {
    if (!window.Swal) {
      return;
    }
    // Show details directly for international transfers
    Swal.fire({
      title: 'International Bank Transfer',
      html: '<div class="text-left space-y-4">' +
        '<div class="bg-blue-50 rounded-lg p-4">' +
        '<h4 class="font-semibold text-blue-900 mb-2">USD & GBP Accounts</h4>' +
        '<p class="text-blue-700 text-sm">View the available details for international transfers below.</p>' +
        '</div>' +
        // USD Card
        '<div class="bg-white rounded-lg border p-4 space-y-2">' +
        '<div class="flex items-center justify-between">' +
        '<span class="text-sm font-semibold text-gray-700">USD Account</span>' +
        '<span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700">International</span>' +
        '</div>' +
        '<div class="grid grid-cols-2 gap-2 text-sm">' +
        '<div class="text-gray-600">Bank:</div><div class="font-medium text-gray-900">First Bank Nigeria</div>' +
        '<div class="text-gray-600">Account Name:</div><div class="font-medium text-gray-900">RCN Mission Hospital</div>' +
        '<div class="text-gray-600">Account Number:</div><div class="font-mono text-gray-900">0001234567</div>' +
        '<div class="text-gray-600">SWIFT:</div><div class="font-mono text-gray-900">FBNINGLA</div>' +
        '<div class="text-gray-600">IBAN:</div><div class="font-mono text-gray-900">GB00FBNI00000000000000</div>' +
        '</div>' +
        '<div class="flex gap-3 pt-2">' +
        '<button onclick="copyAccountDetails(\'USD\')" class="flex-1 bg-gray-200 text-gray-700 py-2 px-3 rounded font-medium hover:bg-gray-300 transition-colors">Copy USD Details</button>' +
        '</div>' +
        '</div>' +
        // GBP Card
        '<div class="bg-white rounded-lg border p-4 space-y-2">' +
        '<div class="flex items-center justify-between">' +
        '<span class="text-sm font-semibold text-gray-700">GBP Account</span>' +
        '<span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700">International</span>' +
        '</div>' +
        '<div class="grid grid-cols-2 gap-2 text-sm">' +
        '<div class="text-gray-600">Bank:</div><div class="font-medium text-gray-900">First Bank Nigeria</div>' +
        '<div class="text-gray-600">Account Name:</div><div class="font-medium text-gray-900">RCN Mission Hospital</div>' +
        '<div class="text-gray-600">Account Number:</div><div class="font-mono text-gray-900">0009876543</div>' +
        '<div class="text-gray-600">SWIFT:</div><div class="font-mono text-gray-900">FBNINGLA</div>' +
        '<div class="text-gray-600">IBAN:</div><div class="font-mono text-gray-900">GB00FBNI00000000000001</div>' +
        '</div>' +
        '<div class="flex gap-3 pt-2">' +
        '<button onclick="copyAccountDetails(\'GBP\')" class="flex-1 bg-gray-200 text-gray-700 py-2 px-3 rounded font-medium hover:bg-gray-300 transition-colors">Copy GBP Details</button>' +
        '</div>' +
        '</div>' +
        '</div>',
      confirmButtonText: 'Close',
      showConfirmButton: true,
      showCloseButton: true
    });
  }

  // Update the requestAccountDetails function to be more user-friendly
  function requestAccountDetails(currency) {
    if (!window.Swal) {
      return;
    }
    var label = (currency || '').toUpperCase();
    Swal.fire({
      title: `Request ${label} Account Details`,
      html: `<div class="text-left space-y-4">
            <div class="bg-green-50 rounded-lg p-4">
                <h4 class="font-semibold text-green-900 mb-2">Quick Response Guaranteed</h4>
                <p class="text-green-700 text-sm">We'll send you the complete account details within 24 hours.</p>
            </div>
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-white rounded-lg border">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <div class="font-medium text-gray-900">Email Us</div>
                        <div class="text-sm text-gray-600">info@rcnmissionhospital.org</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-white rounded-lg border">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <div>
                        <div class="font-medium text-gray-900">Call Us</div>
                        <div class="text-sm text-gray-600">+1 (555) 123-4567</div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="${window.location.origin}/contact" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    Contact Form
                </a>
            </div>
            </div>`,
      confirmButtonText: 'Got it',
      showCloseButton: true
    });
  }
  // Copy full international account details (USD/GBP)
  function copyAccountDetails(currency) {
    var c = (currency || '').toUpperCase();
    var details = {
      USD: {
        bankName: 'First Bank Nigeria',
        accountName: 'RCN Mission Hospital',
        accountNumber: '0001234567',
        swift: 'FBNINGLA',
        iban: 'GB00FBNI00000000000000'
      },
      GBP: {
        bankName: 'First Bank Nigeria',
        accountName: 'RCN Mission Hospital',
        accountNumber: '0009876543',
        swift: 'FBNINGLA',
        iban: 'GB00FBNI00000000000001'
      }
    }[c] || {};

    var text = [
      c + ' Account',
      'Bank: ' + (details.bankName || '—'),
      'Account Name: ' + (details.accountName || '—'),
      'Account Number: ' + (details.accountNumber || '—'),
      'SWIFT: ' + (details.swift || '—'),
      'IBAN: ' + (details.iban || '—')
    ].join('\n');

    navigator.clipboard.writeText(text)
      .then(function() { showToast(c + ' details copied to clipboard', 'success'); })
      .catch(function() { showToast('Failed to copy ' + c + ' details', 'error'); });
  }

  // Payment status alerts after redirect
  document.addEventListener('DOMContentLoaded', function() {
    var cancel = <?php echo isset($_GET['cancel']) ? 'true' : 'false'; ?>;
    var status = '<?php echo isset($_GET['status']) ? $_GET['status'] : ''; ?>'; // e.g., success/failed
    var st = '<?php echo isset($_GET['st']) ? $_GET['st'] : ''; ?>'; // PayPal may return st=Completed
    if (cancel) {
      Swal.fire({ icon: 'error', title: 'Payment cancelled', text: 'You can try again or contact us for help.' });
    } else if ((status && status.toLowerCase() === 'success') || st === 'Completed') {
      Swal.fire({ icon: 'success', title: 'Thank you!', text: 'Your payment completed successfully.' });
    } else if (status && status.toLowerCase() === 'failed') {
      Swal.fire({ icon: 'error', title: 'Payment failed', text: 'Please try again.' });
    }
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>