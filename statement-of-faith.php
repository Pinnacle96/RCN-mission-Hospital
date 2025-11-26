<?php
$page_title = 'Statement of Faith - Our Core Beliefs';
$page_description = 'Our foundational beliefs rooted in Scripture, guiding our healthcare mission and compassionate service.';
$hero_enable = false;
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Modern Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden min-h-[60vh] flex items-center">
  <div class="absolute inset-0 opacity-25">
    <div class="absolute inset-0" style="background-image: url('<?php echo url('assets/images/hero3.jpg'); ?>'); background-size: cover; background-position: center;"></div>
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
        <span class="w-2 h-2 rounded-full bg-yellow-400 mr-2 animate-pulse"></span>
        Foundation of Our Mission
      </div>
      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Statement of Faith</h1>
      <p class="text-xl text-white/90 mb-8 max-w-lg">What we believe, teach, and live out in our healthcare mission.</p>
      <div class="flex flex-wrap gap-4">
        <a href="<?php echo url('about'); ?>" class="px-6 py-3 bg-white text-blue-900 font-semibold rounded-lg hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-1">
          About Our Mission
        </a>
        <a href="<?php echo url('contact'); ?>" class="px-6 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white/10 transition-all duration-300">
          Contact Us
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
  <div class="max-w-4xl mx-auto px-4 text-center">
    <div class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium mb-6">
      <i class="fas fa-cross mr-2"></i>
      Rooted in Scripture, Expressed in Service
    </div>
    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Foundation of Faith</h2>
    <p class="text-lg text-gray-700 mb-8 leading-relaxed">
      At RCN Mission Hospital, our evidence-based healthcare services are rooted in faith, compassion, and Christlike love. 
      We believe that true healing encompasses body, mind, and spirit.
    </p>
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-8 border border-blue-100">
      <blockquote class="text-xl text-gray-800 italic text-center">
        "Whatever you do, do it all for the glory of God"
        <footer class="text-lg text-gray-600 mt-2 not-italic">— 1 Corinthians 10:31</footer>
      </blockquote>
    </div>
  </div>
</section>

<!-- Core Beliefs Section -->
<section class="py-16 bg-gray-50">
  <div class="max-w-6xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Core Beliefs</h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">The foundational truths that guide our mission and shape our compassionate care</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Belief 1 -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md">
        <div class="flex items-start">
          <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-hands-praying text-blue-600 text-lg"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">The Triune God</h3>
            <p class="text-gray-700">God is the source of all life and healing: Father, Son, and Holy Spirit working in perfect unity and love.</p>
          </div>
        </div>
      </div>
      
      <!-- Belief 2 -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md">
        <div class="flex items-start">
          <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-cross text-red-600 text-lg"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Jesus Christ Our Savior</h3>
            <p class="text-gray-700">Jesus Christ is our Savior and the perfect model of compassionate care, healing, and redemption.</p>
          </div>
        </div>
      </div>
      
      <!-- Belief 3 -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md">
        <div class="flex items-start">
          <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-dove text-purple-600 text-lg"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">The Holy Spirit's Guidance</h3>
            <p class="text-gray-700">The Holy Spirit empowers our work, guiding us in excellence, wisdom, and compassionate service.</p>
          </div>
        </div>
      </div>
      
      <!-- Belief 4 -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md">
        <div class="flex items-start">
          <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-bible text-green-600 text-lg"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Scripture as Our Foundation</h3>
            <p class="text-gray-700">The Bible shapes our ethics, compassion, and integrity, providing wisdom for life and service.</p>
          </div>
        </div>
      </div>
      
      <!-- Belief 5 -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md">
        <div class="flex items-start">
          <div class="flex-shrink-0 w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-heart text-yellow-600 text-lg"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Sacredness of Human Life</h3>
            <p class="text-gray-700">Every human life is sacred, created in the image of God and deserving of dignity, respect, and care.</p>
          </div>
        </div>
      </div>
      
      <!-- Belief 6 -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md">
        <div class="flex items-start">
          <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-hand-holding-heart text-indigo-600 text-lg"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Healthcare as Ministry</h3>
            <p class="text-gray-700">Healthcare is ministry—a sacred platform to demonstrate the love of Christ to all people.</p>
          </div>
        </div>
      </div>
      
      <!-- Belief 7 -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md">
        <div class="flex items-start">
          <div class="flex-shrink-0 w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4">
            <i class="fas fa-pray text-teal-600 text-lg"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">The Power of Prayer</h3>
            <p class="text-gray-700">Prayer matters profoundly, and we honor God as the Great Physician who works through our hands.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Mission Commitment Section -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-purple-700 text-white">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-6">Our Commitment</h2>
    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
      <p class="text-xl leading-relaxed mb-6">
        We are committed to healing bodies, strengthening minds, and bringing hope through medicine, mercy, and the love of Jesus Christ.
      </p>
      <p class="text-lg text-blue-100">
        Our faith informs every aspect of our service—from clinical excellence to compassionate care—as we seek to reflect God's love to those we serve.
      </p>
    </div>
  </div>
</section>

<!-- Practical Application Section -->
<section class="py-16 bg-white">
  <div class="max-w-6xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Faith in Action</h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">How our beliefs translate into practical healthcare ministry</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="text-center">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-user-md text-blue-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Compassionate Care</h3>
        <p class="text-gray-600">Treating every patient with the dignity and compassion Christ showed to all he encountered.</p>
      </div>
      
      <div class="text-center">
        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-praying-hands text-purple-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Spiritual Support</h3>
        <p class="text-gray-600">Integrating prayer and spiritual care alongside medical treatment for holistic healing.</p>
      </div>
      
      <div class="text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-heart text-green-600 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-3">Community Service</h3>
        <p class="text-gray-600">Extending care to the most vulnerable through medical missions and outreach programs.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gray-50">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Join Us in Our Mission</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
      Whether through prayer, partnership, or service, you can be part of our faith-based healthcare mission.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="<?php echo url('contact'); ?>" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-300">
        Partner With Us
      </a>
      <a href="<?php echo url('prayer'); ?>" class="px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors duration-300">
        Prayer Support
      </a>
      <a href="<?php echo url('volunteer'); ?>" class="px-6 py-3 bg-gray-900 text-white font-semibold rounded-lg hover:bg-gray-800 transition-colors duration-300">
        Volunteer
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>