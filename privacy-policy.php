<?php
$page_title = 'Privacy Policy';
$page_description = 'How we handle your information and keep data secure.';
$hero_enable = false;
$hero_background = 'assets/images/hero1.jpg';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Modern Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
  <div class="absolute inset-0 opacity-20 pointer-events-none">
    <div class="absolute inset-0" style="background-image: url('<?php echo url($hero_background); ?>'); background-size: cover; background-position: center;"></div>
  </div>
  <div class="absolute top-0 left-0 right-0 bottom-0 opacity-10 pointer-events-none">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse">
          <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1.5" />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#grid)" />
    </svg>
  </div>
  <div class="relative z-10 max-w-7xl mx-auto px-4 py-24">
    <div class="max-w-3xl mx-auto text-center">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        Commitment to Privacy
      </div>
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Privacy Policy</h1>
      <p class="text-lg text-white/90">We value your privacy and handle data responsibly in line with our mission.</p>
    </div>
  </div>
</section>

<!-- Main Content Section -->
<section class="bg-gray-50 py-16">
  <div class="max-w-6xl mx-auto px-4">
    <!-- Quick Overview Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-12">
      <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 text-center">
        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900 mb-2">Data We Collect</h3>
        <p class="text-gray-600 text-sm">Basic contact details for donations, outreach registration, and newsletter updates.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 text-center">
        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900 mb-2">How We Use Data</h3>
        <p class="text-gray-600 text-sm">To process donations, communicate updates, and improve our outreach programs.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 text-center">
        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900 mb-2">Your Choices</h3>
        <p class="text-gray-600 text-sm">You can request updates or deletion of your information by contacting us.</p>
      </div>
    </div>

    <!-- Detailed Policy Content -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
      <!-- Table of Contents -->
      <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Navigation</h3>
        <div class="flex flex-wrap gap-4">
          <a href="#information-collection" class="inline-flex items-center px-4 py-2 bg-white rounded-lg text-gray-700 hover:text-blue-600 transition-colors text-sm font-medium shadow-sm">
            Information Collection
          </a>
          <a href="#data-usage" class="inline-flex items-center px-4 py-2 bg-white rounded-lg text-gray-700 hover:text-blue-600 transition-colors text-sm font-medium shadow-sm">
            Data Usage
          </a>
          <a href="#data-protection" class="inline-flex items-center px-4 py-2 bg-white rounded-lg text-gray-700 hover:text-blue-600 transition-colors text-sm font-medium shadow-sm">
            Data Protection
          </a>
          <a href="#your-rights" class="inline-flex items-center px-4 py-2 bg-white rounded-lg text-gray-700 hover:text-blue-600 transition-colors text-sm font-medium shadow-sm">
            Your Rights
          </a>
        </div>
      </div>

      <div class="p-8">
        <!-- Introduction -->
        <div class="mb-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Commitment to Your Privacy</h2>
          <p class="text-gray-600 leading-relaxed">
            At RCN Mission Hospital, we are committed to protecting your privacy and handling your personal information with care and respect. 
            This Privacy Policy explains how we collect, use, and protect your information in alignment with our mission of compassionate service.
          </p>
        </div>

        <!-- Information Collection -->
        <div id="information-collection" class="mb-8">
          <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
              <span class="text-blue-600 font-semibold">1</span>
            </div>
            Information We Collect
          </h3>
          <div class="bg-gray-50 rounded-lg p-6">
            <h4 class="font-semibold text-gray-900 mb-3">Personal Information</h4>
            <ul class="space-y-2 text-gray-600">
              <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Contact information (name, email, phone number)</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Donation and payment information</span>
              </li>
              <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Communication preferences</span>
              </li>
            </ul>
          </div>
        </div>

        <!-- Data Usage -->
        <div id="data-usage" class="mb-8">
          <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
              <span class="text-green-600 font-semibold">2</span>
            </div>
            How We Use Your Information
          </h3>
          <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-green-50 rounded-lg p-5">
              <h4 class="font-semibold text-gray-900 mb-2">Mission Operations</h4>
              <ul class="space-y-1 text-gray-600 text-sm">
                <li>• Process donations and payments</li>
                <li>• Coordinate volunteer activities</li>
                <li>• Manage outreach programs</li>
                <li>• Provide medical mission support</li>
              </ul>
            </div>
            <div class="bg-blue-50 rounded-lg p-5">
              <h4 class="font-semibold text-gray-900 mb-2">Communication</h4>
              <ul class="space-y-1 text-gray-600 text-sm">
                <li>• Send mission updates and reports</li>
                <li>• Share prayer requests</li>
                <li>• Provide donation receipts</li>
                <li>• Respond to inquiries</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Data Protection -->
        <div id="data-protection" class="mb-8">
          <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
              <span class="text-purple-600 font-semibold">3</span>
            </div>
            Data Protection & Security
          </h3>
          <div class="bg-white border border-gray-200 rounded-lg p-6">
            <div class="flex items-start mb-4">
              <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900 mb-2">Security Measures</h4>
                <p class="text-gray-600 text-sm">
                  We implement appropriate technical and organizational security measures to protect your personal information 
                  against unauthorized access, alteration, disclosure, or destruction. All financial transactions are processed 
                  through secure, encrypted payment gateways.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Your Rights -->
        <div id="your-rights" class="mb-8">
          <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
              <span class="text-orange-600 font-semibold">4</span>
            </div>
            Your Privacy Rights
          </h3>
          <div class="bg-orange-50 rounded-lg p-6">
            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <h4 class="font-semibold text-gray-900 mb-3">Your Control Over Data</h4>
                <ul class="space-y-2 text-gray-600">
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-orange-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    <span>Access and review your personal information</span>
                  </li>
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-orange-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    <span>Request corrections to inaccurate data</span>
                  </li>
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-orange-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    <span>Opt-out of marketing communications</span>
                  </li>
                </ul>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900 mb-3">Request Data Actions</h4>
                <ul class="space-y-2 text-gray-600">
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-orange-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    <span>Request deletion of your information</span>
                  </li>
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-orange-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    <span>Export your data in portable format</span>
                  </li>
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-orange-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    <span>Restrict processing of your data</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Contact Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white text-center">
          <h3 class="text-2xl font-bold mb-4">Questions About Your Privacy?</h3>
          <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
            We're here to help you understand our privacy practices and address any concerns you may have about your personal information.
          </p>
          <div class="flex flex-wrap justify-center gap-4">
            <a href="<?php echo url('contact'); ?>" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
              </svg>
              Contact Our Team
            </a>
            <a href="mailto:privacy@rcnmissionhospital.org" class="inline-flex items-center px-6 py-3 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white/10 transition-colors">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              Email Privacy Team
            </a>
          </div>
        </div>

        <!-- Last Updated -->
        <div class="mt-8 text-center">
          <p class="text-gray-500 text-sm">
            Last updated: <?php echo date('F j, Y'); ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>