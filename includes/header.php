<?php
require_once __DIR__ . '/../config/security.php';
require_once __DIR__ . '/../includes/constants.php';

// SEO defaults with per-page overrides
$defaultDescription = 'Faith-driven medical mission website for outreach, trips, and updates.';
$page_title = isset($page_title) && trim($page_title) !== ''
  ? trim($page_title) . ' • ' . APP_NAME
  : APP_NAME;
$page_description = isset($page_description) && trim($page_description) !== ''
  ? trim($page_description)
  : $defaultDescription;

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$origin = $scheme . '://' . $host;
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$canonical = $origin . $requestUri;

// OG/Twitter image (absolute URL)
$raw_image = isset($page_image) && trim($page_image) !== '' ? trim($page_image) : url('assets/images/logo.png');
$og_image = (strpos($raw_image, 'http') === 0) ? $raw_image : $origin . $raw_image;
$site_url = $origin . url('');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo esc_html($page_title); ?></title>
  <meta name="description" content="<?php echo esc_attr($page_description); ?>">
  <link rel="canonical" href="<?php echo esc_attr($canonical); ?>">
  <meta name="robots" content="index,follow">

  <!-- Favicon & app icons -->
  <link rel="icon" type="image/png" href="<?php echo url('assets/images/logo.png'); ?>">
  <link rel="shortcut icon" href="<?php echo url('assets/images/logo.png'); ?>">
  <link rel="apple-touch-icon" href="<?php echo url('assets/images/logo.png'); ?>">

  <!-- Open Graph -->
  <meta property="og:title" content="<?php echo esc_attr($page_title); ?>">
  <meta property="og:description" content="<?php echo esc_attr($page_description); ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo esc_attr($canonical); ?>">
  <meta property="og:site_name" content="<?php echo esc_attr(APP_NAME); ?>">
  <meta property="og:image" content="<?php echo esc_attr($og_image); ?>">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo esc_attr($page_title); ?>">
  <meta name="twitter:description" content="<?php echo esc_attr($page_description); ?>">
  <meta name="twitter:image" content="<?php echo esc_attr($og_image); ?>">

  <!-- JSON-LD Organization -->
  <script type="application/ld+json">
    <?php echo json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'Organization',
      'name' => APP_NAME,
      'url' => $site_url,
      'logo' => $og_image,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            midnight: '<?php echo COLOR_MIDNIGHT_NAVY; ?>',
            mission_orange: '<?php echo COLOR_MISSION_ORANGE; ?>',
            deep_red: '<?php echo COLOR_DEEP_RED; ?>',
            flame_red: '<?php echo COLOR_FLAME_RED; ?>',
            warm_orange: '<?php echo COLOR_WARM_ORANGE; ?>',
            soft_gray: '<?php echo COLOR_SOFT_GRAY; ?>',
          }
        }
      }
    };
  </script>
  <!-- Poppins font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="preload" as="image" href="<?php echo url('assets/images/logo.png'); ?>" type="image/png">
  <link rel="preload" as="image" href="<?php echo url('assets/images/hero1.jpg'); ?>" type="image/jpeg">
  <link rel="preload" as="image" href="<?php echo url('assets/images/hero2.jpg'); ?>" type="image/jpeg">
  <link rel="preload" as="image" href="<?php echo url('assets/images/hero3.jpg'); ?>" type="image/jpeg">
  <link rel="preload" as="image" href="<?php echo url('assets/images/hero4.jpg'); ?>" type="image/jpeg">
  <link rel="stylesheet" href="<?php echo url('assets/css/custom.css'); ?>">
  <!-- SweetAlert2 for consistent notifications across pages -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Global notify helper: uses SweetAlert2; gracefully degrades to a banner
    (function () {
      function showBanner(message, type) {
        var existing = document.getElementById('global-banner');
        if (existing) existing.remove();
        var banner = document.createElement('div');
        banner.id = 'global-banner';
        banner.style.position = 'fixed';
        banner.style.top = '12px';
        banner.style.left = '50%';
        banner.style.transform = 'translateX(-50%)';
        banner.style.zIndex = '9999';
        banner.style.padding = '12px 16px';
        banner.style.borderRadius = '8px';
        banner.style.boxShadow = '0 10px 25px -5px rgba(0,0,0,0.2)';
        banner.style.color = type === 'success' ? '#065f46' : '#7f1d1d';
        banner.style.background = type === 'success' ? '#d1fae5' : '#fee2e2';
        banner.style.border = '1px solid ' + (type === 'success' ? '#10b981' : '#fca5a5');
        banner.textContent = message;
        document.body.appendChild(banner);
        setTimeout(function () { banner.remove(); }, 2500);
      }

      window.notify = function (message, type) {
        if (window.Swal) {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
          });
          Toast.fire({
            icon: type === 'success' ? 'success' : (type === 'error' ? 'error' : 'info'),
            title: message
          });
        } else {
          showBanner(message, type || 'info');
        }
      };
    })();
  </script>
  <style>
    .nav-link {
      position: relative;
      transition: all 0.3s ease;
    }

    .nav-link:hover {
      transform: translateY(-1px);
    }

    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -4px;
      left: 0;
      background: <?php echo RCN_GRADIENT;
                  ?>;
      transition: width 0.3s ease;
    }

    .nav-link:hover::after {
      width: 100%;
    }

    .dropdown-enter {
      opacity: 0;
      transform: translateY(-10px);
    }

    .dropdown-enter-active {
      opacity: 1;
      transform: translateY(0);
      transition: all 0.2s ease-out;
    }
  </style>
