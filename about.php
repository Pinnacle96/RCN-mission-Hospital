<?php
$page_title = 'About RCN Mission Hospital';
$page_description = 'Learn about our faith-driven medical missions serving communities with compassionate care and the love of Christ.';
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Modern Hero Section (Keeping as is) -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-20">
    <div class="absolute inset-0"
      style="background-image: url('<?php echo url('assets/images/hero3.jpg'); ?>'); background-size: cover; background-position: center;">
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
        Serving With Compassion Since 2023
      </div>

      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight" style="font-family: Poppins, sans-serif;">
        About <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">RCN
          Mission Hospital</span>
      </h1>

      <p class="text-xl text-white/90 mb-8 leading-relaxed">
        We serve with compassion, excellence, and faith-filled hope. Through Arome Care, we provide holistic
        healthcare — body, mind, and spirit — restoring dignity and purpose in every person we serve.
      </p>

      <div class="flex flex-wrap gap-4">
        <a href="<?php echo url('get-involved'); ?>"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium text-white transition-all duration-300 transform hover:scale-105 shadow-lg"
          style="background: <?php echo RCN_GRADIENT; ?>">
          Join Our Mission
        </a>

        <a href="<?php echo url('contact'); ?>"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white/30 text-white hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
          Contact Our Team
        </a>
      </div>
    </div>
  </div>
</section>

<!--  -->

<!-- Compact Patient Support Services -->
<section class="bg-white py-16">
  <div class="max-w-6xl mx-auto px-4">
    <div class="text-center max-w-2xl mx-auto mb-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Comprehensive Patient Support</h2>
      <p class="text-gray-600">Navigation • Counselling • Financial Guidance • Spiritual Care</p>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center border border-blue-200">
        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mx-auto mb-4 shadow-sm">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900">Navigation</h3>
      </div>
      <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center border border-green-200">
        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mx-auto mb-4 shadow-sm">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900">Counselling</h3>
      </div>
      <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center border border-purple-200">
        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mx-auto mb-4 shadow-sm">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900">Financial Guidance</h3>
      </div>
      <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 text-center border border-orange-200">
        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mx-auto mb-4 shadow-sm">
          <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900">Spiritual Care</h3>
      </div>
    </div>
  </div>
</section>

<!-- Compact Services Section -->
<section class="bg-gray-50 py-16">
  <div class="max-w-6xl mx-auto px-4">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Medical Services</h2>
        <p class="text-gray-600 leading-relaxed mb-6">Under Arome Care, we offer comprehensive healthcare services delivered with professional expertise and compassionate care.</p>
        <p class="italic text-gray-800 mb-8">"And whatever you do, do it heartily, as to the Lord and not to men." (Colossians 3:23)</p>
        <a href="<?php echo url('services'); ?>" class="inline-flex items-center px-6 py-3 rounded-lg text-white font-medium shadow-sm hover:shadow-md transition" style="background: <?php echo RCN_GRADIENT; ?>;">
          View All Services
        </a>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
          <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">General Medicine</h3>
          <p class="text-sm text-gray-600">Primary and acute care with compassionate clinicians</p>
        </div>
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
          <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">Surgery</h3>
          <p class="text-sm text-gray-600">Safe procedures by skilled surgical teams</p>
        </div>
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
          <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">Maternal & Child Health</h3>
          <p class="text-sm text-gray-600">Maternity, neonatal, and paediatric services</p>
        </div>
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
          <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">Diagnostics & Labs</h3>
          <p class="text-sm text-gray-600">Evidence-based testing for precise care</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Compact Community Outreach -->
