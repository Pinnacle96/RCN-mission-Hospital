<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_login(['SuperAdmin', 'Admin', 'Editor']); ?>
<?php include __DIR__ . '/includes/admin-header.php'; ?>
<?php
// Helpers for monthly series
function monthly_counts(PDO $pdo, string $table, string $dateCol, int $months = 6): array
{
  try {
    $start = (new DateTime('first day of this month'))->modify('-' . ($months - 1) . ' months')->format('Y-m-d');
    $sql = "SELECT DATE_FORMAT($dateCol, '%Y-%m') AS ym, COUNT(*) AS c FROM $table WHERE $dateCol >= ? GROUP BY ym ORDER BY ym";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$start]);
    $map = [];
    while ($row = $stmt->fetch()) {
      $map[$row['ym']] = (int)$row['c'];
    }

    $labels = [];
    $data = [];
    for ($i = $months - 1; $i >= 0; $i--) {
      $dt = (new DateTime('first day of this month'))->modify('-' . $i . ' months');
      $ym = $dt->format('Y-m');
      $labels[] = $dt->format('M Y');
      $data[] = $map[$ym] ?? 0;
    }

    return ['labels' => $labels, 'data' => $data];
  } catch (Exception $e) {
    // Return empty data if there's an error
    $labels = [];
    $data = [];
    for ($i = $months - 1; $i >= 0; $i--) {
      $dt = (new DateTime('first day of this month'))->modify('-' . $i . ' months');
      $labels[] = $dt->format('M Y');
      $data[] = 0;
    }
    return ['labels' => $labels, 'data' => $data];
  }
}

// Get growth percentages with fallback
function get_growth_percentage(PDO $pdo, string $table, string $dateCol): float
{
  try {
    $currentMonth = (new DateTime('first day of this month'))->format('Y-m');
    $lastMonth = (new DateTime('first day of last month'))->format('Y-m');

    $sql = "SELECT DATE_FORMAT($dateCol, '%Y-%m') AS ym, COUNT(*) AS c 
                FROM $table 
                WHERE $dateCol >= ? 
                GROUP BY ym 
                HAVING ym IN (?, ?) 
                ORDER BY ym";

    $startDate = (new DateTime('first day of last month'))->format('Y-m-d');
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$startDate, $lastMonth, $currentMonth]);

    $data = [];
    while ($row = $stmt->fetch()) {
      $data[$row['ym']] = (int)$row['c'];
    }

    $lastMonthCount = $data[$lastMonth] ?? 0;
    $currentMonthCount = $data[$currentMonth] ?? 0;

    if ($lastMonthCount === 0) return $currentMonthCount > 0 ? 100.0 : 0.0;

    return round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100, 1);
  } catch (Exception $e) {
    return 0.0;
  }
}

