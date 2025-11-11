<?php
$page_title = 'Privacy Policy';
$page_description = 'How we handle your information and keep data secure.';
$hero_enable = false;
$hero_background = 'assets/images/hero1.jpg';
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
    <div class="max-w-3xl mx-auto text-center">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
        Commitment to Privacy
      </div>
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Privacy Policy</h1>
      <p class="text-lg text-white/90">We value your privacy and handle data responsibly in line with our mission.</p>
    </div>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">
  <div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-2xl font-semibold mb-4">Overview</h2>
    <p class="text-midnight/80 mb-4">We collect minimal information necessary to operate our website and mission programs. We do not sell personal data and strive to protect your information.</p>
    <div class="grid md:grid-cols-3 gap-6 mt-6">
      <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="font-semibold mb-2">Data We Collect</h3>
        <p class="text-midnight/80 text-sm">Basic contact details for donations, outreach registration, and newsletter updates.</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="font-semibold mb-2">How We Use Data</h3>
        <p class="text-midnight/80 text-sm">To process donations, communicate updates, and improve our outreach programs.</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="font-semibold mb-2">Your Choices</h3>
        <p class="text-midnight/80 text-sm">You can request updates or deletion of your information by contacting us.</p>
      </div>
    </div>
    <div class="mt-6">
      <a href="<?php echo url('contact'); ?>" class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 text-white rounded-lg font-medium shadow hover:bg-indigo-700">
        Contact Us
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M12 5L19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>