<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../includes/constants.php'; ?>
<?php
$id = (int)($_GET['id'] ?? 0);
$trip = null;
try {
  $stmt = db()->prepare('SELECT * FROM trips WHERE id = ? LIMIT 1');
  $stmt->execute([$id]);
  $trip = $stmt->fetch();
} catch (Throwable $e) {
  $trip = null;
}
if (!$trip) {
  header('HTTP/1.1 404 Not Found');
}

$title = $trip ? $trip['title'] : 'Trip not found';
$page_title = $title . ' • ' . APP_NAME;
$page_description = $trip && !empty($trip['description']) ? substr($trip['description'], 0, 160) : 'Mission trip details';
$page_image = $trip && !empty($trip['image']) ? url('uploads/' . $trip['image']) : url('assets/images/hero1.jpg');

// Calculate trip status
$today = strtotime(date('Y-m-d'));
$start_date = strtotime($trip['start_date']);
$end_date = !empty($trip['end_date']) ? strtotime($trip['end_date']) : null;
$register_deadline = !empty($trip['register_deadline']) ? strtotime($trip['register_deadline']) : null;

$trip_status = '';
$status_color = '';
if ($end_date && $end_date < $today) {
  $trip_status = 'Completed';
  $status_color = 'bg-gray-100 text-gray-800';
} elseif ($start_date && $start_date > $today) {
  $days_until = ceil(($start_date - $today) / 86400);
  $trip_status = $days_until . ' days to go';
  $status_color = 'bg-blue-100 text-blue-800';
} elseif ($end_date && $end_date >= $today) {
  $trip_status = 'In Progress';
  $status_color = 'bg-orange-100 text-orange-800';
} else {
  $trip_status = 'Starting Soon';
  $status_color = 'bg-green-100 text-green-800';
}
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Modern Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-r from-blue-900 to-indigo-800">
  <div class="absolute inset-0 opacity-20">
    <div class="absolute inset-0"
      style="background-image: url('<?php echo esc_attr($page_image); ?>'); background-size: cover; background-position: center;">
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

  <div class="relative max-w-7xl mx-auto px-4 py-20 text-white">
    <nav class="flex text-sm text-white/80 mb-4">
      <a href="<?php echo url(''); ?>" class="hover:underline transition-colors">Home</a>
      <span class="mx-2">/</span>
      <a href="<?php echo url('trips.php'); ?>" class="hover:underline transition-colors">Trips</a>
      <span class="mx-2">/</span>
      <span class="text-white"><?php echo esc_html($title); ?></span>
    </nav>

    <div class="flex flex-wrap items-start justify-between gap-6">
      <div class="max-w-2xl">
        <div
          class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-4">
          <span
            class="w-2 h-2 rounded-full <?php echo strpos($status_color, 'blue') !== false ? 'bg-blue-400' : (strpos($status_color, 'orange') !== false ? 'bg-orange-400' : (strpos($status_color, 'green') !== false ? 'bg-green-400' : 'bg-gray-400')); ?> mr-2 animate-pulse"></span>
          <?php echo $trip_status; ?>
        </div>

        <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight" style="font-family: Poppins, sans-serif;">
          <?php echo esc_html($title); ?>
        </h1>

        <div class="space-y-2 mb-6">
          <div class="flex items-center text-white/90">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
              </path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="font-medium"><?php echo esc_html($trip['location']); ?></span>
          </div>

          <div class="flex items-center text-white/90">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
              </path>
            </svg>
            <span><?php echo esc_html($trip['start_date']); ?><?php if (!empty($trip['end_date'])): ?> –
              <?php echo esc_html($trip['end_date']); ?><?php endif; ?></span>
          </div>

          <?php if ($register_deadline): ?>
            <div class="flex items-center text-white/90">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>Register by: <?php echo esc_html($trip['register_deadline']); ?></span>
            </div>
          <?php endif; ?>
        </div>

        <div class="flex flex-wrap gap-3">
          <a href="<?php echo url('get-involved'); ?>?trip=<?php echo (int)$trip['id']; ?>"
            class="inline-flex items-center px-5 py-3 rounded-lg font-medium text-white transition-all duration-300 transform hover:scale-105 shadow-lg"
            style="background: <?php echo RCN_GRADIENT; ?>">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
              </path>
            </svg>
            Support This Trip
          </a>

          <a href="<?php echo url('contact'); ?>?subject=<?php echo urlencode('Trip Interest: ' . $trip['title']); ?>&trip=<?php echo (int)$trip['id']; ?>"
            class="inline-flex items-center px-5 py-3 rounded-lg font-medium border-2 border-white/30 text-white hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
              </path>
            </svg>
            Ask Questions
          </a>
        </div>
      </div>

      <?php if (!empty($trip['cost']) || !empty($trip['spots_available'])): ?>
        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 min-w-[280px]">
          <h3 class="font-semibold text-white mb-4 text-lg">Trip Details</h3>
          <div class="space-y-3">
            <?php if (!empty($trip['cost'])): ?>
              <div class="flex justify-between items-center">
                <span class="text-white/80">Estimated Cost</span>
                <span
                  class="text-white font-semibold text-lg">$<?php echo esc_html(number_format((float)$trip['cost'], 0)); ?></span>
              </div>
            <?php endif; ?>

            <?php if (!empty($trip['spots_available'])): ?>
              <div class="flex justify-between items-center">
                <span class="text-white/80">Spots Available</span>
                <span
                  class="text-white font-semibold text-lg"><?php echo (int)$trip['spots_available']; ?></span>
              </div>
            <?php endif; ?>

            <?php if ($register_deadline): ?>
              <div class="pt-3 border-t border-white/20">
                <div class="text-center">
                  <p class="text-white/70 text-sm mb-2">Registration Deadline</p>
                  <p class="text-white font-medium"><?php echo esc_html($trip['register_deadline']); ?></p>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Main Content -->
