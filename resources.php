<?php
$page_title = 'Resources';
$page_description = 'Guides, downloads, and practical tools to support outreach.';
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
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Resources</h1>
        <p class="text-lg text-white/90">Practical materials to equip volunteers, partners, and churches.</p>
      </div>
    </div>
  </div>
  <svg class="absolute bottom-0 left-0 w-full pointer-events-none" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
    <path fill="#fff" d="M0,96L60,101.3C120,107,240,117,360,106.7C480,96,600,64,720,69.3C840,75,960,117,1080,133.3C1200,149,1320,139,1380,133.3L1440,128L1440,160L1380,160C1320,160,1200,160,1080,160C960,160,840,160,720,160C600,160,480,160,360,160C240,160,120,160,60,160L0,160Z"></path>
  </svg>
</section>

<?php
  try {
    $stmt = db()->query('SELECT title, description, file_link, file, date FROM resources ORDER BY date DESC');
    $resources = $stmt->fetchAll();
  } catch (Throwable $e) { $resources = []; }
?>

<section class="max-w-7xl mx-auto px-4 py-16">
  <?php if (!empty($resources)): ?>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($resources as $r): ?>
        <article class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden hover:shadow-md transition">
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-2"><?php echo esc_html($r['title']); ?></h3>
            <p class="text-sm text-gray-500 mb-2"><?php echo esc_html(date('M j, Y', strtotime($r['date']))); ?></p>
            <p class="text-midnight/80 mb-4"><?php echo esc_html($r['description']); ?></p>
            <div class="flex items-center gap-3">
              <?php if (!empty($r['file'])): ?>
                <a class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-mission_orange text-white font-medium hover:opacity-90 transition" href="<?php echo esc_attr(BASE_PATH . 'uploads/resources/' . $r['file']); ?>" target="_blank">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16"/></svg>
                  Download File
                </a>
              <?php endif; ?>
              <?php if (!empty($r['file_link'])): ?>
                <a class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-mission_orange text-white font-medium hover:opacity-90 transition" href="<?php echo esc_attr($r['file_link']); ?>" target="_blank">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16"/></svg>
                  External Link
                </a>
              <?php endif; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="text-center py-16">
      <div class="max-w-md mx-auto">
        <h3 class="text-2xl font-semibold text-gray-900 mb-3">No Resources Available</h3>
        <p class="text-gray-500 mb-6">We are preparing materials to equip your outreach. Please check back soon.</p>
        <a class="inline-flex items-center px-6 py-3 rounded-lg bg-mission_orange text-white font-medium hover:opacity-90 transition" href="<?php echo url('get-involved'); ?>">Get Involved</a>
      </div>
    </div>
  <?php endif; ?>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>