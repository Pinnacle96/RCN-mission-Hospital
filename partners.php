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

<!-- Enhanced Impact Stats Section -->
<section id="impact" class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-purple-900 text-white py-20 overflow-hidden">
  <!-- Animated Background -->
  <div class="absolute inset-0 opacity-5">
    <div class="absolute inset-0 animate-pulse" style="background: radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%), radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);"></div>
  </div>
  
  <div class="relative max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold mb-6">Your Partnership Creates <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">Lasting Change</span></h2>
      <p class="text-xl text-blue-200 leading-relaxed">Every donation directly supports our medical missions and transforms communities through sustainable healthcare solutions.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
      <div class="text-center group">
        <div class="relative inline-block mb-4">
          <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-pink-500 rounded-full blur-lg opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
          <div class="relative bg-slate-800 rounded-full p-4 w-20 h-20 flex items-center justify-center">
            <div class="text-2xl lg:text-3xl font-bold text-white" data-count="50">0</div>
          </div>
        </div>
        <div class="text-blue-200 font-medium">Medical Missions</div>
        <div class="text-sm text-blue-300 mt-1">Across 3 continents</div>
      </div>
      
      <div class="text-center group">
        <div class="relative inline-block mb-4">
          <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-cyan-500 rounded-full blur-lg opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
          <div class="relative bg-slate-800 rounded-full p-4 w-20 h-20 flex items-center justify-center">
            <div class="text-2xl lg:text-3xl font-bold text-white" data-count="10000">0</div>
          </div>
        </div>
        <div class="text-blue-200 font-medium">Patients Treated</div>
        <div class="text-sm text-blue-300 mt-1">Life-changing care</div>
      </div>
      
      <div class="text-center group">
        <div class="relative inline-block mb-4">
          <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-blue-500 rounded-full blur-lg opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
          <div class="relative bg-slate-800 rounded-full p-4 w-20 h-20 flex items-center justify-center">
            <div class="text-2xl lg:text-3xl font-bold text-white" data-count="500">0</div>
          </div>
        </div>
        <div class="text-blue-200 font-medium">Volunteers</div>
        <div class="text-sm text-blue-300 mt-1">Dedicated professionals</div>
      </div>
      
      <div class="text-center group">
        <div class="relative inline-block mb-4">
          <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full blur-lg opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
          <div class="relative bg-slate-800 rounded-full p-4 w-20 h-20 flex items-center justify-center">
            <div class="text-2xl lg:text-3xl font-bold text-white" data-count="15">0</div>
          </div>
        </div>
        <div class="text-blue-200 font-medium">Countries Reached</div>
        <div class="text-sm text-blue-300 mt-1">Global impact</div>
      </div>
    </div>
  </div>
</section>