</head>

<body class="bg-soft_gray text-midnight" style="font-family: 'Poppins', sans-serif;">
  <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
      <a href="<?php echo url(''); ?>" class="flex items-center group">
        <img src="<?php echo url('assets/images/logo.png'); ?>" alt="RCN Mission Hospital Logo"
          class="inline-block rounded-lg w-auto h-10 md:h-12 lg:h-14 transition-transform duration-300 group-hover:scale-105"
          fetchpriority="high" onerror="this.onerror=null;this.src='<?php echo url('logo.php'); ?>';">
      </a>
      <nav class="hidden md:flex gap-8 text-sm items-center font-semibold">
        <!-- About dropdown -->
        <div class="relative group">
          <button
            class="nav-link inline-flex items-center gap-1 text-gray-700 hover:text-mission_orange py-2 transition-colors duration-200">
            About
            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180"
              viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M5.23 7.21a.75.75 0 011.06.02L10 10.17l3.71-2.94a.75.75 0 011.04 1.08l-4.23 3.35a.75.75 0 01-.94 0L5.21 8.31a.75.75 0 01.02-1.1z" />
            </svg>
          </button>
          <div
            class="absolute left-0 mt-1 w-56 bg-white border border-gray-200 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform origin-top">
            <div class="py-2">
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('about'); ?>">About Us</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('partners'); ?>">Partners</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('statement-of-faith'); ?>">Statement of Faith</a>
            </div>
          </div>
        </div>

        <!-- Programs dropdown -->
        <div class="relative group">
          <button
            class="nav-link inline-flex items-center gap-1 text-gray-700 hover:text-mission_orange py-2 transition-colors duration-200">
            Programs
            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180"
              viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M5.23 7.21a.75.75 0 011.06.02L10 10.17l3.71-2.94a.75.75 0 011.04 1.08l-4.23 3.35a.75.75 0 01-.94 0L5.21 8.31a.75.75 0 01.02-1.1z" />
            </svg>
          </button>
          <div
            class="absolute left-0 mt-1 w-56 bg-white border border-gray-200 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform origin-top">
            <div class="py-2">
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('doc-care'); ?>">Doc Care</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('dinna-care'); ?>">Dinna Care</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('arome-care'); ?>">Arome Care</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('future-programs'); ?>">Future Programs</a>
            </div>
          </div>
        </div>

        <!-- Resources dropdown -->
        <div class="relative group">
          <button
            class="nav-link inline-flex items-center gap-1 text-gray-700 hover:text-mission_orange py-2 transition-colors duration-200">
            Resources
            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180"
              viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M5.23 7.21a.75.75 0 011.06.02L10 10.17l3.71-2.94a.75.75 0 011.04 1.08l-4.23 3.35a.75.75 0 01-.94 0L5.21 8.31a.75.75 0 01.02-1.1z" />
            </svg>
          </button>
          <div
            class="absolute left-0 mt-1 w-56 bg-white border border-gray-200 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform origin-top">
            <div class="py-2">
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('blog'); ?>">Blog</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('resources'); ?>">Resources</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('gallery'); ?>">Gallery</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('outreach-report'); ?>">Outreach Report</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('sponsor-update'); ?>">Sponsor Update</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('privacy-policy'); ?>">Privacy Policy</a>
            </div>
          </div>
        </div>

        <!-- Trips dropdown -->
        <div class="relative group">
          <button
            class="nav-link inline-flex items-center gap-1 text-gray-700 hover:text-mission_orange py-2 transition-colors duration-200">
            Trips
            <svg class="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180"
              viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M5.23 7.21a.75.75 0 011.06.02L10 10.17l3.71-2.94a.75.75 0 011.04 1.08l-4.23 3.35a.75.75 0 01-.94 0L5.21 8.31a.75.75 0 01.02-1.1z" />
            </svg>
          </button>
          <div
            class="absolute left-0 mt-1 w-56 bg-white border border-gray-200 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform origin-top">
            <div class="py-2">
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('trips/upcoming'); ?>">Upcoming Trips</a>
              <a class="block px-4 py-2 text-gray-700 hover:bg-orange-50 hover:text-mission_orange transition-colors duration-150"
                href="<?php echo url('trips/past'); ?>">Past Trips</a>
            </div>
          </div>
        </div>

        <!-- Singles -->
        <a class="nav-link text-gray-700 hover:text-mission_orange py-2 transition-colors duration-200"
          href="<?php echo url('get-involved'); ?>">Get Involved</a>
        <a class="nav-link text-gray-700 hover:text-mission_orange py-2 transition-colors duration-200"
          href="<?php echo url('contact'); ?>">Contact</a>
      </nav>
      <div class="flex items-center gap-4">
        <a href="<?php echo url('partners'); ?>"
          class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-semibold shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105"
          style="background: <?php echo RCN_GRADIENT; ?>;">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" class="icon-stroke" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="9" cy="7" r="4" class="icon-stroke" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" />
            <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75" class="icon-stroke"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Partner with us
        </a>
        <button id="mobileNavToggle"
          class="md:hidden inline-flex items-center justify-center p-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200"
          aria-controls="mobileNav" aria-expanded="false" aria-label="Toggle navigation">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 6h18M3 12h18M3 18h18" class="icon-stroke" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile overlay menu -->
    <div id="mobileNav" class="fixed inset-0 z-50 md:hidden hidden">
      <div id="mobileNavBackdrop"
        class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300"></div>
      <div
        class="absolute top-0 right-0 w-4/5 max-w-sm h-full bg-white shadow-xl transform transition-transform duration-300 ease-in-out">
        <div class="px-6 py-5 flex items-center justify-between border-b border-gray-200">
          <span class="font-bold text-lg text-gray-900">Menu</span>
          <button id="mobileNavClose" class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
            aria-label="Close navigation">
            <svg class="h-6 w-6 text-gray-600" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M6 6l12 12M18 6L6 18" class="icon-stroke" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" />
            </svg>
          </button>
        </div>
        <nav class="px-6 py-6 text-sm space-y-8 max-h-[calc(100vh-80px)] overflow-y-auto mobile-nav-panel">
          <div>
            <div class="text-xs uppercase text-gray-500 font-semibold mb-3 tracking-wide">About</div>
            <div class="grid gap-1">
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('about'); ?>">About Us</a>
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('partners'); ?>">Partners</a>
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('statement-of-faith'); ?>">Statement of Faith</a>
            </div>
          </div>
          <div>
            <div class="text-xs uppercase text-gray-500 font-semibold mb-3 tracking-wide">Programs</div>
            <div class="grid gap-1">
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('doc-care'); ?>">Doc Care</a>
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('dinna-care'); ?>">Dinna Care</a>
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('arome-care'); ?>">Arome Care</a>
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('future-programs'); ?>">Future Programs</a>
            </div>
          </div>
          <div>
            <div class="text-xs uppercase text-gray-500 font-semibold mb-3 tracking-wide">Resources</div>
            <div class="grid gap-1">
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('blog'); ?>">Blog</a>
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('resources'); ?>">Resources</a>
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('gallery'); ?>">Gallery</a>
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('outreach-report'); ?>">Outreach Report</a>
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('sponsor-update'); ?>">Sponsor Update</a>
              <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                href="<?php echo url('privacy-policy'); ?>">Privacy Policy</a>
            </div>
          </div>
          <div class="grid gap-1">
            <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
              href="<?php echo url('get-involved'); ?>">Get Involved</a>
            <div>
              <div class="text-xs uppercase text-gray-500 font-semibold mb-3 tracking-wide mt-4">Trips
              </div>
              <div class="grid gap-1">
                <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                  href="<?php echo url('trips/upcoming'); ?>">Upcoming Trips</a>
                <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
                  href="<?php echo url('trips/past'); ?>">Past Trips</a>
              </div>
            </div>
            <a class="block py-2.5 px-3 text-gray-700 hover:bg-orange-50 hover:text-mission_orange rounded-lg transition-colors duration-150"
              href="<?php echo url('contact'); ?>">Contact</a>
          </div>
          <a href="<?php echo url('partners'); ?>"
            class="inline-flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl text-white font-semibold shadow-sm hover:shadow-md transition-all duration-200 mt-4"
            style="background: <?php echo RCN_GRADIENT; ?>;">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" class="icon-stroke" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <circle cx="9" cy="7" r="4" class="icon-stroke" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
              <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75" class="icon-stroke"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Partner with us
          </a>
        </nav>
      </div>
    </div>
  </header>

  <main>
    <?php
    if (!isset($hero_enable)) {
      $hero_enable = true;
    }
    if ($hero_enable) {
      $rawTitle = isset($page_title) ? trim($page_title) : APP_NAME;
      if (strpos($rawTitle, '•') !== false) {
        $parts = explode('•', $rawTitle);
        $rawTitle = trim($parts[0]);
      }
      $heroTitle = isset($hero_title) && trim($hero_title) !== '' ? trim($hero_title) : $rawTitle;
      $heroSubtitle = isset($hero_subtitle) && trim($hero_subtitle) !== '' ? trim($hero_subtitle) : (isset($page_description) ? trim($page_description) : '');
      $bg = isset($hero_background) && trim($hero_background) !== '' ? trim($hero_background) : (isset($page_image) && trim($page_image) !== '' ? trim($page_image) : url('assets/images/hero2.jpg'));
      if (strpos($bg, 'http') !== 0) {
        $bg = url(trim($bg, '/'));
      }
    ?>
      <section class="relative overflow-hidden">
        <div class="absolute inset-0"
          style="background-image: url('<?php echo esc_attr($bg); ?>'); background-size: cover; background-position: center;">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40"></div>
        <div class="relative max-w-7xl mx-auto px-4 py-20 md:py-24 text-white">
          <div class="max-w-2xl">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight"
              style="font-family: Poppins, sans-serif;">
              <?php echo esc_html($heroTitle); ?>
            </h1>
            <?php if (!empty($heroSubtitle)): ?>
              <p class="text-xl text-white/90 leading-relaxed"><?php echo esc_html($heroSubtitle); ?></p>
            <?php endif; ?>
          </div>
        </div>
      </section>
    <?php } ?>