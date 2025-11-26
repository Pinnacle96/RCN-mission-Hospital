<?php require_once __DIR__ . '/config/security.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>
<?php require_once __DIR__ . '/includes/constants.php'; ?>
<?php
// Page-level SEO overrides
$page_title = 'Outreach Reports • ' . APP_NAME;
$page_description = 'Explore mission outreach reports, impact summaries, photos, and downloadable files.';
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 9;
?>

<!-- Modern Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-20">
    <div class="absolute inset-0"
      style="background-image: url('<?php echo url('assets/images/hero1.jpg'); ?>'); background-size: cover; background-position: center;">
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
      <nav class="flex text-sm text-white/80 mb-6">
        <a href="<?php echo url(''); ?>" class="hover:text-orange-300 transition-colors">Home</a>
        <span class="mx-3">/</span>
        <span class="text-white">Outreach Reports</span>
      </nav>

      <div
        class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        Mission Impact & Stories
      </div>

      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight" style="font-family: Poppins, sans-serif;">
        Outreach <span
          class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">Reports</span>
      </h1>

      <p class="text-xl text-white/90 mb-8 leading-relaxed">
        Explore detailed reports, impact summaries, and inspiring stories from our medical missions and
        community outreach programs around the world.
      </p>

      <div class="flex flex-wrap gap-4">
        <a href="#reports-grid"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium text-white transition-all duration-300 transform hover:scale-105 shadow-lg"
          style="background: <?php echo RCN_GRADIENT; ?>">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
          </svg>
          View Reports
        </a>

        <a href="#stats"
          class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white/30 text-white hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
            </path>
          </svg>
          See Impact Stats
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section id="stats" class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Our Outreach Impact</h2>
      <p class="text-xl text-gray-600 leading-relaxed">Quantifying the difference we're making together in
        communities worldwide.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="50">0</div>
        <div class="text-gray-600">Outreach Missions</div>
      </div>
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="25000">0</div>
        <div class="text-gray-600">Lives Impacted</div>
      </div>
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="15">0</div>
        <div class="text-gray-600">Countries Reached</div>
      </div>
      <div class="text-center">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2" data-count="75">0</div>
        <div class="text-gray-600">Reports Published</div>
      </div>
    </div>
  </div>
</section>

