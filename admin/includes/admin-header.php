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
  </style>
</head>

<body class="min-h-screen bg-gray-50" style="font-family: 'Inter', sans-serif;">
  <div class="min-h-screen flex">
    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

    <!-- Sidebar -->
    <aside id="adminSidebar"
      class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 z-40 sidebar-transition transform -translate-x-full md:translate-x-0 md:static md:z-auto overflow-y-auto"
      style="-webkit-overflow-scrolling: touch;">
      <div class="px-6 py-6 border-b border-gray-200" style="background: <?php echo RCN_GRADIENT; ?>;">
        <div class="flex items-center gap-3">
          <img src="<?php echo url('assets/images/logo.png'); ?>" alt="Logo"
            class="h-8 w-auto rounded-lg shadow-sm">
          <div>
            <div class="text-white font-bold text-lg"><?php echo esc_html(APP_NAME); ?></div>
            <div class="text-white/90 text-sm font-medium">Admin Portal</div>
          </div>
        </div>
      </div>

      <nav class="px-4 py-6 space-y-2">
        <!-- Dashboard -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/dashboard'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z"
              class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M9 22V12H15V22" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
          <span>Dashboard</span>
        </a>

        <!-- Blog -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/blog'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z"
              class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M8 7H16" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M8 12H16" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M8 17H12" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
          <span>Blog</span>
        </a>

        <!-- Resources -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/resources'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 3V21M3 9H21M3 15H21" class="icon-stroke" stroke="currentColor"
              stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M5 5H19C19.5304 5 20.0391 5.21071 20.4142 5.58579C20.7893 5.96086 21 6.46957 21 7V17C21 17.5304 20.7893 18.0391 20.4142 18.4142C20.0391 18.7893 19.5304 19 19 19H5C4.46957 19 3.96086 18.7893 3.58579 18.4142C3.21071 18.0391 3 17.5304 3 17V7C3 6.46957 3.21071 5.96086 3.58579 5.58579C3.96086 5.21071 4.46957 5 5 5Z"
              class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <span>Resources</span>
        </a>

        <!-- Donations -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/donations'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8Z" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <span>Donations</span>
        </a>

        <!-- Subscriptions -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/subscriptions'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 7H21M3 12H21M3 17H21" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <span>Subscriptions</span>
        </a>

        <!-- Outreach Reports -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/outreach'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
              class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z"
              class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M12 4V6" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M4 12H6" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M12 18V20" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M18 12H20" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
          <span>Outreach Reports</span>
        </a>

        <!-- Trips -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/trips'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 6L18 4M18 4L20 6M18 4V8" class="icon-stroke" stroke="currentColor"
              stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M3 12H21M3 12C3 13.1819 3.23279 14.3522 3.68508 15.4442C4.13738 16.5361 4.80031 17.5282 5.63604 18.364C6.47177 19.1997 7.46392 19.8626 8.55585 20.3149C9.64778 20.7672 10.8181 21 12 21C13.1819 21 14.3522 20.7672 15.4442 20.3149C16.5361 19.8626 17.5282 19.1997 18.364 18.364C19.1997 17.5282 19.8626 16.5361 20.3149 15.4442C20.7672 14.3522 21 13.1819 21 12M3 12C3 10.8181 3.23279 9.64778 3.68508 8.55585C4.13738 7.46392 4.80031 6.47177 5.63604 5.63604C6.47177 4.80031 7.46392 4.13738 8.55585 3.68508C9.64778 3.23279 10.8181 3 12 3C13.1819 3 14.3522 3.23279 15.4442 3.68508C16.5361 4.13738 17.5282 4.80031 18.364 5.63604C19.1997 6.47177 19.8626 7.46392 20.3149 8.55585C20.7672 9.64778 21 10.8181 21 12"
              class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <span>Trips</span>
        </a>

        <!-- Gallery -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/gallery.php'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 5H21V19H3V5Z" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M8 13L11 16L16 11" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="7" cy="8" r="1" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <span>Gallery</span>
        </a>

        <!-- Sponsors -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/sponsors'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21"
              class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z"
              class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13"
              class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88"
              class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <span>Sponsors</span>
        </a>

        <!-- Testimonials -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/testimonials'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 8h10" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M7 12h7" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M7 16h10" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <span>Testimonials</span>
        </a>

        <!-- Teams -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/team'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <span>Teams</span>
        </a>

        <!-- Future Programs -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
          href="<?php echo url('admin/future-programs'); ?>">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" class="icon-stroke" stroke="currentColor"
              stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <span>Future Programs</span>
        </a>

        <?php if (in_array($user['role'] ?? '', ['SuperAdmin', 'Admin'], true)): ?>
          <!-- Users -->
          <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
            href="<?php echo url('admin/users'); ?>">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21"
                class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
              <path
                d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z"
                class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
              <path
                d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13"
                class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
              <path
                d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88"
                class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span>Users</span>
          </a>
        <?php endif; ?>

        <?php if (in_array($user['role'] ?? '', ['SuperAdmin', 'Admin'], true)): ?>
          <!-- Newsletter -->
          <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
            href="<?php echo url('admin/newsletter'); ?>">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M22 6l-10 7L2 6" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span>Newsletter</span>
          </a>
          <!-- Email Queue -->
          <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
            href="<?php echo url('admin/queue'); ?>">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 7h18M3 12h18M3 17h18" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span>Email Management</span>
          </a>
        <?php endif; ?>

        <?php if (($user['role'] ?? '') === 'SuperAdmin'): ?>
          <!-- Settings -->
          <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200"
            href="<?php echo url('admin/settings'); ?>">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M19.4 15A1.65 1.65 0 0 0 20 13.5 1.65 1.65 0 0 0 19.4 12 1.66 1.66 0 0 0 20 10.5 1.66 1.66 0 0 0 19.4 9" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M4.6 9A1.66 1.66 0 0 0 4 10.5 1.66 1.66 0 0 0 4.6 12 1.65 1.65 0 0 0 4 13.5 1.65 1.65 0 0 0 4.6 15" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M12 5V7" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M12 17V19" class="icon-stroke" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span>Settings</span>
          </a>
        <?php endif; ?>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="bg-white border-b border-gray-200 sticky top-0 z-20 shadow-sm">
        <div class="px-6 py-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
              <button id="sidebarToggle"
                class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 md:hidden"
                aria-label="Toggle sidebar">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3 6h18M3 12h18M3 18h18" class="icon-stroke" stroke="currentColor"
                    stroke-linecap="round" />
                </svg>
              </button>
              <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <h1 class="text-xl font-semibold text-gray-900">Admin Dashboard</h1>
              </div>
            </div>

            <div class="flex items-center gap-4">
              <a href="<?php echo url('admin/change-password'); ?>"
                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200 font-medium">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M15 7C15.7956 7 16.5587 7.31607 17.1213 7.87868C17.6839 8.44129 18 9.20435 18 10V11H16V10C16 9.73478 15.8946 9.48043 15.7071 9.29289C15.5196 9.10536 15.2652 9 15 9C14.7348 9 14.4804 9.10536 14.2929 9.29289C14.1054 9.48043 14 9.73478 14 10V11H12V10C12 9.20435 12.3161 8.44129 12.8787 7.87868C13.4413 7.31607 14.2044 7 15 7Z"
                    class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path
                    d="M6 12H18C18.5304 12 19.0391 12.2107 19.4142 12.5858C19.7893 12.9609 20 13.4696 20 14V20C20 20.5304 19.7893 21.0391 19.4142 21.4142C19.0391 21.7893 18.5304 22 18 22H6C5.46957 22 4.96086 21.7893 4.58579 21.4142C4.21071 21.0391 4 20.5304 4 20V14C4 13.4696 4.21071 12.9609 4.58579 12.5858C4.96086 12.2107 5.46957 12 6 12Z"
                    class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
                Change Password
              </a>

              <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                  <div class="text-sm font-medium text-gray-900">
                    <?php echo esc_html($user['name'] ?? ''); ?></div>
                  <div class="text-xs text-gray-500 capitalize">
                    <?php echo esc_html($user['role'] ?? ''); ?></div>
                </div>
                <div
                  class="w-8 h-8 rounded-full user-avatar flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                  <?php echo strtoupper(substr($user['name'] ?? 'U', 0, 1)); ?>
                </div>
              </div>

              <a href="<?php echo url('admin/logout.php'); ?>"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-white text-sm font-medium shadow-sm hover:shadow-md transition-all duration-200"
                style="background: <?php echo RCN_GRADIENT; ?>;">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
                    class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M16 17L21 12L16 7" class="icon-stroke" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M21 12H9" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
                Logout
              </a>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-1 px-6 py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
          <?php /* Page content begins here */ ?>