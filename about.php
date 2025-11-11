<?php
$page_title = 'About RCN Mission Hospital';
$page_description = 'Learn about our faith-driven medical missions serving communities with compassionate care and the love of Christ.';
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Modern Hero Section -->
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
        Transforming lives through faith-driven medical missions, providing compassionate healthcare and sharing
        the hope of Jesus Christ with underserved communities worldwide.
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

<!-- Mission & Vision Section -->
<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <div>
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">Our Mission & Vision</h2>
        <p class="text-xl text-gray-600 leading-relaxed mb-8">
          RCN Mission Hospital exists to provide excellent medical care while sharing the love of Christ with
          underserved communities around the world.
        </p>
        <div class="space-y-6">
          <div class="flex items-start gap-4">
            <div
              class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center flex-shrink-0">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Our Mission</h3>
              <p class="text-gray-600">To demonstrate God's love by providing quality healthcare, sharing
                the Gospel, and empowering communities through sustainable medical missions.</p>
            </div>
          </div>
          <div class="flex items-start gap-4">
            <div
              class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center flex-shrink-0">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-900 mb-2">Our Vision</h3>
              <p class="text-gray-600">A world where every person has access to compassionate healthcare
                and the opportunity to experience the healing power of Jesus Christ.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="relative">
        <img src="<?php echo url('assets/images/hero2.jpg'); ?>" alt="Medical mission team serving patients"
          class="rounded-2xl shadow-2xl w-full h-96 object-cover">
        <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
          <div class="text-3xl font-bold text-gray-900 mb-2"><?php echo max(1, (int)date('Y') - 2023) . '+'; ?></div>
          <div class="text-gray-600">Years of Service</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Values Section -->
<section class="bg-gradient-to-br from-gray-50 to-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Our Core Values</h2>
      <p class="text-xl text-gray-600 leading-relaxed">These principles guide everything we do in our mission to
        serve communities with excellence and compassion.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center group hover:shadow-xl transition-all duration-500">
        <div
          class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
            </path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Compassionate Care</h3>
        <p class="text-gray-600 leading-relaxed">We treat every patient with the love and dignity they deserve,
          seeing each person as made in God's image.</p>
      </div>

      <div
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center group hover:shadow-xl transition-all duration-500">
        <div
          class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
            </path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Medical Excellence</h3>
        <p class="text-gray-600 leading-relaxed">We maintain the highest standards of medical practice, ensuring
          quality care that communities can trust.</p>
      </div>

      <div
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center group hover:shadow-xl transition-all duration-500">
        <div
          class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-100 to-purple-50 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
            </path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Spiritual Integrity</h3>
        <p class="text-gray-600 leading-relaxed">We integrate prayer and Gospel sharing into our medical work,
          offering holistic healing for body and soul.</p>
      </div>

      <div
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center group hover:shadow-xl transition-all duration-500">
        <div
          class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-100 to-orange-50 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
            </path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Community Partnership</h3>
        <p class="text-gray-600 leading-relaxed">We work alongside local leaders and churches to ensure
          culturally relevant and sustainable impact.</p>
      </div>

      <div
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center group hover:shadow-xl transition-all duration-500">
        <div
          class="w-20 h-20 rounded-2xl bg-gradient-to-br from-red-100 to-red-50 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Empowerment Focus</h3>
        <p class="text-gray-600 leading-relaxed">We train local healthcare workers and promote preventive care
          to build self-sufficient communities.</p>
      </div>

      <div
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center group hover:shadow-xl transition-all duration-500">
        <div
          class="w-20 h-20 rounded-2xl bg-gradient-to-br from-cyan-100 to-cyan-50 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-10 h-10 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
            </path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Safety & Excellence</h3>
        <p class="text-gray-600 leading-relaxed">We prioritize the safety of our volunteers and patients while
          maintaining excellence in all our operations.</p>
      </div>
      
    </div>
  </div>
</section>

