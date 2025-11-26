<?php $hero_enable = false; ?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>

<!-- Enhanced Hero Slider (Kept exactly as is) -->
<section class="relative overflow-hidden">
  <div id="heroSlider"
    class="relative h-screen min-h-[600px] max-h-[800px] overflow-hidden bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900">
    <!-- Slides -->
    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100" data-slide="0"
      aria-hidden="false">
      <img src="<?php echo url('assets/images/hero1.jpg'); ?>" alt="Medical mission outreach"
        class="w-full h-full object-cover" fetchpriority="high" loading="eager" decoding="async"
        onerror="this.style.display='none'">
      <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-purple-900/50"></div>
    </div>
    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-slide="1"
      aria-hidden="true">
      <img src="<?php echo url('assets/images/hero2.jpg'); ?>" alt="Serving communities in need"
        class="w-full h-full object-cover" onerror="this.style.display='none'">
      <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/70 to-blue-900/50"></div>
    </div>
    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-slide="2"
      aria-hidden="true">
      <img src="<?php echo url('assets/images/hero3.jpg'); ?>" alt="Sharing the Gospel"
        class="w-full h-full object-cover" onerror="this.style.display='none'">
      <div class="absolute inset-0 bg-gradient-to-r from-purple-900/70 to-indigo-900/50"></div>
    </div>
    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-slide="3"
      aria-hidden="true">
      <img src="<?php echo url('assets/images/hero4.jpg'); ?>" alt="Empowering local healthcare"
        class="w-full h-full object-cover" onerror="this.style.display='none'">
      <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-cyan-900/50"></div>
    </div>

    <!-- Hero content overlay -->
    <div class="absolute inset-0 flex items-center">
      <div class="max-w-7xl mx-auto px-4 text-white text-center lg:text-left">
        <div class="max-w-3xl">
          <div
            class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
            <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
            Transforming Lives Through Healthcare & Faith
          </div>

          <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight"
            style="font-family: Poppins, sans-serif;">
            Serve Jesus With Your <span
              class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">Medical
              Expertise</span>
          </h1>

          <p class="text-xl md:text-2xl text-white/90 mb-8 leading-relaxed max-w-2xl">
            Join short-term medical missions that provide eternal impact through healthcare, compassion, and
            the Gospel.
          </p>

          <div class="flex flex-wrap gap-4 mb-8">
            <a href="<?php echo url('trips/upcoming'); ?>"
              class="inline-flex items-center px-8 py-4 rounded-xl text-white font-bold text-lg shadow-2xl hover:shadow-xl transition-all duration-300 transform hover:scale-105"
              style="background: <?php echo RCN_GRADIENT; ?>">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              Join a Mission Trip
            </a>
            <a href="<?php echo url('get-involved'); ?>"
              class="inline-flex items-center px-8 py-4 rounded-xl bg-white text-gray-900 font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                </path>
              </svg>
              Support Our Mission
            </a>
          </div>

          <div class="flex flex-wrap items-center gap-6 text-white/80 text-sm">
            <div class="flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
              </svg>
              <span>Safe & Organized Trips</span>
            </div>
            <div class="flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
              </svg>
              <span>Medical & Non-Medical Volunteers</span>
            </div>
            <div class="flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                </path>
              </svg>
              <span>Compassionate Care</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Controls -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-3">
      <button class="h-3 w-3 rounded-full bg-white shadow-lg transition-all duration-300" data-dot="0"
        aria-label="Slide 1"></button>
      <button class="h-3 w-3 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300" data-dot="1"
        aria-label="Slide 2"></button>
      <button class="h-3 w-3 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300" data-dot="2"
        aria-label="Slide 3"></button>
      <button class="h-3 w-3 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300" data-dot="3"
        aria-label="Slide 4"></button>
    </div>

    <div class="absolute bottom-8 right-8 flex items-center gap-2">
      <button id="heroPrev"
        class="p-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-white hover:bg-white/30 transition-all duration-300"
        aria-label="Previous slide">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </button>
      <button id="heroNext"
        class="p-3 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-white hover:bg-white/30 transition-all duration-300"
        aria-label="Next slide">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </button>
    </div>
  </div>
</section>