<section class="bg-white py-16">
  <div class="max-w-6xl mx-auto px-4">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <div class="relative">
        <img src="<?php echo url('assets/images/hero4.jpg'); ?>" alt="Community outreach" class="rounded-xl shadow-lg w-full h-64 object-cover">
        <div class="absolute -bottom-4 -right-4 bg-white rounded-lg shadow-lg p-4 border border-gray-100">
          <div class="text-2xl font-bold text-gray-900 mb-1">1000+</div>
          <div class="text-sm text-gray-600">Screenings Conducted</div>
        </div>
      </div>
      <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Community Outreach & Prevention</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Healthcare extends beyond hospital walls. Our outreach brings health education, screening, and preventive services into the community.</p>
        <p class="text-gray-600 leading-relaxed mb-6">We teach disease prevention, nutrition, maternal health, and child well‑being to build stronger, healthier communities.</p>
        <p class="italic text-gray-800 mb-6">"Carry each other's burdens, and in this way you will fulfil the law of Christ." (Galatians 6:2)</p>
        <a href="<?php echo url('outreach-report'); ?>" class="inline-flex items-center px-6 py-3 rounded-lg text-white font-medium shadow-sm hover:shadow-md transition" style="background: <?php echo RCN_GRADIENT; ?>;">
          See Outreach Reports
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Compact Mission & Vision -->
<section class="bg-gray-50 py-16">
  <div class="max-w-6xl mx-auto px-4">
    <div class="grid lg:grid-cols-2 gap-12 items-start">
      <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission & Vision</h2>
        <p class="text-gray-600 leading-relaxed mb-8">
          RCN Mission Hospital exists to provide excellent medical care while sharing the love of Christ with
          underserved communities around the world.
        </p>
        
        <div class="space-y-6">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">Our Mission</h3>
              <p class="text-gray-600 text-sm">To demonstrate God's love by providing quality healthcare, sharing the Gospel, and empowering communities through sustainable medical missions.</p>
            </div>
          </div>
          
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">Our Vision</h3>
              <p class="text-gray-600 text-sm">A world where every person has access to compassionate healthcare and the opportunity to experience the healing power of Jesus Christ.</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Our Mandate</h3>
        <div class="space-y-4">
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
              <span class="text-white text-sm font-bold">1</span>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">Healing</h4>
              <p class="text-gray-600 text-sm">Providing evidence-based, high-quality clinical care to individuals and families — especially the underserved and vulnerable.</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
              <span class="text-white text-sm font-bold">2</span>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">Teaching</h4>
              <p class="text-gray-600 text-sm">Training the next generation of healthcare workers through skills-building, mentorship, and medical missions.</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
              <span class="text-white text-sm font-bold">3</span>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">Transformation</h4>
              <p class="text-gray-600 text-sm">Rural outreaches, preventive health education, maternal-child interventions, and compassionate humanitarian action.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Compact Values Section -->
<section class="bg-white py-16">
  <div class="max-w-6xl mx-auto px-4">
    <div class="text-center max-w-2xl mx-auto mb-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Core Values</h2>
      <p class="text-gray-600">These principles guide everything we do in our mission to serve communities with excellence and compassion.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900 mb-3">Compassionate Care</h3>
        <p class="text-gray-600 text-sm">We treat every patient with the love and dignity they deserve, seeing each person as made in God's image.</p>
      </div>

      <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900 mb-3">Medical Excellence</h3>
        <p class="text-gray-600 text-sm">We maintain the highest standards of medical practice, ensuring quality care that communities can trust.</p>
      </div>

      <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
        </div>
        <h3 class="font-semibold text-gray-900 mb-3">Spiritual Integrity</h3>
        <p class="text-gray-600 text-sm">We integrate prayer and Gospel sharing into our medical work, offering holistic healing for body and soul.</p>
      </div>
    </div>
  </div>
</section>