<section class="max-w-7xl mx-auto px-4 py-12 grid lg:grid-cols-3 gap-8">
  <!-- Main Content -->
  <article class="lg:col-span-2">
    <?php if (!$trip): ?>
      <!-- 404 State -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Trip Not Found</h2>
        <p class="text-gray-600 mb-6">We couldn't find the trip you're looking for.</p>
        <a href="<?php echo url('trips.php'); ?>"
          class="inline-flex items-center px-5 py-2 rounded-lg font-medium text-white transition-all duration-300"
          style="background: <?php echo RCN_GRADIENT; ?>">
          Browse All Trips
        </a>
      </div>
    <?php else: ?>
      <!-- Trip Description -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Mission</h2>
        <div class="prose max-w-none text-gray-700 leading-relaxed">
          <?php
            $allowedTags = '<p><br><strong><em><u><ul><ol><li><h1><h2><h3><h4><h5><h6><blockquote><a><img><span>'; 
            echo strip_tags($trip['description'], $allowedTags);
          ?>
        </div>
      </div>

      <!-- Quick Stats -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
          <div class="text-2xl font-bold text-gray-900 mb-1">
            <?php echo !empty($trip['spots_available']) ? (int)$trip['spots_available'] : 'N/A'; ?></div>
          <div class="text-sm text-gray-600">Spots Available</div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
          <div class="text-2xl font-bold text-gray-900 mb-1">
            $<?php echo !empty($trip['cost']) ? number_format((float)$trip['cost'], 0) : 'N/A'; ?></div>
          <div class="text-sm text-gray-600">Estimated Cost</div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
          <div class="text-2xl font-bold text-gray-900 mb-1">
            <?php echo !empty($trip['end_date']) ? date_diff(date_create($trip['start_date']), date_create($trip['end_date']))->days + 1 : 'N/A'; ?>
          </div>
          <div class="text-sm text-gray-600">Days</div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
          <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $trip_status; ?></div>
          <div class="text-sm text-gray-600">Status</div>
        </div>
      </div>

      <!-- Call to Action Cards -->
      <div class="grid md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
          <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
              </path>
            </svg>
          </div>
          <h3 class="font-semibold text-lg mb-2">Support This Mission</h3>
          <p class="text-gray-600 text-sm mb-4">Your donation helps provide medical care, supplies, and resources
            for this mission trip.</p>
          <a href="<?php echo url('get-involved'); ?>?trip=<?php echo (int)$trip['id']; ?>"
            class="inline-flex items-center px-4 py-2 rounded-lg font-medium text-white transition-all duration-300"
            style="background: <?php echo RCN_GRADIENT; ?>">
            Donate Now
          </a>
        </div>

        <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 border border-orange-100">
          <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
              </path>
            </svg>
          </div>
          <h3 class="font-semibold text-lg mb-2">Join This Mission</h3>
          <p class="text-gray-600 text-sm mb-4">Interested in volunteering? We'd love to have you join our team.
          </p>
          <a href="<?php echo url('contact'); ?>?subject=<?php echo urlencode('Volunteer Interest: ' . $trip['title']); ?>&trip=<?php echo (int)$trip['id']; ?>"
            class="inline-flex items-center px-4 py-2 rounded-lg font-medium border border-orange-300 text-orange-700 bg-white hover:bg-orange-50 transition-colors">
            Express Interest
          </a>
        </div>
      </div>

      <!-- Interest Form -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Register Your Interest</h3>
        <p class="text-gray-600 mb-6">Fill out this form to let us know you're interested in this mission trip.
          We'll follow up with more details.</p>

        <form id="interestForm" class="space-y-4" onsubmit="event.preventDefault(); handleInterestForm();">
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label for="interestName" class="block text-sm font-medium text-gray-700 mb-1">Full Name
                *</label>
              <input id="interestName" type="text"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                placeholder="Your name" required>
            </div>
            <div>
              <label for="interestEmail" class="block text-sm font-medium text-gray-700 mb-1">Email Address
                *</label>
              <input id="interestEmail" type="email"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                placeholder="your.email@example.com" required>
            </div>
          </div>

          <div>
            <label for="interestNote" class="block text-sm font-medium text-gray-700 mb-1">Questions or
              Comments</label>
            <textarea id="interestNote" rows="3"
              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
              placeholder="Any specific questions or information you'd like to share..."></textarea>
          </div>

          <button type="submit"
            class="w-full bg-gray-900 text-white py-3 px-6 rounded-lg font-medium hover:bg-gray-800 transition-colors flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
              </path>
            </svg>
            Submit Interest Form
          </button>
        </form>

        <script>
          function handleInterestForm() {
            const name = document.getElementById('interestName').value;
            const email = document.getElementById('interestEmail').value;
            const note = document.getElementById('interestNote').value;
            const url =
              '<?php echo url('contact'); ?>?subject=<?php echo urlencode('Trip Interest: ' . $trip['title']); ?>&trip=<?php echo (int)$trip['id']; ?>' +
              '&name=' + encodeURIComponent(name) +
              '&email=' + encodeURIComponent(email) +
              '&note=' + encodeURIComponent(note);
            window.location.href = url;
          }
        </script>
      </div>
    <?php endif; ?>
  </article>

  <!-- Sidebar -->
  <aside class="space-y-6">
    <!-- Share Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
      <h3 class="font-semibold text-lg mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
          </path>
        </svg>
        Share This Trip
      </h3>
      <p class="text-gray-600 text-sm mb-4">Help spread the word about this mission opportunity.</p>
      <div class="flex gap-2">
        <?php $shareUrl = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ($_SERVER['REQUEST_URI'] ?? ''); ?>
        <a class="flex-1 text-center px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center"
          target="_blank" rel="noopener"
          href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($shareUrl); ?>">
          <svg class="w-4 h-4 mr-1 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
          </svg>
          <span class="text-sm">Facebook</span>
        </a>
        <a class="flex-1 text-center px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center"
          target="_blank" rel="noopener"
          href="https://twitter.com/intent/tweet?url=<?php echo urlencode($shareUrl); ?>&text=<?php echo urlencode($title); ?>">
          <svg class="w-4 h-4 mr-1 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.016 10.016 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
          </svg>
          <span class="text-sm">Twitter</span>
        </a>
        <a class="flex-1 text-center px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center"
          target="_blank" rel="noopener"
          href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($shareUrl); ?>">
          <svg class="w-4 h-4 mr-1 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
          </svg>
          <span class="text-sm">LinkedIn</span>
        </a>
      </div>
    </div>

    <!-- Other Trips -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
      <h3 class="font-semibold text-lg mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
          </path>
        </svg>
        Other Mission Trips
      </h3>
      <?php
      try {
        $others = db()->prepare('SELECT id, title, start_date, location FROM trips WHERE id <> ? ORDER BY start_date DESC LIMIT 5');
        $others->execute([$id]);
        $list = $others->fetchAll();
      } catch (Throwable $e) {
        $list = [];
      }
      ?>
      <div class="space-y-3">
        <?php foreach ($list as $o): ?>
          <a href="<?php echo url('trips/' . (int)$o['id']); ?>"
            class="block p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors group">
            <h4 class="font-medium text-gray-900 group-hover:text-blue-700 transition-colors">
              <?php echo esc_html($o['title']); ?></h4>
            <div class="flex justify-between items-center mt-1">
              <span class="text-sm text-gray-600"><?php echo esc_html($o['location']); ?></span>
              <span class="text-xs text-gray-500"><?php echo esc_html($o['start_date']); ?></span>
            </div>
          </a>
        <?php endforeach; ?>
        <?php if (empty($list)): ?>
          <p class="text-gray-500 text-sm py-2">No other trips available at the moment.</p>
        <?php endif; ?>
      </div>
      <div class="mt-4 pt-4 border-t border-gray-200">
        <a href="<?php echo url('trips.php'); ?>"
          class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
          View All Trips
          <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
    </div>

    <!-- Quick Contact -->
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
      <h3 class="font-semibold text-lg mb-2">Need Help?</h3>
      <p class="text-blue-100 text-sm mb-4">Have questions about this trip or our mission work?</p>
      <a href="<?php echo url('contact'); ?>"
        class="inline-flex items-center px-4 py-2 rounded-lg font-medium bg-white text-blue-700 hover:bg-blue-50 transition-colors w-full justify-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
          </path>
        </svg>
        Contact Us
      </a>
    </div>
  </aside>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
