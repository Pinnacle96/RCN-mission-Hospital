<?php
$page_title = 'Blog & Stories';
$page_description = 'Latest updates, stories, and mission insights from RCN Mission Hospital.';
// Disable the general site hero for this page (custom hero below)
$hero_enable = false;
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>

<!-- Modern Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute inset-0"
      style="background-image: url('<?php echo url('assets/images/hero3.jpg'); ?>'); background-size: cover; background-position: center;">
    </div>
  </div>

  <div class="absolute top-0 left-0 right-0 bottom-0 opacity-5">
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
    <div class="max-w-3xl mx-auto text-center">
      <div
        class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
          </path>
        </svg>
        Latest Updates & Stories
      </div>

      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight" style="font-family: Poppins, sans-serif;">
        Mission <span
          class="text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-yellow-300">Stories</span>
      </h1>

      <p class="text-xl text-white/90 mb-8 leading-relaxed max-w-2xl mx-auto">
        Discover inspiring stories, mission updates, and reflections from our work transforming lives through
        healthcare and compassion.
      </p>

      <!-- Stats Bar -->
      <div class="flex flex-wrap justify-center gap-6 mt-10">
        <div class="text-center">
          <div class="text-2xl font-bold text-white mb-1">
            <?php
            try {
              $count_stmt = db()->query('SELECT COUNT(*) as count FROM blog_posts');
              $post_count = $count_stmt->fetch()['count'];
              echo $post_count;
            } catch (Throwable $e) {
              echo '0';
            }
            ?>
          </div>
          <div class="text-white/70 text-sm">Stories Published</div>
        </div>

        <div class="text-center">
          <div class="text-2xl font-bold text-white mb-1">
            <?php
            try {
              $recent_stmt = db()->query('SELECT COUNT(*) as count FROM blog_posts WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)');
              $recent_count = $recent_stmt->fetch()['count'];
              echo $recent_count;
            } catch (Throwable $e) {
              echo '0';
            }
            ?>
          </div>
          <div class="text-white/70 text-sm">This Month</div>
        </div>

        <div class="text-center">
          <div class="text-2xl font-bold text-white mb-1">
            <?php
            try {
              $authors_stmt = db()->query('SELECT COUNT(DISTINCT author) as count FROM blog_posts');
              $authors_count = $authors_stmt->fetch()['count'];
              echo $authors_count;
            } catch (Throwable $e) {
              echo '0';
            }
            ?>
          </div>
          <div class="text-white/70 text-sm">Team Members</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scroll Indicator -->
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

<!-- Featured Post Section -->
<?php
try {
  $featured_stmt = db()->query('SELECT title, slug, excerpt, image, author, created_at FROM blog_posts ORDER BY created_at DESC LIMIT 1');
  $featured_post = $featured_stmt->fetch();
} catch (Throwable $e) {
  $featured_post = null;
}
?>

<?php if ($featured_post): ?>
  <section class="bg-gradient-to-br from-gray-50 to-white py-16">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Featured Story</h2>
          <p class="text-gray-600">Our latest and most inspiring mission update</p>
        </div>
        <div class="hidden md:block">
          <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm font-medium rounded-full">Latest</span>
        </div>
      </div>

      <article
        class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-500">
        <div class="lg:flex">
          <div class="lg:w-1/2 relative overflow-hidden">
            <?php if (!empty($featured_post['image'])): ?>
              <img src="<?php echo url('uploads/' . esc_attr($featured_post['image'])); ?>"
                alt="<?php echo esc_attr($featured_post['title']); ?>"
                class="w-full h-64 lg:h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <?php else: ?>
              <div
                class="w-full h-64 lg:h-full bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                <svg class="h-16 w-16 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </div>
            <?php endif; ?>
            <div class="absolute top-4 left-4">
              <span
                class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-800 text-sm font-medium rounded-full border border-white/50">
                Featured
              </span>
            </div>
          </div>

          <div class="lg:w-1/2 p-8 flex flex-col justify-center">
            <div class="flex items-center gap-3 text-sm text-gray-500 mb-4">
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <?php echo date('F j, Y', strtotime($featured_post['created_at'])); ?>
              </span>
              <span class="text-gray-300">•</span>
              <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                By <?php echo esc_html($featured_post['author']); ?>
              </span>
            </div>

            <h3
              class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300 leading-tight">
              <a href="<?php echo url('blog/' . esc_attr($featured_post['slug'])); ?>">
                <?php echo esc_html($featured_post['title']); ?>
              </a>
            </h3>

            <p class="text-gray-600 mb-6 text-lg leading-relaxed">
              <?php echo esc_html($featured_post['excerpt']); ?>
            </p>

            <div class="mt-auto">
              <a class="inline-flex items-center gap-3 px-6 py-3 rounded-xl text-white font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group/button"
                style="background: <?php echo RCN_GRADIENT; ?>;"
                href="<?php echo url('blog/' . esc_attr($featured_post['slug'])); ?>">
                Read Full Story
                <svg class="h-5 w-5 group-hover/button:translate-x-1 transition-transform duration-300"
                  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 12h14m-7-7l7 7-7 7" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </article>
    </div>
  </section>
<?php endif; ?>

