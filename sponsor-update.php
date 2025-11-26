<?php
$page_title = 'Sponsor Updates';
$page_description = 'Updates and messages from our sponsors and partners.';
$hero_enable = false;
$hero_background = 'assets/images/hero2.jpg';
?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>

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
        Gratitude & Updates from Sponsors
      </div>
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Sponsor Updates</h1>
      <p class="text-lg text-white/90">Messages and notes from partners who make this mission possible.</p>
    </div>
  </div>
</section>

<!-- Dynamic Sponsor Updates Section -->
<section class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Recent Sponsor Messages</h2>
      <p class="text-gray-600">Hear directly from our partners about their experiences and impact</p>
    </div>

    <?php
      try {
        $stmt = db()->query('SELECT name, message, image, created_at FROM sponsors ORDER BY created_at DESC');
        $sponsors = $stmt->fetchAll();
      } catch (Throwable $e) { $sponsors = []; }
    ?>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($sponsors as $s): ?>
        <article class="bg-gradient-to-br from-gray-50 to-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
          <?php if (!empty($s['image'])): ?>
            <div class="w-16 h-16 rounded-full bg-white shadow-sm border border-gray-200 flex items-center justify-center mx-auto mb-4 overflow-hidden">
              <img src="<?php echo url('uploads/' . esc_attr($s['image'])); ?>" alt="<?php echo esc_attr($s['name']); ?>" class="w-12 h-12 rounded-full object-cover">
            </div>
          <?php else: ?>
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mx-auto mb-4">
              <span class="text-white font-semibold text-lg"><?php echo substr(esc_html($s['name']), 0, 2); ?></span>
            </div>
          <?php endif; ?>
          
          <h3 class="text-xl font-bold text-gray-900 text-center mb-3"><?php echo esc_html($s['name']); ?></h3>
          <p class="text-gray-600 leading-relaxed mb-4 text-center"><?php echo esc_html($s['message']); ?></p>
          
          <?php if (!empty($s['created_at'])): ?>
            <div class="text-center">
              <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                <?php echo date('M j, Y', strtotime($s['created_at'])); ?>
              </span>
            </div>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if (empty($sponsors)): ?>
      <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
        <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">No Sponsor Updates Yet</h3>
        <p class="text-gray-600 max-w-md mx-auto mb-6">
          Check back soon for messages and updates from our valued partners and sponsors.
        </p>
        <a href="<?php echo url('partners '); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
          Become a Sponsor
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Our Valued Partners Section -->
<section class="bg-gradient-to-br from-gray-50 to-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-medium mb-4">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        Covenant Partnerships
      </div>
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Our Valued Partners</h2>
      <p class="text-xl text-gray-600 leading-relaxed mb-6">
        "Two are better than one... for they have a good reward for their labour" (Ecclesiastes 4:9)
      </p>
      <p class="text-gray-600">
        Partnership is the lifeblood of our mission. We recognize that no single institution can transform healthcare alone, especially in underserved communities.
      </p>
    </div>

    <div id="partnersSlider" class="relative" data-center-slider>
      <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white">
        <div class="flex items-stretch gap-8 px-6 py-6 transition-transform duration-500 ease-in-out" data-track>
          <div class="shrink-0 w-[300px] md:w-[340px] lg:w-[360px]">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 group hover:shadow-xl transition-all duration-500">
              <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3">Fear God Ministries</h3>
              <p class="text-gray-600 mb-4">Windsor, Ontario, Canada</p>
              <p class="text-gray-600 leading-relaxed">A Kingdom-focused partner committed to advancing compassionate healthcare through prayer support, humanitarian contributions, and shared apostolic burden.</p>
            </div>
          </div>
          <div class="shrink-0 w-[300px] md:w-[340px] lg:w-[360px]">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 group hover:shadow-xl transition-all duration-500">
              <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3">World Medical Relief</h3>
              <p class="text-gray-600 mb-4">Detroit, Michigan, USA</p>
              <p class="text-gray-600 leading-relaxed">A remarkable blessing providing medical equipment, consumables, and hospital resources that strengthen our capacity to provide high-quality, life-saving care.</p>
            </div>
          </div>
          <div class="shrink-0 w-[300px] md:w-[340px] lg:w-[360px]">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 group hover:shadow-xl transition-all duration-500">
              <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3">United Vessels of Love</h3>
              <p class="text-gray-600 mb-4">Katy, Texas, USA</p>
              <p class="text-gray-600 leading-relaxed">Strategic partners serving the poor and displaced through emergency medical backpacks, digital ultrasound systems, and field mission support for IDP communities.</p>
            </div>
          </div>
          <div class="shrink-0 w-[300px] md:w-[340px] lg:w-[360px]">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 group hover:shadow-xl transition-all duration-500">
              <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-50 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3">Pastor & Mrs. Akin</h3>
              <p class="text-gray-600 mb-4">Aberdeen, United Kingdom</p>
              <p class="text-gray-600 leading-relaxed">Faithful supporters whose personal generosity, encouragement, and kingdom-hearted commitment continue to strengthen our humanitarian and clinical initiatives.</p>
            </div>
          </div>
          <div class="shrink-0 w-[300px] md:w-[340px] lg:w-[360px]">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 group hover:shadow-xl transition-all duration-500">
              <div class="w-16 h-16 bg-gradient-to-br from-pink-100 to-pink-50 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3">Esther Foundation</h3>
              <p class="text-gray-600 mb-4">Washington, D.C., USA</p>
              <p class="text-gray-600 leading-relaxed">Partners in empowering women, families, and communities through maternal and child health initiatives, reinforcing our fight against maternal mortality.</p>
            </div>
          </div>
          <div class="shrink-0 w-[300px] md:w-[340px] lg:w-[360px]">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 group hover:shadow-xl transition-all duration-500">
              <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-orange-50 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3">RCN Theological Seminary</h3>
              <p class="text-gray-600 mb-4">Adullam</p>
              <p class="text-gray-600 leading-relaxed">Our home family and anchor, providing foundational partnership in vision, manpower, and spiritual support through shared values and apostolic mandate.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-6 flex items-center justify-between">
        <button class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50" aria-label="Previous" data-prev>
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18l-6-6 6-6" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" /></svg>
          Prev
        </button>
        <div class="flex items-center gap-2">
          <button class="h-2.5 w-2.5 rounded-full bg-white/60 border border-gray-300" data-dot="0" aria-label="Go to item 1"></button>
          <button class="h-2.5 w-2.5 rounded-full bg-white/60 border border-gray-300" data-dot="1" aria-label="Go to item 2"></button>
          <button class="h-2.5 w-2.5 rounded-full bg-white/60 border border-gray-300" data-dot="2" aria-label="Go to item 3"></button>
          <button class="h-2.5 w-2.5 rounded-full bg-white/60 border border-gray-300" data-dot="3" aria-label="Go to item 4"></button>
          <button class="h-2.5 w-2.5 rounded-full bg-white/60 border border-gray-300" data-dot="4" aria-label="Go to item 5"></button>
          <button class="h-2.5 w-2.5 rounded-full bg-white/60 border border-gray-300" data-dot="5" aria-label="Go to item 6"></button>
        </div>
        <button class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50" aria-label="Next" data-next>
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 6l6 6-6 6" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" /></svg>
          Next
        </button>
      </div>
    </div>

    <!-- Covenant of Impact Section -->
    <div class="mt-16 bg-gradient-to-r from-blue-600 to-purple-700 rounded-2xl p-8 text-white text-center">
      <h3 class="text-2xl font-bold mb-4">A Covenant of Impact</h3>
      <p class="text-lg text-blue-100 leading-relaxed mb-6">
        Together with our partners, we are rewriting the narrative of healthcare delivery — one community, one family, and one life at a time.
      </p>
      <p class="text-blue-100 italic mb-6">
        "The Lord gave the word: great was the company of those that published it" (Psalm 68:11)
      </p>
      <p class="text-blue-100">
        We remain grateful for every partner standing with us. The harvest is truly great, and by God's help and these covenant relationships, we continue to labour with enduring excellence.
      </p>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="bg-white py-16">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-6">Join Our Covenant of Impact</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
      Become part of our mission to bring healing and hope to underserved communities through compassionate healthcare.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="<?php echo url('partner-with-us'); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
        Become a Partner
      </a>
      <a href="<?php echo url('contact'); ?>" class="inline-flex items-center px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
        Contact Us
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
