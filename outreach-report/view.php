<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../includes/constants.php'; ?>
<?php
$id = (int)($_GET['id'] ?? 0);
$report = null;
try {
  $stmt = db()->prepare('SELECT id, title, description, file_link, image, date FROM outreach_reports WHERE id=? LIMIT 1');
  $stmt->execute([$id]);
  $report = $stmt->fetch();
} catch (Throwable $e) {
  $report = null;
}

if (!$report) {
  $page_title = 'Report Not Found • ' . APP_NAME;
  $page_description = 'The requested outreach report could not be found.';
} else {
  $page_title = esc_html($report['title']) . ' • Outreach Report';
  $page_description = substr(strip_tags($report['description']), 0, 160);
  $page_image = !empty($report['image']) ? url('uploads/' . esc_attr($report['image'])) : null;
}
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Modern Hero Section -->
<?php if ($report): ?>
  <section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-20">
      <?php if (!empty($report['image'])): ?>
        <div class="absolute inset-0"
          style="background-image: url('<?php echo url('uploads/' . esc_attr($report['image'])); ?>'); background-size: cover; background-position: center;">
        </div>
      <?php else: ?>
        <div class="absolute inset-0 bg-gradient-to-br from-blue-800 to-purple-700"></div>
      <?php endif; ?>
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

    <div class="relative max-w-7xl mx-auto px-4 py-20">
      <nav class="flex text-sm text-white/80 mb-6">
        <a href="<?php echo url(''); ?>" class="hover:text-orange-300 transition-colors">Home</a>
        <span class="mx-3">/</span>
        <a href="<?php echo url('outreach-report'); ?>" class="hover:text-orange-300 transition-colors">Outreach
          Reports</a>
        <span class="mx-3">/</span>
        <span class="text-white truncate max-w-xs"><?php echo esc_html($report['title']); ?></span>
      </nav>

      <div class="max-w-4xl">
        <div
          class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
          </svg>
          Outreach Report
        </div>

        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight"
          style="font-family: Poppins, sans-serif;">
          <?php echo esc_html($report['title']); ?>
        </h1>

        <div class="flex items-center gap-6 text-white/80 mb-8">
          <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
              </path>
            </svg>
            <time datetime="<?php echo esc_attr($report['date']); ?>">
              <?php echo date('F j, Y', strtotime($report['date'])); ?>
            </time>
          </div>

          <?php if (!empty($report['file_link'])): ?>
            <div class="h-6 w-px bg-white/30"></div>
            <a href="<?php echo esc_attr($report['file_link']); ?>" target="_blank" rel="noopener"
              class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white hover:bg-white/30 transition-all duration-300">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
              </svg>
              Download Full Report
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- Main Content -->
<section class="max-w-7xl mx-auto px-4 py-12">
  <?php if (!$report): ?>
    <!-- 404 State -->
    <div class="max-w-2xl mx-auto text-center py-20">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12">
        <svg class="h-24 w-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Report Not Found</h1>
        <p class="text-gray-600 mb-8 text-lg leading-relaxed">
          The outreach report you're looking for doesn't exist or may have been moved.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
          <a href="<?php echo url('outreach-report'); ?>"
            class="inline-flex items-center gap-3 px-6 py-3 rounded-xl text-white font-medium shadow-lg hover:shadow-xl transition-all duration-300"
            style="background: <?php echo RCN_GRADIENT; ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 12H5M12 19l-7-7 7-7"></path>
            </svg>
            Back to Reports
          </a>
          <a href="<?php echo url(''); ?>"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors">
            Go Home
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="grid lg:grid-cols-4 gap-12">
      <!-- Main content -->
      <article class="lg:col-span-3">
        <?php if (!empty($report['image'])): ?>
          <figure class="mb-8 rounded-2xl overflow-hidden shadow-2xl">
            <img src="<?php echo url('uploads/' . esc_attr($report['image'])); ?>"
              alt="<?php echo esc_attr($report['title']); ?>" class="w-full h-64 md:h-96 object-cover">
          </figure>
        <?php endif; ?>

        <?php
        // Helper functions to embed media from file_link if present
        function is_youtube($u) {
          $host = parse_url($u, PHP_URL_HOST) ?: '';
          return stripos($host, 'youtube.com') !== false || stripos($host, 'youtu.be') !== false;
        }
        function youtube_id($u) {
          $host = parse_url($u, PHP_URL_HOST) ?: '';
          if (stripos($host, 'youtu.be') !== false) {
            $path = trim(parse_url($u, PHP_URL_PATH) ?: '', '/');
            return $path ?: null;
          }
          parse_str(parse_url($u, PHP_URL_QUERY) ?: '', $qs);
          return $qs['v'] ?? null;
        }
        function is_vimeo($u) {
          $host = parse_url($u, PHP_URL_HOST) ?: '';
          return stripos($host, 'vimeo.com') !== false;
        }
        function vimeo_id($u) {
          $path = trim(parse_url($u, PHP_URL_PATH) ?: '', '/');
          return $path ?: null;
        }
        function has_ext($u, $exts) {
          $path = parse_url($u, PHP_URL_PATH) ?: '';
          $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
          return in_array($ext, $exts, true);
        }
        function is_video_file($u) { return has_ext($u, ['mp4','webm','ogg','m4v']); }
        function is_audio_file($u) { return has_ext($u, ['mp3','wav','ogg','m4a']); }
        function is_pdf($u) { return has_ext($u, ['pdf']); }
        ?>

        <?php if (!empty($report['file_link'])): ?>
          <div class="mb-8">
            <?php $link = $report['file_link']; ?>
            <?php if (is_youtube($link) && ($yt = youtube_id($link))): ?>
              <div class="aspect-video w-full rounded-2xl overflow-hidden shadow">
                <iframe class="w-full h-full" src="https://www.youtube.com/embed/<?php echo esc_attr($yt); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
              </div>
            <?php elseif (is_vimeo($link) && ($vm = vimeo_id($link))): ?>
              <div class="aspect-video w-full rounded-2xl overflow-hidden shadow">
                <iframe class="w-full h-full" src="https://player.vimeo.com/video/<?php echo esc_attr($vm); ?>" title="Vimeo video player" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
              </div>
            <?php elseif (is_video_file($link)): ?>
              <video class="w-full rounded-2xl shadow" controls preload="metadata">
                <source src="<?php echo esc_attr($link); ?>">
                Your browser does not support the video tag.
              </video>
            <?php elseif (is_audio_file($link)): ?>
              <audio class="w-full" controls preload="metadata">
                <source src="<?php echo esc_attr($link); ?>">
                Your browser does not support the audio element.
              </audio>
            <?php elseif (is_pdf($link)): ?>
              <div class="rounded-2xl overflow-hidden border border-gray-200">
                <iframe class="w-full" style="height: 70vh;" src="<?php echo esc_attr($link); ?>" title="PDF document"></iframe>
              </div>
            <?php else: ?>
              <a href="<?php echo esc_attr($link); ?>" target="_blank" rel="noopener"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16"/></svg>
                Open Attachment
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <!-- Report Content -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
          <div class="prose prose-lg md:prose-xl max-w-none leading-relaxed">
            <?php echo $report['description']; ?>
          </div>

          <!-- Action Buttons -->
          <div class="mt-12 pt-8 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Found this report helpful?</h3>
                <p class="text-gray-600">Share it with others who might be interested in our mission work.
                </p>
              </div>
              <div class="flex gap-3">
                <?php if (!empty($report['file_link'])): ?>
                  <a href="<?php echo esc_attr($report['file_link']); ?>" target="_blank" rel="noopener"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                    style="background: <?php echo RCN_GRADIENT; ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                      </path>
                    </svg>
                    Open Attachment
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </article>

      <!-- Sidebar -->
      <aside class="lg:col-span-1 space-y-8">
        <!-- Share Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
              </path>
            </svg>
            Share This Report
          </h3>
          <?php $shareUrl = url('outreach-report/' . (int)$report['id']); ?>
          <div class="grid grid-cols-3 gap-2">
            <a class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center gap-2 text-sm"
              target="_blank" rel="noopener"
              href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($shareUrl); ?>">
              <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
              </svg>
              <span class="truncate">Facebook</span>
            </a>
            <a class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center gap-2 text-sm"
              target="_blank" rel="noopener"
              href="https://twitter.com/intent/tweet?url=<?php echo urlencode($shareUrl); ?>&text=<?php echo urlencode($report['title']); ?>">
              <svg class="w-4 h-4 text-gray-800 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.016 10.016 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
              </svg>
              <span class="truncate">Twitter</span>
            </a>
            <a class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center gap-2 text-sm"
              target="_blank" rel="noopener"
              href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($shareUrl); ?>">
              <svg class="w-4 h-4 text-blue-700 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
              </svg>
              <span class="truncate">LinkedIn</span>
            </a>
          </div>
        </div>
        <!-- Other Reports -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
              </path>
            </svg>
            More Reports
          </h3>
          <?php
          try {
            $stmt = db()->prepare('SELECT id, title, date FROM outreach_reports WHERE id <> ? ORDER BY date DESC, id DESC LIMIT 6');
            $stmt->execute([$report['id']]);
            $others = $stmt->fetchAll();
          } catch (Throwable $e) {
            $others = [];
          }
          ?>
          <div class="space-y-4">
            <?php foreach ($others as $o): ?>
              <a href="<?php echo url('outreach-report/view.php'); ?>?id=<?php echo (int)$o['id']; ?>"
                class="block group">
                <div
                  class="p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors">
                  <h4
                    class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-blue-700 transition-colors mb-1 leading-tight">
                    <?php echo esc_html($o['title']); ?>
                  </h4>
                  <div class="flex items-center justify-between">
                    <span
                      class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($o['date'])); ?></span>
                    <svg class="w-3 h-3 text-gray-400 group-hover:text-blue-600 transition-colors"
                      fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7"></path>
                    </svg>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
            <?php if (empty($others)): ?>
              <p class="text-gray-500 text-sm py-2">No other reports available at the moment.</p>
            <?php endif; ?>
          </div>

          <div class="mt-4 pt-4 border-t border-gray-200">
            <a href="<?php echo url('outreach-report'); ?>"
              class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
              View All Reports
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                </path>
              </svg>
            </a>
          </div>
        </div>

        <!-- Quick Contact -->
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
          <h3 class="font-semibold text-lg mb-2">Questions?</h3>
          <p class="text-blue-100 text-sm mb-4">Have questions about this report or our mission work?</p>
          <a href="<?php echo url('contact'); ?>"
            class="inline-flex items-center px-4 py-2 rounded-lg font-medium bg-white text-blue-700 hover:bg-blue-50 transition-colors w-full justify-center text-sm">
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

  .prose p {
    margin-bottom: 1.5em;
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
</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>