<!-- Compact Story Section -->
<section class="bg-gray-50 py-16">
  <div class="max-w-6xl mx-auto px-4">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
        <div class="space-y-4 text-gray-600">
          <p>RCN Mission Hospital stands as a beacon of compassion, excellence, and faith-driven healthcare in Makurdi, Benue State. Born out of the apostolic vision of the Remnant Christian Network (RCN) led by Apostle Dr Arome Osayi.</p>
          <p>At RCN Mission Hospital, AromeCare represents our commitment to accessible, dignified, and quality healthcare for all — especially the indigent, less privileged, and underserved populations.</p>
          <p>We function not merely as a hospital, but as a mission — a place where medicine meets mercy, where compassion meets competence, and where every patient encounter becomes an opportunity to restore hope.</p>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-6">
          <div class="text-center">
            <div class="text-2xl font-bold text-gray-900 mb-1">10,000+</div>
            <div class="text-gray-600 text-sm">Patients Served</div>
          </div>
          <div class="text-center">
            <div class="text-2xl font-bold text-gray-900 mb-1">50+</div>
            <div class="text-gray-600 text-sm">Mission Trips</div>
          </div>
          <div class="text-center">
            <div class="text-2xl font-bold text-gray-900 mb-1">500+</div>
            <div class="text-gray-600 text-sm">Volunteers</div>
          </div>
          <div class="text-center">
            <div class="text-2xl font-bold text-gray-900 mb-1">100+</div>
            <div class="text-gray-600 text-sm">Local Partners</div>
          </div>
        </div>
      </div>
      <div class="relative">
        <img src="<?php echo url('assets/images/hero1.jpg'); ?>" alt="RCN Mission Hospital team" class="rounded-xl shadow-lg w-full h-80 object-cover">
        <div class="absolute -bottom-4 -right-4 bg-white rounded-lg shadow-lg p-4 border border-gray-100">
          <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo max(1, (int)date('Y') - 2023) . '+'; ?></div>
          <div class="text-sm text-gray-600">Years of Service</div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Leadership Team Section -->