<!-- Modern Stats Section -->
<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-purple-900 py-20 overflow-hidden">
  <!-- Animated Background -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute inset-0" style="background: radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%);"></div>
  </div>
  
  <div class="relative max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
      <div class="text-center group">
        <div class="relative inline-block mb-4">
          <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-pink-500 rounded-full blur-lg opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
          <div class="relative bg-slate-800 rounded-full p-4 w-20 h-20 flex items-center justify-center">
            <div class="text-2xl lg:text-3xl font-bold text-white" data-count="50">0</div>
          </div>
        </div>
        <div class="text-blue-200 font-medium">Mission Trips</div>
        <div class="text-sm text-blue-300 mt-1">Across 3 continents</div>
      </div>
      
      <div class="text-center group">
        <div class="relative inline-block mb-4">
          <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-cyan-500 rounded-full blur-lg opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
          <div class="relative bg-slate-800 rounded-full p-4 w-20 h-20 flex items-center justify-center">
            <div class="text-2xl lg:text-3xl font-bold text-white" data-count="10000">0</div>
          </div>
        </div>
        <div class="text-blue-200 font-medium">Patients Served</div>
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

<!-- Modern Mission Pillars Section -->
<section class="bg-gradient-to-br from-white via-blue-50 to-indigo-100 py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Our Mission in <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Action</span></h2>
      <p class="text-xl text-gray-600 leading-relaxed">Combining medical excellence with compassionate care to transform communities physically and spiritually.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
      <div class="group relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
        <div class="relative bg-white rounded-2xl shadow-xl border border-gray-100 p-8 text-center h-full">
          <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
              </path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Medical Excellence</h3>
          <p class="text-gray-600 leading-relaxed">Providing life-saving medical care and treatment to underserved communities with professional expertise and cutting-edge practices.</p>
        </div>
      </div>

      <div class="group relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
        <div class="relative bg-white rounded-2xl shadow-xl border border-gray-100 p-8 text-center h-full">
          <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
              </path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Spiritual Care</h3>
          <p class="text-gray-600 leading-relaxed">Sharing the hope of Jesus Christ and praying with patients, offering spiritual comfort alongside physical healing.</p>
        </div>
      </div>

      <div class="group relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-orange-600 to-red-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
        <div class="relative bg-white rounded-2xl shadow-xl border border-gray-100 p-8 text-center h-full">
          <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-100 to-orange-50 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Community Empowerment</h3>
          <p class="text-gray-600 leading-relaxed">Educating local communities on preventive healthcare and sustainable practices to create lasting positive change.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modern Serve With Us Section -->
