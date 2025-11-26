<?php
$page_title = 'Future Programs';
$page_description = 'Initiatives we’re preparing to launch in the near future.';
$hero_enable = false;
?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>

<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
  <div class="absolute inset-0 opacity-25 pointer-events-none">
    <div class="absolute inset-0" style="background-image: url('<?php echo url('assets/images/hero4.jpg'); ?>'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/40"></div>
  </div>
  <div class="relative z-10 max-w-7xl mx-auto px-4 py-20">
    <div class="max-w-3xl mx-auto text-center">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        Coming Soon
      </div>
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Future Programs</h1>
      <p class="text-lg text-white/90">Preparing new ways to serve and reach more people with compassionate care.</p>
    </div>
  </div>
  <svg class="absolute bottom-0 left-0 w-full pointer-events-none" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
    <path fill="#fff" d="M0,96L60,101.3C120,107,240,117,360,106.7C480,96,600,64,720,69.3C840,75,960,117,1080,133.3C1200,149,1320,139,1380,133.3L1440,128L1440,160L1380,160C1320,160,1200,160,1080,160C960,160,840,160,720,160C600,160,480,160,360,160C240,160,120,160,60,160L0,160Z"></path>
  </svg>
</section>

<?php
  try {
    $stmt = db()->query('SELECT title, description, start_date, end_date FROM future_programs ORDER BY start_date ASC');
    $programs = $stmt->fetchAll();
  } catch (Throwable $e) { $programs = []; }
?>

<section class="bg-gray-50 py-16">
  <div class="max-w-4xl mx-auto px-4">
    <!-- Single Main Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
      <!-- Card Header -->
      <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold text-white mb-2">Upcoming Initiatives</h2>
            <p class="text-blue-100">New programs launching soon to expand our mission impact</p>
          </div>
          <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
      </div>

      <!-- Card Content -->
      <div class="p-8">
        <?php if (!empty($programs)): ?>
          <div class="space-y-6">
            <?php foreach ($programs as $index => $p): ?>
              <div class="flex gap-6 pb-6 <?php echo $index < count($programs) - 1 ? 'border-b border-gray-100' : ''; ?>">
                <!-- Timeline Indicator -->
                <div class="flex flex-col items-center">
                  <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                  <?php if ($index < count($programs) - 1): ?>
                    <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
                  <?php endif; ?>
                </div>
                
                <!-- Program Content -->
                <div class="flex-1">
                  <div class="flex items-start justify-between mb-3">
                    <h3 class="text-xl font-bold text-gray-900"><?php echo esc_html($p['title']); ?></h3>
                    <?php if (!empty($p['start_date']) || !empty($p['end_date'])): ?>
                      <div class="flex items-center gap-2 bg-blue-50 px-3 py-1 rounded-full">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium text-blue-700">
                          <?php echo !empty($p['start_date']) ? esc_html(date('M j, Y', strtotime($p['start_date']))) : 'Coming Soon'; ?>
                          <?php if (!empty($p['end_date'])): ?> 
                            - <?php echo esc_html(date('M j, Y', strtotime($p['end_date']))); ?>
                          <?php endif; ?>
                        </span>
                      </div>
                    <?php endif; ?>
                  </div>
                  <p class="text-gray-600 leading-relaxed"><?php echo esc_html($p['description']); ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Call to Action -->
          <div class="mt-8 pt-6 border-t border-gray-100">
            <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 text-center">
              <h4 class="text-lg font-semibold text-gray-900 mb-2">Stay Updated</h4>
              <p class="text-gray-600 mb-4">Be the first to know when these programs launch and how you can get involved.</p>
              <div class="flex flex-wrap justify-center gap-4">
                <a href="<?php echo url('contact'); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                  </svg>
                  Subscribe for Updates
                </a>
                <a href="<?php echo url('get-involved'); ?>" class="inline-flex items-center px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                  Get Involved
                </a>
              </div>
            </div>
          </div>

        <?php else: ?>
          <!-- Empty State -->
          <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Programs in Development</h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
              We're prayerfully preparing new initiatives to expand our mission impact. Check back soon for updates on upcoming programs.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
              <a href="<?php echo url('get-involved'); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                Get Involved
              </a>
              <a href="<?php echo url('contact'); ?>" class="inline-flex items-center px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                Contact Us
              </a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Additional Info Section -->
    <div class="mt-8 text-center">
      <p class="text-gray-500 text-sm">
        All programs are subject to change based on community needs and available resources.
      </p>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>