try {
  $pdo = db();

  // Basic counts
  $blogCount = (int)$pdo->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
  $outreachCount = (int)$pdo->query('SELECT COUNT(*) FROM outreach_reports')->fetchColumn();
  $resourcesCount = (int)$pdo->query('SELECT COUNT(*) FROM resources')->fetchColumn();
  $sponsorsCount = (int)$pdo->query('SELECT COUNT(*) FROM sponsors')->fetchColumn();
  $usersCount = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
  $futureProgramsCount = (int)$pdo->query('SELECT COUNT(*) FROM future_programs')->fetchColumn();
  $tripsCount = (int)$pdo->query('SELECT COUNT(*) FROM trips')->fetchColumn();
  $galleryCount = (int)$pdo->query('SELECT COUNT(*) FROM gallery')->fetchColumn();

  // Get growth percentages for tables with date columns
  $blogGrowth = get_growth_percentage($pdo, 'blog_posts', 'created_at');
  $outreachGrowth = get_growth_percentage($pdo, 'outreach_reports', 'date');
  $resourcesGrowth = get_growth_percentage($pdo, 'resources', 'date');

  // Get chart data
  $blogSeries = monthly_counts($pdo, 'blog_posts', 'created_at', 6);
  $outreachSeries = monthly_counts($pdo, 'outreach_reports', 'date', 6);
  $resourcesSeries = monthly_counts($pdo, 'resources', 'date', 6);

  // Recent activity from audit_logs
  $recentLogs = $pdo->query("
        SELECT al.action, al.timestamp, u.name as user_name 
        FROM audit_logs al 
        LEFT JOIN users u ON al.user_id = u.id 
        ORDER BY al.timestamp DESC 
        LIMIT 8
    ")->fetchAll();

  // Get recent blog posts
  $recentBlogs = $pdo->query("
        SELECT title, created_at, 'published' as status 
        FROM blog_posts 
        ORDER BY created_at DESC 
        LIMIT 4
    ")->fetchAll();

  // Get upcoming trips
  $upcomingTrips = $pdo->query("
        SELECT title, start_date, location 
        FROM trips 
        WHERE start_date >= CURDATE() 
        ORDER BY start_date ASC 
        LIMIT 4
    ")->fetchAll();

  // Get system stats
  $totalRecords = $blogCount + $outreachCount + $resourcesCount + $sponsorsCount + $futureProgramsCount + $tripsCount + $galleryCount;

  // Email queue stats
  $queueStats = [
    'pending' => (int)$pdo->query("SELECT COUNT(*) FROM email_queue WHERE status='pending'")->fetchColumn(),
    'sent' => (int)$pdo->query("SELECT COUNT(*) FROM email_queue WHERE status='sent'")->fetchColumn(),
    'failed' => (int)$pdo->query("SELECT COUNT(*) FROM email_queue WHERE status='failed'")->fetchColumn(),
  ];

  // Build monthly series for queue statuses (last 6 months)
  $start = (new DateTime('first day of this month'))->modify('-5 months')->format('Y-m-d');
  $labels = [];
  $months = [];
  for ($i = 5; $i >= 0; $i--) {
    $dt = (new DateTime('first day of this month'))->modify('-' . $i . ' months');
    $ym = $dt->format('Y-m');
    $labels[] = $dt->format('M Y');
    $months[$ym] = ['pending' => 0, 'sent' => 0, 'failed' => 0];
  }
  $stmt = $pdo->prepare("SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, status, COUNT(*) AS c FROM email_queue WHERE created_at >= ? GROUP BY ym, status");
  $stmt->execute([$start]);
  while ($row = $stmt->fetch()) {
    $ym = $row['ym'];
    $s = $row['status'];
    if (isset($months[$ym]) && isset($months[$ym][$s])) {
      $months[$ym][$s] = (int)$row['c'];
    }
  }
  $queueSeries = [
    'labels' => $labels,
    'pending' => array_map(fn($ym) => $months[$ym]['pending'], array_keys($months)),
    'sent' => array_map(fn($ym) => $months[$ym]['sent'], array_keys($months)),
    'failed' => array_map(fn($ym) => $months[$ym]['failed'], array_keys($months)),
  ];
} catch (Throwable $e) {
  // Fallback data in case of errors
  $blogCount = $outreachCount = $resourcesCount = $sponsorsCount = $usersCount = $futureProgramsCount = $tripsCount = $galleryCount = 0;
  $blogGrowth = $outreachGrowth = $resourcesGrowth = 0;

  // Create sample chart data
  $labels = [];
  for ($i = 5; $i >= 0; $i--) {
    $dt = (new DateTime('first day of this month'))->modify('-' . $i . ' months');
    $labels[] = $dt->format('M Y');
  }
  $blogSeries = ['labels' => $labels, 'data' => [2, 5, 3, 8, 6, 4]];
  $outreachSeries = ['labels' => $labels, 'data' => [1, 3, 2, 4, 5, 3]];
  $resourcesSeries = ['labels' => $labels, 'data' => [0, 2, 1, 3, 4, 2]];

  $recentLogs = [];
  $recentBlogs = [];
  $upcomingTrips = [];
  $totalRecords = 0;
  $queueStats = ['pending' => 0, 'sent' => 0, 'failed' => 0];
  $labels = [];
  $queueSeries = ['labels' => [], 'pending' => [], 'sent' => [], 'failed' => []];
}
?>

<div class="min-h-screen bg-gray-50/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
          <p class="mt-2 text-sm text-gray-600">Welcome back! Here's what's happening with your content today.
          </p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center gap-3">
          <div class="text-sm text-gray-500">
            Last updated: <?php echo date('M j, Y g:i A'); ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
      <!-- Blog Posts -->
      <a href="<?php echo url('admin/blog'); ?>" class="group">
        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 hover:border-blue-200">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-xl bg-orange-50 group-hover:bg-orange-100 transition-colors">
              <svg class="h-6 w-6 text-orange-600" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M8 7H16" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M8 12H16" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M8 17H12" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </div>
            <div
              class="<?php echo $blogGrowth >= 0 ? 'text-green-600' : 'text-red-600'; ?> text-sm font-medium">
              <?php echo $blogGrowth >= 0 ? '+' : ''; ?><?php echo $blogGrowth; ?>%
            </div>
          </div>
          <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $blogCount; ?></div>
          <div class="text-sm text-gray-500">Blog Posts</div>
        </div>
      </a>

      <!-- Outreach Reports -->
      <a href="<?php echo url('admin/outreach'); ?>" class="group">
        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 hover:border-blue-200">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-xl bg-blue-50 group-hover:bg-blue-100 transition-colors">
              <svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path
                  d="M12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M12 4V6" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M4 12H6" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M12 18V20" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M18 12H20" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </div>
            <div
              class="<?php echo $outreachGrowth >= 0 ? 'text-green-600' : 'text-red-600'; ?> text-sm font-medium">
              <?php echo $outreachGrowth >= 0 ? '+' : ''; ?><?php echo $outreachGrowth; ?>%
            </div>
          </div>
          <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $outreachCount; ?></div>
          <div class="text-sm text-gray-500">Outreach Reports</div>
        </div>
      </a>

      <!-- Resources -->
      <a href="<?php echo url('admin/resources'); ?>" class="group">
        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 hover:border-blue-200">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-xl bg-green-50 group-hover:bg-green-100 transition-colors">
              <svg class="h-6 w-6 text-green-600" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M12 3V21M3 9H21M3 15H21" class="icon-stroke" stroke="currentColor"
                  stroke-linecap="round" stroke-linejoin="round" />
                <path
                  d="M5 5H19C19.5304 5 20.0391 5.21071 20.4142 5.58579C20.7893 5.96086 21 6.46957 21 7V17C21 17.5304 20.7893 18.0391 20.4142 18.4142C20.0391 18.7893 19.5304 19 19 19H5C4.46957 19 3.96086 18.7893 3.58579 18.4142C3.21071 18.0391 3 17.5304 3 17V7C3 6.46957 3.21071 5.96086 3.58579 5.58579C3.96086 5.21071 4.46957 5 5 5Z"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </div>
            <div
              class="<?php echo $resourcesGrowth >= 0 ? 'text-green-600' : 'text-red-600'; ?> text-sm font-medium">
              <?php echo $resourcesGrowth >= 0 ? '+' : ''; ?><?php echo $resourcesGrowth; ?>%
            </div>
          </div>
          <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $resourcesCount; ?></div>
          <div class="text-sm text-gray-500">Resources</div>
        </div>
      </a>

      <!-- Sponsors -->
      <a href="<?php echo url('admin/sponsors'); ?>" class="group">
        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 hover:border-blue-200">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-xl bg-purple-50 group-hover:bg-purple-100 transition-colors">
              <svg class="h-6 w-6 text-purple-600" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path
                  d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path
                  d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path
                  d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </div>
          </div>
          <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $sponsorsCount; ?></div>
          <div class="text-sm text-gray-500">Sponsors</div>
        </div>
      </a>

      <!-- Users -->
      <a href="<?php echo url('admin/users'); ?>" class="group">
        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 hover:border-blue-200">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-xl bg-indigo-50 group-hover:bg-indigo-100 transition-colors">
              <svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path
                  d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path
                  d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path
                  d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </div>
          </div>
          <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $usersCount; ?></div>
          <div class="text-sm text-gray-500">Users</div>
        </div>
      </a>

      <!-- Future Programs -->
      <a href="<?php echo url('admin/future-programs'); ?>" class="group">
        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 hover:border-blue-200">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-xl bg-red-50 group-hover:bg-red-100 transition-colors">
              <svg class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" class="icon-stroke" stroke="currentColor"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </div>
          </div>
          <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $futureProgramsCount; ?></div>
          <div class="text-sm text-gray-500">Future Programs</div>
        </div>
      </a>

      <!-- Trips -->
      <a href="<?php echo url('admin/trips'); ?>" class="group">
        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 hover:border-blue-200">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-xl bg-cyan-50 group-hover:bg-cyan-100 transition-colors">
              <svg class="h-6 w-6 text-cyan-600" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M16 6L18 4M18 4L20 6M18 4V8" class="icon-stroke" stroke="currentColor"
                  stroke-linecap="round" stroke-linejoin="round" />
                <path
                  d="M3 12H21M3 12C3 13.1819 3.23279 14.3522 3.68508 15.4442C4.13738 16.5361 4.80031 17.5282 5.63604 18.364C6.47177 19.1997 7.46392 19.8626 8.55585 20.3149C9.64778 20.7672 10.8181 21 12 21C13.1819 21 14.3522 20.7672 15.4442 20.3149C16.5361 19.8626 17.5282 19.1997 18.364 18.364C19.1997 17.5282 19.8626 16.5361 20.3149 15.4442C20.7672 14.3522 21 13.1819 21 12M3 12C3 10.8181 3.23279 9.64778 3.68508 8.55585C4.13738 7.46392 4.80031 6.47177 5.63604 5.63604C6.47177 4.80031 7.46392 4.13738 8.55585 3.68508C9.64778 3.23279 10.8181 3 12 3C13.1819 3 14.3522 3.23279 15.4442 3.68508C16.5361 4.13738 17.5282 4.80031 18.364 5.63604C19.1997 6.47177 19.8626 7.46392 20.3149 8.55585C20.7672 9.64778 21 10.8181 21 12"
                  class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </div>
          </div>
          <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $tripsCount; ?></div>
          <div class="text-sm text-gray-500">Trips</div>
        </div>
      </a>

      <!-- Gallery -->
      <a href="<?php echo url('admin/gallery'); ?>" class="group">
        <div
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 hover:border-blue-200">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-xl bg-amber-50 group-hover:bg-amber-100 transition-colors">
              <svg class="h-6 w-6 text-amber-600" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M4 16L8 12L12 16L16 12L20 16" class="icon-stroke" stroke="currentColor"
                  stroke-linecap="round" stroke-linejoin="round" />
                <path d="M4 20H20" class="icon-stroke" stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M4 8H20V4H4V8Z" class="icon-stroke" stroke="currentColor"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </div>
          </div>
          <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $galleryCount; ?></div>
          <div class="text-sm text-gray-500">Gallery Images</div>
        </div>
      </a>

      <!-- Email Queue Health -->
      <a href="<?php echo url('admin/queue'); ?>" class="group">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 hover:border-blue-200">
          <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-xl bg-yellow-50 group-hover:bg-yellow-100 transition-colors">
              <svg class="h-6 w-6 text-yellow-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 9V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 17.01V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.29 3.85997L2.82002 17C2.64408 17.3039 2.55177 17.6531 2.55346 18.0085C2.55514 18.3639 2.65077 18.7122 2.83002 19.014C3.00927 19.3158 3.2642 19.5594 3.5675 19.719C3.8708 19.8785 4.21123 19.9481 4.55002 19.92H19.45C19.7888 19.9481 20.1292 19.8785 20.4325 19.719C20.7358 19.5594 20.9907 19.3158 21.17 19.014C21.3492 18.7122 21.4449 18.3639 21.4465 18.0085C21.4482 17.6531 21.3559 17.3039 21.18 17L13.71 3.85997C13.5324 3.56438 13.281 3.32625 12.9841 3.17089C12.6873 3.01553 12.3553 2.94942 12.02 2.98001C11.6848 3.0106 11.3653 3.13688 11.0959 3.34308C10.8265 3.54927 10.617 3.82629 10.49 4.13998L10.29 3.85997Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="text-sm font-medium text-gray-700">Pending <?php echo (int)$queueStats['pending']; ?></div>
          </div>
          <div class="text-sm text-gray-500 mb-3">Sent: <?php echo (int)$queueStats['sent']; ?> • Failed: <?php echo (int)$queueStats['failed']; ?></div>
          <div style="height:120px"><canvas id="queueTrend"></canvas></div>
        </div>
      </a>
    </div>

    <!-- Charts & Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
      <!-- Content Trends Chart -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-semibold text-gray-900">Content Trends</h3>
          <div class="text-sm text-gray-500">Last 6 months</div>
        </div>
        <div class="h-80">
          <canvas id="contentTrend"></canvas>
        </div>
      </div>

      <!-- Content Distribution -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-semibold text-gray-900">Content Distribution</h3>
          <div class="text-sm text-gray-500">Total: <?php echo $totalRecords; ?> items</div>
        </div>
        <div class="h-80">
          <canvas id="contentDistribution"></canvas>
        </div>
      </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Recent Activity -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
          <span class="text-sm text-gray-500"><?php echo count($recentLogs); ?> activities</span>
        </div>
        <div class="space-y-4">
          <?php foreach ($recentLogs as $log): ?>
            <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
              <div class="w-2 h-2 mt-2 rounded-full bg-blue-500 flex-shrink-0"></div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900"><?php echo esc_html($log['action']); ?></p>
                <div class="flex items-center gap-2 mt-1">
                  <p class="text-xs text-gray-500">
                    <?php echo date('M j, Y g:i A', strtotime($log['timestamp'])); ?></p>
                  <?php if (!empty($log['user_name'])): ?>
                    <span class="text-xs text-gray-400">•</span>
                    <p class="text-xs text-gray-500">by <?php echo esc_html($log['user_name']); ?></p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          <?php if (empty($recentLogs)): ?>
            <div class="text-center py-8 text-gray-500">
              <svg class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <p class="mt-2 text-sm">No recent activity</p>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Recent Content -->
      <div class="grid grid-cols-1 gap-6">
        <!-- Recent Blog Posts -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Recent Blog Posts</h3>
            <a href="<?php echo url('admin/blog'); ?>"
              class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
          </div>
          <div class="space-y-4">
            <?php foreach ($recentBlogs as $post): ?>
              <div
                class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900 truncate">
                    <?php echo esc_html($post['title']); ?></p>
                  <p class="text-xs text-gray-500 mt-1">
                    <?php echo date('M j, Y', strtotime($post['created_at'])); ?></p>
                </div>
                <svg class="h-4 w-4 text-gray-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd" />
                </svg>
              </div>
            <?php endforeach; ?>
            <?php if (empty($recentBlogs)): ?>
              <div class="text-center py-4 text-gray-500">
                <svg class="h-8 w-8 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <p class="mt-1 text-sm">No blog posts yet</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Upcoming Trips -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Upcoming Trips</h3>
            <a href="<?php echo url('admin/trips'); ?>"
              class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
          </div>
          <div class="space-y-4">
            <?php foreach ($upcomingTrips as $trip): ?>
              <div
                class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900 truncate">
                    <?php echo esc_html($trip['title']); ?></p>
                  <div class="flex items-center gap-2 mt-1">
                    <p class="text-xs text-gray-500">
                      <?php echo date('M j, Y', strtotime($trip['start_date'])); ?></p>
                    <span class="text-xs text-gray-400">•</span>
                    <p class="text-xs text-gray-500"><?php echo esc_html($trip['location']); ?></p>
                  </div>
                </div>
                <svg class="h-4 w-4 text-gray-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd" />
                </svg>
              </div>
            <?php endforeach; ?>
            <?php if (empty($upcomingTrips)): ?>
              <div class="text-center py-4 text-gray-500">
                <svg class="h-8 w-8 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="mt-1 text-sm">No upcoming trips</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Data from PHP
  const labels = <?php echo json_encode($blogSeries['labels']); ?>;
  const blogData = <?php echo json_encode($blogSeries['data']); ?>;
  const outreachData = <?php echo json_encode($outreachSeries['data']); ?>;
  const resourcesData = <?php echo json_encode($resourcesSeries['data']); ?>;

  // Trend line chart
  const trendCtx = document.getElementById('contentTrend').getContext('2d');
  new Chart(trendCtx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
          label: 'Blog Posts',
          data: blogData,
          borderColor: '#f97316',
          backgroundColor: 'rgba(249,115,22,0.05)',
          borderWidth: 2,
          tension: 0.4,
          fill: true
        },
        {
          label: 'Outreach Reports',
          data: outreachData,
          borderColor: '#0ea5e9',
          backgroundColor: 'rgba(14,165,233,0.05)',
          borderWidth: 2,
          tension: 0.4,
          fill: true
        },
        {
          label: 'Resources',
          data: resourcesData,
          borderColor: '#22c55e',
          backgroundColor: 'rgba(34,197,94,0.05)',
          borderWidth: 2,
          tension: 0.4,
          fill: true
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            usePointStyle: true,
            padding: 20
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          },
          grid: {
            color: 'rgba(0,0,0,0.05)'
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      },
      interaction: {
        intersect: false,
        mode: 'index'
      }
    }
  });

  // Distribution doughnut chart
  const distCtx = document.getElementById('contentDistribution').getContext('2d');
  new Chart(distCtx, {
    type: 'doughnut',
    data: {
      labels: ['Blog Posts', 'Outreach Reports', 'Resources', 'Sponsors', 'Future Programs', 'Trips',
        'Gallery'
      ],
      datasets: [{
        data: [
          <?php echo (int)$blogCount; ?>,
          <?php echo (int)$outreachCount; ?>,
          <?php echo (int)$resourcesCount; ?>,
          <?php echo (int)$sponsorsCount; ?>,
          <?php echo (int)$futureProgramsCount; ?>,
          <?php echo (int)$tripsCount; ?>,
          <?php echo (int)$galleryCount; ?>
        ],
        backgroundColor: [
          '#f97316', '#0ea5e9', '#22c55e', '#a855f7', '#ef4444', '#06b6d4', '#f59e0b'
        ],
        borderWidth: 0,
        hoverOffset: 8
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            usePointStyle: true,
            padding: 20,
            boxWidth: 8
          }
        }
      },
      cutout: '65%'
    }
  });

  // Email Queue mini trend
  const queueLabels = <?php echo json_encode($queueSeries['labels']); ?>;
  const queuePending = <?php echo json_encode($queueSeries['pending']); ?>;
  const queueSent = <?php echo json_encode($queueSeries['sent']); ?>;
  const queueFailed = <?php echo json_encode($queueSeries['failed']); ?>;
  const queueCtx = document.getElementById('queueTrend').getContext('2d');
  new Chart(queueCtx, {
    type: 'line',
    data: {
      labels: queueLabels,
      datasets: [
        { label: 'Pending', data: queuePending, borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,0.08)', borderWidth: 2, tension: 0.4, fill: true },
        { label: 'Sent', data: queueSent, borderColor: '#22c55e', backgroundColor: 'rgba(34,197,94,0.08)', borderWidth: 2, tension: 0.4, fill: true },
        { label: 'Failed', data: queueFailed, borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.08)', borderWidth: 2, tension: 0.4, fill: true }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { grid: { display: false } } },
      interaction: { intersect: false, mode: 'index' }
    }
  });
</script>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>