<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center max-w-4xl mx-auto mb-16">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-medium mb-6">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        Serve Jesus With Your Skills
      </div>
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
        "Serve Jesus With Your Medical Hands or Your Non-Medical Heart"
      </h2>
      <p class="text-xl text-gray-600 leading-relaxed">
        There is a place where medicine meets mercy. Where surgical blades bring hope, and compassion becomes a channel of God's love to the broken and overlooked.
      </p>
      <blockquote class="mt-8 text-lg text-gray-700 italic border-l-4 border-blue-500 pl-6 py-2">
        "I was sick and you looked after me, I was in prison and you came to visit me… Truly I tell you, whatever you did for one of the least of these brothers and sisters of mine, you did for me."<br>
        <cite class="not-italic text-gray-600 text-base mt-2 block">— Matthew 25:36, 40 (NIV)</cite>
      </blockquote>
    </div>

    <!-- Three Core Programs -->
    <div class="grid md:grid-cols-3 gap-8 mb-16">
      <!-- AromeCare -->
      <div class="group relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
        <div class="relative bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-100 h-full">
          <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">AromeCare</h3>
          <p class="text-gray-700 mb-4 leading-relaxed">
            <strong>Healing the Body, Honouring the Forgotten</strong><br>
            Surgical festivals, mass screenings, and healthcare for the most vulnerable in villages, IDP camps, and prisons.
          </p>
          <div class="bg-white rounded-lg p-4 border border-blue-200">
            <p class="text-sm text-gray-600 italic">
              "He sent them out to proclaim the kingdom of God and to heal the sick."<br>
              <span class="text-blue-600">— Luke 9:2</span>
            </p>
          </div>
        </div>
      </div>

      <!-- DinnaCare -->
      <div class="group relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-600 to-rose-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
        <div class="relative bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl p-8 border border-pink-100 h-full">
          <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">DinnaCare</h3>
          <p class="text-gray-700 mb-4 leading-relaxed">
            <strong>A Mother's Touch in Christ's Name</strong><br>
            School deworming, maternal health, cancer screening, and dignity-restoring care for women and children.
          </p>
          <div class="bg-white rounded-lg p-4 border border-pink-200">
            <p class="text-sm text-gray-600 italic">
              "She opens her arms to the poor and extends her hands to the needy."<br>
              <span class="text-pink-600">— Proverbs 31:20</span>
            </p>
          </div>
        </div>
      </div>

      <!-- DocCare -->
      <div class="group relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
        <div class="relative bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 border border-green-100 h-full">
          <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">DocCare</h3>
          <p class="text-gray-700 mb-4 leading-relaxed">
            <strong>Empowering the Hands that Heal</strong><br>
            Training healthcare workers, adopting rural health posts, and building sustainable healthcare systems.
          </p>
          <div class="bg-white rounded-lg p-4 border border-green-200">
            <p class="text-sm text-gray-600 italic">
              "And the things you have heard… entrust to reliable people who will also be qualified to teach others."<br>
              <span class="text-green-600">— 2 Timothy 2:2</span>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Call to Serve -->
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 md:p-12 text-white text-center overflow-hidden">
      <!-- Background Pattern -->
      <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23ffffff\" fill-opacity=\"0.1\"><circle cx=\"30\" cy=\"30\" r=\"4\"/></g></g></svg>');"></div>
      </div>
      
      <div class="relative">
        <h3 class="text-2xl md:text-3xl font-bold mb-6">Serve Jesus With What You Have</h3>
        <p class="text-lg text-blue-100 mb-6 leading-relaxed">
          You may be a doctor or nurse, but also a teacher, engineer, logistics expert, media professional, 
          project manager, accountant, or prayer warrior. You may never hold a stethoscope, but you can carry 
          a stretcher in other ways.
        </p>
        <blockquote class="mb-8 text-blue-100 italic text-lg">
          "Each of you should use whatever gift you have received to serve others, as faithful stewards of God's grace in its various forms."<br>
          <cite class="not-italic text-white font-semibold mt-2 block">— 1 Peter 4:10</cite>
        </blockquote>

        <!-- Ways to Serve -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
          <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20 hover:bg-white/20 transition-all duration-300">
            <div class="text-white font-semibold mb-2">Sponsor a surgery</div>
          </div>
          <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20 hover:bg-white/20 transition-all duration-300">
            <div class="text-white font-semibold mb-2">Adopt a school for deworming</div>
          </div>
          <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20 hover:bg-white/20 transition-all duration-300">
            <div class="text-white font-semibold mb-2">Equip a rural health post</div>
          </div>
          <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20 hover:bg-white/20 transition-all duration-300">
            <div class="text-white font-semibold mb-2">Support prenatal care</div>
          </div>
        </div>

        <div class="flex flex-wrap justify-center gap-4">
          <a href="<?php echo url('get-involved'); ?>" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Serve With Your Skills
          </a>
          <a href="<?php echo url('trips'); ?>" class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-xl font-bold text-lg hover:bg-white/10 transition-all duration-300 transform hover:scale-105">
            Join a Mission Trip
          </a>
        </div>

        <!-- Final Call -->
        <div class="mt-8 pt-6 border-t border-white/20">
          <p class="text-blue-100 text-lg">
            <strong>Jesus is still walking through the land—healing, teaching, feeding, and calling.</strong><br>
            And He says, "Come, follow Me." Will you serve Jesus with your skill, your resources, and your compassion?
          </p>
          <p class="text-white font-bold text-xl mt-4">
            Let's make medicine a mission again. Let's make compassion a calling.
          </p>
          <p class="text-blue-100 mt-4 text-sm">
            — Dr Chukwudi Okebaram, Medical Director and Director of Medical Missions
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modern Mission Reports Section -->
<section class="bg-gradient-to-br from-slate-50 via-white to-blue-50 py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex flex-col lg:flex-row items-start lg:items-end justify-between mb-12">
      <div class="max-w-2xl">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Mission <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Reports</span></h2>
        <p class="text-xl text-gray-600 leading-relaxed">Read our latest mission report and see the impact of your support.</p>
      </div>
      <a href="<?php echo url('outreach-report'); ?>"
        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-300 mt-6 lg:mt-0 group">
        View Mission Reports
        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </a>
    </div>

    <?php
    require_once __DIR__ . '/config/db.php';
    try {
      $stmt = db()->query("SELECT id, title, description, image, date FROM outreach_reports ORDER BY date DESC, id DESC LIMIT 3");
      $reports = $stmt->fetchAll();
    } catch (Throwable $e) {
      $reports = [];
    }
    if (!function_exists('excerpt_plain')) {
      function excerpt_plain(string $html, int $limit = 220): string {
        $text = trim(preg_replace('/\s+/u', ' ', strip_tags($html)));
        if (mb_strlen($text) <= $limit) return $text;
        $cut = mb_substr($text, 0, $limit);
        $cut = preg_replace('/\s+\S*$/u', '', $cut);
        return rtrim($cut) . '…';
      }
    }
    ?>

    <div class="grid md:grid-cols-3 gap-8">
      <?php foreach ($reports as $r): ?>
        <article class="group relative">
          <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
          <div class="relative bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden group-hover:shadow-2xl transition-all duration-500 h-full flex flex-col">
            <div class="relative overflow-hidden">
              <?php if (!empty($r['image'])): ?>
                <img src="<?php echo url('uploads/' . esc_attr($r['image'])); ?>" alt="<?php echo esc_attr($r['title']); ?>" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
              <?php else: ?>
                <div class="w-full h-48 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                  <svg class="h-12 w-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                </div>
              <?php endif; ?>
              <div class="absolute top-4 left-4">
                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-800 text-sm font-medium rounded-full border border-white/50">
                  <?php echo date('M Y', strtotime($r['date'])); ?>
                </span>
              </div>
            </div>

            <div class="p-6 flex-grow flex flex-col">
              <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span><?php echo date('M j, Y', strtotime($r['date'])); ?></span>
              </div>

              <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors duration-300 line-clamp-2">
                <a href="<?php echo url('outreach-report/view.php'); ?>?id=<?php echo (int)$r['id']; ?>"><?php echo esc_html($r['title']); ?></a>
              </h3>

              <p class="text-gray-600 mb-4 leading-relaxed flex-grow line-clamp-3">
                <?php echo esc_html(excerpt_plain($r['description'], 220)); ?>
              </p>

              <a href="<?php echo url('outreach-report/view.php'); ?>?id=<?php echo (int)$r['id']; ?>" class="inline-flex items-center gap-2 text-blue-600 font-medium hover:text-blue-700 transition-colors duration-300 group/link mt-auto">
                Read Report
                <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if (empty($reports)): ?>
      <div class="text-center py-12">
        <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Mission Reports</h3>
        <p class="text-gray-500">We are compiling our latest mission reports. Check back soon.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Modern Blog Section -->
