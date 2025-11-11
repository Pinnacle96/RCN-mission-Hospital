<?php
// Use a custom hero for a more modern, immersive design on this page
$page_title = 'Get Involved - Join Our Mission';
$page_description = 'Discover ways to serve through medical missions, donations, prayer, and partnerships. Make a difference in communities worldwide.';
$hero_enable = false;
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Enhanced Modern Hero -->
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
        Transform Lives Through Service
      </div>

      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight" style="font-family: Poppins, sans-serif;">
        Join Our <span
          class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">Mission</span>
      </h1>

      <p class="text-xl text-white/90 mb-8 leading-relaxed">
        Use your skills to provide compassionate care and share the hope of the Gospel through medical missions,
        donations, and prayer partnerships.
      </p>

      <div class="flex flex-wrap gap-4">
        <a href="#volunteer"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium text-white transition-all duration-300 transform hover:scale-105 shadow-lg"
          style="background: <?php echo RCN_GRADIENT; ?>">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          Volunteer on a Trip
        </a>

        <a href="#donate"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white/30 text-white hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
            </path>
          </svg>
          Donate Supplies
        </a>

        <a href="#pray"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white/30 text-white hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
            </path>
          </svg>
          Join Prayer Team
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Impact Stats -->
<section class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="500">0</div>
        <div class="text-gray-600">Volunteers</div>
      </div>
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="50">0</div>
        <div class="text-gray-600">Missions</div>
      </div>
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="15">0</div>
        <div class="text-gray-600">Countries</div>
      </div>
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="10000">0</div>
        <div class="text-gray-600">Lives Impacted</div>
      </div>
    </div>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">
  <!-- Intro -->
  <div class="text-center mb-16">
    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Make a Difference Today</h2>
    <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
      There are many ways to serve: travel on a medical mission, donate vital supplies, pray with us, partner as
      an organization, or help prepare medication before trips. Your participation brings spiritual and physical
      healing to patients and communities.
    </p>
    <div class="w-24 h-1 bg-gradient-to-r from-orange-500 to-red-500 mx-auto mt-8 rounded-full"></div>
  </div>

  <!-- Ways to Serve (feature cards) -->
  <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
    <div id="volunteer"
      class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-500 group">
      <div
        class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
        <svg class="h-7 w-7 text-orange-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" class="icon-stroke" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <circle cx="8.5" cy="7" r="4" class="icon-stroke" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" />
          <path d="M20 8v6M23 11h-6" class="icon-stroke" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
      <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors duration-300">
        Volunteer on a trip</h3>
      <p class="text-gray-600 mb-6 leading-relaxed">Physicians, dentists, nurses, pharmacists, optometrists,
        allied health, students, and non-medical volunteers are welcome.</p>
      <a class="inline-flex items-center gap-2 text-orange-600 font-semibold group-hover:gap-3 transition-all duration-300"
        href="<?php echo url('trips/upcoming'); ?>">
        See upcoming trips
        <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-300" viewBox="0 0 24 24"
          fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 12h14m-7-7l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </a>
    </div>

    <div id="donate"
      class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-500 group">
      <div
        class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
        <svg class="h-7 w-7 text-blue-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
            class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>
      </div>
      <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300">
        Donate medical supplies</h3>
      <p class="text-gray-600 mb-6 leading-relaxed">Fund medicine and essential items like glasses and shoes. Your
        gift impacts patients directly.</p>
      <a class="inline-flex items-center gap-2 text-blue-600 font-semibold group-hover:gap-3 transition-all duration-300"
        href="<?php echo url('resources'); ?>">
        Ways to give
        <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-300" viewBox="0 0 24 24"
          fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 12h14m-7-7l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </a>
    </div>

    <div id="pray"
      class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-500 group">
      <div
        class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
        <svg class="h-7 w-7 text-green-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" class="icon-stroke" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <circle cx="9" cy="7" r="4" class="icon-stroke" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" />
          <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75" class="icon-stroke" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
      <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-green-600 transition-colors duration-300">
        Join prayer</h3>
      <p class="text-gray-600 mb-6 leading-relaxed">Pray for volunteers, patients, and partners. We host regular
        online prayer times.</p>
      <a class="inline-flex items-center gap-2 text-green-600 font-semibold group-hover:gap-3 transition-all duration-300"
        href="<?php echo url('contact'); ?>?subject=<?php echo urlencode('Prayer Team'); ?>">
        Get prayer updates
        <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-300" viewBox="0 0 24 24"
          fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 12h14m-7-7l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </a>
    </div>

    <div id="partners"
      class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-2xl transition-all duration-500 group">
      <div
        class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
        <svg class="h-7 w-7 text-purple-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M16 11V7a4 4 0 00-8 0v4H6v10h12V11ZM10 7a2 2 0 014 0v4h-4Z" class="icon-stroke"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
      <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-purple-600 transition-colors duration-300">
        Partner with us</h3>
      <p class="text-gray-600 mb-6 leading-relaxed">Organizations help with logistics, supplies, and outreach
        connections. Let's collaborate.</p>
      <a class="inline-flex items-center gap-2 text-purple-600 font-semibold group-hover:gap-3 transition-all duration-300"
        href="<?php echo url('partners'); ?>">
        Learn about partnerships
        <svg class="h-5 w-5 group-hover:translate-x-1 transition-transform duration-300" viewBox="0 0 24 24"
          fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 12h14m-7-7l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </a>
    </div>
  </div>

  <!-- Who can volunteer & Requirements -->
  <div class="grid lg:grid-cols-2 gap-8 mb-20">
    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-8 border border-orange-200">
      <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center">
          <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" class="icon-stroke" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="8.5" cy="7" r="4" class="icon-stroke" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </div>
        Who can volunteer
      </h3>
      <ul class="space-y-3 text-gray-700">
        <li class="flex items-start gap-3">
          <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 flex-shrink-0"></div>
          <span><strong>Medical:</strong> MD/DO, PA, NP, RN, LPN, CNA, Pharmacist, Dentist, Optometrist,
            PT/OT, Radiology Tech</span>
        </li>
        <li class="flex items-start gap-3">
          <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 flex-shrink-0"></div>
          <span>Students in medical and allied health programs</span>
        </li>
        <li class="flex items-start gap-3">
          <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 flex-shrink-0"></div>
          <span><strong>Non-medical:</strong> logistics, registration, hospitality, prayer, and support
            roles</span>
        </li>
      </ul>
    </div>

    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 border border-blue-200">
      <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
          <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
              class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </div>
        General requirements
      </h3>
      <ul class="space-y-3 text-gray-700">
        <li class="flex items-start gap-3">
          <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
          <span>Heart to serve and share the love of Christ</span>
        </li>
        <li class="flex items-start gap-3">
          <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
          <span>Valid travel documents and readiness to follow trip guidance</span>
        </li>
        <li class="flex items-start gap-3">
          <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
          <span>Training and orientation provided before departure</span>
        </li>
      </ul>
    </div>
  </div>

  <!-- What participants say -->
  <div class="mb-20">
    <div class="text-center mb-12">
      <h2 class="text-4xl font-bold text-gray-900 mb-4">What Participants Say</h2>
      <p class="text-xl text-gray-600 max-w-2xl mx-auto">Hear from volunteers who have experienced the
        transformative power of medical missions</p>
    </div>
    <div class="grid md:grid-cols-3 gap-8">
      <!-- Card 1 -->
      <article
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 group">
        <div class="flex items-center gap-4 mb-6">
          <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg"
            style="background: <?php echo RCN_GRADIENT; ?>;">JD</div>
          <div>
            <p class="font-bold text-gray-900 text-lg">Jane D.</p>
            <p class="text-sm text-gray-500">Volunteer • Multiple missions</p>
          </div>
        </div>
        <div class="text-gray-700 leading-relaxed">
          <div class="text-orange-500 mb-4">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
            </svg>
          </div>
          <p class="italic">"Serving on medical missions changed my life trajectory. I want to keep being part
            of Gospel impact in Africa and wherever God leads me."</p>
        </div>
      </article>
      <!-- Card 2 -->
      <article
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 group">
        <div class="flex items-center gap-4 mb-6">
          <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg"
            style="background: <?php echo RCN_GRADIENT; ?>;">RT</div>
          <div>
            <p class="font-bold text-gray-900 text-lg">R. Thompson</p>
            <p class="text-sm text-gray-500">Radiology Tech • Several missions</p>
          </div>
        </div>
        <div class="text-gray-700 leading-relaxed">
          <div class="text-orange-500 mb-4">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
            </svg>
          </div>
          <p class="italic">"Each trip brings new experiences and a deeper awe of God's creation. It's a
            privilege to serve patients with compassionate care."</p>
        </div>
      </article>
      <!-- Card 3 -->
      <article
        class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 group">
        <div class="flex items-center gap-4 mb-6">
          <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg"
            style="background: <?php echo RCN_GRADIENT; ?>;">AC</div>
          <div>
            <p class="font-bold text-gray-900 text-lg">A. Chen</p>
            <p class="text-sm text-gray-500">Clinician • Multiple missions</p>
          </div>
        </div>
        <div class="text-gray-700 leading-relaxed">
          <div class="text-orange-500 mb-4">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
            </svg>
          </div>
          <p class="italic">"It's not just about going — it's about growing spiritually. I learned from the
            team and built lasting relationships through serving."</p>
        </div>
      </article>
    </div>
  </div>

  <!-- Medication Sorting Team -->
  <div id="sorting-team"
    class="bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl p-8 mb-20 text-white shadow-xl">
    <div class="md:flex md:items-center md:justify-between">
      <div class="md:max-w-2xl">
        <h2 class="text-3xl font-bold mb-4">Medication Sorting Team</h2>
        <p class="text-orange-100 text-lg leading-relaxed mb-4">Help pack and organize medicine and supplies
          before a team departs. Your preparation helps clinics run smoothly and patients get timely care.</p>
      </div>
      <div class="mt-6 md:mt-0">
        <a class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-white text-orange-600 font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300"
          href="<?php echo url('contact'); ?>?subject=<?php echo urlencode('Medication Sorting Team'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" class="icon-stroke" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Join the sorting team
        </a>
      </div>
    </div>
  </div>

  <!-- Upcoming trips teaser -->
  <div class="mb-20">
    <div class="text-center mb-12">
      <h2 class="text-4xl font-bold text-gray-900 mb-4">Upcoming Mission Trips</h2>
      <p class="text-xl text-gray-600">Join one of our upcoming medical missions and make a lasting impact</p>
    </div>
    <?php
    require_once __DIR__ . '/config/db.php';
    try {
      $stmt = db()->query("SELECT id, title, location, start_date, end_date, description, image FROM trips WHERE (end_date >= CURDATE() OR start_date >= CURDATE()) ORDER BY start_date ASC LIMIT 3");
      $trips = $stmt->fetchAll();
    } catch (Throwable $e) {
      $trips = [];
    }
    ?>
    <div class="grid md:grid-cols-3 gap-8">
      <?php foreach ($trips as $t): ?>
        <?php
        $img = !empty($t['image']) ? url('uploads/' . $t['image']) : url('assets/images/hero2.jpg');
        ?>
        <article
          class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500 group">
          <a href="<?php echo url('trips/' . (int)$t['id']); ?>">
            <div class="relative overflow-hidden">
              <img src="<?php echo $img; ?>" alt="<?php echo esc_attr($t['title']); ?>"
                class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
              <div
                class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors duration-300">
              </div>
            </div>
          </a>
          <div class="p-6">
            <p class="text-xs uppercase tracking-wide text-orange-600 font-semibold mb-2">
              <?php echo esc_html($t['location']); ?></p>
            <h3
              class="text-xl font-bold text-gray-900 mb-3 group-hover:text-orange-600 transition-colors duration-300">
              <a href="<?php echo url('trips/' . (int)$t['id']); ?>"><?php echo esc_html($t['title']); ?></a>
            </h3>
            <p class="text-sm text-gray-600 mb-4 flex items-center gap-2">
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                  class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
              <?php echo date('M j, Y', strtotime($t['start_date'])); ?><?php if (!empty($t['end_date'])): ?>
              – <?php echo date('M j, Y', strtotime($t['end_date'])); ?><?php endif; ?>
            </p>
            <p class="text-gray-600 text-sm line-clamp-3 mb-6 leading-relaxed">
              <?php echo esc_html($t['description']); ?></p>
            <div class="flex items-center gap-3">
              <a href="<?php echo url('get-involved'); ?>?trip=<?php echo (int)$t['id']; ?>"
                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white font-semibold text-sm shadow-sm hover:shadow-md transition-all duration-200"
                style="background: <?php echo RCN_GRADIENT; ?>;">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                    class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
                Donate
              </a>
              <a href="<?php echo url('trips/' . (int)$t['id']); ?>"
                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition-colors duration-200">
                View details
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 5l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
      <?php if (empty($trips)): ?>
        <div class="col-span-full text-center py-12">
          <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">No Upcoming Trips</h3>
          <p class="text-gray-600">Check back soon for new mission opportunities.</p>
        </div>
      <?php endif; ?>
    </div>
    <div class="text-center mt-8">
      <a href="<?php echo url('trips/upcoming'); ?>"
        class="inline-flex items-center gap-2 px-8 py-4 rounded-xl border-2 border-orange-500 text-orange-600 font-semibold hover:bg-orange-50 transition-all duration-300">
        View all upcoming trips
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 12h14m-7-7l7 7-7 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </a>
    </div>
  </div>

  <!-- FAQs -->
  <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-20">
    <div class="text-center mb-8">
      <h2 class="text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
      <p class="text-xl text-gray-600">Get answers to common questions about volunteering and involvement</p>
    </div>
    <div class="space-y-4 max-w-4xl mx-auto">
      <details
        class="border border-gray-200 rounded-2xl p-6 hover:border-orange-300 transition-colors duration-300 group">
        <summary
          class="cursor-pointer font-semibold text-lg text-gray-900 flex items-center justify-between group-open:text-orange-600">
          Do I need to be a medical professional?
          <svg class="h-6 w-6 text-gray-400 group-open:text-orange-500 group-open:rotate-180 transition-all duration-300"
            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 9l6 6 6-6" class="icon-stroke" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </summary>
        <p class="mt-4 text-gray-600 leading-relaxed">Medical and non-medical roles are available. We welcome
          clinicians, students, and volunteers for logistics, registration, hospitality, and prayer.</p>
      </details>
      <details
        class="border border-gray-200 rounded-2xl p-6 hover:border-orange-300 transition-colors duration-300 group">
        <summary
          class="cursor-pointer font-semibold text-lg text-gray-900 flex items-center justify-between group-open:text-orange-600">
          How do I apply for a trip?
          <svg class="h-6 w-6 text-gray-400 group-open:text-orange-500 group-open:rotate-180 transition-all duration-300"
            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 9l6 6 6-6" class="icon-stroke" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </summary>
        <p class="mt-4 text-gray-600 leading-relaxed">Browse <a
            class="text-orange-600 hover:text-orange-700 font-semibold"
            href="<?php echo url('trips/upcoming'); ?>">Upcoming Trips</a> and submit your interest. Our
          team will follow up with next steps and application details.</p>
      </details>
      <details
        class="border border-gray-200 rounded-2xl p-6 hover:border-orange-300 transition-colors duration-300 group">
        <summary
          class="cursor-pointer font-semibold text-lg text-gray-900 flex items-center justify-between group-open:text-orange-600">
          Can I support without traveling?
          <svg class="h-6 w-6 text-gray-400 group-open:text-orange-500 group-open:rotate-180 transition-all duration-300"
            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 9l6 6 6-6" class="icon-stroke" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </summary>
        <p class="mt-4 text-gray-600 leading-relaxed">Absolutely! You can donate medical supplies, join our
          prayer team, partner as an organization, or help on the Medication Sorting Team. Every form of
          support makes a difference.</p>
      </details>
    </div>
  </div>

  <!-- Final CTAs -->
  <div class="rounded-2xl p-12 text-white shadow-2xl" style="background: <?php echo RCN_GRADIENT; ?>;">
    <div class="text-center max-w-4xl mx-auto">
      <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Make an Impact?</h2>
      <p class="text-xl text-white/90 mb-8 leading-relaxed">Join a medical mission, support with supplies, or
        serve from home. Every role matters in bringing hope and healing.</p>
      <div class="flex flex-wrap justify-center gap-6">
        <a class="inline-flex items-center gap-3 px-8 py-4 rounded-xl bg-white text-orange-600 font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300"
          href="<?php echo url('trips/upcoming'); ?>">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" class="icon-stroke" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="8.5" cy="7" r="4" class="icon-stroke" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" />
            <path d="M20 8v6M23 11h-6" class="icon-stroke" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Join a Mission Trip
        </a>
        <a class="inline-flex items-center gap-3 px-8 py-4 rounded-xl border-2 border-white text-white font-bold hover:bg-white/10 transition-all duration-300"
          href="<?php echo url('resources'); ?>">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
              class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
          Explore Resources
        </a>
        <a class="inline-flex items-center gap-3 px-8 py-4 rounded-xl border-2 border-white text-white font-bold hover:bg-white/10 transition-all duration-300"
          href="<?php echo url('contact'); ?>?subject=<?php echo urlencode('Volunteering Interest'); ?>">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"
              class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
          Register Your Interest
        </a>
      </div>
    </div>
  </div>
</section>

<style>
  details summary::-webkit-details-marker {
    display: none;
  }

  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>
<script>
  // Animated counter for stats
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
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>