<!-- Enhanced Donation Options Section -->
<section id="donate-options" class="relative bg-gradient-to-br from-slate-50 via-white to-blue-50 py-20 overflow-hidden">
  <!-- Background Elements -->
  <div class="absolute top-0 right-0 w-72 h-72 bg-gradient-to-bl from-blue-100 to-transparent rounded-full -translate-y-36 translate-x-36"></div>
  <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-purple-100 to-transparent rounded-full translate-y-48 -translate-x-48"></div>
  
  <div class="relative max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Choose Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Giving Path</span></h2>
      <p class="text-xl text-gray-600 leading-relaxed">Select the donation method that aligns with your preferences. Every contribution fuels our mission of healing and hope.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Online Payments Card -->
      <div class="group relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
        <div class="relative bg-white rounded-2xl shadow-xl border border-gray-100 p-8 h-full flex flex-col">
          <div class="flex items-center justify-between mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                </path>
              </svg>
            </div>
            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">Instant</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Digital Payments</h3>
          <p class="text-gray-600 mb-6 flex-grow">Secure online donations with instant confirmation and immediate impact tracking.</p>

          <div class="space-y-4">
            <!-- PayPal Button -->
            <form action="https://www.paypal.com/donate" method="post" target="_top" class="w-full">
              <input type="hidden" name="hosted_button_id" value="<?php echo htmlspecialchars(PAYPAL_HOSTED_BUTTON_ID); ?>">
              <input type="hidden" name="notify_url" value="<?php echo htmlspecialchars(($origin ?? (($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'))) . url('api/paypal/ipn.php')); ?>">
              <button type="submit"
                class="w-full bg-blue-600 text-white py-3 px-4 rounded-xl font-medium hover:bg-blue-700 transition-all duration-300 flex items-center justify-center gap-2 group/btn shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" viewBox="0 0 24 24" fill="currentColor">
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
              class="w-full bg-green-600 text-white py-3 px-4 rounded-xl font-medium hover:bg-green-700 transition-all duration-300 flex items-center justify-center gap-2 group/btn shadow-lg hover:shadow-xl">
              <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" viewBox="0 0 24 24" fill="currentColor">
                <path
                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
              </svg>
              Donate with Paystack
            </button>
          </div>
        </div>
      </div>

      <!-- Bank Transfer Card -->
      <div class="group relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
        <div class="relative bg-white rounded-2xl shadow-xl border border-gray-100 p-8 h-full flex flex-col">
          <div class="flex items-center justify-between mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
              </svg>
            </div>
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Direct</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Bank Transfer</h3>
          <p class="text-gray-600 mb-6 flex-grow">Direct bank transfers with zero processing fees. International options available for USD/GBP/EUR.</p>

          <!-- Quick Account Info -->
          <div class="space-y-4 bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 mb-4 border border-gray-200">
            <div class="flex items-center justify-between mb-3">
              <span class="text-sm font-semibold text-gray-700">NGN Account</span>
              <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700 font-medium">Local</span>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm">
              <div class="text-gray-600">Bank:</div>
              <div class="font-medium text-gray-900">First Bank</div>
              <div class="text-gray-600">Account Name:</div>
              <div class="font-medium text-gray-900">RCN MEDICAL CENTER</div>
              <div class="text-gray-600">Account Number:</div>
              <div class="font-mono text-gray-900 bg-gray-100 px-2 py-1 rounded">2045571486</div>
            </div>
          </div>

          <div class="space-y-3">
            <button onclick="copyAccountNumber('NGN Account','2045571486')"
              class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-xl font-medium hover:bg-gray-200 transition-all duration-300 flex items-center justify-center gap-2 group/btn">
              <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                </path>
              </svg>
              Copy NGN Details
            </button>

            <button onclick="showInternationalOptions()"
              class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-xl font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-300 flex items-center justify-center gap-2 group/btn shadow-lg hover:shadow-xl">
              <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064">
                </path>
              </svg>
              International Options
            </button>
          </div>
        </div>
      </div>

      <!-- Crypto & Other Options Card -->
      <div class="group relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
        <div class="relative bg-white rounded-2xl shadow-xl border border-gray-100 p-8 h-full flex flex-col">
          <div class="flex items-center justify-between mb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-100 to-purple-50 flex items-center justify-center">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">Modern</span>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Alternative Methods</h3>
          <p class="text-gray-600 mb-6 flex-grow">Explore modern giving options including cryptocurrency, stock transfers, and corporate matching.</p>

          <div class="space-y-4">
            <button onclick="showCryptoOptions()"
              class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-4 rounded-xl font-medium hover:from-purple-700 hover:to-pink-700 transition-all duration-300 flex items-center justify-center gap-2 group/btn shadow-lg hover:shadow-xl">
              <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Crypto Donations
            </button>

            <button onclick="showCorporateOptions()"
              class="w-full bg-gradient-to-r from-gray-700 to-gray-900 text-white py-3 px-4 rounded-xl font-medium hover:from-gray-800 hover:to-black transition-all duration-300 flex items-center justify-center gap-2 group/btn shadow-lg hover:shadow-xl">
              <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
              Corporate Giving
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Enhanced Recurring Donation Section -->
<section class="relative bg-gradient-to-br from-white via-blue-50 to-indigo-100 py-20 overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-30">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%239C92AC\" fill-opacity=\"0.1\"><circle cx=\"30\" cy=\"30\" r=\"4\"/></g></g></svg>');"></div>
  </div>
  
  <div class="relative max-w-7xl mx-auto px-4">
    <div class="grid lg:grid-cols-2 gap-16 items-center">
      <div>
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-medium mb-6">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
          </svg>
          Sustainable Impact
        </div>
        
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Become a <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-pink-500">Monthly Partner</span></h2>
        <p class="text-xl text-gray-600 leading-relaxed mb-8">
          Join our circle of monthly supporters and provide consistent funding for ongoing medical missions, community health programs, and emergency response initiatives.
        </p>

        <div class="space-y-6 mb-8">
          <div class="flex items-start gap-4 p-4 rounded-2xl bg-white shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-100 to-orange-50 flex items-center justify-center flex-shrink-0">
              <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                </path>
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Predictable Funding</h3>
              <p class="text-gray-600">Monthly giving allows us to plan long-term projects and respond immediately to urgent medical needs.</p>
            </div>
          </div>

          <div class="flex items-start gap-4 p-4 rounded-2xl bg-white shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center flex-shrink-0">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Sustainable Transformation</h3>
              <p class="text-gray-600">Support ongoing community health programs and local healthcare worker training initiatives.</p>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap gap-4">
          <button onclick="setupRecurringDonation()"
            class="inline-flex items-center px-8 py-4 rounded-xl text-white font-bold text-lg shadow-2xl hover:shadow-xl hover:scale-105 transition-all duration-300 group"
            style="background: <?php echo RCN_GRADIENT; ?>">
            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
              </path>
            </svg>
            Start Monthly Giving
          </button>
          
          <a href="#impact-stories"
            class="inline-flex items-center px-8 py-4 rounded-xl border-2 border-gray-300 text-gray-700 font-bold text-lg hover:border-blue-500 hover:text-blue-600 transition-all duration-300">
            See Impact Stories
          </a>
        </div>
      </div>

      <div class="relative">
        <div class="absolute -inset-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl blur-xl opacity-10"></div>
        <div class="relative bg-gradient-to-br from-blue-600 to-purple-700 rounded-2xl p-8 text-white shadow-2xl">
          <h3 class="text-2xl font-bold mb-8">Monthly Impact Breakdown</h3>
          <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-white/10 rounded-xl backdrop-blur-sm hover:bg-white/20 transition-all duration-300">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                  <span class="font-bold">$25</span>
                </div>
                <span>Medical supplies for 50 patients</span>
              </div>
              <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-white/10 rounded-xl backdrop-blur-sm hover:bg-white/20 transition-all duration-300">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                  <span class="font-bold">$50</span>
                </div>
                <span>Support one local healthcare worker</span>
              </div>
              <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-white/10 rounded-xl backdrop-blur-sm hover:bg-white/20 transition-all duration-300">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                  <span class="font-bold">$100</span>
                </div>
                <span>Fund a mobile clinic for a day</span>
              </div>
              <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-white/10 rounded-xl backdrop-blur-sm hover:bg-white/20 transition-all duration-300">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                  <span class="font-bold">$250</span>
                </div>
                <span>Sponsor a medical mission volunteer</span>
              </div>
              <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
            </div>
          </div>
          
          <div class="mt-6 p-4 bg-white/10 rounded-xl backdrop-blur-sm">
            <div class="text-sm opacity-90">Most popular: $50/month</div>
            <div class="w-full bg-white/20 rounded-full h-2 mt-2">
              <div class="bg-green-400 h-2 rounded-full" style="width: 65%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Enhanced FAQ Section -->