<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex flex-col lg:flex-row items-start lg:items-end justify-between mb-12">
      <div class="max-w-2xl">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Mission Stories & <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-pink-500">Updates</span></h2>
        <p class="text-xl text-gray-600 leading-relaxed">Read inspiring stories from our mission field and stay updated with our latest work.</p>
      </div>
      <a href="<?php echo url('blog'); ?>"
        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-300 mt-6 lg:mt-0 group">
        View All Stories
        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </a>
    </div>

    <?php
    try {
      $stmt = db()->query("SELECT title, slug, excerpt, image, author, created_at FROM blog_posts ORDER BY created_at DESC LIMIT 3");
      $posts = $stmt->fetchAll();
    } catch (Throwable $e) {
      $posts = [];
    }
    ?>

    <div class="grid md:grid-cols-3 gap-8">
      <?php foreach ($posts as $p): ?>
        <article class="group relative">
          <div class="absolute -inset-0.5 bg-gradient-to-r from-orange-600 to-pink-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-300"></div>
          <div class="relative bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden group-hover:shadow-2xl transition-all duration-500 h-full flex flex-col">
            <?php if (!empty($p['image'])): ?>
              <a href="<?php echo url('blog/' . esc_attr($p['slug'])); ?>">
                <div class="relative overflow-hidden">
                  <img src="<?php echo url('uploads/' . esc_attr($p['image'])); ?>"
                    alt="<?php echo esc_attr($p['title']); ?>"
                    class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                  <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300">
                  </div>
                </div>
              </a>
            <?php else: ?>
              <div class="h-48 bg-gradient-to-br from-orange-50 to-pink-100 flex items-center justify-center">
                <svg class="h-12 w-12 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                  </path>
                </svg>
              </div>
            <?php endif; ?>

            <div class="p-6 flex-grow flex flex-col">
              <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                <span><?php echo date('M j, Y', strtotime($p['created_at'])); ?></span>
                <span class="text-gray-300">•</span>
                <span>By <?php echo esc_html($p['author']); ?></span>
              </div>

              <h3
                class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors duration-300 leading-tight">
                <a
                  href="<?php echo url('blog/' . esc_attr($p['slug'])); ?>"><?php echo esc_html($p['title']); ?></a>
              </h3>

              <p class="text-gray-600 line-clamp-3 mb-4 leading-relaxed flex-grow">
                <?php echo esc_html($p['excerpt']); ?>
              </p>

              <a href="<?php echo url('blog/' . esc_attr($p['slug'])); ?>"
                class="inline-flex items-center gap-2 text-orange-600 font-medium hover:text-orange-700 transition-colors duration-300 group/link mt-auto">
                Read Story
                <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                  </path>
                </svg>
              </a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if (empty($posts)): ?>
      <div class="text-center py-12">
        <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
          </path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Stories Yet</h3>
        <p class="text-gray-500">Check back soon for inspiring mission stories and updates.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Modern Testimonials Section -->
