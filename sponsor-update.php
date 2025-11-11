<?php
$page_title = 'Sponsor Updates';
$page_description = 'Updates and messages from our sponsors and partners.';
$hero_enable = false;
$hero_background = 'assets/images/hero2.jpg';
?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>

<!-- Modern Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
  <div class="absolute inset-0 opacity-20 pointer-events-none">
    <div class="absolute inset-0" style="background-image: url('<?php echo url($hero_background); ?>'); background-size: cover; background-position: center;"></div>
  </div>
  <div class="absolute top-0 left-0 right-0 bottom-0 opacity-10 pointer-events-none">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse">
          <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1.5" />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#grid)" />
    </svg>
  </div>
  <div class="relative z-10 max-w-7xl mx-auto px-4 py-24">
    <div class="max-w-3xl mx-auto text-center">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        Gratitude & Updates from Sponsors
      </div>
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Sponsor Updates</h1>
      <p class="text-lg text-white/90">Messages and notes from partners who make this mission possible.</p>
    </div>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">
  <?php
    try {
      $stmt = db()->query('SELECT name, message, image FROM sponsors ORDER BY id DESC');
      $sponsors = $stmt->fetchAll();
    } catch (Throwable $e) { $sponsors = []; }
  ?>

  <div class="grid md:grid-cols-3 gap-6">
    <?php foreach ($sponsors as $s): ?>
      <article class="bg-white rounded-xl shadow overflow-hidden hover:shadow-md transition-shadow">
        <?php if (!empty($s['image'])): ?>
          <img src="<?php echo url('uploads/' . esc_attr($s['image'])); ?>" alt="<?php echo esc_attr($s['name']); ?>" class="w-full h-40 object-cover">
        <?php endif; ?>
        <div class="p-5">
          <h3 class="text-lg font-semibold mb-2"><?php echo esc_html($s['name']); ?></h3>
          <p class="text-sm text-midnight/80"><?php echo esc_html($s['message']); ?></p>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <?php if (empty($sponsors)): ?>
    <div class="bg-white rounded-xl shadow p-6 text-center">
      <p class="text-midnight/70">No sponsor updates yet. Check back soon.</p>
    </div>
  <?php endif; ?>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>