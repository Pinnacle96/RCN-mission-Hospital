<?php
$page_title = 'Statement of Faith';
$page_description = 'Our core beliefs rooted in Scripture and the Gospel of Jesus Christ.';
$hero_enable = false;
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
  <div class="absolute inset-0 opacity-25 pointer-events-none">
    <div class="absolute inset-0" style="background-image: url('<?php echo url('assets/images/hero3.jpg'); ?>'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/40"></div>
  </div>
  <div class="relative z-10 max-w-7xl mx-auto px-4 py-20">
    <div class="max-w-3xl">
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Statement of Faith</h1>
      <p class="text-lg text-white/90">What we believe, teach, and live out in our mission.</p>
      <div class="mt-6 flex gap-4">
        <a href="<?php echo url('about'); ?>" class="inline-flex items-center px-6 py-3 rounded-lg font-medium bg-white text-gray-900 shadow hover:shadow-md transition">About Our Mission</a>
        <a href="<?php echo url('contact'); ?>" class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white/40 text-white hover:bg-white/10 transition">Contact Us</a>
      </div>
    </div>
  </div>
  <svg class="absolute bottom-0 left-0 w-full pointer-events-none" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
    <path fill="#fff" d="M0,96L60,101.3C120,107,240,117,360,106.7C480,96,600,64,720,69.3C840,75,960,117,1080,133.3C1200,149,1320,139,1380,133.3L1440,128L1440,160L1380,160C1320,160,1200,160,1080,160C960,160,840,160,720,160C600,160,480,160,360,160C240,160,120,160,60,160L0,160Z"></path>
  </svg>
</section>

<section class="max-w-7xl mx-auto px-4 py-16">
  <div class="grid md:grid-cols-2 gap-10">
    <div>
      <h2 class="text-2xl font-bold mb-4">Core Beliefs</h2>
      <ul class="space-y-4 text-midnight/80">
        <li><span class="font-semibold text-gray-900">Scripture:</span> The Bible is the inspired, infallible Word of God and the final authority for faith and conduct.</li>
        <li><span class="font-semibold text-gray-900">Triune God:</span> One God eternally existent in three Persons: Father, Son, and Holy Spirit.</li>
        <li><span class="font-semibold text-gray-900">Jesus Christ:</span> Fully God and fully man, His virgin birth, sinless life, atoning death, bodily resurrection, and future return.</li>
        <li><span class="font-semibold text-gray-900">Salvation:</span> By grace through faith in Jesus Christ alone; we are called to discipleship and holy living.</li>
        <li><span class="font-semibold text-gray-900">Holy Spirit:</span> Indwells and empowers believers for godly living and witness.</li>
        <li><span class="font-semibold text-gray-900">The Church:</span> The body of Christ, called to worship, fellowship, discipleship, and mission.</li>
      </ul>
    </div>
    <div>
      <h2 class="text-2xl font-bold mb-4">Mission & Practice</h2>
      <div class="space-y-4 text-midnight/80">
        <p>We uphold the Gospel of Jesus Christ and the Great Commission (Matthew 28:19), integrating compassionate healthcare with the proclamation of the Good News.</p>
        <p>We affirm the dignity of every person created in the image of God, serving communities with excellence, humility, and prayer.</p>
        <p>We partner with local churches and believers to encourage sustainable, Christ-centered impact.</p>
      </div>
    </div>
  </div>

  <div class="mt-12 bg-gradient-to-br from-orange-50 to-yellow-50 border border-orange-100 rounded-2xl p-8">
    <h3 class="text-xl font-semibold text-gray-900 mb-2">Affirmation</h3>
    <p class="text-midnight/80">Our team, volunteers, and partners joyfully affirm this statement as the foundation of our faith and mission.</p>
    <div class="mt-6">
      <a href="<?php echo url('get-involved'); ?>" class="inline-flex items-center px-6 py-3 rounded-lg bg-mission_orange text-white font-medium shadow hover:opacity-90 transition">Get Involved</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>