<section class="bg-gradient-to-br from-slate-900 via-blue-900 to-purple-900 py-20 text-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold mb-6">Inspiring <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">Stories</span></h2>
      <p class="text-xl text-blue-200 leading-relaxed">Hear from volunteers and patients whose lives have been transformed through our mission work.</p>
    </div>

    <?php $testimonials = db()->query("SELECT * FROM testimonials WHERE is_active=1 ORDER BY sort_order ASC, id DESC")->fetchAll(); ?>

    <?php if (!empty($testimonials)): ?>
      <?php $bubbleGradients = ['from-orange-500 to-red-500','from-green-500 to-emerald-500','from-purple-500 to-indigo-500']; ?>
      <div id="testimonialsSlider" class="relative">
        <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm">
          <div class="flex items-stretch gap-8 px-6 py-6 transition-transform duration-500 ease-in-out" data-track>
            <?php foreach ($testimonials as $i => $t): ?>
              <?php
                $name = trim($t['name'] ?? '');
                $parts = preg_split('/\s+/', $name);
                $first = isset($parts[0][0]) ? strtoupper($parts[0][0]) : '';
                $second = isset($parts[1][0]) ? strtoupper($parts[1][0]) : '';
                $initials = $first . $second;
                $bubble = $bubbleGradients[$i % count($bubbleGradients)];
              ?>
              <div class="shrink-0 w-[300px] md:w-[340px] lg:w-[360px]">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 p-8 relative group hover:bg-white/15 transition-all duration-500 h-full">
                  <div class="absolute -top-4 left-6">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br <?php echo $bubble; ?> flex items-center justify-center text-white text-2xl">"</div>
                  </div>
                  <div class="mt-4">
                    <p class="text-blue-100 leading-relaxed mb-6 italic">“<?php echo esc_html($t['message']); ?>”</p>
                    <div class="flex items-center gap-4">
                      <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold overflow-hidden">
                        <?php if (!empty($t['photo'])): ?>
                          <img src="<?php echo esc_attr(url('uploads/testimonials/' . $t['photo'])); ?>" alt="Photo" class="h-12 w-12 object-cover">
                        <?php else: ?>
                          <?php echo esc_html($initials ?: '•'); ?>
                        <?php endif; ?>
                      </div>
                      <div>
                        <h4 class="font-semibold text-white"><?php echo esc_html($name); ?></h4>
                        <?php if (!empty($t['role'])): ?><p class="text-sm text-blue-200"><?php echo esc_html($t['role']); ?></p><?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <!-- Controls -->
        <div class="mt-6 flex items-center justify-between">
          <button id="testimonialsPrev" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-white/30 text-white hover:bg-white/10 transition-all duration-300" aria-label="Previous">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18l-6-6 6-6" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" /></svg>
            Prev
          </button>
          <div class="flex items-center gap-2" id="testimonialsDots">
            <?php foreach ($testimonials as $i => $_): ?>
              <button class="h-2.5 w-2.5 rounded-full bg-white/30 border border-white/50 hover:bg-white/50 transition-all duration-300" data-dot="<?php echo (int)$i; ?>" aria-label="Go to testimonial <?php echo (int)$i+1; ?>"></button>
            <?php endforeach; ?>
          </div>
          <button id="testimonialsNext" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-white/30 text-white hover:bg-white/10 transition-all duration-300" aria-label="Next">
            Next
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 6l6 6-6 6" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" /></svg>
          </button>
        </div>
      </div>
    <?php else: ?>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 p-8 relative group hover:bg-white/15 transition-all duration-500">
          <div class="absolute -top-4 left-6"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center text-white text-2xl">"</div></div>
          <div class="mt-4">
            <p class="text-blue-100 leading-relaxed mb-6 italic">"Serving with RCN Mission Hospital transformed my perspective on healthcare."</p>
            <div class="flex items-center gap-4"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold">DR</div><div><h4 class="font-semibold text-white">Dr. Sarah Johnson</h4><p class="text-sm text-blue-200">Medical Volunteer</p></div></div>
          </div>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 p-8 relative group hover:bg-white/15 transition-all duration-500">
          <div class="absolute -top-4 left-6"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white text-2xl">"</div></div>
          <div class="mt-4">
            <p class="text-blue-100 leading-relaxed mb-6 italic">"As a non-medical volunteer, I found my place in prayer and logistics."</p>
            <div class="flex items-center gap-4"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-semibold">MJ</div><div><h4 class="font-semibold text-white">Michael Thompson</h4><p class="text-sm text-blue-200">Prayer Team Volunteer</p></div></div>
          </div>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 p-8 relative group hover:bg-white/15 transition-all duration-500">
          <div class="absolute -top-4 left-6"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center text-white text-2xl">"</div></div>
          <div class="mt-4">
            <p class="text-blue-100 leading-relaxed mb-6 italic">"The medical care saved my daughter's life."</p>
            <div class="flex items-center gap-4"><div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-semibold">AM</div><div><h4 class="font-semibold text-white">Amina Mohammed</h4><p class="text-sm text-blue-200">Patient's Mother</p></div></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Stats under testimonials -->
    <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
      <div class="group">
        <div class="text-3xl font-bold text-white mb-2 group-hover:scale-110 transition-transform duration-300">98%</div>
        <div class="text-blue-200">Volunteer Satisfaction</div>
      </div>
      <div class="group">
        <div class="text-3xl font-bold text-white mb-2 group-hover:scale-110 transition-transform duration-300">100+</div>
        <div class="text-blue-200">Lives Changed Weekly</div>
      </div>
      <div class="group">
        <div class="text-3xl font-bold text-white mb-2 group-hover:scale-110 transition-transform duration-300">15</div>
        <div class="text-blue-200">Countries Reached</div>
      </div>
      <div class="group">
        <div class="text-3xl font-bold text-white mb-2 group-hover:scale-110 transition-transform duration-300">24/7</div>
        <div class="text-blue-200">Prayer Support</div>
      </div>
    </div>
  </div>