<!-- Reports Grid Section -->
<section id="reports-grid" class="bg-gradient-to-br from-gray-50 to-white py-20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex flex-col lg:flex-row items-start lg:items-end justify-between mb-12">
      <div class="max-w-2xl">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Mission Reports</h2>
        <p class="text-xl text-gray-600 leading-relaxed">Detailed accounts of our medical missions, community
          impact, and transformation stories.</p>
      </div>

      <!-- Filter Options -->
      <div class="flex bg-gray-100 rounded-xl p-1 mt-6 lg:mt-0">
        <button class="px-4 py-2 rounded-lg text-sm font-medium bg-white text-gray-900 shadow-sm">All
          Reports</button>
        <button class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900">2024</button>
        <button class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900">2023</button>
      </div>
    </div>

    <?php
    try {
      $count = (int)db()->query('SELECT COUNT(*) FROM outreach_reports')->fetchColumn();
      $pages = max(1, (int)ceil($count / $perPage));
      if ($page > $pages) $page = $pages;
      $offset = ($page - 1) * $perPage;
      $reports = db()->query('SELECT id, title, description, file_link, image, date FROM outreach_reports ORDER BY date DESC, id DESC LIMIT ' . (int)$perPage . ' OFFSET ' . (int)$offset)->fetchAll();
    } catch (Throwable $e) {
      $reports = [];
      $pages = 1;
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

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($reports as $r): ?>
        <article
          class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-500">
          <?php if (!empty($r['image'])): ?>
            <div class="relative overflow-hidden">
              <img src="<?php echo url('uploads/' . esc_attr($r['image'])); ?>"
                alt="<?php echo esc_attr($r['title']); ?>"
                class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105">
              <div class="absolute top-4 left-4">
                <span
                  class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-800 text-sm font-medium rounded-full border border-white/50">
                  <?php echo date('M Y', strtotime($r['date'])); ?>
                </span>
              </div>
            </div>
          <?php else: ?>
            <div
              class="h-56 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center relative">
              <svg class="h-12 w-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
              </svg>
              <div class="absolute top-4 left-4">
                <span
                  class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-800 text-sm font-medium rounded-full border border-white/50">
                  <?php echo date('M Y', strtotime($r['date'])); ?>
                </span>
              </div>
            </div>
          <?php endif; ?>

          <div class="p-6">
            <h3
              class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors duration-300 leading-tight">
              <a href="<?php echo url('outreach-report/view.php'); ?>?id=<?php echo (int)$r['id']; ?>">
                <?php echo esc_html($r['title']); ?>
              </a>
            </h3>

            <p class="text-gray-600 mb-4 leading-relaxed text-sm line-clamp-3">
              <?php echo esc_html(excerpt_plain($r['description'], 220)); ?>
            </p>

            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
              <div class="flex items-center gap-4">
                <a href="<?php echo url('outreach-report/view.php'); ?>?id=<?php echo (int)$r['id']; ?>"
                  class="inline-flex items-center gap-2 text-blue-600 font-medium hover:text-blue-700 transition-colors duration-300 text-sm">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                  </svg>
                  Read Report
                </a>

                <?php if (!empty($r['file_link'])): ?>
                  <a href="<?php echo esc_attr($r['file_link']); ?>" target="_blank" rel="noopener"
                    class="inline-flex items-center gap-2 text-green-600 font-medium hover:text-green-700 transition-colors duration-300 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                      </path>
                    </svg>
                    Download PDF
                  </a>
                <?php endif; ?>
              </div>

              <span class="text-xs text-gray-500">
                <?php echo date('M j, Y', strtotime($r['date'])); ?>
              </span>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if (($pages ?? 1) > 1): ?>
      <div class="mt-8 flex items-center justify-center gap-2">
        <?php if ($page > 1): ?>
          <a href="<?php echo url('outreach-report'); ?>?page=<?php echo (int)($page - 1); ?>" class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Prev</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $pages; $i++): ?>
          <a href="<?php echo url('outreach-report'); ?>?page=<?php echo (int)$i; ?>" class="px-3 py-2 rounded-lg <?php echo $i === $page ? 'bg-gray-900 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50'; ?>"><?php echo (int)$i; ?></a>
        <?php endfor; ?>
        <?php if ($page < $pages): ?>
          <a href="<?php echo url('outreach-report'); ?>?page=<?php echo (int)($page + 1); ?>" class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Next</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (empty($reports)): ?>
      <!-- Empty State -->
      <div class="text-center py-16">
        <div class="max-w-md mx-auto">
          <svg class="h-24 w-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
          </svg>
          <h3 class="text-2xl font-semibold text-gray-900 mb-3">No Reports Available</h3>
          <p class="text-gray-500 mb-6">We're currently compiling our latest mission reports. Check back soon for
            updates on our outreach impact.</p>
          <a href="<?php echo url('blog'); ?>"
            class="inline-flex items-center px-5 py-2 rounded-lg font-medium text-white transition-all duration-300"
            style="background: <?php echo RCN_GRADIENT; ?>">
            Read Our Blog
          </a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-900 to-indigo-800 text-white py-20">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-4xl md:text-5xl font-bold mb-6">Stay Updated</h2>
    <p class="text-xl text-white/90 max-w-3xl mx-auto mb-8 leading-relaxed">
      Subscribe to receive our latest outreach reports and mission updates directly in your inbox.
    </p>
    <form id="newsletterForm" class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
      <input id="newsletterEmail" name="email" type="email" placeholder="Your email address"
        class="flex-1 px-4 py-3 rounded-lg border border-white/30 bg-white/10 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50">
      <button type="submit"
        class="px-6 py-3 rounded-lg bg-white text-gray-900 font-medium hover:bg-gray-100 transition-colors shadow-lg">
        Subscribe
      </button>
    </form>
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
  // Newsletter subscribe handler (outreach report)
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('newsletterForm');
    if (!form) return;
    const input = form.querySelector('#newsletterEmail') || form.querySelector('input[type="email"]');

    // Use global toast helper if available

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