<section class="bg-gradient-to-br from-gray-50 to-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Our Leadership Team</h2>
      <p class="text-xl text-gray-600 leading-relaxed">Dedicated professionals committed to serving with
        excellence and compassion.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php
      require_once __DIR__ . '/config/db.php';
      $leaders = [];
      try {
        $stmt = db()->prepare('SELECT m.* FROM team_members m JOIN team_groups g ON m.group_id=g.id WHERE g.slug=? AND m.active=1 ORDER BY m.sort_order, m.id');
        $stmt->execute(['leadership']);
        $leaders = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Throwable $e) { $leaders = []; }
      if (!empty($leaders)):
        foreach ($leaders as $m):
          $avatar = trim($m['avatar_image'] ?? '') !== '' ? $m['avatar_image'] : null;
          $initials = $m['avatar_initials'] ?? '';
      ?>
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center group hover:shadow-xl transition-all duration-500">
        <?php if ($avatar): ?>
          <img src="<?php echo url($avatar); ?>" alt="<?php echo htmlspecialchars($m['name']); ?>" class="w-24 h-24 rounded-full object-cover mx-auto mb-6">
        <?php else: ?>
          <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6"><?php echo htmlspecialchars($initials ?: substr($m['name'],0,2)); ?></div>
        <?php endif; ?>
        <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($m['name']); ?></h3>
        <?php if (!empty($m['role_title'])): ?><p class="text-blue-600 font-medium mb-4"><?php echo htmlspecialchars($m['role_title']); ?></p><?php endif; ?>
        <?php if (!empty($m['bio'])): ?><p class="text-gray-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($m['bio'])); ?></p><?php endif; ?>
        <div class="flex items-center justify-center gap-4">
          <?php if (!empty($m['twitter_url'])): ?><a href="<?php echo htmlspecialchars($m['twitter_url']); ?>" aria-label="Twitter" class="text-gray-500 hover:text-blue-500 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0016 2a4.5 4.5 0 00-4.5 4.5c0 .35.04.69.12 1A12.82 12.82 0 013 3s-4 9 5 13a13.28 13.28 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a><?php endif; ?>
          <?php if (!empty($m['facebook_url'])): ?><a href="<?php echo htmlspecialchars($m['facebook_url']); ?>" aria-label="Facebook" class="text-gray-500 hover:text-blue-700 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.5 9.9v-7h-2.2V12h2.2V9.8c0-2.2 1.3-3.5 3.3-3.5.95 0 1.9.17 1.9.17v2.1h-1.1c-1.1 0-1.4.7-1.4 1.4V12h2.4l-.4 2.9h-2v7A10 10 0 0022 12z"/></svg></a><?php endif; ?>
          <?php if (!empty($m['linkedin_url'])): ?><a href="<?php echo htmlspecialchars($m['linkedin_url']); ?>" aria-label="LinkedIn" class="text-gray-500 hover:text-blue-600 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM0 8h5v16H0V8zm7 0h4.8v2.2h.07c.67-1.27 2.3-2.6 4.73-2.6C20.55 7.6 24 10.1 24 15.2V24h-5v-7.2c0-1.7-.03-3.9-2.4-3.9-2.4 0-2.76 1.86-2.76 3.8V24H7V8z"/></svg></a><?php endif; ?>
        </div>
      </div>
      <?php endforeach; else: ?>
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center group hover:shadow-xl transition-all duration-500">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6">CO</div>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Dr. Chuks O.</h3>
        <p class="text-blue-600 font-medium mb-4">Medical Director</p>
        <p class="text-gray-600 leading-relaxed">Board-certified physician with 20+ years of medical mission
          experience and a passion for training local healthcare workers.</p>
      </div>
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center group hover:shadow-xl transition-all duration-500">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6">SM</div>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Sarah Martinez</h3>
        <p class="text-green-600 font-medium mb-4">Operations Director</p>
        <p class="text-gray-600 leading-relaxed">Oversees mission logistics and volunteer coordination with 15
          years of experience in international humanitarian work.</p>
      </div>
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center group hover:shadow-xl transition-all duration-500">
        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6">PR</div>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Pastor Robert Chen</h3>
        <p class="text-purple-600 font-medium mb-4">Spiritual Director</p>
        <p class="text-gray-600 leading-relaxed">Provides spiritual leadership and ensures the integration of
          faith and medical care in all our mission activities.</p>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Our Team Section (Tabbed) -->
