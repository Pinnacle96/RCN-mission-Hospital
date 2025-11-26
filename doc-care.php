<?php
$page_title = 'DOC Care - Building Healthcare Capacity for the Future';
$page_description = 'Healthcare workforce training, skill development, and professional capacity-building initiatives.';
$hero_enable = false;
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Modern Hero Section -->
<section class="relative bg-gradient-to-br from-teal-900 via-blue-800 to-indigo-900 text-white overflow-hidden min-h-[60vh] flex items-center">
  <div class="absolute inset-0 opacity-25">
    <div class="absolute inset-0" style="background-image: url('<?php echo url('assets/images/hero2.jpg'); ?>'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/40"></div>
  </div>
  
  <!-- Animated background elements -->
  <div class="absolute top-0 left-0 right-0 bottom-0 opacity-10">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-teal-300 rounded-full mix-blend-overlay filter blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-overlay filter blur-3xl"></div>
  </div>
  
  <div class="relative z-10 max-w-7xl mx-auto px-4 w-full">
    <div class="max-w-2xl">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        Healthcare Capacity Building
      </div>
      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">DOC Care</h1>
      <p class="text-xl text-white/90 mb-8 max-w-lg">Building healthcare capacity for the future through workforce training and professional development.</p>
      <div class="flex flex-wrap gap-4">
        <a href="#programs" class="px-6 py-3 bg-white text-teal-900 font-semibold rounded-lg hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-1">
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
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Building Healthcare Capacity for the Future</h2>
        <p class="text-lg text-gray-700 mb-6">
          Recognizing that sustainable healthcare transformation requires skilled hands, DOC Care strengthens Nigeria's healthcare workforce through comprehensive training and support programs.
        </p>
        <p class="text-lg text-gray-700 mb-8">
          Our initiatives empower young healthcare professionals with the skills, resources, and ethical foundation needed to serve in rural and underserved communities.
        </p>
        <div class="flex items-center space-x-4">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center mr-3">
              <i class="fas fa-user-md text-teal-600"></i>
            </div>
            <span class="font-medium">Workforce Training</span>
          </div>
          <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
              <i class="fas fa-graduation-cap text-blue-600"></i>
            </div>
            <span class="font-medium">Skill Development</span>
          </div>
        </div>
      </div>
      <div class="relative">
        <div class="bg-gradient-to-br from-teal-500 to-blue-600 rounded-2xl p-1 shadow-xl">
          <div class="bg-white rounded-xl p-6 h-full">
            <div class="space-y-4">
              <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                  <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-hands-helping text-teal-600 text-sm"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="font-semibold text-gray-900">Sustainable Transformation</h3>
                  <p class="text-gray-600 mt-1">Empowering systems to serve humanity in righteousness and compassion.</p>
                </div>
              </div>
              <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                  <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-blue-600 text-sm"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="font-semibold text-gray-900">Rural Deployment</h3>
                  <p class="text-gray-600 mt-1">Supporting healthcare professionals in underserved communities.</p>
                </div>
              </div>
              <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                  <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-flask text-indigo-600 text-sm"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="font-semibold text-gray-900">Clinical Research</h3>
                  <p class="text-gray-600 mt-1">Facilitating research collaborations and evidence-based interventions.</p>
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
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">DOC Care focuses on two key areas to build sustainable healthcare capacity</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Program 1 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="h-2 bg-teal-500"></div>
        <div class="p-6">
          <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-users-cog text-teal-600 text-xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">H-WORSSIP Program</h3>
          <p class="text-gray-600 mb-4">Healthcare Workforce Skills and Support Intervention Program</p>
          <ul class="space-y-2 text-gray-600">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Clinical workforce training and development</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Clinical workforce skill transfer programs</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Support for healthcare professionals in rural communities</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Establishment and support of rural health posts</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Clinical research collaborations and interventions</span>
            </li>
          </ul>
        </div>
      </div>
      
      <!-- Program 2 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="h-2 bg-blue-500"></div>
        <div class="p-6">
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
            <i class="fas fa-briefcase-medical text-blue-600 text-xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Workgroups Healthcare</h3>
          <p class="text-gray-600 mb-4">Workplace health and safety initiatives</p>
          <ul class="space-y-2 text-gray-600">
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Workgroup medical outreaches and health screenings</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Substance abuse counseling and rehabilitation programs</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Workplace safety campaigns and training</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Mental health support for healthcare workers</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
              <span>Healthcare ethics and professional development</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Approach</h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">Building sustainable healthcare systems through comprehensive capacity development</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="text-center">
        <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-brain text-teal-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Knowledge Transfer</h3>
        <p class="text-gray-600">Equipping healthcare professionals with advanced clinical skills and evidence-based practices.</p>
      </div>
      
      <div class="text-center">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-handshake text-blue-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Community Integration</h3>
        <p class="text-gray-600">Supporting healthcare workers in rural deployment and community health post establishment.</p>
      </div>
      
      <div class="text-center">
        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-shield-alt text-indigo-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Workplace Wellness</h3>
        <p class="text-gray-600">Promoting mental health, safety, and ethical practices in healthcare environments.</p>
      </div>
    </div>
  </div>
</section>

<!-- Impact Section -->
<section id="impact" class="py-16 bg-gradient-to-r from-teal-600 to-blue-700 text-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold mb-4">Our Impact</h2>
      <p class="text-lg text-teal-100 max-w-2xl mx-auto">Through dedicated workforce development and capacity building, DOC Care is shaping the future of healthcare in Nigeria</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">200+</div>
        <div class="text-teal-100">Healthcare Professionals Trained</div>
      </div>
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">15+</div>
        <div class="text-teal-100">Rural Health Posts Supported</div>
      </div>
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">50+</div>
        <div class="text-teal-100">Workplace Safety Campaigns</div>
      </div>
      <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20">
        <div class="text-3xl font-bold mb-2">1000+</div>
        <div class="text-teal-100">Workers Reached Through Outreach</div>
      </div>
    </div>
    
    <div class="mt-12 bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
      <h3 class="text-xl font-bold mb-4 text-center">Apostolic Vision and Impact</h3>
      <p class="text-center text-teal-100 max-w-3xl mx-auto">
        In harmony with his long-standing commitment to philanthropy and community service, Apostle Arome Osayi's healthcare vision through DOC Care empowers systems to serve humanity in righteousness and compassion, building sustainable healthcare capacity for future generations.
      </p>
      <div class="mt-6 flex justify-center">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 text-sm">
          <i class="fas fa-graduation-cap mr-2"></i>
          Empowering healthcare professionals for transformative service
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-white">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Join Our Capacity Building Mission</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
      Whether you're a healthcare professional, educator, researcher, or donor, your support helps us build sustainable healthcare systems across Nigeria.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="#" class="px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors duration-300">
        Become a Trainer
      </a>
      <a href="#" class="px-6 py-3 bg-white border-2 border-teal-600 text-teal-600 font-semibold rounded-lg hover:bg-teal-50 transition-colors duration-300">
        Support Our Programs
      </a>
      <a href="#" class="px-6 py-3 bg-gray-900 text-white font-semibold rounded-lg hover:bg-gray-800 transition-colors duration-300">
        Research Partnerships
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>