<section class="bg-gradient-to-br from-slate-900 via-purple-900 to-blue-900 text-white py-20">
  <div class="max-w-6xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold mb-6">Questions <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-purple-300">Answered</span></h2>
      <p class="text-xl text-blue-200 leading-relaxed">Get detailed answers to common questions about supporting our mission and maximizing your impact.</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
      <div class="space-y-6">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/15 transition-all duration-300 group">
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-lg bg-blue-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
              <span class="text-white font-bold text-sm">Q</span>
            </div>
            <div>
              <h3 class="text-xl font-semibold mb-4">Is my donation tax-deductible?</h3>
              <p class="text-blue-200 leading-relaxed">Yes, RCN Mission Hospital is a registered 501(c)(3) non-profit organization. All donations are tax-deductible to the extent allowed by law. You will receive a receipt for your records.</p>
            </div>
          </div>
        </div>

        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/15 transition-all duration-300 group">
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-lg bg-green-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
              <span class="text-white font-bold text-sm">Q</span>
            </div>
            <div>
              <h3 class="text-xl font-semibold mb-4">How are my funds used?</h3>
              <p class="text-blue-200 leading-relaxed">85% of all donations go directly to program expenses including medical supplies, mission trips, and community health programs. 15% supports administrative costs and fundraising efforts.</p>
            </div>
          </div>
        </div>

        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/15 transition-all duration-300 group">
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-lg bg-purple-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
              <span class="text-white font-bold text-sm">Q</span>
            </div>
            <div>
              <h3 class="text-xl font-semibold mb-4">Can I designate my gift to a specific program?</h3>
              <p class="text-blue-200 leading-relaxed">Yes, you can specify if you'd like your donation to support general operations, specific mission trips, medical supplies, or community health education programs.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/15 transition-all duration-300 group">
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-lg bg-orange-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
              <span class="text-white font-bold text-sm">Q</span>
            </div>
            <div>
              <h3 class="text-xl font-semibold mb-4">How do I update my recurring donation?</h3>
              <p class="text-blue-200 leading-relaxed">Contact our support team at info@rcnmissionhospital.org or call +1 (555) 123-4567 to make changes to your recurring donation plan.</p>
            </div>
          </div>
        </div>

        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/15 transition-all duration-300 group">
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-lg bg-pink-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
              <span class="text-white font-bold text-sm">Q</span>
            </div>
            <div>
              <h3 class="text-xl font-semibold mb-4">Do you accept stock or cryptocurrency donations?</h3>
              <p class="text-blue-200 leading-relaxed">Yes! We accept donations of stocks, cryptocurrencies, and other assets. Contact our donations team for specialized assistance with these giving methods.</p>
            </div>
          </div>
        </div>

        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/15 transition-all duration-300 group">
          <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
              <span class="text-white font-bold text-sm">Q</span>
            </div>
            <div>
              <h3 class="text-xl font-semibold mb-4">How can I get involved beyond financial support?</h3>
              <p class="text-blue-200 leading-relaxed">We welcome volunteers, prayer partners, and advocates. Visit our Get Involved page to explore all the ways you can support our mission beyond financial contributions.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Enhanced CTA Section -->