<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-end justify-between mb-10">
      <div>
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900">Our Team</h2>
        <p class="text-gray-600 mt-3">Meet the people who serve with skill and compassion.</p>
      </div>
      <div class="flex gap-2" role="tablist" aria-label="Team categories">
        <button class="tab-btn px-4 py-2 rounded-lg font-medium text-white shadow transition focus:outline-none"
                style="background: <?php echo RCN_GRADIENT; ?>" data-target="team-medical" aria-selected="true">
          Medical Team
        </button>
      </div>
    </div>

    <!-- Leadership Tab -->
    

    <!-- Medical Team Tab -->
    <div id="team-medical" class="tab-panel">
      <div class="relative" data-center-slider>
        <div class="overflow-hidden">
          <div class="flex gap-8" data-track>
            <?php
            require_once __DIR__ . '/config/db.php';
            require_once __DIR__ . '/includes/logger.php';
            $members_med = [];
            try {
              $stmt = db()->prepare("SELECT m.*\n                 FROM team_members m\n                 JOIN team_groups g ON m.group_id = g.id\n                 WHERE g.active = 1 AND m.active = 1\n                   AND (g.slug = ? OR LOWER(g.name) LIKE ?)\n                 ORDER BY m.sort_order, m.id");
              $stmt->execute(['medical', '%medical%']);
              $members_med = $stmt->fetchAll(PDO::FETCH_ASSOC);
              log_info('about_team_medical', 'Fetched members', ['count' => count($members_med)]);
              if (empty($members_med)) {
                $gs = db()->query('SELECT id, slug, name, active FROM team_groups ORDER BY sort_order, id')->fetchAll(PDO::FETCH_ASSOC);
                $ms = db()->query('SELECT id, group_id, name, active FROM team_members ORDER BY id DESC LIMIT 100')->fetchAll(PDO::FETCH_ASSOC);
                log_info('about_team_medical', 'No medical members found', ['groups' => $gs, 'members' => $ms]);
              }
            } catch (Throwable $e) { 
              log_error('about_team_medical', 'Query failed', ['error' => $e->getMessage()]);
              $members_med = []; 
            }
            if (!empty($members_med)):
              foreach ($members_med as $m):
                $avatar = trim($m['avatar_image'] ?? '') !== '' ? $m['avatar_image'] : null;
                $initials = $m['avatar_initials'] ?? '';
            ?>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
              <?php if ($avatar): ?>
                <img src="<?php echo url($avatar); ?>" alt="<?php echo htmlspecialchars($m['name']); ?>" class="w-24 h-24 rounded-full object-cover mx-auto mb-6">
              <?php else: ?>
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6"><?php echo htmlspecialchars($initials ?: substr($m['name'],0,2)); ?></div>
              <?php endif; ?>
              <h3 class="text-2xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($m['name']); ?></h3>
              <?php if (!empty($m['role_title'])): ?><p class="text-cyan-600 font-medium mb-4"><?php echo htmlspecialchars($m['role_title']); ?></p><?php endif; ?>
              <div class="flex items-center justify-center gap-4">
                <?php if (!empty($m['twitter_url'])): ?><a href="<?php echo htmlspecialchars($m['twitter_url']); ?>" aria-label="Twitter" class="text-gray-500 hover:text-blue-500 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0016 2a4.5 4.5 0 00-4.5 4.5c0 .35.04.69.12 1A12.82 12.82 0 013 3s-4 9 5 13a13.28 13.28 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a><?php endif; ?>
                <?php if (!empty($m['facebook_url'])): ?><a href="<?php echo htmlspecialchars($m['facebook_url']); ?>" aria-label="Facebook" class="text-gray-500 hover:text-blue-700 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.5 9.9v-7h-2.2V12h2.2V9.8c0-2.2 1.3-3.5 3.3-3.5.95 0 1.9.17 1.9.17v2.1h-1.1c-1.1 0-1.4.7-1.4 1.4V12h2.4l-.4 2.9h-2v7A10 10 0 0022 12z"/></svg></a><?php endif; ?>
                <?php if (!empty($m['linkedin_url'])): ?><a href="<?php echo htmlspecialchars($m['linkedin_url']); ?>" aria-label="LinkedIn" class="text-gray-500 hover:text-blue-600 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM0 8h5v16H0V8zm7 0h4.8v2.2h.07c.67-1.27 2.3-2.6 4.73-2.6C20.55 7.6 24 10.1 24 15.2V24h-5v-7.2c0-1.7-.03-3.9-2.4-3.9-2.4 0-2.76 1.86-2.76 3.8V24H7V8z"/></svg></a><?php endif; ?>
              </div>
            </div>
            <?php endforeach; else: ?>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
              <div class="w-24 h-24 rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6">AA</div>
              <h3 class="text-2xl font-bold text-gray-900 mb-1">Dr. Adaeze Akon</h3>
              <p class="text-cyan-600 font-medium mb-4">Lead Surgeon</p>
              <div class="flex items-center justify-center gap-4">
                <a href="#" aria-label="Twitter" class="text-gray-500 hover:text-blue-500 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0016 2a4.5 4.5 0 00-4.5 4.5c0 .35.04.69.12 1A12.82 12.82 0 013 3s-4 9 5 13a13.28 13.28 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
                <a href="#" aria-label="Facebook" class="text-gray-500 hover:text-blue-700 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.5 9.9v-7h-2.2V12h2.2V9.8c0-2.2 1.3-3.5 3.3-3.5.95 0 1.9.17 1.9.17v2.1h-1.1c-1.1 0-1.4.7-1.4 1.4V12h2.4l-.4 2.9h-2v7A10 10 0 0022 12z"/></svg></a>
                <a href="#" aria-label="LinkedIn" class="text-gray-500 hover:text-blue-600 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM0 8h5v16H0V8zm7 0h4.8v2.2h.07c.67-1.27 2.3-2.6 4.73-2.6C20.55 7.6 24 10.1 24 15.2V24h-5v-7.2c0-1.7-.03-3.9-2.4-3.9-2.4 0-2.76 1.86-2.76 3.8V24H7V8z"/></svg></a>
              </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
              <div class="w-24 h-24 rounded-full bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6">OE</div>
              <h3 class="text-2xl font-bold text-gray-900 mb-1">Nurse Oluchi Eze</h3>
              <p class="text-rose-600 font-medium mb-4">Head of Patient Care</p>
              <div class="flex items-center justify-center gap-4">
                <a href="#" aria-label="Twitter" class="text-gray-500 hover:text-blue-500 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0016 2a4.5 4.5 0 00-4.5 4.5c0 .35.04.69.12 1A12.82 12.82 0 013 3s-4 9 5 13a13.28 13.28 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
                <a href="#" aria-label="Facebook" class="text-gray-500 hover:text-blue-700 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.5 9.9v-7h-2.2V12h2.2V9.8c0-2.2 1.3-3.5 3.3-3.5.95 0 1.9.17 1.9.17v2.1h-1.1c-1.1 0-1.4.7-1.4 1.4V12h2.4l-.4 2.9h-2v7A10 10 0 0022 12z"/></svg></a>
                <a href="#" aria-label="LinkedIn" class="text-gray-500 hover:text-blue-600 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM0 8h5v16H0V8zm7 0h4.8v2.2h.07c.67-1.27 2.3-2.6 4.73-2.6C20.55 7.6 24 10.1 24 15.2V24h-5v-7.2c0-1.7-.03-3.9-2.4-3.9-2.4 0-2.76 1.86-2.76 3.8V24H7V8z"/></svg></a>
              </div>
            </div>
            <?php endif; ?>
        </div>
        <button type="button" aria-label="Previous" data-prev
                class="absolute left-0 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white border border-gray-200 shadow hover:bg-gray-50">
          <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <button type="button" aria-label="Next" data-next
                class="absolute right-0 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white border border-gray-200 shadow hover:bg-gray-50">
          <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>

    <script>
      (function(){
        var buttons = document.querySelectorAll('.tab-btn');
        var panels = document.querySelectorAll('.tab-panel');
        function showPanel(id){
          panels.forEach(function(p){ p.classList.add('hidden'); });
          var el = document.getElementById(id);
          if(el){ el.classList.remove('hidden'); }
        }
        buttons.forEach(function(btn){
          btn.addEventListener('click', function(){
            buttons.forEach(function(b){ b.setAttribute('aria-selected','false'); });
            btn.setAttribute('aria-selected','true');
            var target = btn.getAttribute('data-target');
            if(target){ showPanel(target); }
          });
        });
        showPanel('team-medical');
      })();
    </script>
  </div>
</section>

<!-- Compact CTA Section -->
<section class="bg-gradient-to-r from-blue-900 to-indigo-800 text-white py-16">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-6">Journey With Us</h2>
    <p class="text-white/90 mb-8 leading-relaxed">Join this mission of healing, hope, and transformation — whether as a patient, partner, volunteer, or friend.</p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="<?php echo url('get-involved'); ?>" class="inline-flex items-center px-6 py-3 rounded-lg bg-white text-gray-900 font-medium shadow-lg hover:shadow-xl transition-all duration-300">
        Get Involved
      </a>
      <a href="<?php echo url('contact'); ?>" class="inline-flex items-center px-6 py-3 rounded-lg border-2 border-white text-white font-medium hover:bg-white/10 transition-all duration-300">
        Contact Us
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