</section>

<!-- Modern Newsletter Section -->
<section class="bg-gradient-to-br from-white via-blue-50 to-indigo-100 py-20">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <div class="relative bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-8 md:p-12 text-white overflow-hidden">
      <!-- Background Pattern -->
      <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23ffffff\" fill-opacity=\"0.1\"><circle cx=\"30\" cy=\"30\" r=\"4\"/></g></g></svg>');"></div>
      </div>
      
      <div class="relative">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Stay Connected</h2>
        <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">Get mission updates, prayer requests, and inspiring stories delivered to your inbox.</p>
        <form id="newsletterForm" class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
          <input id="newsletterEmail" name="email" type="email" placeholder="Your email address"
            class="flex-1 px-4 py-3 rounded-lg border border-white/30 bg-white/10 backdrop-blur-sm text-white placeholder-blue-200 focus:ring-2 focus:ring-white focus:border-white transition-colors"
            required>
          <button type="submit"
            class="px-6 py-3 rounded-lg bg-white text-blue-600 font-medium shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
            Subscribe
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Modern CTA Section -->
<section class="bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-900 text-white py-20 relative overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-blue-500/20 via-transparent to-transparent"></div>
  </div>
  
  <div class="relative max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl md:text-5xl font-bold mb-6" style="font-family: Poppins, sans-serif;">Ready to Make a <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">Difference?</span></h2>
    <p class="text-xl text-white/90 max-w-3xl mx-auto mb-8 leading-relaxed">
      Whether you join a mission trip, support our work financially, or pray for our teams, your involvement changes lives for eternity.
    </p>
    <div class="flex flex-wrap justify-center gap-6">
      <a href="<?php echo url('trips.php'); ?>"
        class="group relative inline-flex items-center px-8 py-4 rounded-xl bg-white text-gray-900 font-bold text-lg shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-white to-gray-100 group-hover:from-gray-100 group-hover:to-white transition-all duration-300"></div>
        <span class="relative flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          Join a Mission Trip
        </span>
      </a>
      <a href="<?php echo url('get-involved'); ?>"
        class="group relative inline-flex items-center px-8 py-4 rounded-xl border-2 border-white text-white font-bold text-lg hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
        <span class="relative flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
            </path>
          </svg>
          Support Our Mission
        </span>
      </a>
      <a href="<?php echo url('contact'); ?>"
        class="group relative inline-flex items-center px-8 py-4 rounded-xl border-2 border-white text-white font-bold text-lg hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
        <span class="relative flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
            </path>
          </svg>
          Contact Us
        </span>
      </a>
    </div>
  </div>
