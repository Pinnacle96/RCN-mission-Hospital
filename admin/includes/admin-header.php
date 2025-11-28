<?php
require_once __DIR__ . '/../../config/security.php';
require_once __DIR__ . '/../../includes/constants.php';
require_login(['SuperAdmin', 'Admin', 'Editor']);
$user = current_user();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title><?php echo esc_html(APP_NAME); ?> • Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="<?php echo url('assets/images/logo.png'); ?>">
  <link rel="shortcut icon" href="<?php echo url('assets/images/logo.png'); ?>">
  <link rel="stylesheet" href="<?php echo url('assets/css/custom.css'); ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    .sidebar-transition {
      transition: all 0.3s ease-in-out;
    }

    .nav-item {
      transition: all 0.2s ease;
    }

    .nav-item:hover {
      transform: translateX(4px);
    }

    .user-avatar {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .icon-stroke {
      stroke-width: 1.5;
    }

    /* Modern enhancements */
    .glass-effect {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .pulse-dot {
      animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }

    .floating-shapes {
      position: absolute;
      pointer-events: none;
    }

    .nav-icon-container {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50" style="font-family: 'Inter', sans-serif;">
  <!-- Floating Background Shapes -->
  <div class="floating-shapes top-10 left-10 opacity-5">
    <svg width="100" height="100" viewBox="0 0 100 100">
      <path d="M20,20 Q50,5 80,20 T100,50 Q85,80 50,100 T0,50 Q15,20 50,0 T100,50" fill="currentColor" class="text-blue-500"/>
    </svg>
  </div>
  
  <div class="min-h-screen flex">
    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

    <!-- Enhanced Sidebar -->
    <aside id="adminSidebar"
      class="fixed inset-y-0 left-0 w-64 bg-white/95 backdrop-blur-lg border-r border-gray-200/50 z-40 sidebar-transition transform -translate-x-full md:translate-x-0 md:static md:z-auto overflow-y-auto shadow-xl"
      style="-webkit-overflow-scrolling: touch;">
      
      <!-- Modern Header with Medical SVG Background -->
      <div class="relative px-6 py-6 border-b border-white/20 overflow-hidden" style="background: <?php echo RCN_GRADIENT; ?>;">
        <!-- Medical-themed SVG Background Pattern -->
        <div class="absolute inset-0 opacity-10">
          <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
              <pattern id="medicalPattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <!-- Medical Cross -->
                <path d="M10 2L10 8M8 6L12 6M6 10L12 10M8 14L12 14M10 12L10 18" stroke="white" stroke-width="0.5" fill="none"/>
                <!-- Heart -->
                <path d="M10 16S8 14 6 12a4 4 0 0 1 6.5-6A4 4 0 0 1 18 12c-2 2-4 4-4 4" stroke="white" stroke-width="0.3" fill="none"/>
              </pattern>
              <linearGradient id="headerShine" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="white" stop-opacity="0.1"/>
                <stop offset="50%" stop-color="white" stop-opacity="0.2"/>
                <stop offset="100%" stop-color="white" stop-opacity="0.1"/>
              </linearGradient>
            </defs>
            <rect width="100%" height="100%" fill="url(#medicalPattern)"/>
            <rect width="100%" height="100%" fill="url(#headerShine)"/>
          </svg>
        </div>

        <!-- Status Indicator -->
        <div class="absolute top-4 right-4">
          <div class="relative">
            <div class="w-3 h-3 bg-green-400 rounded-full animate-ping opacity-75"></div>
            <div class="absolute top-0 w-3 h-3 bg-green-500 rounded-full pulse-dot"></div>
          </div>
        </div>

        <button id="sidebarClose" class="absolute top-4 right-12 md:hidden inline-flex items-center justify-center p-2 rounded-lg text-white/90 hover:bg-white/20 transition-all duration-200" aria-label="Close sidebar">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 6l12 12M6 18L18 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>

        <!-- Logo and Branding -->
        <div class="relative flex items-center gap-4">
          <!-- Enhanced Logo Container -->
          <div class="relative">
            <div class="absolute -inset-1 bg-white/30 rounded-xl blur-sm"></div>
            <div class="relative bg-white/10 backdrop-blur-sm rounded-lg p-2 border border-white/20 shadow-lg">
              <img src="<?php echo url('assets/images/logo.png'); ?>" alt="Logo"
                class="h-10 w-auto rounded-lg">
            </div>
          </div>
          
          <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
              <h1 class="text-white font-bold text-xl tracking-tight drop-shadow-sm"><?php echo esc_html(APP_NAME); ?></h1>
              <!-- Verification Badge -->
              <svg class="h-4 w-4 text-white/80 drop-shadow-sm" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
              </svg>
            </div>
            
            <!-- Admin Portal with Status -->
            <div class="flex items-center gap-3 mb-2">
              <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-400 rounded-full pulse-dot"></div>
                <span class="text-white/90 text-sm font-semibold tracking-wide drop-shadow-sm">Admin Portal</span>
              </div>
              
              <!-- Role Badge -->
              <span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white/90 text-xs font-medium rounded-full border border-white/30 shadow-sm">
                <?php echo esc_html($user['role'] ?? 'User'); ?>
              </span>
            </div>
            
            <!-- Welcome Message -->
            <p class="text-white/70 text-xs font-medium drop-shadow-sm">
              Welcome, <span class="text-white font-semibold"><?php echo esc_html(explode(' ', $user['name'] ?? 'User')[0]); ?></span>
            </p>
          </div>
        </div>
      </div>

      <!-- Enhanced Navigation -->
      <nav class="px-4 py-6 space-y-1">
        <!-- Dashboard -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 font-medium transition-all duration-200 border border-transparent hover:border-blue-200 relative overflow-hidden"
          href="<?php echo url('admin/dashboard'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-blue-100 group-hover:bg-blue-500">
            <svg class="h-4 w-4 text-blue-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <polyline points="9 22 9 12 15 12 15 22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Dashboard</span>
        </a>

        <!-- Blog -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-600 font-medium transition-all duration-200 border border-transparent hover:border-green-200 relative overflow-hidden"
          href="<?php echo url('admin/blog'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-green-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-green-100 group-hover:bg-green-500">
            <svg class="h-4 w-4 text-green-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Blog</span>
        </a>

        <!-- Resources -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 hover:text-purple-600 font-medium transition-all duration-200 border border-transparent hover:border-purple-200 relative overflow-hidden"
          href="<?php echo url('admin/resources'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-purple-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-purple-100 group-hover:bg-purple-500">
            <svg class="h-4 w-4 text-purple-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Resources</span>
        </a>

        <!-- Donations -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:text-amber-600 font-medium transition-all duration-200 border border-transparent hover:border-amber-200 relative overflow-hidden"
          href="<?php echo url('admin/donations'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-amber-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-amber-100 group-hover:bg-amber-500">
            <svg class="h-4 w-4 text-amber-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Donations</span>
        </a>

        <!-- Subscriptions -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-600 font-medium transition-all duration-200 border border-transparent hover:border-red-200 relative overflow-hidden"
          href="<?php echo url('admin/subscriptions'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-red-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-red-100 group-hover:bg-red-500">
            <svg class="h-4 w-4 text-red-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M3 7h18M3 12h18M3 17h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Subscriptions</span>
        </a>

        <!-- Outreach Reports -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-blue-50 hover:text-cyan-600 font-medium transition-all duration-200 border border-transparent hover:border-cyan-200 relative overflow-hidden"
          href="<?php echo url('admin/outreach'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-cyan-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-cyan-100 group-hover:bg-cyan-500">
            <svg class="h-4 w-4 text-cyan-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Outreach Reports</span>
        </a>

        <!-- Trips -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-600 font-medium transition-all duration-200 border border-transparent hover:border-indigo-200 relative overflow-hidden"
          href="<?php echo url('admin/trips'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-indigo-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-indigo-100 group-hover:bg-indigo-500">
            <svg class="h-4 w-4 text-indigo-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M16 6L18 4M18 4L20 6M18 4V8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M3 12H21M3 12C3 13.1819 3.23279 14.3522 3.68508 15.4442C4.13738 16.5361 4.80031 17.5282 5.63604 18.364C6.47177 19.1997 7.46392 19.8626 8.55585 20.3149C9.64778 20.7672 10.8181 21 12 21C13.1819 21 14.3522 20.7672 15.4442 20.3149C16.5361 19.8626 17.5282 19.1997 18.364 18.364C19.1997 17.5282 19.8626 16.5361 20.3149 15.4442C20.7672 14.3522 21 13.1819 21 12M3 12C3 10.8181 3.23279 9.64778 3.68508 8.55585C4.13738 7.46392 4.80031 6.47177 5.63604 5.63604C6.47177 4.80031 7.46392 4.13738 8.55585 3.68508C9.64778 3.23279 10.8181 3 12 3C13.1819 3 14.3522 3.23279 15.4442 3.68508C16.5361 4.13738 17.5282 4.80031 18.364 5.63604C19.1997 6.47177 19.8626 7.46392 20.3149 8.55585C20.7672 9.64778 21 10.8181 21 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Trips</span>
        </a>

        <!-- Gallery -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-rose-50 hover:text-pink-600 font-medium transition-all duration-200 border border-transparent hover:border-pink-200 relative overflow-hidden"
          href="<?php echo url('admin/gallery.php'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-pink-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-pink-100 group-hover:bg-pink-500">
            <svg class="h-4 w-4 text-pink-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M3 5H21V19H3V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8 13L11 16L16 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="7" cy="8" r="1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Gallery</span>
        </a>

        <!-- Sponsors -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-teal-50 hover:to-emerald-50 hover:text-teal-600 font-medium transition-all duration-200 border border-transparent hover:border-teal-200 relative overflow-hidden"
          href="<?php echo url('admin/sponsors'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-teal-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-teal-100 group-hover:bg-teal-500">
            <svg class="h-4 w-4 text-teal-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Sponsors</span>
        </a>

        <!-- Testimonials -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-600 font-medium transition-all duration-200 border border-transparent hover:border-orange-200 relative overflow-hidden"
          href="<?php echo url('admin/testimonials'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-orange-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-orange-100 group-hover:bg-orange-500">
            <svg class="h-4 w-4 text-orange-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M7 8h10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M7 12h7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M7 16h10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Testimonials</span>
        </a>

        <!-- Teams -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-violet-50 hover:to-purple-50 hover:text-violet-600 font-medium transition-all duration-200 border border-transparent hover:border-violet-200 relative overflow-hidden"
          href="<?php echo url('admin/team'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-violet-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-violet-100 group-hover:bg-violet-500">
            <svg class="h-4 w-4 text-violet-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Teams</span>
        </a>

        <!-- Future Programs -->
        <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-lime-50 hover:to-green-50 hover:text-lime-600 font-medium transition-all duration-200 border border-transparent hover:border-lime-200 relative overflow-hidden"
          href="<?php echo url('admin/future-programs'); ?>">
          <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-lime-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
          
          <div class="nav-icon-container bg-lime-100 group-hover:bg-lime-500">
            <svg class="h-4 w-4 text-lime-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
              <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          
          <span class="font-semibold">Future Programs</span>
        </a>

        <?php if (in_array($user['role'] ?? '', ['SuperAdmin', 'Admin'], true)): ?>
          <!-- Users -->
          <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-sky-50 hover:to-cyan-50 hover:text-sky-600 font-medium transition-all duration-200 border border-transparent hover:border-sky-200 relative overflow-hidden"
            href="<?php echo url('admin/users'); ?>">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-sky-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
            
            <div class="nav-icon-container bg-sky-100 group-hover:bg-sky-500">
              <svg class="h-4 w-4 text-sky-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
                <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            
            <span class="font-semibold">Users</span>
          </a>
        <?php endif; ?>

        <?php if (in_array($user['role'] ?? '', ['SuperAdmin', 'Admin'], true)): ?>
          <!-- Newsletter -->
          <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-fuchsia-50 hover:to-pink-50 hover:text-fuchsia-600 font-medium transition-all duration-200 border border-transparent hover:border-fuchsia-200 relative overflow-hidden"
            href="<?php echo url('admin/newsletter'); ?>">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-fuchsia-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
            
            <div class="nav-icon-container bg-fuchsia-100 group-hover:bg-fuchsia-500">
              <svg class="h-4 w-4 text-fuchsia-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
                <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22 6l-10 7L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            
            <span class="font-semibold">Newsletter</span>
          </a>

          <!-- Email Queue -->
          <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-red-50 hover:text-rose-600 font-medium transition-all duration-200 border border-transparent hover:border-rose-200 relative overflow-hidden"
            href="<?php echo url('admin/queue'); ?>">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-rose-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
            
            <div class="nav-icon-container bg-rose-100 group-hover:bg-rose-500">
              <svg class="h-4 w-4 text-rose-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
                <path d="M3 7h18M3 12h18M3 17h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            
            <span class="font-semibold">Email Management</span>
          </a>
        <?php endif; ?>

        <?php if (($user['role'] ?? '') === 'SuperAdmin'): ?>
          <!-- Settings -->
          <a class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-slate-50 hover:text-gray-600 font-medium transition-all duration-200 border border-transparent hover:border-gray-200 relative overflow-hidden"
            href="<?php echo url('admin/settings'); ?>">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-gray-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
            
            <div class="nav-icon-container bg-gray-100 group-hover:bg-gray-500">
              <svg class="h-4 w-4 text-gray-600 group-hover:text-white transition-colors duration-300" viewBox="0 0 24 24" fill="none">
                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19.4 15A1.65 1.65 0 0 0 20 13.5 1.65 1.65 0 0 0 19.4 12 1.66 1.66 0 0 0 20 10.5 1.66 1.66 0 0 0 19.4 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M4.6 9A1.66 1.66 0 0 0 4 10.5 1.66 1.66 0 0 0 4.6 12 1.65 1.65 0 0 0 4 13.5 1.65 1.65 0 0 0 4.6 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 5V7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 17V19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            
            <span class="font-semibold">Settings</span>
          </a>
        <?php endif; ?>
      </nav>
    </aside>

    <!-- Enhanced Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
      <!-- Modern Header -->
      <header class="bg-white/80 backdrop-blur-lg border-b border-gray-200/50 sticky top-0 z-20 shadow-sm">
        <div class="px-6 py-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
              <!-- Enhanced Sidebar Toggle -->
              <button id="sidebarToggle"
                class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 md:hidden shadow-sm hover:shadow-md"
                aria-label="Toggle sidebar">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3 6h18M3 12h18M3 18h18" class="icon-stroke" stroke="currentColor"
                    stroke-linecap="round" />
                </svg>
              </button>
              
              <!-- Enhanced Title Area -->
              <div class="flex items-center gap-3">
                <div class="relative">
                  <div class="w-3 h-3 bg-gradient-to-r from-green-400 to-green-500 rounded-full pulse-dot shadow-sm"></div>
                  <div class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-75"></div>
                </div>
                <div>
                  <h1 class="text-xl font-bold text-gray-900 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                    Admin Dashboard
                  </h1>
                  <p class="text-xs text-gray-500 font-medium">Manage your medical mission operations</p>
                </div>
              </div>
            </div>

            <!-- Enhanced User Controls -->
            <div class="flex flex-wrap items-center gap-2 sm:gap-4">
              <!-- Change Password -->
              <a href="<?php echo url('admin/change-password'); ?>"
                class="group flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium border border-transparent hover:border-blue-200">
                <div class="relative">
                  <div class="absolute inset-0 bg-blue-500 rounded-lg blur-sm group-hover:blur transition-all duration-300 opacity-0 group-hover:opacity-30"></div>
                  <svg class="h-4 w-4 relative" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M15 7C15.7956 7 16.5587 7.31607 17.1213 7.87868C17.6839 8.44129 18 9.20435 18 10V11H16V10C16 9.73478 15.8946 9.48043 15.7071 9.29289C15.5196 9.10536 15.2652 9 15 9C14.7348 9 14.4804 9.10536 14.2929 9.29289C14.1054 9.48043 14 9.73478 14 10V11H12V10C12 9.20435 12.3161 8.44129 12.8787 7.87868C13.4413 7.31607 14.2044 7 15 7Z"
                      class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                      stroke-linejoin="round" />
                    <path
                      d="M6 12H18C18.5304 12 19.0391 12.2107 19.4142 12.5858C19.7893 12.9609 20 13.4696 20 14V20C20 20.5304 19.7893 21.0391 19.4142 21.4142C19.0391 21.7893 18.5304 22 18 22H6C5.46957 22 4.96086 21.7893 4.58579 21.4142C4.21071 21.0391 4 20.5304 4 20V14C4 13.4696 4.21071 12.9609 4.58579 12.5858C4.96086 12.2107 5.46957 12 6 12Z"
                      class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </div>
                <span class="font-semibold">Password</span>
              </a>

              <!-- Enhanced User Profile -->
              <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                  <div class="text-sm font-semibold text-gray-900 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                    <?php echo esc_html($user['name'] ?? ''); ?>
                  </div>
                  <div class="text-xs text-gray-500 capitalize font-medium">
                    <?php echo esc_html($user['role'] ?? ''); ?>
                  </div>
                </div>
                
                <!-- Enhanced Avatar -->
                <div class="relative">
                  <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full blur-sm opacity-75"></div>
                  <div
                    class="relative w-10 h-10 rounded-full user-avatar flex items-center justify-center text-white font-bold shadow-lg border-2 border-white">
                    <?php echo strtoupper(substr($user['name'] ?? 'U', 0, 1)); ?>
                  </div>
                </div>
              </div>

              <!-- Enhanced Logout Button -->
              <a href="<?php echo url('admin/logout.php'); ?>"
                class="group flex items-center gap-2 px-4 py-2 rounded-xl text-white text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200 relative overflow-hidden w-full sm:w-auto mt-2 sm:mt-0"
                style="background: <?php echo RCN_GRADIENT; ?>;">
                <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                <svg class="h-4 w-4 relative z-10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
                    class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M16 17L21 12L16 7" class="icon-stroke" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M21 12H9" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
                <span class="relative z-10">Logout</span>
              </a>
            </div>
          </div>
        </div>
      </header>

      <!-- Main Content Area -->
      <main class="flex-1 px-6 py-8 bg-gradient-to-br from-gray-50/50 to-blue-50/50">
        <div class="max-w-7xl mx-auto">
          <?php /* Page content begins here */ ?>