<section class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 text-white py-24 overflow-hidden">
  <!-- Animated Background -->
  <div class="absolute inset-0">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-blue-500/20 via-transparent to-transparent"></div>
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
  </div>
  
  <div class="relative max-w-4xl mx-auto px-4 text-center">
    <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
      <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
      Join Our Mission Today
    </div>
    
    <h2 class="text-4xl md:text-6xl font-bold mb-8">Ready to Transform <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">Lives Together?</span></h2>
    
    <p class="text-xl text-white/90 max-w-2xl mx-auto mb-12 leading-relaxed">
      Your partnership enables us to bring healing and hope to communities in need. Choose your preferred payment method and start making a lasting impact today.
    </p>
    
    <div class="flex flex-wrap justify-center gap-6">
      <a href="#donate-options"
        class="group relative inline-flex items-center px-10 py-5 rounded-2xl bg-white text-gray-900 font-bold text-lg shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-white to-gray-100 group-hover:from-gray-100 group-hover:to-white transition-all duration-300"></div>
        <span class="relative">Donate Now</span>
      </a>
      
      <a href="<?php echo url('contact'); ?>"
        class="group relative inline-flex items-center px-10 py-5 rounded-2xl border-2 border-white text-white font-bold text-lg hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
        <span class="relative">Have Questions?</span>
      </a>
    </div>
    
    <div class="mt-12 flex items-center justify-center gap-8 text-white/70">
      <div class="flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
        </svg>
        <span>Secure Payments</span>
      </div>
      <div class="flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
        </svg>
        <span>Tax Deductible</span>
      </div>
      <div class="flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
        </svg>
        <span>Instant Receipt</span>
      </div>
    </div>
  </div>
</section>