</section>

<style>
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>

<script>
  // Hero Slider (Kept exactly as is)
  document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('[data-slide]');
    const dots = document.querySelectorAll('[data-dot]');
    const prevBtn = document.getElementById('heroPrev');
    const nextBtn = document.getElementById('heroNext');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.style.opacity = i === index ? '1' : '0';
        slide.setAttribute('aria-hidden', i !== index);
      });

      dots.forEach((dot, i) => {
        dot.classList.toggle('bg-white', i === index);
        dot.classList.toggle('bg-white/40', i !== index);
      });

      currentSlide = index;
    }

    function nextSlide() {
      showSlide((currentSlide + 1) % slides.length);
    }

    function prevSlide() {
      showSlide((currentSlide - 1 + slides.length) % slides.length);
    }

    // Auto-advance slides
    function startSlider() {
      slideInterval = setInterval(nextSlide, 5000);
    }

    function stopSlider() {
      clearInterval(slideInterval);
    }

    // Event listeners
    nextBtn.addEventListener('click', () => {
      stopSlider();
      nextSlide();
      startSlider();
    });

    prevBtn.addEventListener('click', () => {
      stopSlider();
      prevSlide();
      startSlider();
    });

    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        stopSlider();
        showSlide(index);
        startSlider();
      });
    });

    // Pause on hover
    const slider = document.getElementById('heroSlider');
    slider.addEventListener('mouseenter', stopSlider);
    slider.addEventListener('mouseleave', startSlider);

    // Start the slider
    startSlider();

    // Animated counter for stats
    const counters = document.querySelectorAll('[data-count]');
    const speed = 200;

    counters.forEach(counter => {
      const updateCount = () => {
        const target = +counter.getAttribute('data-count');
        const count = +counter.innerText;
        const increment = target / speed;

        if (count < target) {
          counter.innerText = Math.ceil(count + increment);
          setTimeout(updateCount, 1);
        } else {
          counter.innerText = target;
        }
      };

      // Start counting when element is in viewport
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

  // Newsletter subscribe handler (Kept exactly as is)
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('newsletterForm');
    if (!form) return;
    const input = form.querySelector('#newsletterEmail') || form.querySelector('input[type="email"]');

    form.addEventListener('submit', async function (e) {
      e.preventDefault();
      const email = (input?.value || '').trim();
      if (!email) {
        (window.notify ? window.notify('Please enter your email address.', 'error') : alert('Please enter your email address.'));
        return;
      }
      const endpoint = '<?php echo url('api/newsletter/subscribe.php'); ?>';
      const body = new URLSearchParams({ email, source: location.pathname });
      try {
        const res = await fetch(endpoint, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body
        });
        const data = await res.json();
        if (res.ok && data.ok) {
          (window.notify ? window.notify(data.message || 'Please check your email to confirm your subscription.', 'success') : alert(data.message || 'Please check your email to confirm your subscription.'));
          if (input) input.value = '';
        } else {
          (window.notify ? window.notify(data.message || 'Subscription failed. Please try again.', 'error') : alert(data.message || 'Subscription failed. Please try again.'));
        }
      } catch (err) {
        (window.notify ? window.notify('Network error. Please try again.', 'error') : alert('Network error. Please try again.'));
      }
    });
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