<!-- Story Section -->
<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
      <div class="relative">
        <img src="<?php echo url('assets/images/hero1.jpg'); ?>"
          alt="RCN Mission Hospital team serving together"
          class="rounded-2xl shadow-2xl w-full h-96 object-cover">
        <div
          class="absolute -bottom-6 -right-6 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-6 text-white">
          <div class="text-3xl font-bold mb-2">10,000+</div>
          <div class="text-blue-100">Patients Served</div>
        </div>
      </div>
      <div>
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Our Story</h2>
        <div class="space-y-6 text-gray-600 leading-relaxed">
          <p class="text-lg">
            RCN Mission Hospital began in 2023 with a simple vision: to bring quality healthcare and the
            hope of Jesus to communities with limited access to medical services.
          </p>
          <p>
            What started as a small team of dedicated medical professionals has grown into a movement of
            compassion, serving thousands of patients across multiple countries while maintaining our
            commitment to both physical and spiritual healing.
          </p>
          <p>
            Today, we continue to expand our reach while staying true to our founding principles - that
            every person deserves access to compassionate healthcare and the opportunity to experience God's
            love.
          </p>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-6">
          <div>
            <div class="text-2xl font-bold text-gray-900 mb-1">50+</div>
            <div class="text-gray-600">Mission Trips</div>
          </div>
          <div>
            <div class="text-2xl font-bold text-gray-900 mb-1">15</div>
            <div class="text-gray-600">Countries</div>
          </div>
          <div>
            <div class="text-2xl font-bold text-gray-900 mb-1">500+</div>
            <div class="text-gray-600">Volunteers</div>
          </div>
          <div>
            <div class="text-2xl font-bold text-gray-900 mb-1">100+</div>
            <div class="text-gray-600">Local Partners</div>
          </div>
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
        $stmt = $pdo->prepare('SELECT m.* FROM team_members m JOIN team_groups g ON m.group_id=g.id WHERE g.slug=? AND m.active=1 ORDER BY m.sort_order, m.id');
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
        <?php if (!empty($m['bio_text'])): ?><p class="text-gray-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($m['bio_text'])); ?></p><?php endif; ?>
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
                style="background: <?php echo RCN_GRADIENT; ?>" data-target="team-leadership" aria-selected="true">
          Leadership
        </button>
        <button class="tab-btn px-4 py-2 rounded-lg font-medium border border-gray-200 text-gray-700 bg-white hover:bg-gray-50 transition focus:outline-none"
                data-target="team-medical" aria-selected="false">
          Medical Team
        </button>
      </div>
    </div>

    <!-- Leadership Tab -->
    <div id="team-leadership" class="tab-panel">
      <div class="relative" data-center-slider>
        <div class="overflow-hidden">
          <div class="flex gap-8" data-track>
            <?php
            require_once __DIR__ . '/config/db.php';
            $members_lead = [];
            try {
              $stmt = $pdo->prepare('SELECT m.* FROM team_members m JOIN team_groups g ON m.group_id=g.id WHERE g.slug=? AND m.active=1 ORDER BY m.sort_order, m.id');
              $stmt->execute(['leadership']);
              $members_lead = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Throwable $e) { $members_lead = []; }
            if (!empty($members_lead)):
              foreach ($members_lead as $m):
                $avatar = trim($m['avatar_image'] ?? '') !== '' ? $m['avatar_image'] : null;
                $initials = $m['avatar_initials'] ?? '';
            ?>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
              <?php if ($avatar): ?>
                <img src="<?php echo url($avatar); ?>" alt="<?php echo htmlspecialchars($m['name']); ?>" class="w-24 h-24 rounded-full object-cover mx-auto mb-6">
              <?php else: ?>
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6"><?php echo htmlspecialchars($initials ?: substr($m['name'],0,2)); ?></div>
              <?php endif; ?>
              <h3 class="text-2xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($m['name']); ?></h3>
              <?php if (!empty($m['role_title'])): ?><p class="text-blue-600 font-medium mb-4"><?php echo htmlspecialchars($m['role_title']); ?></p><?php endif; ?>
              <div class="flex items-center justify-center gap-4">
                <?php if (!empty($m['twitter_url'])): ?><a href="<?php echo htmlspecialchars($m['twitter_url']); ?>" aria-label="Twitter" class="text-gray-500 hover:text-blue-500 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0016 2a4.5 4.5 0 00-4.5 4.5c0 .35.04.69.12 1A12.82 12.82 0 013 3s-4 9 5 13a13.28 13.28 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a><?php endif; ?>
                <?php if (!empty($m['facebook_url'])): ?><a href="<?php echo htmlspecialchars($m['facebook_url']); ?>" aria-label="Facebook" class="text-gray-500 hover:text-blue-700 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.5 9.9v-7h-2.2V12h2.2V9.8c0-2.2 1.3-3.5 3.3-3.5.95 0 1.9.17 1.9.17v2.1h-1.1c-1.1 0-1.4.7-1.4 1.4V12h2.4l-.4 2.9h-2v7A10 10 0 0022 12z"/></svg></a><?php endif; ?>
                <?php if (!empty($m['linkedin_url'])): ?><a href="<?php echo htmlspecialchars($m['linkedin_url']); ?>" aria-label="LinkedIn" class="text-gray-500 hover:text-blue-600 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM0 8h5v16H0V8zm7 0h4.8v2.2h.07c.67-1.27 2.3-2.6 4.73-2.6C20.55 7.6 24 10.1 24 15.2V24h-5v-7.2c0-1.7-.03-3.9-2.4-3.9-2.4 0-2.76 1.86-2.76 3.8V24H7V8z"/></svg></a><?php endif; ?>
              </div>
            </div>
            <?php endforeach; else: ?>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
              <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6">CO</div>
              <h3 class="text-2xl font-bold text-gray-900 mb-1">Dr. Chuks O.</h3>
              <p class="text-blue-600 font-medium mb-4">Medical Director</p>
              <div class="flex items-center justify-center gap-4">
                <a href="#" aria-label="Twitter" class="text-gray-500 hover:text-blue-500 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0016 2a4.5 4.5 0 00-4.5 4.5c0 .35.04.69.12 1A12.82 12.82 0 013 3s-4 9 5 13a13.28 13.28 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
                <a href="#" aria-label="Facebook" class="text-gray-500 hover:text-blue-700 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.5 9.9v-7h-2.2V12h2.2V9.8c0-2.2 1.3-3.5 3.3-3.5.95 0 1.9.17 1.9.17v2.1h-1.1c-1.1 0-1.4.7-1.4 1.4V12h2.4l-.4 2.9h-2v7A10 10 0 0022 12z"/></svg></a>
                <a href="#" aria-label="LinkedIn" class="text-gray-500 hover:text-blue-600 transition"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM0 8h5v16H0V8zm7 0h4.8v2.2h.07c.67-1.27 2.3-2.6 4.73-2.6C20.55 7.6 24 10.1 24 15.2V24h-5v-7.2c0-1.7-.03-3.9-2.4-3.9-2.4 0-2.76 1.86-2.76 3.8V24H7V8z"/></svg></a>
              </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
              <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6">SM</div>
              <h3 class="text-2xl font-bold text-gray-900 mb-1">Sarah Martinez</h3>
              <p class="text-green-600 font-medium mb-4">Operations Director</p>
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

    <!-- Medical Team Tab -->
    <div id="team-medical" class="tab-panel hidden">
      <div class="relative" data-center-slider>
        <div class="overflow-hidden">
          <div class="flex gap-8" data-track>
            <?php
            require_once __DIR__ . '/config/db.php';
            $members_med = [];
            try {
              $stmt = $pdo->prepare('SELECT m.* FROM team_members m JOIN team_groups g ON m.group_id=g.id WHERE g.slug=? AND m.active=1 ORDER BY m.sort_order, m.id');
              $stmt->execute(['medical']);
              $members_med = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Throwable $e) { $members_med = []; }
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
        showPanel('team-leadership');
      })();
    </script>
  </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-900 to-indigo-800 text-white py-20">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">Join Our Mission</h2>
    <p class="text-xl text-white/90 max-w-3xl mx-auto mb-8 leading-relaxed">
      Whether you're a medical professional, prayer warrior, or passionate supporter, there's a place for you in
      our mission.
    </p>
    <div class="flex flex-wrap justify-center gap-6">
      <a href="<?php echo url('get-involved'); ?>"
        class="inline-flex items-center px-8 py-4 rounded-xl bg-white text-gray-900 font-bold text-lg shadow-2xl hover:shadow-xl hover:scale-105 transition-all duration-300">
        Get Involved
      </a>
      <a href="<?php echo url('contact'); ?>"
        class="inline-flex items-center px-8 py-4 rounded-xl border-2 border-white text-white font-bold text-lg hover:bg-white/10 transition-all duration-300">
        Contact Us
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
