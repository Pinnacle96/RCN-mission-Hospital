<?php require_once __DIR__ . '/config/security.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>
<?php require_once __DIR__ . '/includes/constants.php'; ?>
<?php
$view = strtolower(trim($_GET['view'] ?? 'upcoming'));
if (!in_array($view, ['upcoming', 'past'], true)) {
  $view = 'upcoming';
}

// SEO overrides
$page_title = ($view === 'upcoming' ? 'Upcoming Trips' : 'Past Trips') . ' • ' . APP_NAME;
$page_description = ($view === 'upcoming')
  ? 'See upcoming mission trips and donate towards the work.'
  : 'Browse past mission trips and mission highlights.';
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Modern Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-r from-blue-900 to-indigo-800">
  <div class="absolute inset-0 opacity-20">
    <div class="absolute inset-0"
      style="background-image: url('<?php echo url('assets/images/hero2.jpg'); ?>'); background-size: cover; background-position: center;">
    </div>
  </div>

  <!-- Background pattern -->
  <div class="absolute top-0 left-0 right-0 bottom-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
          <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#grid)" />
    </svg>
  </div>

  <div class="relative max-w-7xl mx-auto px-4 py-24 text-white">
    <div class="max-w-2xl">
      <div
        class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        <?php echo $view === 'upcoming' ? 'Open for Registration' : 'Mission Highlights'; ?>
      </div>

      <h1 class="text-5xl md:text-6xl font-bold mb-4 leading-tight" style="font-family: Poppins, sans-serif;">
        Mission <span
          class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">Trips</span>
      </h1>

      <p class="text-xl text-white/90 mb-8 leading-relaxed">
        <?php echo $view === 'upcoming'
          ? 'Join our upcoming medical missions and transform lives through healthcare and compassion.'
          : 'Explore the impact of our past mission trips and see how your support makes a difference.'; ?>
      </p>

      <div class="flex flex-wrap gap-4">
        <a class="inline-flex items-center px-6 py-3 rounded-lg font-medium text-white transition-all duration-300 transform hover:scale-105 shadow-lg"
          style="background: <?php echo RCN_GRADIENT; ?>"
          href="<?php echo url('trips.php'); ?>?view=upcoming">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          See Upcoming Trips
        </a>

        <a class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white/30 hover:bg-white/10 transition-all duration-300 backdrop-blur-sm"
          href="<?php echo url('trips.php'); ?>?view=past">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
          </svg>
          Browse Past Trips
        </a>
      </div>
    </div>
  </div>

  <!-- Scroll indicator -->
  <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2">
    <div class="animate-bounce">
      <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
        </path>
      </svg>
    </div>
  </div>
</section>