<!-- Main Blog Content -->
<section class="max-w-7xl mx-auto px-4 py-16">
  <div class="flex flex-col lg:flex-row gap-12">
    <!-- Blog Posts Grid -->
    <div class="lg:w-2/3">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">All Stories</h2>
          <p class="text-gray-600">Browse through all our mission updates and stories</p>
        </div>

        <!-- Sort Options -->
        <div class="hidden md:flex bg-gray-100 rounded-xl p-1">
          <button
            class="px-4 py-2 rounded-lg text-sm font-medium bg-white text-gray-900 shadow-sm">Newest</button>
          <button
            class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900">Popular</button>
        </div>
      </div>

      <?php
      try {
        $stmt = db()->query('SELECT title, slug, excerpt, image, author, created_at FROM blog_posts ORDER BY created_at DESC');
        $posts = $stmt->fetchAll();
      } catch (Throwable $e) {
        $posts = [];
      }
      ?>

      <?php if (empty($posts)): ?>
        <!-- Empty State -->
        <div class="text-center py-16">
          <div class="max-w-md mx-auto">
            <svg class="h-24 w-24 mx-auto text-gray-300 mb-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <h3 class="text-2xl font-semibold text-gray-900 mb-3">No Stories Yet</h3>
            <p class="text-gray-500 mb-6">We're working on sharing our mission stories. Check back soon for
              inspiring updates from our work.</p>
            <a href="<?php echo url(''); ?>"
              class="inline-flex items-center px-5 py-2 rounded-lg font-medium text-white transition-all duration-300"
              style="background: <?php echo RCN_GRADIENT; ?>">
              Back to Home
            </a>
          </div>
        </div>
      <?php else: ?>
        <!-- Remove featured post from main grid if it exists -->
        <?php $grid_posts = $featured_post ? array_slice($posts, 1) : $posts; ?>

        <div class="grid md:grid-cols-2 gap-8">
          <?php foreach ($grid_posts as $p): ?>
            <article
              class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
              <?php if (!empty($p['image'])): ?>
                <a href="<?php echo url('blog/' . esc_attr($p['slug'])); ?>">
                  <div class="relative overflow-hidden">
                    <img src="<?php echo url('uploads/' . esc_attr($p['image'])); ?>"
                      alt="<?php echo esc_attr($p['title']); ?>"
                      class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div
                      class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300">
                    </div>
                  </div>
                </a>
              <?php else: ?>
                <div
                  class="h-48 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center relative">
                  <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                </div>
              <?php endif; ?>

              <div class="p-6">
                <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                  <span class="flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <?php echo date('M j, Y', strtotime($p['created_at'])); ?>
                  </span>
                  <span class="text-gray-300">•</span>
                  <span class="flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    By <?php echo esc_html($p['author']); ?>
                  </span>
                </div>

                <h3
                  class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200 leading-tight">
                  <a href="<?php echo url('blog/' . esc_attr($p['slug'])); ?>">
                    <?php echo esc_html($p['title']); ?>
                  </a>
                </h3>

                <p class="text-sm text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                  <?php echo esc_html($p['excerpt']); ?>
                </p>

                <div class="mt-4">
                  <a class="inline-flex items-center gap-2 text-sm px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 group/button"
                    href="<?php echo url('blog/' . esc_attr($p['slug'])); ?>">
                    Read Story
                    <svg class="h-4 w-4 group-hover/button:translate-x-1 transition-transform duration-200"
                      viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M5 12h14m-7-7l7 7-7 7" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </a>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="lg:w-1/3">
      <!-- Newsletter Signup -->
      <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white mb-8">
        <div class="w-12 h-12 rounded-lg bg-white/20 flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
            </path>
          </svg>
        </div>
        <h3 class="font-semibold text-lg mb-2">Stay Updated</h3>
        <p class="text-blue-100 text-sm mb-4">Get the latest mission stories and updates delivered to your
          inbox.</p>
        <form id="newsletterForm" class="space-y-3">
          <input id="newsletterEmail" name="email" type="email" placeholder="Your email address"
            class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50">
          <button type="submit"
            class="w-full bg-white text-blue-700 py-3 px-4 rounded-lg font-medium hover:bg-blue-50 transition-colors">Subscribe</button>
        </form>
      </div>

      <!-- Recent Stories -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-lg mb-4 flex items-center">
          <svg class="w-5 h-5 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          Recent Stories
        </h3>
        <div class="space-y-4">
          <?php
          try {
            $recent_stmt = db()->query('SELECT title, slug, created_at FROM blog_posts ORDER BY created_at DESC LIMIT 4');
            $recent_posts = $recent_stmt->fetchAll();
          } catch (Throwable $e) {
            $recent_posts = [];
          }
          ?>

          <?php foreach ($recent_posts as $recent): ?>
            <a href="<?php echo url('blog/' . esc_attr($recent['slug'])); ?>" class="block group">
              <div class="flex items-start space-x-3">
                <div class="flex-1 min-w-0">
                  <h4
                    class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 mb-1">
                    <?php echo esc_html($recent['title']); ?>
                  </h4>
                  <p class="text-xs text-gray-500">
                    <?php echo date('M j, Y', strtotime($recent['created_at'])); ?></p>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-900 to-indigo-800 text-white py-16">
  <div class="max-w-7xl mx-auto px-4 text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-4" style="font-family: Poppins, sans-serif;">
      Inspired by Our Stories?
    </h2>
    <p class="text-xl text-white/90 max-w-2xl mx-auto mb-8">
      Join our mission and be part of the next chapter in transforming lives through healthcare.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="<?php echo url('get-involved'); ?>"
        class="inline-flex items-center px-6 py-3 rounded-lg font-medium bg-white text-gray-900 hover:bg-gray-100 transition-colors shadow-lg">
        Get Involved
      </a>
      <a href="<?php echo url('contact'); ?>"
        class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white text-white hover:bg-white/10 transition-colors">
        Share Your Story
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
  // Newsletter subscribe handler (blog index)
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

<?php include __DIR__ . '/../includes/footer.php'; ?>