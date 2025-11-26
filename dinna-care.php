<?php
$page_title = 'Dinna Care - Reproductive & Maternal Health Support';
$page_description = 'Compassionate outreach and community care initiatives focused on women\'s health and reproductive justice.';
$hero_enable = false;
$hero_background = 'assets/images/hero2.jpg';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Modern Hero Section -->
<section class="relative bg-gradient-to-br from-indigo-900 via-purple-800 to-pink-700 text-white overflow-hidden min-h-[70vh] flex items-center">
  <div class="absolute inset-0 opacity-20">
    <div class="absolute inset-0" style="background-image: url('<?php echo url($hero_background); ?>'); background-size: cover; background-position: center;"></div>
  </div>
  
  <!-- Animated background elements -->
  <div class="absolute top-0 left-0 right-0 bottom-0 opacity-10">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-white rounded-full mix-blend-overlay filter blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-pink-300 rounded-full mix-blend-overlay filter blur-3xl"></div>
  </div>
  
  <div class="relative z-10 max-w-7xl mx-auto px-4 w-full">
    <div class="max-w-2xl">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        Community Care & Education
      </div>
      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Dinna Care</h1>
      <p class="text-xl text-white/90 mb-8 max-w-lg">Compassionate outreach and community care initiatives focused on women's health and reproductive justice.</p>
      <div class="flex flex-wrap gap-4">
        <a href="#programs" class="px-6 py-3 bg-white text-indigo-900 font-semibold rounded-lg hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-1">
          Our Programs
        </a>
        <a href="#impact" class="px-6 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white/10 transition-all duration-300">
          Our Impact
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Introduction Section -->
<section class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Holistic Community Transformation</h2>
        <p class="text-lg text-gray-700 mb-6">
          Dinna Care is part of RCN's integrated approach to community transformation, focusing specifically on women's health, reproductive justice, and adolescent care.
        </p>
        <p class="text-lg text-gray-700 mb-8">
          Through our initiatives, we provide essential healthcare services, education, and support to women and girls across Nigeria, restoring dignity and improving maternal and neonatal survival rates.
        </p>
        <div class="flex items-center space-x-4">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
              <i class="fas fa-female text-indigo-600"></i>
            </div>
            <span class="font-medium">Women's Health</span>
          </div>
          <div class="flex items-center">
            <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-3">
              <i class="fas fa-baby text-pink-600"></i>
            </div>
            <span class="font-medium">Maternal Care</span>
          </div>
        </div>
      </div>
      <div class="relative">
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-1 shadow-xl">
          <div class="bg-white rounded-xl p-6 h-full">
            <div class="space-y-4">
              <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                  <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-heart text-indigo-600 text-sm"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="font-semibold text-gray-900">Integrated Healthcare</h3>
                  <p class="text-gray-600 mt-1">Combining medical missions, preventive healthcare, and professional capacity-building.</p>
                </div>
              </div>
              <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                  <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-hands-helping text-purple-600 text-sm"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="font-semibold text-gray-900">Community Partnerships</h3>
                  <p class="text-gray-600 mt-1">Collaborating with local and international partners to enhance healthcare delivery.</p>
                </div>
              </div>
              <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                  <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-graduate text-pink-600 text-sm"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="font-semibold text-gray-900">Education & Empowerment</h3>
                  <p class="text-gray-600 mt-1">Providing health education and resources to empower women and girls.</p>
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
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">Dinna Care focuses on three key areas to support women's health and reproductive justice</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Program 1 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="h-2 bg-indigo-500"></div>
        <div class="p-6">
          <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-school text-indigo-600 text-xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">School Medical Missions</h3>
          <ul class="space-y-2 text-gray-600">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>School Hygiene and Nutrition Campaign</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Rural School Deworming Campaign</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>School Clinics first aid support</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Menstrual hygiene education and sanitary pad provision</span>
            </li>
          </ul>
        </div>
      </div>
      
      <!-- Program 2 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="h-2 bg-purple-500"></div>
        <div class="p-6">
          <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-female text-purple-600 text-xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Reproductive Healthcare</h3>
          <ul class="space-y-2 text-gray-600">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Free antenatal services and investigations</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Female medical and cancer screening services</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Reproductive health counseling for married women</span>
            </li>
          </ul>
        </div>
      </div>
      
      <!-- Program 3 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="h-2 bg-pink-500"></div>
        <div class="p-6">
          <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-hand-holding-heart text-pink-600 text-xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Specialized Support Services</h3>
          <ul class="space-y-2 text-gray-600">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Free Obstetric Fistula Repair Campaigns</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Cancer support services for women and girls</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Safe deliveries for displaced pregnant women</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Impact Section -->
<section id="impact" class="py-16 bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold mb-4">Our Impact</h2>
      <p class="text-lg text-indigo-100 max-w-2xl mx-auto">Through dedicated service and community partnerships, Dinna Care has made a tangible difference in women's health across Nigeria</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">1000+</div>
        <div class="text-indigo-100">Women screened for cancer</div>
      </div>
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">500+</div>
        <div class="text-indigo-100">Safe deliveries for displaced women</div>
      </div>
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">50+</div>
        <div class="text-indigo-100">Schools reached with health education</div>
      </div>
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">2000+</div>
        <div class="text-indigo-100">Girls provided with menstrual hygiene support</div>
      </div>
    </div>
    
    <div class="mt-12 bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
      <h3 class="text-xl font-bold mb-4 text-center">Apostolic Vision and Impact</h3>
      <p class="text-center text-indigo-100 max-w-3xl mx-auto">
        In harmony with his long-standing commitment to philanthropy and community service, Apostle Arome Osayi's healthcare vision through Dinna Care has become a living testimony of applied theology: turning faith into care, and doctrine into deliverance.
      </p>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-white">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Join Us in Making a Difference</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
      Whether through volunteering, partnerships, or donations, your support helps us continue our vital work in women's health and community care.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="#" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors duration-300">
        Get Involved
      </a>
      <a href="#" class="px-6 py-3 bg-white border-2 border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition-colors duration-300">
        Donate Now
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>