<!-- Main Content -->
<section class="max-w-7xl mx-auto px-4 py-12">
  <!-- Breadcrumb + filters -->
  <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-10">
    <div class="mb-6 md:mb-0">
      <nav class="flex text-sm text-gray-600 mb-3">
        <a href="<?php echo url(''); ?>" class="hover:text-mission_orange transition-colors">Home</a>
        <span class="mx-2">/</span>
        <a href="<?php echo url('trips.php'); ?>" class="hover:text-mission_orange transition-colors">Trips</a>
        <span class="mx-2">/</span>
        <span
          class="text-gray-900 font-medium"><?php echo $view === 'upcoming' ? 'Upcoming Trips' : 'Past Trips'; ?></span>
      </nav>

      <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2" style="font-family: Poppins, sans-serif;">
        <?php echo $view === 'upcoming' ? 'Upcoming Mission Trips' : 'Past Mission Highlights'; ?>
      </h2>

      <p class="text-gray-600 max-w-2xl">
        <?php echo $view === 'upcoming'
          ? 'Join us in upcoming missions. You can register to volunteer or donate to support each trip.'
          : 'Highlights and details from past mission trips showing the impact of our work.'; ?>
      </p>
    </div>

    <div class="flex bg-gray-100 rounded-xl p-1">
      <a class="px-5 py-2 rounded-lg text-sm font-medium transition-all duration-300 <?php echo $view === 'upcoming' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900'; ?>"
        href="<?php echo url('trips.php'); ?>?view=upcoming">
        Upcoming
      </a>
      <a class="px-5 py-2 rounded-lg text-sm font-medium transition-all duration-300 <?php echo $view === 'past' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900'; ?>"
        href="<?php echo url('trips.php'); ?>?view=past">
        Past
      </a>
    </div>
  </div>

  <!-- Info Cards -->
  <div class="grid md:grid-cols-3 gap-6 mb-12">
    <div
      class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md">
      <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center mb-4">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
      </div>
      <h3 class="font-semibold text-lg mb-2">Who Can Serve</h3>
      <p class="text-gray-600 text-sm mb-3">Medical and non-medical volunteers are welcome. There's a place for
        you to serve.</p>
      <ul class="text-sm text-gray-600 space-y-1">
        <li class="flex items-start">
          <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <span>Physicians, Dentists, Nurse Practitioners</span>
        </li>
        <li class="flex items-start">
          <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <span>Nurses, Pharmacists, Optometrists</span>
        </li>
        <li class="flex items-start">
          <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <span>Medical students and allied health</span>
        </li>
        <li class="flex items-start">
          <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <span>Non-medical volunteers for logistics and prayer</span>
        </li>
      </ul>
    </div>

    <div
      class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md">
      <div class="w-12 h-12 rounded-lg bg-orange-50 flex items-center justify-center mb-4">
        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
          </path>
        </svg>
      </div>
      <h3 class="font-semibold text-lg mb-2">Safety & Planning</h3>
      <p class="text-gray-600 text-sm">We partner locally to plan itineraries and keep volunteers safe, with
        logistics handled by experienced leaders.</p>
    </div>

    <div
      class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md">
      <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center mb-4">
        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
          </path>
        </svg>
      </div>
      <h3 class="font-semibold text-lg mb-2">Costs & Fundraising</h3>
      <p class="text-gray-600 text-sm">We keep trip costs as low as possible and help volunteers raise funds. God
        provides in amazing ways.</p>
    </div>
  </div>

  <!-- Trips Grid -->
  <?php
  try {
    if ($view === 'upcoming') {
      $stmt = db()->query('SELECT id, title, location, start_date, end_date, description, image, cost, register_deadline, spots_available FROM trips WHERE (end_date >= CURDATE() OR start_date >= CURDATE()) ORDER BY start_date ASC');
    } else {
      // Past trips: either have an end_date before today, or no end_date and a start_date before today
      $stmt = db()->query("SELECT id, title, location, start_date, end_date, description, image, cost, register_deadline, spots_available FROM trips WHERE ((end_date IS NOT NULL AND end_date < CURDATE()) OR (end_date IS NULL AND start_date < CURDATE())) ORDER BY COALESCE(end_date, start_date) DESC");
    }
    $trips = $stmt->fetchAll();
  } catch (Throwable $e) {
    $trips = [];
  }
  ?>

  <?php if (!empty($trips)): ?>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($trips as $i => $t): ?>
        <?php
        $fallbackImages = [
          url('assets/images/hero1.jpg'),
          url('assets/images/hero2.jpg'),
          url('assets/images/hero3.jpg'),
          url('assets/images/hero4.jpg'),
        ];
        $img = !empty($t['image']) ? url('uploads/' . $t['image']) : $fallbackImages[$i % count($fallbackImages)];
        $start = strtotime($t['start_date']);
        $end = !empty($t['end_date']) ? strtotime($t['end_date']) : null;
        $today = strtotime(date('Y-m-d'));
        $statusBadge = '';
        $statusColor = '';
        if ($view === 'upcoming') {
          if ($start && $start > $today) {
            $days = ceil(($start - $today) / 86400);
            $statusBadge = $days . ' days to go';
            $statusColor = 'bg-blue-100 text-blue-800';
          } elseif ($end && $end >= $today) {
            $statusBadge = 'In progress';
            $statusColor = 'bg-orange-100 text-orange-800';
          } else {
            $statusBadge = 'Starting soon';
            $statusColor = 'bg-green-100 text-green-800';
          }
        } else {
          $statusBadge = 'Completed';
          $statusColor = 'bg-gray-100 text-gray-800';
        }
        ?>
        <article
          class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
          <div class="relative overflow-hidden">
            <a href="<?php echo url('trips/' . (int)$t['id']); ?>">
              <img src="<?php echo $img; ?>" alt="Trip image"
                class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
            </a>
            <div class="absolute top-3 left-3 flex flex-wrap gap-2">
              <span
                class="px-3 py-1 text-xs font-medium rounded-full bg-white/90 backdrop-blur-sm text-gray-800 border border-white/50"><?php echo esc_html($t['location']); ?></span>
              <span
                class="px-3 py-1 text-xs font-medium rounded-full <?php echo $statusColor; ?>"><?php echo esc_html($statusBadge); ?></span>
            </div>
          </div>

          <div class="p-6">
            <div class="flex justify-between items-start mb-2">
              <p class="text-xs uppercase tracking-wide text-gray-500 font-medium">
                <?php echo esc_html($t['location']); ?>
              </p>
              <?php if (!empty($t['cost'])): ?>
                <span
                  class="text-sm font-semibold text-gray-900">$<?php echo esc_html(number_format((float)$t['cost'], 0)); ?></span>
              <?php endif; ?>
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-mission_orange transition-colors">
              <a href="<?php echo url('trips/' . (int)$t['id']); ?>"><?php echo esc_html($t['title']); ?></a>
            </h3>

            <div class="flex items-center text-sm text-gray-500 mb-3">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
              </svg>
              <span><?php echo esc_html($t['start_date']); ?><?php if (!empty($t['end_date'])): ?> –
                <?php echo esc_html($t['end_date']); ?><?php endif; ?></span>
            </div>

            <?php if (!empty($t['register_deadline'])): ?>
              <div class="flex items-center text-sm text-gray-500 mb-3">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Register by: <?php echo esc_html($t['register_deadline']); ?></span>
              </div>
            <?php endif; ?>

            <?php if (!empty($t['spots_available'])): ?>
              <div class="flex items-center text-sm text-gray-500 mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                  </path>
                </svg>
                <span><?php echo (int)$t['spots_available']; ?> spots available</span>
              </div>
            <?php endif; ?>

            <p class="text-gray-600 line-clamp-3 mb-5"><?php echo esc_html($t['description']); ?></p>

            <div class="flex flex-wrap gap-2">
              <?php if ($view === 'upcoming'): ?>
                <a href="<?php echo url('get-involved'); ?>?trip=<?php echo (int)$t['id']; ?>"
                  class="flex-1 text-center px-4 py-2 rounded-lg font-medium text-white transition-all duration-300 hover:shadow-md"
                  style="background: <?php echo RCN_GRADIENT; ?>">
                  Donate
                </a>
                <a href="<?php echo url('contact'); ?>"
                  class="flex-1 text-center px-4 py-2 rounded-lg font-medium border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                  Inquire
                </a>
              <?php else: ?>
                <a href="<?php echo url('trips/' . (int)$t['id']); ?>"
                  class="flex-1 text-center px-4 py-2 rounded-lg font-medium border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                  View Details
                </a>
              <?php endif; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <!-- Empty State -->
    <div class="text-center py-16">
      <div class="max-w-md mx-auto">
        <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">No trips found</h3>
        <p class="text-gray-500 mb-6">
          <?php echo $view === 'upcoming'
            ? 'There are currently no upcoming trips scheduled. Check back later for new mission opportunities.'
            : 'No past trips are available at the moment.'; ?>
        </p>
        <?php if ($view === 'past'): ?>
          <a href="<?php echo url('trips.php'); ?>?view=upcoming"
            class="inline-flex items-center px-5 py-2 rounded-lg font-medium text-white transition-all duration-300"
            style="background: <?php echo RCN_GRADIENT; ?>">
            View Upcoming Trips
          </a>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-900 to-indigo-800 text-white py-16">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-4" style="font-family: Poppins, sans-serif;">
      Ready to Make a Difference?
    </h2>
    <p class="text-xl text-white/90 max-w-2xl mx-auto mb-8">
      Whether you join a mission trip or support from home, your involvement changes lives.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="<?php echo url('get-involved'); ?>"
        class="inline-flex items-center px-6 py-3 rounded-lg font-medium bg-white text-gray-900 hover:bg-gray-100 transition-colors shadow-lg">
        Get Involved
      </a>
      <a href="<?php echo url('contact'); ?>"
        class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white text-white hover:bg-white/10 transition-colors">
        Contact Us
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>