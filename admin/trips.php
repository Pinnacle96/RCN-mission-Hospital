<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../config/csrf.php'; ?>
<?php require_once __DIR__ . '/../includes/constants.php'; ?>
<?php require_login(['SuperAdmin', 'Admin', 'Editor']); ?>
<?php include __DIR__ . '/includes/admin-header.php'; ?>
<?php
$action = $_GET['action'] ?? 'list';
$error = '';
$notice = '';

// Ensure new columns exist (best-effort) so admins can use new fields
try {
  $columns = db()->query('SHOW COLUMNS FROM trips')->fetchAll(PDO::FETCH_COLUMN, 0);
  $alterStatements = [];
  if (!in_array('image', $columns, true)) $alterStatements[] = 'ADD COLUMN image VARCHAR(255) DEFAULT NULL';
  if (!in_array('cost', $columns, true)) $alterStatements[] = 'ADD COLUMN cost DECIMAL(10,2) DEFAULT NULL';
  if (!in_array('register_deadline', $columns, true)) $alterStatements[] = 'ADD COLUMN register_deadline DATE DEFAULT NULL';
  if (!in_array('spots_available', $columns, true)) $alterStatements[] = 'ADD COLUMN spots_available INT DEFAULT NULL';
  if ($alterStatements) {
    $sql = 'ALTER TABLE trips ' . implode(', ', $alterStatements);
    db()->exec($sql);
  }
} catch (Throwable $e) { /* ignore */
}

function handle_upload(?array $file): ?string
{
  if (!$file || !isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) return null;
  if ($file['size'] > MAX_UPLOAD_BYTES) throw new Exception('File too large.');
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime = finfo_file($finfo, $file['tmp_name']);
  finfo_close($finfo);
  $allowed = ['image/jpeg', 'image/png', 'image/webp'];
  if (!in_array($mime, $allowed, true)) throw new Exception('Unsupported file type.');
  $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
  $name = 'trip_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
  $dest = UPLOAD_DIR . $name;
  if (!move_uploaded_file($file['tmp_name'], $dest)) throw new Exception('Upload failed.');
  return $name;
}

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!csrf_validate($token)) throw new Exception('Invalid request.');
    if ($action === 'create' || $action === 'edit') {
      $title = trim($_POST['title'] ?? '');
      $location = trim($_POST['location'] ?? '');
      $start_date = trim($_POST['start_date'] ?? '');
      $end_date = trim($_POST['end_date'] ?? '');
      $description = trim($_POST['description'] ?? '');
      $cost = trim($_POST['cost'] ?? '');
      $register_deadline = trim($_POST['register_deadline'] ?? '');
      $spots_available = trim($_POST['spots_available'] ?? '');
      if ($title === '' || $location === '' || $start_date === '' || $end_date === '' || $description === '') {
        throw new Exception('Please fill in all required fields.');
      }
      $image = null;
      if (!empty($_FILES['image']['name'])) {
        $image = handle_upload($_FILES['image']);
      }
      if ($action === 'create') {
        $stmt = db()->prepare('INSERT INTO trips (title, location, start_date, end_date, description, image, cost, register_deadline, spots_available) VALUES (?,?,?,?,?,?,?,?,?)');
        $stmt->execute([$title, $location, $start_date, $end_date, $description, $image, ($cost !== '' ? $cost : null), ($register_deadline !== '' ? $register_deadline : null), ($spots_available !== '' ? (int)$spots_available : null)]);
        $notice = 'Trip created successfully.';
        $action = 'list';
      } else {
        $id = (int)($_POST['id'] ?? 0);
        if ($image) {
          $stmt = db()->prepare('UPDATE trips SET title=?, location=?, start_date=?, end_date=?, description=?, image=?, cost=?, register_deadline=?, spots_available=? WHERE id=?');
          $stmt->execute([$title, $location, $start_date, $end_date, $description, $image, ($cost !== '' ? $cost : null), ($register_deadline !== '' ? $register_deadline : null), ($spots_available !== '' ? (int)$spots_available : null), $id]);
        } else {
          $stmt = db()->prepare('UPDATE trips SET title=?, location=?, start_date=?, end_date=?, description=?, cost=?, register_deadline=?, spots_available=? WHERE id=?');
          $stmt->execute([$title, $location, $start_date, $end_date, $description, ($cost !== '' ? $cost : null), ($register_deadline !== '' ? $register_deadline : null), ($spots_available !== '' ? (int)$spots_available : null), $id]);
        }
        $notice = 'Trip updated successfully.';
        $action = 'list';
      }
    } elseif ($action === 'delete') {
      $id = (int)($_POST['id'] ?? 0);
      $stmt = db()->prepare('DELETE FROM trips WHERE id=?');
      $stmt->execute([$id]);
      $notice = 'Trip deleted successfully.';
      $action = 'list';
    }
  }
} catch (Throwable $e) {
  $error = 'Error: ' . $e->getMessage();
}

