<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../includes/constants.php'; ?>
<?php
$slug = $_GET['slug'] ?? '';
$post = null;
try {
  $stmt = db()->prepare('SELECT * FROM blog_posts WHERE slug = ? LIMIT 1');
  $stmt->execute([$slug]);
  $post = $stmt->fetch();
} catch (Throwable $e) {
  $post = null;
}

// Prepare per-page SEO overrides using header.php support
if ($post) {
  $page_title = $post['title'] ?? '';
  $descSource = $post['excerpt'] ?? '';
  if (!$descSource) {
    $descSource = strip_tags($post['content'] ?? '');
  }
  $page_description = trim(mb_substr($descSource, 0, 160));
  if (!empty($post['image'])) {
    $page_image = url('uploads/' . $post['image']);
  }

  // Reading time estimate
  $wordCount = !empty($post['content']) ? str_word_count(strip_tags($post['content'])) : 0;
  $readMinutes = max(1, (int)round($wordCount / 200));

  // Share URLs
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $origin = $scheme . '://' . $host;
  $shareUrl = $origin . url('blog/' . $post['slug']);
  $shareText = rawurlencode($post['title']);

  // Related posts (latest excluding current)
  $related = [];
  try {
    $stmt = db()->prepare('SELECT title, slug, excerpt, image, author, created_at FROM blog_posts WHERE slug <> ? ORDER BY created_at DESC LIMIT 3');
    $stmt->execute([$post['slug']]);
    $related = $stmt->fetchAll();
  } catch (Throwable $e) {
    $related = [];
  }
}
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Modern Hero Section -->
<?php if ($post): ?>
  <section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
      <?php if (!empty($post['image'])): ?>
        <div class="absolute inset-0"
          style="background-image: url('<?php echo url('uploads/' . esc_attr($post['image'])); ?>'); background-size: cover; background-position: center;">
        </div>
      <?php else: ?>
        <div class="absolute inset-0 bg-gradient-to-br from-blue-800 to-purple-700"></div>
      <?php endif; ?>
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

    <div class="relative max-w-4xl mx-auto px-4 py-20">
      <!-- Breadcrumb -->
      <nav class="flex text-sm text-white/80 mb-6">
        <a href="<?php echo url(''); ?>" class="hover:text-orange-300 transition-colors">Home</a>
        <span class="mx-3">/</span>
        <a href="<?php echo url('blog'); ?>" class="hover:text-orange-300 transition-colors">Blog</a>
        <span class="mx-3">/</span>
        <span class="text-white truncate max-w-xs"><?php echo esc_html($post['title']); ?></span>
      </nav>

      <div class="text-center max-w-3xl mx-auto">
        <!-- Category Badge -->
        <div
          class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
            </path>
          </svg>
          Mission Story
        </div>

        <!-- Title -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight"
          style="font-family: Poppins, sans-serif;">
          <?php echo esc_html($post['title']); ?>
        </h1>

        <!-- Excerpt -->
        <?php if (!empty($post['excerpt'])): ?>
          <p class="text-xl text-white/90 mb-8 leading-relaxed max-w-2xl mx-auto">
            <?php echo esc_html($post['excerpt']); ?>
          </p>
        <?php endif; ?>

        <!-- Meta Information -->
        <div class="flex flex-wrap items-center justify-center gap-6 text-white/80">
          <div class="flex items-center gap-3">
            <div class="flex items-center gap-2">
              <div
                class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center text-white font-semibold text-sm shadow-lg">
                <?php echo strtoupper(substr($post['author'], 0, 1)); ?>
              </div>
              <div>
                <div class="font-medium text-white"><?php echo esc_html($post['author']); ?></div>
                <div class="text-sm text-white/70">Author</div>
              </div>
            </div>
          </div>

          <div class="h-8 w-px bg-white/30"></div>

          <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
              </path>
            </svg>
            <time datetime="<?php echo esc_attr($post['created_at']); ?>">
              <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
            </time>
          </div>

          <div class="h-8 w-px bg-white/30"></div>

          <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span><?php echo $readMinutes; ?> min read</span>
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
<?php endif; ?>

