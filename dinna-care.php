<?php
$page_title = 'Dinna Care';
$page_description = 'Compassionate outreach and community care initiatives.';
$hero_enable = false;
$hero_background = 'assets/images/hero2.jpg';
?>
<?php include __DIR__ . '/includes/header.php'; ?>

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
    <div class="max-w-3xl">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        Community Care & Education
      </div>
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Dinna Care</h1>
      <p class="text-lg text-white/90">Compassionate outreach and community care initiatives.</p>
    </div>
  </div>
</section>

<!-- Feature Sections -->
<section class="max-w-7xl mx-auto px-4 py-16">
  <div class="grid md:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow p-6">
      <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center mb-4">
        <svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </div>
      <h3 class="text-lg font-semibold mb-2">Health Education</h3>
      <p class="text-midnight/80">Community classes on hygiene, nutrition, and disease prevention.</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
      <div class="h-10 w-10 rounded-lg bg-purple-50 flex items-center justify-center mb-4">
        <svg class="h-6 w-6 text-purple-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </div>
      <h3 class="text-lg font-semibold mb-2">Community Outreach</h3>
      <p class="text-midnight/80">Organized outreach days delivering care and sharing hope.</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
      <div class="h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center mb-4">
        <svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8V12L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <h3 class="text-lg font-semibold mb-2">Family Support</h3>
      <p class="text-midnight/80">Support services for vulnerable families needing sustained care.</p>
    </div>
  </div>

  <div class="mt-10 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-xl p-6 text-white flex items-center justify-between">
    <div>
      <h4 class="text-xl font-semibold mb-1">Support Dinna Care</h4>
      <p class="text-white/90">Fuel outreach, education, and compassionate care.</p>
    </div>
    <a href="<?php echo url('partners'); ?>" class="inline-flex items-center gap-2 px-5 py-3 bg-white text-indigo-700 rounded-lg font-medium shadow">
      Donate & Partner
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M12 5L19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>