function fetch_trip(int $id): array
{
  $stmt = db()->prepare('SELECT * FROM trips WHERE id=? LIMIT 1');
  $stmt->execute([$id]);
  return $stmt->fetch() ?: ['id' => 0, 'title' => '', 'location' => '', 'start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d'), 'description' => '', 'image' => null, 'cost' => null, 'register_deadline' => null, 'spots_available' => null];
}
?>

<div class="min-h-screen bg-gray-50/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Trip Management</h1>
          <p class="mt-2 text-sm text-gray-600">Create and manage mission trips and outreach programs</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center gap-3">
          <?php if ($action === 'list'): ?>
            <a href="<?php echo url('trips/upcoming'); ?>" target="_blank"
              class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" class="icon-stroke" stroke="currentColor"
                  stroke-width="2" />
                <path
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  class="icon-stroke" stroke="currentColor" stroke-width="2" />
              </svg>
              View Public Page
            </a>
            <a href="<?php echo url('admin/trips.php'); ?>?action=create"
              class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
              style="background: <?php echo RCN_GRADIENT; ?>;">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" />
              </svg>
              New Trip
            </a>
          <?php else: ?>
            <a href="<?php echo url('admin/trips.php'); ?>"
              class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5M12 19l-7-7 7-7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Back to Trips
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Alert Messages -->
    <?php if ($notice): ?>
      <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3">
        <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
        <div class="text-green-700 font-medium"><?php echo esc_html($notice); ?></div>
      </div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-center gap-3">
        <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
        <div class="text-red-700 font-medium"><?php echo esc_html($error); ?></div>
      </div>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
      <!-- Trips List -->
      <?php $trips = db()->query('SELECT * FROM trips ORDER BY start_date DESC, id DESC')->fetchAll(); ?>

      <?php if (empty($trips)): ?>
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No trips yet</h3>
          <p class="text-gray-500 mb-6">Get started by creating your first mission trip.</p>
          <a href="<?php echo url('admin/trips.php'); ?>?action=create"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
            style="background: <?php echo RCN_GRADIENT; ?>;">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" />
            </svg>
            Create First Trip
          </a>
        </div>
      <?php else: ?>
        <!-- Trips Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($trips as $trip): ?>
            <?php
            $isUpcoming = strtotime($trip['start_date']) > time();
            $hasDeadline = !empty($trip['register_deadline']) && strtotime($trip['register_deadline']) > time();
            $spotsLeft = !empty($trip['spots_available']) ? (int)$trip['spots_available'] : null;
            ?>
            <div
              class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 group">
              <?php if (!empty($trip['image'])): ?>
                <div class="h-48 bg-gray-200 overflow-hidden">
                  <img src="<?php echo url('uploads/' . $trip['image']); ?>"
                    alt="<?php echo esc_attr($trip['title']); ?>"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
              <?php else: ?>
                <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                  <svg class="h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </div>
              <?php endif; ?>

              <div class="p-6">
                <!-- Status Badges -->
                <div class="flex items-center gap-2 mb-3">
                  <?php if ($isUpcoming): ?>
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      <span class="w-1.5 h-1.5 rounded-full bg-green-400 mr-1.5"></span>
                      Upcoming
                    </span>
                  <?php else: ?>
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-1.5"></span>
                      Past
                    </span>
                  <?php endif; ?>

                  <?php if ($spotsLeft !== null): ?>
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      <?php echo $spotsLeft; ?> spots
                    </span>
                  <?php endif; ?>
                </div>

                <h3
                  class="font-semibold text-gray-900 text-lg mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                  <?php echo esc_html($trip['title']); ?></h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo esc_html($trip['description']); ?></p>

                <!-- Trip Details -->
                <div class="space-y-2 text-sm text-gray-500 mb-4">
                  <div class="flex items-center gap-2">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                        class="icon-stroke" stroke="currentColor" stroke-width="2" />
                      <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" class="icon-stroke" stroke="currentColor"
                        stroke-width="2" />
                    </svg>
                    <?php echo esc_html($trip['location']); ?>
                  </div>
                  <div class="flex items-center gap-2">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    </svg>
                    <?php echo date('M j, Y', strtotime($trip['start_date'])); ?> -
                    <?php echo date('M j, Y', strtotime($trip['end_date'])); ?>
                  </div>
                  <?php if (!empty($trip['cost'])): ?>
                    <div class="flex items-center gap-2">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                          class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                      $<?php echo number_format((float)$trip['cost'], 2); ?>
                    </div>
                  <?php endif; ?>
                  <?php if ($hasDeadline): ?>
                    <div class="flex items-center gap-2 text-amber-600">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" class="icon-stroke"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                      Register by <?php echo date('M j, Y', strtotime($trip['register_deadline'])); ?>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                  <a href="<?php echo url('admin/trips.php'); ?>?action=edit&id=<?php echo (int)$trip['id']; ?>"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    </svg>
                    Edit
                  </a>
                  <form method="post" action="<?php echo url('admin/trips.php'); ?>?action=delete"
                    onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.')"
                    class="flex-1">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo (int)$trip['id']; ?>">
                    <button type="submit"
                      class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-red-300 text-red-700 font-medium hover:bg-red-50 transition-colors duration-200">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                          class="icon-stroke" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Delete
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    <?php elseif ($action === 'create' || $action === 'edit'): ?>
      <!-- Trip Form -->
      <?php $trip = ($action === 'edit') ? fetch_trip((int)($_GET['id'] ?? 0)) : ['id' => 0, 'title' => '', 'location' => '', 'start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d'), 'description' => '', 'image' => null, 'cost' => null, 'register_deadline' => null, 'spots_available' => null]; ?>

      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <!-- Form Header -->
          <div class="px-6 py-4 border-b border-gray-200" style="background: <?php echo RCN_GRADIENT; ?>;">
            <h2 class="text-xl font-semibold text-white">
              <?php echo $action === 'create' ? 'Create New Trip' : 'Edit Trip'; ?>
            </h2>
          </div>

          <!-- Form Content -->
          <form method="post" enctype="multipart/form-data" class="p-6 space-y-6">
            <?php echo csrf_field(); ?>
            <?php if ($action === 'edit'): ?>
              <input type="hidden" name="id" value="<?php echo (int)$trip['id']; ?>">
            <?php endif; ?>

            <!-- Title & Location -->
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trip Title</label>
                <input name="title"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  value="<?php echo esc_attr($trip['title']); ?>" placeholder="Mission Trip Name"
                  required>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                <input name="location"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  value="<?php echo esc_attr($trip['location']); ?>" placeholder="City, Country" required>
              </div>
            </div>

            <!-- Dates -->
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input name="start_date" type="date"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  value="<?php echo esc_attr($trip['start_date']); ?>" required>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input name="end_date" type="date"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  value="<?php echo esc_attr($trip['end_date']); ?>" required>
              </div>
            </div>

            <!-- Description -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
              <textarea name="description"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                rows="4" placeholder="Describe the trip purpose, activities, and requirements..."
                required><?php echo esc_html($trip['description']); ?></textarea>
            </div>

            <!-- Additional Details -->
            <div class="grid md:grid-cols-3 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Cost (USD)</label>
                <input name="cost" type="number" step="0.01" min="0"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  value="<?php echo esc_attr($trip['cost'] ?? ''); ?>" placeholder="0.00">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Registration Deadline</label>
                <input name="register_deadline" type="date"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  value="<?php echo esc_attr($trip['register_deadline'] ?? ''); ?>">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Spots Available</label>
                <input name="spots_available" type="number" min="0"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  value="<?php echo esc_attr($trip['spots_available'] ?? ''); ?>" placeholder="Unlimited">
              </div>
            </div>

            <!-- Image Upload -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
              <div class="space-y-4">
                <?php if (!empty($trip['image'])): ?>
                  <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                    <img src="<?php echo url('uploads/' . $trip['image']); ?>" alt="Current image"
                      class="h-16 w-16 object-cover rounded-lg">
                    <div class="flex-1">
                      <p class="text-sm font-medium text-gray-900">Current Image</p>
                      <p class="text-sm text-gray-500"><?php echo esc_html($trip['image']); ?></p>
                    </div>
                  </div>
                <?php endif; ?>

                <div
                  class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-gray-400 transition-colors duration-200">
                  <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="hidden"
                    id="imageInput">
                  <label for="imageInput" class="cursor-pointer">
                    <svg class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm text-gray-600 mb-1">Click to upload an image</p>
                    <p class="text-xs text-gray-500">JPEG, PNG, WebP (Max 2MB)</p>
                  </label>
                </div>
                <div id="imagePreview" class="hidden">
                  <img id="previewImage" class="h-32 w-full object-cover rounded-xl">
                </div>
              </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
              <button type="submit"
                class="inline-flex items-center gap-2 px-8 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed"
                style="background: <?php echo RCN_GRADIENT; ?>;" id="submitBtn">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 13l4 4L19 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <?php echo $action === 'create' ? 'Create Trip' : 'Update Trip'; ?>
              </button>
              <a href="<?php echo url('admin/trips.php'); ?>"
                class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                Cancel
              </a>
            </div>
          </form>
        </div>
      </div>

      <script>
        // Image preview functionality
        document.getElementById('imageInput').addEventListener('change', function(e) {
          const file = e.target.files[0];
          const preview = document.getElementById('imagePreview');
          const previewImage = document.getElementById('previewImage');

          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              previewImage.src = e.target.result;
              preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
          } else {
            preview.classList.add('hidden');
          }
        });

        // Form submission handling
        document.addEventListener('DOMContentLoaded', function() {
          const form = document.querySelector('form');
          const submitBtn = document.getElementById('submitBtn');

          if (form && submitBtn) {
            form.addEventListener('submit', function() {
              submitBtn.disabled = true;
              submitBtn.classList.add('opacity-60', 'cursor-not-allowed');
              const originalText = submitBtn.innerHTML;
              submitBtn.innerHTML =
                '<svg class="h-5 w-5 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
            });
          }
        });
      </script>
    <?php endif; ?>
  </div>
</div>

<style>
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>