<!-- Main Content -->
<section class="max-w-7xl mx-auto px-4 py-12">
  <?php if ($post): ?>
    <div class="grid lg:grid-cols-4 gap-12">
      <!-- Main content -->
      <div class="lg:col-span-3">
        <!-- Hero image -->
        <?php if (!empty($post['image'])): ?>
          <figure class="mb-12 rounded-2xl overflow-hidden shadow-2xl">
            <img src="<?php echo url('uploads/' . esc_attr($post['image'])); ?>"
              alt="<?php echo esc_attr($post['title']); ?>" class="w-full h-64 md:h-96 object-cover">
          </figure>
        <?php endif; ?>

        <!-- Content -->
        <article class="prose prose-lg md:prose-xl max-w-none leading-relaxed">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
            <?php
            $allowedTags = '<p><br><strong><em><u><ul><ol><li><h1><h2><h3><h4><h5><h6><blockquote><a><img>';
            $safeContent = strip_tags($post['content'], $allowedTags);
            echo $safeContent;
            ?>
          </div>
        </article>

        <!-- Share Section -->
        <div class="mt-12 pt-8 border-t border-gray-200">
          <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">Found this story inspiring?</h3>
              <p class="text-gray-600">Share it with others who might be encouraged</p>
            </div>
            <div class="flex gap-3">
              <a class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-200 text-sm font-medium"
                target="_blank" rel="noopener"
                href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode($shareUrl); ?>&text=<?php echo $shareText; ?>">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                  <path
                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                </svg>
                Twitter
              </a>
              <a class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-200 text-sm font-medium"
                target="_blank" rel="noopener"
                href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode($shareUrl); ?>">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
                </svg>
                Facebook
              </a>
              <a class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-200 text-sm font-medium"
                target="_blank" rel="noopener"
                href="https://wa.me/?text=<?php echo rawurlencode($shareUrl); ?>">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                  <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893-.001-3.189-1.262-6.209-3.553-8.485" />
                </svg>
                WhatsApp
              </a>
            </div>
          </div>
        </div>

        <!-- Back to Blog -->
        <div class="mt-12 pt-8 border-t border-gray-200">
          <a class="inline-flex items-center gap-3 px-6 py-3 rounded-xl text-white font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
            style="background: <?php echo RCN_GRADIENT; ?>" href="<?php echo url('blog'); ?>">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            Back to All Stories
          </a>
        </div>
      </div>

      <!-- Sidebar -->
      <aside class="lg:col-span-1 space-y-8">
        <!-- Author Bio -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="text-center">
            <div
              class="w-16 h-16 rounded-full bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center text-white font-semibold text-lg mx-auto mb-4 shadow-lg">
              <?php echo strtoupper(substr($post['author'], 0, 1)); ?>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1"><?php echo esc_html($post['author']); ?></h3>
            <p class="text-sm text-gray-600 mb-4">Mission Storyteller</p>
            <p class="text-sm text-gray-600 leading-relaxed">
              Sharing inspiring stories of hope and transformation from our mission work around the world.
            </p>
          </div>
        </div>

        <!-- Related posts -->
        <?php if (!empty($related)): ?>
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
              </svg>
              More Stories
            </h3>
            <div class="space-y-4">
              <?php foreach ($related as $r): ?>
                <article
                  class="group hover:shadow-md transition-all duration-300 rounded-lg overflow-hidden border border-gray-200">
                  <?php if (!empty($r['image'])): ?>
                    <a href="<?php echo url('blog/' . esc_attr($r['slug'])); ?>">
                      <img src="<?php echo url('uploads/' . esc_attr($r['image'])); ?>"
                        alt="<?php echo esc_attr($r['title']); ?>"
                        class="w-full h-24 object-cover group-hover:scale-105 transition-transform duration-300">
                    </a>
                  <?php else: ?>
                    <div class="h-24 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
                      <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </div>
                  <?php endif; ?>
                  <div class="p-4">
                    <h4
                      class="font-semibold text-gray-900 text-sm line-clamp-2 group-hover:text-blue-600 transition-colors duration-200 mb-2 leading-tight">
                      <a href="<?php echo url('blog/' . esc_attr($r['slug'])); ?>">
                        <?php echo esc_html($r['title']); ?>
                      </a>
                    </h4>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                      <span><?php echo date('M j', strtotime($r['created_at'])); ?></span>
                      <span>By <?php echo esc_html($r['author']); ?></span>
                    </div>
                  </div>
                </article>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Newsletter -->
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
          <div class="w-12 h-12 rounded-lg bg-white/20 flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
              </path>
            </svg>
          </div>
          <h3 class="font-semibold text-lg mb-2">Stay Inspired</h3>
          <p class="text-blue-100 text-sm mb-4">Get our latest mission stories delivered to your inbox.</p>
          <form id="newsletterForm" class="space-y-3">
            <input id="newsletterEmail" name="email" type="email" placeholder="Your email address"
              class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 text-sm">
            <button type="submit"
              class="w-full bg-white text-blue-700 py-3 px-4 rounded-lg font-medium hover:bg-blue-50 transition-colors text-sm">Subscribe</button>
          </form>
        </div>
      </aside>
    </div>

  <?php else: ?>
    <!-- 404 State -->
    <div class="max-w-2xl mx-auto text-center py-20">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12">
        <svg class="h-24 w-24 mx-auto text-gray-300 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Story Not Found</h1>
        <p class="text-gray-600 mb-8 text-lg leading-relaxed">
          The mission story you're looking for doesn't exist or may have been moved to a different location.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
          <a class="inline-flex items-center gap-3 px-6 py-3 rounded-xl text-white font-medium shadow-lg hover:shadow-xl transition-all duration-300"
            style="background: <?php echo RCN_GRADIENT; ?>" href="<?php echo url('blog'); ?>">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            Back to Stories
          </a>
          <a href="<?php echo url(''); ?>"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors">
            Go Home
          </a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</section>

