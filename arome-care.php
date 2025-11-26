<?php
$page_title = 'Arome Care - Healing for the Vulnerable';
$page_description = 'Medical missions, surgical festivals, and healthcare for vulnerable communities across Nigeria.';
$hero_enable = false;
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Modern Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden min-h-[60vh] flex items-center">
  <div class="absolute inset-0 opacity-25">
    <div class="absolute inset-0" style="background-image: url('<?php echo url('assets/images/hero4.jpg'); ?>'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/40"></div>
  </div>
  
  <!-- Animated background elements -->
  <div class="absolute top-0 left-0 right-0 bottom-0 opacity-10">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-overlay filter blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl"></div>
  </div>
  
  <div class="relative z-10 max-w-7xl mx-auto px-4 w-full">
    <div class="max-w-2xl">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        Medical Missions & Surgical Care
      </div>
      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Arome Care</h1>
      <p class="text-xl text-white/90 mb-8 max-w-lg">Healing for the vulnerable through medical missions, surgical festivals, and compassionate healthcare.</p>
      <div class="flex flex-wrap gap-4">
        <a href="#programs" class="px-6 py-3 bg-white text-blue-900 font-semibold rounded-lg hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-1">
          Our Programs
        </a>
        <a href="#impact" class="px-6 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white/10 transition-all duration-300">
          Our Impact
        </a>
      </div>
    </div>
  </div>
  
  <svg class="absolute bottom-0 left-0 w-full pointer-events-none" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
    <path fill="#f8fafc" d="M0,96L60,101.3C120,107,240,117,360,106.7C480,96,600,64,720,69.3C840,75,960,117,1080,133.3C1200,149,1320,139,1380,133.3L1440,128L1440,160L1380,160C1320,160,1200,160,1080,160C960,160,840,160,720,160C600,160,480,160,360,160C240,160,120,160,60,160L0,160Z"></path>
  </svg>
</section>

<!-- Introduction Section -->
<section class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Healing for the Vulnerable</h2>
        <p class="text-lg text-gray-700 mb-6">
          AromeCare serves as the medical missions arm of RCN Medical Center, championing medical outreaches, surgical festivals, and vulnerable group healthcare campaigns.
        </p>
        <p class="text-lg text-gray-700 mb-8">
          Through these initiatives, free medical services are taken to remote and underserved areas, including internally displaced persons (IDP) camps, prisons, orphanages, and mission fields.
        </p>
        <div class="flex items-center space-x-4">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
              <i class="fas fa-stethoscope text-blue-600"></i>
            </div>
            <span class="font-medium">Medical Missions</span>
          </div>
          <div class="flex items-center">
            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
              <i class="fas fa-procedures text-purple-600"></i>
            </div>
            <span class="font-medium">Surgical Festivals</span>
          </div>
        </div>
      </div>
      <div class="relative">
        <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl p-1 shadow-xl">
          <div class="bg-white rounded-xl p-6 h-full">
            <div class="space-y-4">
              <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                  <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-hand-holding-medical text-blue-600 text-sm"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="font-semibold text-gray-900">Compassionate Care</h3>
                  <p class="text-gray-600 mt-1">Bringing healing and hope to the most vulnerable communities.</p>
                </div>
              </div>
              <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                  <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-sm"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="font-semibold text-gray-900">Community Focused</h3>
                  <p class="text-gray-600 mt-1">Serving IDP camps, prisons, orphanages, and remote areas.</p>
                </div>
              </div>
              <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                  <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-heartbeat text-indigo-600 text-sm"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="font-semibold text-gray-900">Life-Saving Surgeries</h3>
                  <p class="text-gray-600 mt-1">Providing surgical interventions for those who could never afford them.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Programs Section -->
<section id="programs" class="py-16 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Programs</h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">AromeCare focuses on four key areas to provide comprehensive healthcare to vulnerable communities</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Program 1 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="h-2 bg-blue-500"></div>
        <div class="p-6">
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-clinic-medical text-blue-600 text-xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Medical Outreaches</h3>
          <ul class="space-y-2 text-gray-600">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Medical outreaches during evangelical campaigns</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Medical missions in remote mission fields</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Mass screening for neglected tropical diseases</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Mass screening for chronic and endemic conditions</span>
            </li>
          </ul>
        </div>
      </div>
      
      <!-- Program 2 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="h-2 bg-purple-500"></div>
        <div class="p-6">
          <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-procedures text-purple-600 text-xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Surgical Festivals</h3>
          <ul class="space-y-2 text-gray-600">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Specialized surgeries (eye, cleft palate, pediatric)</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>General surgery (hernia repairs, lumpectomy, thyroidectomy)</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Lifesaving interventions for those who can't afford care</span>
            </li>
          </ul>
        </div>
      </div>
      
      <!-- Program 3 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="h-2 bg-indigo-500"></div>
        <div class="p-6">
          <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-hands-helping text-indigo-600 text-xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Vulnerable Group Campaigns</h3>
          <ul class="space-y-2 text-gray-600">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Medical missions to prisons and correctional services</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Healthcare services in IDP camps</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Medical care for motherless babies homes</span>
            </li>
          </ul>
        </div>
      </div>
      
      <!-- Program 4 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="h-2 bg-teal-500"></div>
        <div class="p-6">
          <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-hand-holding-heart text-teal-600 text-xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Healthcare Fund</h3>
          <ul class="space-y-2 text-gray-600">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Sliding scale financing of healthcare services</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Free/subsidized treatment for at-risk groups</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Healthcare financing for referred indigent patients</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Free care for vulnerable elderly</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Impact Section -->
<section id="impact" class="py-16 bg-gradient-to-r from-blue-600 to-purple-700 text-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold mb-4">Our Impact</h2>
      <p class="text-lg text-blue-100 max-w-2xl mx-auto">Through dedicated medical missions and compassionate care, AromeCare has transformed lives across Nigeria</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">50+</div>
        <div class="text-blue-100">Medical Missions Completed</div>
      </div>
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">1000+</div>
        <div class="text-blue-100">Surgical Procedures</div>
      </div>
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">25+</div>
        <div class="text-blue-100">Communities Served</div>
      </div>
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">5000+</div>
        <div class="text-blue-100">Patients Treated</div>
      </div>
    </div>
    
    <div class="mt-12 bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
      <h3 class="text-xl font-bold mb-4 text-center">Apostolic Vision and Impact</h3>
      <p class="text-center text-blue-100 max-w-3xl mx-auto">
        In harmony with his long-standing commitment to philanthropy and community service, Apostle Arome Osayi's healthcare vision through AromeCare has become a living testimony of applied theology: turning faith into care, and doctrine into deliverance.
      </p>
      <div class="mt-6 flex justify-center">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 text-sm">
          <i class="fas fa-praying-hands mr-2"></i>
          Healing care for the spirit, soul, and body
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-white">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Join Our Medical Missions</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
      Whether you're a healthcare professional, volunteer, or donor, your support helps us bring healing to vulnerable communities across Nigeria.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="#" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-300">
        Volunteer Today
      </a>
      <a href="#" class="px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors duration-300">
        Support Our Work
      </a>
      <a href="#" class="px-6 py-3 bg-gray-900 text-white font-semibold rounded-lg hover:bg-gray-800 transition-colors duration-300">
        Medical Partnerships
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>