<script>
  // Enhanced SweetAlert2 Functions
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

  // Enhanced Animated counter for stats
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

  // Enhanced Copy account number functionality
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

  // Enhanced Payment integration functions
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

  // Enhanced recurring donation setup
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

  // Enhanced international options
  function showInternationalOptions() {
    if (!window.Swal) {
      return;
    }
    Swal.fire({
      title: 'International Bank Transfer',
      html: '<div class="text-left space-y-4">' +
        '<div class="bg-blue-50 rounded-lg p-4">' +
        '<h4 class="font-semibold text-blue-900 mb-2">USD / GBP / EUR Accounts</h4>' +
        '<p class="text-blue-700 text-sm">Use the following domiciliary accounts for international transfers.</p>' +
        '</div>' +
        // USD Card
        '<div class="bg-white rounded-lg border p-4 space-y-2">' +
        '<div class="flex items-center justify-between">' +
        '<span class="text-sm font-semibold text-gray-700">USD Account</span>' +
        '<span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700">International</span>' +
        '</div>' +
        '<div class="grid grid-cols-2 gap-2 text-sm">' +
        '<div class="text-gray-600">Bank:</div><div class="font-medium text-gray-900">First Bank</div>' +
        '<div class="text-gray-600">Account Name:</div><div class="font-medium text-gray-900">RCN MEDICAL CENTER</div>' +
        '<div class="text-gray-600">Account Number:</div><div class="font-mono text-gray-900">2045578832</div>' +
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
        '<div class="text-gray-600">Bank:</div><div class="font-medium text-gray-900">First Bank</div>' +
        '<div class="text-gray-600">Account Name:</div><div class="font-medium text-gray-900">RCN MEDICAL CENTER</div>' +
        '<div class="text-gray-600">Account Number:</div><div class="font-mono text-gray-900">2045578894</div>' +
        '</div>' +
        '<div class="flex gap-3 pt-2">' +
        '<button onclick="copyAccountDetails(\'GBP\')" class="flex-1 bg-gray-200 text-gray-700 py-2 px-3 rounded font-medium hover:bg-gray-300 transition-colors">Copy GBP Details</button>' +
        '</div>' +
        '</div>' +
        // EUR Card
        '<div class="bg-white rounded-lg border p-4 space-y-2">' +
        '<div class="flex items-center justify-between">' +
        '<span class="text-sm font-semibold text-gray-700">EUR Account</span>' +
        '<span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700">International</span>' +
        '</div>' +
        '<div class="grid grid-cols-2 gap-2 text-sm">' +
        '<div class="text-gray-600">Bank:</div><div class="font-medium text-gray-900">First Bank</div>' +
        '<div class="text-gray-600">Account Name:</div><div class="font-medium text-gray-900">RCN MEDICAL CENTER</div>' +
        '<div class="text-gray-600">Account Number:</div><div class="font-mono text-gray-900">2045578966</div>' +
        '</div>' +
        '<div class="flex gap-3 pt-2">' +
        '<button onclick="copyAccountDetails(\'EUR\')" class="flex-1 bg-gray-200 text-gray-700 py-2 px-3 rounded font-medium hover:bg-gray-300 transition-colors">Copy EUR Details</button>' +
        '</div>' +
        '</div>' +
        '</div>',
      confirmButtonText: 'Close',
      showConfirmButton: true,
      showCloseButton: true
    });
  }

  // New functions for additional options
  function showCryptoOptions() {
    if (!window.Swal) { return; }
    Swal.fire({
      title: 'Crypto Donations',
      html: '<div class="text-left space-y-4">' +
        '<div class="bg-purple-50 rounded-lg p-4">' +
        '<h4 class="font-semibold text-purple-900 mb-2">Modern Giving Options</h4>' +
        '<p class="text-purple-700 text-sm">We accept various cryptocurrencies. Contact us for wallet addresses and instructions.</p>' +
        '</div>' +
        '<div class="space-y-3">' +
        '<div class="flex items-center gap-3 p-3 bg-white rounded-lg border">' +
        '<div class="w-8 h-8 bg-bitcoin rounded-full flex items-center justify-center">₿</div>' +
        '<div><div class="font-medium">Bitcoin (BTC)</div><div class="text-sm text-gray-600">Most popular</div></div>' +
        '</div>' +
        '<div class="flex items-center gap-3 p-3 bg-white rounded-lg border">' +
        '<div class="w-8 h-8 bg-ethereum rounded-full flex items-center justify-center text-white" style="background: #627EEA;">Ξ</div>' +
        '<div><div class="font-medium">Ethereum (ETH)</div><div class="text-sm text-gray-600">ERC-20 tokens</div></div>' +
        '</div>' +
        '<div class="flex items-center gap-3 p-3 bg-white rounded-lg border">' +
        '<div class="w-8 h-8 bg-usdc rounded-full flex items-center justify-center text-white" style="background: #2775CA;">$</div>' +
        '<div><div class="font-medium">Stablecoins</div><div class="text-sm text-gray-600">USDC, USDT</div></div>' +
        '</div>' +
        '</div>' +
        '<div class="text-center pt-4">' +
        '<button onclick="requestCryptoDetails()" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">Request Wallet Addresses</button>' +
        '</div>' +
        '</div>',
      showConfirmButton: false,
      showCloseButton: true
    });
  }

  function showCorporateOptions() {
    if (!window.Swal) { return; }
    Swal.fire({
      title: 'Corporate Giving',
      html: '<div class="text-left space-y-4">' +
        '<div class="bg-gray-50 rounded-lg p-4">' +
        '<h4 class="font-semibold text-gray-900 mb-2">Partnership Opportunities</h4>' +
        '<p class="text-gray-700 text-sm">Explore corporate sponsorship, matching gifts, and employee engagement programs.</p>' +
        '</div>' +
        '<div class="space-y-3">' +
        '<div class="flex items-center gap-3 p-3 bg-white rounded-lg border">' +
        '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>' +
        '<div><div class="font-medium">Matching Gifts</div><div class="text-sm text-gray-600">Double employee donations</div></div>' +
        '</div>' +
        '<div class="flex items-center gap-3 p-3 bg-white rounded-lg border">' +
        '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>' +
        '<div><div class="font-medium">Sponsorships</div><div class="text-sm text-gray-600">Mission trip sponsorships</div></div>' +
        '</div>' +
        '<div class="flex items-center gap-3 p-3 bg-white rounded-lg border">' +
        '<svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>' +
        '<div><div class="font-medium">Volunteer Programs</div><div class="text-sm text-gray-600">Team volunteering</div></div>' +
        '</div>' +
        '</div>' +
        '<div class="text-center pt-4">' +
        '<button onclick="contactCorporateTeam()" class="bg-gray-800 text-white px-6 py-3 rounded-lg hover:bg-black transition-colors">Contact Corporate Team</button>' +
        '</div>' +
        '</div>',
      showConfirmButton: false,
      showCloseButton: true
    });
  }

  function requestCryptoDetails() {
    Swal.fire({
      title: 'Crypto Donation Details',
      html: '<div class="text-left space-y-4">' +
        '<p>Please contact our donations team to receive cryptocurrency wallet addresses and detailed instructions.</p>' +
        '<div class="bg-purple-50 rounded-lg p-4">' +
        '<div class="font-semibold text-purple-900">Email:</div>' +
        '<div class="text-purple-700">crypto@rcnmissionhospital.org</div>' +
        '</div>' +
        '</div>',
      confirmButtonText: 'Got it'
    });
  }

  function contactCorporateTeam() {
    Swal.fire({
      title: 'Corporate Partnerships',
      html: '<div class="text-left space-y-4">' +
        '<p>Our corporate team will contact you within 24 hours to discuss partnership opportunities.</p>' +
        '<div class="space-y-3">' +
        '<div><label class="block text-sm font-medium text-gray-700 mb-1">Your Name</label><input type="text" class="swal2-input" placeholder="John Smith"></div>' +
        '<div><label class="block text-sm font-medium text-gray-700 mb-1">Company</label><input type="text" class="swal2-input" placeholder="Your Company"></div>' +
        '<div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label><input type="email" class="swal2-input" placeholder="john@company.com"></div>' +
        '</div>' +
        '</div>',
      showCancelButton: true,
      confirmButtonText: 'Submit',
      preConfirm: () => {
        // Add form submission logic here
        return true;
      }
    });
  }

  // Enhanced Copy full international account details
  function copyAccountDetails(currency) {
    var c = (currency || '').toUpperCase();
    var details = {
      USD: {
        bankName: 'First Bank',
        accountName: 'RCN MEDICAL CENTER',
        accountNumber: '2045578832',
        swift: '—',
        iban: '—'
      },
      GBP: {
        bankName: 'First Bank',
        accountName: 'RCN MEDICAL CENTER',
        accountNumber: '2045578894',
        swift: '—',
        iban: '—'
      },
      EUR: {
        bankName: 'First Bank',
        accountName: 'RCN MEDICAL CENTER',
        accountNumber: '2045578966',
        swift: '—',
        iban: '—'
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