<style>
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .prose {
    color: #374151;
    line-height: 1.75;
  }

  .prose h1,
  .prose h2,
  .prose h3,
  .prose h4,
  .prose h5,
  .prose h6 {
    color: #111827;
    font-weight: 700;
    margin-top: 2.5em;
    margin-bottom: 1em;
    line-height: 1.3;
  }

  .prose h1 {
    font-size: 2.5em;
  }

  .prose h2 {
    font-size: 2em;
  }

  .prose h3 {
    font-size: 1.5em;
  }

  .prose h4 {
    font-size: 1.25em;
  }

  .prose p {
    margin-bottom: 1.5em;
    font-size: 1.125em;
  }

  .prose a {
    color: #f97316;
    text-decoration: none;
    font-weight: 500;
    border-bottom: 1px solid transparent;
    transition: all 0.2s ease;
  }

  .prose a:hover {
    color: #ea580c;
    border-bottom-color: #ea580c;
  }

  .prose ul,
  .prose ol {
    margin-bottom: 1.5em;
    padding-left: 1.5em;
  }

  .prose li {
    margin-bottom: 0.75em;
    font-size: 1.125em;
  }

  .prose blockquote {
    border-left: 4px solid #f97316;
    padding-left: 2em;
    margin: 2.5em 0;
    font-style: italic;
    color: #6b7280;
    background: #f9fafb;
    padding: 1.5em 2em;
    border-radius: 0.75em;
    font-size: 1.125em;
  }

  .prose strong {
    color: #111827;
    font-weight: 700;
  }

  .prose em {
    color: #6b7280;
    font-style: italic;
  }

  .prose img {
    border-radius: 0.75em;
    margin: 2em 0;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
  }
</style>

<script>
  // Newsletter subscribe handler (blog post)
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