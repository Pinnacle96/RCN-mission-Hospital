<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../config/csrf.php'; ?>
<?php require_login(['SuperAdmin','Admin','Editor']); ?>
<?php include __DIR__ . '/includes/admin-header.php'; ?>
<?php require_once __DIR__ . '/../includes/constants.php'; ?>
<?php
// Admin Gallery Management
$action = $_GET['action'] ?? 'list';
$error = '';
$notice = '';

// Dynamic gallery categories helpers
function ensure_categories_table(): void {
  try {
    db()->query('SELECT id, name FROM gallery_categories LIMIT 1');
  } catch (Throwable $e) {
    try {
      db()->exec('CREATE TABLE IF NOT EXISTS gallery_categories (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(64) NOT NULL UNIQUE,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
    } catch (Throwable $e2) {}
  }
}

function get_categories(): array {
  ensure_categories_table();
  try {
    $rows = db()->query('SELECT name FROM gallery_categories ORDER BY name ASC')->fetchAll();
    $list = array_map(fn($r) => $r['name'], $rows ?: []);
    // Seed defaults once if table is empty
    if (!$list) {
      $defaults = ['Outreach','Trips','Hospital','Volunteers','Facilities','Sponsors','Community'];
      $stmt = db()->prepare('INSERT IGNORE INTO gallery_categories (name) VALUES (?)');
      foreach ($defaults as $d) { $stmt->execute([$d]); }
      $list = $defaults;
    }
    return $list;
  } catch (Throwable $e) { return []; }
}

function gallery_upload_dir(): string {
  $dir = __DIR__ . '/../uploads/gallery';
  if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
  return $dir;
}

function sanitize_filename(string $name): string {
  $name = preg_replace('/[^A-Za-z0-9_.-]/', '_', $name);
  return trim($name, '_');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $post_action = $_POST['action'] ?? '';
  if ($post_action === 'create') {
    try {
      if (!csrf_validate($_POST['csrf_token'] ?? null)) { throw new Exception('Invalid request token. Please refresh and try again.'); }
      // Support both single and multi-file inputs gracefully
      $files = [];
      if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
        // Normalize the multi-file structure
        $count = count($_FILES['images']['name']);
        for ($i = 0; $i < $count; $i++) {
          $files[] = [
            'name' => $_FILES['images']['name'][$i] ?? '',
            'type' => $_FILES['images']['type'][$i] ?? '',
            'tmp_name' => $_FILES['images']['tmp_name'][$i] ?? '',
            'error' => $_FILES['images']['error'][$i] ?? UPLOAD_ERR_NO_FILE,
            'size' => $_FILES['images']['size'][$i] ?? 0,
          ];
        }
      } elseif (!empty($_FILES['image'])) {
        $files[] = $_FILES['image'];
      }

      if (!$files) {
        throw new Exception('Please select at least one image to upload');
      }

      $caption = trim($_POST['caption'] ?? '');
      ensure_categories_table();
      $category = trim($_POST['category'] ?? '');
      $new_category = trim($_POST['new_category'] ?? '');
      $categories = get_categories();
      if ($new_category !== '') {
        // Create the new category if it does not exist
        if (!in_array($new_category, $categories, true)) {
          $stmt = db()->prepare('INSERT INTO gallery_categories (name) VALUES (?)');
          $stmt->execute([$new_category]);
          $categories[] = $new_category;
        }
        $category = $new_category;
      } elseif ($category !== '' && !in_array($category, $categories, true)) {
        throw new Exception('Invalid category selected');
      }

      // Ensure optional category column exists
      try {
        db()->query('SELECT category FROM gallery LIMIT 1');
      } catch (Throwable $e) {
        try { db()->exec('ALTER TABLE gallery ADD COLUMN category VARCHAR(64) NULL AFTER caption'); } catch (Throwable $e2) {}
      }
      $allowed = ['jpg','jpeg','png','gif','webp'];
      $dir = gallery_upload_dir();

      // Process each selected file; collect successes and failures
      $saved = 0; $failed = [];
      foreach ($files as $file) {
        // Map common upload errors to friendly messages
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
          $code = (int)$file['error'];
          $msg = match ($code) {
            UPLOAD_ERR_INI_SIZE => 'Image exceeds server max upload size',
            UPLOAD_ERR_FORM_SIZE => 'Image exceeds form max upload size',
            UPLOAD_ERR_PARTIAL => 'Image partially uploaded, please try again',
            UPLOAD_ERR_NO_FILE => 'No file provided',
            UPLOAD_ERR_NO_TMP_DIR => 'Server missing temp directory',
            UPLOAD_ERR_CANT_WRITE => 'Server failed to write file',
            UPLOAD_ERR_EXTENSION => 'Upload blocked by server extension',
            default => 'Unknown upload error'
          };
          $failed[] = $file['name'] . ': ' . $msg;
          continue;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
          $failed[] = $file['name'] . ': invalid image type';
          continue;
        }
        if (($file['size'] ?? 0) > 5 * 1024 * 1024) { // 5MB cap
          $failed[] = $file['name'] . ': image too large (max 5MB)';
          continue;
        }
        $base = sanitize_filename(pathinfo($file['name'], PATHINFO_FILENAME));
        $uniq = $base . '_' . time() . '_' . mt_rand(1000,9999) . '.' . $ext;
        $dest = $dir . '/' . $uniq;
        if (!@move_uploaded_file($file['tmp_name'], $dest)) {
          $lastErr = error_get_last();
          $failed[] = $file['name'] . ': failed to save uploaded file' . ($lastErr ? ' (' . ($lastErr['message'] ?? '') . ')' : '');
          continue;
        }
        $stmt = db()->prepare('INSERT INTO gallery (image, caption, category, uploaded_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$uniq, $caption !== '' ? $caption : null, $category !== '' ? $category : null]);
        $saved++;
      }

      if ($saved > 0) {
        $notice = $saved === 1 ? 'Image uploaded successfully' : ($saved . ' images uploaded successfully');
      }
      if ($failed) {
        $error = 'Some files failed: ' . esc_html(implode('; ', $failed));
      }
      $action = 'list';
    } catch (Throwable $e) {
      $error = $e->getMessage();
      $action = 'create';
    }
  } elseif ($post_action === 'delete') {
    try {
      if (!csrf_validate($_POST['csrf_token'] ?? null)) { throw new Exception('Invalid request token. Please refresh and try again.'); }
      $id = (int)($_POST['id'] ?? 0);
      if ($id <= 0) throw new Exception('Invalid item');
      $item = db()->prepare('SELECT * FROM gallery WHERE id = ? LIMIT 1');
      $item->execute([$id]);
      $row = $item->fetch();
      if (!$row) throw new Exception('Item not found');
      $del = db()->prepare('DELETE FROM gallery WHERE id = ? LIMIT 1');
      $del->execute([$id]);
      // Try remove file
      $file = __DIR__ . '/../uploads/gallery/' . $row['image'];
      if (is_file($file)) { @unlink($file); }
      $notice = 'Image deleted';
      $action = 'list';
    } catch (Throwable $e) {
      $error = $e->getMessage();
      $action = 'list';
    }
  }
  // Category management actions
  if ($post_action === 'cat_create') {
    try {
      if (!csrf_validate($_POST['csrf_token'] ?? null)) { throw new Exception('Invalid request token. Please refresh and try again.'); }
      $name = trim($_POST['name'] ?? '');
      if ($name === '') throw new Exception('Category name required');
      ensure_categories_table();
      $stmt = db()->prepare('INSERT INTO gallery_categories (name) VALUES (?)');
      $stmt->execute([$name]);
      $notice = 'Category added';
      $action = 'categories';
    } catch (Throwable $e) {
      $error = $e->getMessage();
      $action = 'categories';
    }
  } elseif ($post_action === 'cat_update') {
    try {
      if (!csrf_validate($_POST['csrf_token'] ?? null)) { throw new Exception('Invalid request token. Please refresh and try again.'); }
      $id = (int)($_POST['id'] ?? 0);
      $name = trim($_POST['name'] ?? '');
      if ($id <= 0 || $name === '') throw new Exception('Invalid category update');
      ensure_categories_table();
      $stmt = db()->prepare('UPDATE gallery_categories SET name = ? WHERE id = ?');
      $stmt->execute([$name, $id]);
      $notice = 'Category updated';
      $action = 'categories';
    } catch (Throwable $e) {
      $error = $e->getMessage();
      $action = 'categories';
    }
  } elseif ($post_action === 'cat_delete') {
    try {
      if (!csrf_validate($_POST['csrf_token'] ?? null)) { throw new Exception('Invalid request token. Please refresh and try again.'); }
      $id = (int)($_POST['id'] ?? 0);
      if ($id <= 0) throw new Exception('Invalid category id');
      ensure_categories_table();
      // prevent deleting categories in use
      $nameStmt = db()->prepare('SELECT name FROM gallery_categories WHERE id = ?');
      $nameStmt->execute([$id]);
      $cat = $nameStmt->fetch();
      if (!$cat) throw new Exception('Category not found');
      $countStmt = db()->prepare('SELECT COUNT(*) AS cnt FROM gallery WHERE category = ?');
      $countStmt->execute([$cat['name']]);
      $cnt = (int)($countStmt->fetch()['cnt'] ?? 0);
      if ($cnt > 0) {
        throw new Exception('Cannot delete: category is in use by ' . $cnt . ' image(s). Reassign items first.');
      }
      $stmt = db()->prepare('DELETE FROM gallery_categories WHERE id = ?');
      $stmt->execute([$id]);
      $notice = 'Category deleted';
      $action = 'categories';
    } catch (Throwable $e) {
      $error = $e->getMessage();
      $action = 'categories';
    }
  }
}
?>
<div class="min-h-screen bg-gray-50/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Gallery</h1>
          <p class="mt-2 text-sm text-gray-600">Upload and manage gallery images</p>
        </div>
        <?php if ($action === 'list'): ?>
          <div class="flex items-center gap-3">
            <a href="<?php echo url('gallery'); ?>" target="_blank"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 5H7C5.89543 5 5 5.89543 5 7V17C5 18.1046 5.89543 19 7 19H17C18.1046 19 19 18.1046 19 17V11" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M19 5L13 11" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              View Public Page
            </a>
            <a href="<?php echo url('admin/gallery.php'); ?>?action=create"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
              style="background: <?php echo RCN_GRADIENT; ?>;">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              Upload Image
            </a>
            <a href="<?php echo url('admin/gallery.php'); ?>?action=categories"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
              Manage Categories
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <?php if (!empty($error)): ?>
      <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-center gap-3">
        <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
        <div class="text-red-700 font-medium"><?php echo esc_html($error); ?></div>
      </div>
    <?php endif; ?>
    <?php if (!empty($notice)): ?>
      <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3">
        <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
        <div class="text-green-700 font-medium"><?php echo esc_html($notice); ?></div>
      </div>
    <?php endif; ?>

    <?php if ($action === 'create'): ?>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Upload New Image</h2>
        <form method="post" enctype="multipart/form-data" class="space-y-6">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="action" value="create">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image File</label>
            <input type="file" name="image" accept="image/*" class="block w-full border rounded-lg px-3 py-2">
            <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF, WEBP up to 5MB.</p>
            <div class="mt-3">
              <label class="block text-sm font-medium text-gray-700 mb-1">Bulk Upload (optional)</label>
              <input type="file" name="images[]" accept="image/*" multiple class="block w-full border rounded-lg px-3 py-2">
              <p class="text-xs text-gray-500 mt-1">Select multiple images to upload at once.</p>
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <?php $cats = get_categories(); ?>
            <select name="category" class="block w-full border rounded-lg px-3 py-2">
              <option value="">No category</option>
              <?php foreach ($cats as $c): ?>
                <option value="<?php echo esc_attr($c); ?>"><?php echo esc_html($c); ?></option>
              <?php endforeach; ?>
            </select>
            <div class="mt-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Add new category (optional)</label>
              <input type="text" name="new_category" maxlength="64" class="block w-full border rounded-lg px-3 py-2" placeholder="Type a new category name">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Caption (optional)</label>
            <input type="text" name="caption" maxlength="255" class="block w-full border rounded-lg px-3 py-2" placeholder="Enter a short caption">
          </div>
          <div class="flex items-center gap-3">
            <a href="<?php echo url('admin/gallery.php'); ?>" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-5 py-2.5 rounded-lg text-white font-semibold" style="background: <?php echo RCN_GRADIENT; ?>;">Upload</button>
          </div>
        </form>
      </div>
    <?php elseif ($action === 'categories'): ?>
      <?php ensure_categories_table(); $catRows = db()->query('SELECT * FROM gallery_categories ORDER BY name ASC')->fetchAll(); ?>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl font-semibold text-gray-900">Manage Categories</h2>
          <a href="<?php echo url('admin/gallery.php'); ?>" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Back to Gallery</a>
        </div>
        <form method="post" class="mb-6 flex items-end gap-3">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="action" value="cat_create">
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">New Category Name</label>
            <input type="text" name="name" maxlength="64" class="block w-full border rounded-lg px-3 py-2" placeholder="e.g., Volunteers">
          </div>
          <button type="submit" class="px-5 py-2.5 rounded-lg text-white font-semibold" style="background: <?php echo RCN_GRADIENT; ?>;">Add</button>
        </form>

        <?php if (empty($catRows)): ?>
          <p class="text-gray-600">No categories yet. Add your first above.</p>
        <?php else: ?>
          <div class="divide-y border rounded-xl">
            <?php foreach ($catRows as $row): ?>
              <div class="p-4 flex items-center justify-between">
                <form method="post" class="flex-1 flex items-center gap-3">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="action" value="cat_update">
                  <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                  <input type="text" name="name" value="<?php echo esc_attr($row['name']); ?>" maxlength="64" class="block w-full border rounded-lg px-3 py-2">
                  <button type="submit" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Save</button>
                </form>
                <form method="post" onsubmit="return confirm('Delete this category?');">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="action" value="cat_delete">
                  <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                  <button type="submit" class="px-3 py-2 rounded-lg border text-red-700 hover:bg-red-50">Delete</button>
                </form>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <?php
        // Ensure optional position column exists for ordering
        try {
          db()->query('SELECT position FROM gallery LIMIT 1');
        } catch (Throwable $e) {
          try { db()->exec('ALTER TABLE gallery ADD COLUMN position INT NULL AFTER caption'); } catch (Throwable $e2) {}
          try { db()->exec('UPDATE gallery SET position = id WHERE position IS NULL'); } catch (Throwable $e3) {}
        }

        // Handle bulk category assign/clear on list page
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($post_action ?? '') === 'bulk_assign') {
          try {
            if (!csrf_validate($_POST['csrf_token'] ?? null)) { throw new Exception('Invalid request token. Please refresh and try again.'); }
            $ids = array_values(array_filter(array_map(fn($x) => (int)$x, explode(',', (string)($_POST['ids'] ?? ''))), fn($v) => $v > 0));
            if (!$ids) throw new Exception('No images selected');
            // Ensure category column exists
            try { db()->query('SELECT category FROM gallery LIMIT 1'); } catch (Throwable $e) { try { db()->exec('ALTER TABLE gallery ADD COLUMN category VARCHAR(64) NULL AFTER caption'); } catch (Throwable $e2) {} }
            ensure_categories_table();
            $new_category = trim($_POST['new_category'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $assign = null;
            if ($new_category !== '') {
              // create new if not exists
              $exists = db()->prepare('SELECT id FROM gallery_categories WHERE name = ?');
              $exists->execute([$new_category]);
              if (!$exists->fetch()) {
                $ins = db()->prepare('INSERT INTO gallery_categories (name) VALUES (?)');
                $ins->execute([$new_category]);
              }
              $assign = $new_category;
            } elseif ($category !== '') {
              $assign = $category;
            } else {
              $assign = null; // treat empty as clear
            }
            if ($assign === null) {
              $stmt = db()->prepare('UPDATE gallery SET category = NULL WHERE id = ?');
              foreach ($ids as $id) { $stmt->execute([$id]); }
              $notice = 'Category cleared for ' . count($ids) . ' image(s)';
            } else {
              $stmt = db()->prepare('UPDATE gallery SET category = ? WHERE id = ?');
              foreach ($ids as $id) { $stmt->execute([$assign, $id]); }
              $notice = 'Category assigned to ' . count($ids) . ' image(s)';
            }
          } catch (Throwable $e) {
            $error = 'Bulk assign failed: ' . esc_html($e->getMessage());
          }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($post_action ?? '') === 'bulk_clear') {
          try {
            if (!csrf_validate($_POST['csrf_token'] ?? null)) { throw new Exception('Invalid request token. Please refresh and try again.'); }
            $ids = array_values(array_filter(array_map(fn($x) => (int)$x, explode(',', (string)($_POST['ids'] ?? ''))), fn($v) => $v > 0));
            if (!$ids) throw new Exception('No images selected');
            try { db()->query('SELECT category FROM gallery LIMIT 1'); } catch (Throwable $e) { try { db()->exec('ALTER TABLE gallery ADD COLUMN category VARCHAR(64) NULL AFTER caption'); } catch (Throwable $e2) {} }
            $stmt = db()->prepare('UPDATE gallery SET category = NULL WHERE id = ?');
            foreach ($ids as $id) { $stmt->execute([$id]); }
            $notice = 'Category cleared for ' . count($ids) . ' image(s)';
          } catch (Throwable $e) {
            $error = 'Bulk clear failed: ' . esc_html($e->getMessage());
          }
        }

        // Handle reorder submissions
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($post_action ?? '') === 'reorder') {
          try {
            if (!csrf_validate($_POST['csrf_token'] ?? null)) { throw new Exception('Invalid request token. Please refresh and try again.'); }
            $order = $_POST['order'] ?? '';
            if (!is_string($order) || trim($order) === '') throw new Exception('Invalid order payload');
            $ids = array_values(array_filter(array_map(fn($x) => (int)$x, explode(',', $order)), fn($v) => $v > 0));
            if (!$ids) throw new Exception('No items to reorder');
            $pdo = db();
            $pdo->beginTransaction();
            $pos = 1;
            $stmt = $pdo->prepare('UPDATE gallery SET position = ? WHERE id = ?');
            foreach ($ids as $id) { $stmt->execute([$pos++, $id]); }
            $pdo->commit();
            $notice = 'Order saved';
          } catch (Throwable $e) {
            if (isset($pdo) && $pdo->inTransaction()) { $pdo->rollBack(); }
            $error = 'Reorder failed: ' . esc_html($e->getMessage());
          }
        }

        $rows = db()->query('SELECT * FROM gallery ORDER BY position ASC, uploaded_at DESC, id DESC')->fetchAll();
      ?>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <?php if (empty($rows)): ?>
          <div class="text-center py-12">
            <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No images yet</h3>
            <p class="text-gray-500 mb-6">Upload your first gallery image.</p>
            <a href="<?php echo url('admin/gallery.php'); ?>?action=create" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200" style="background: <?php echo RCN_GRADIENT; ?>;">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              Upload Image
            </a>
          </div>
        <?php else: ?>
          <!-- Bulk category assign/clear form -->
          <form method="post" id="bulkForm" class="mb-4 flex items-end gap-3">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" value="bulk_assign">
            <input type="hidden" name="ids" id="bulkIds" value="">
            <?php $cats = get_categories(); ?>
            <div class="flex-1">
              <label class="block text-sm font-medium text-gray-700 mb-1">Assign category to selected</label>
              <select name="category" class="block w-full border rounded-lg px-3 py-2">
                <option value="">No category</option>
                <?php foreach ($cats as $c): ?>
                  <option value="<?php echo esc_attr($c); ?>"><?php echo esc_html($c); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Add new (optional)</label>
              <input type="text" name="new_category" maxlength="64" class="block w-56 border rounded-lg px-3 py-2" placeholder="Type a new name">
            </div>
            <button type="submit" class="px-4 py-2 rounded-lg text-white font-semibold" style="background: <?php echo RCN_GRADIENT; ?>;">Assign to Selected</button>
            <button type="button" id="clearSelected" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Clear Category</button>
          </form>

          <form method="post" id="orderForm" class="space-y-4">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action" value="reorder">
            <input type="hidden" name="order" id="orderInput" value="">
            <div class="flex items-center justify-between mb-2">
              <div class="text-sm text-gray-600">Drag cards to reorder. Use checkboxes for bulk actions.</div>
              <button type="submit" class="px-4 py-2 rounded-lg text-white font-semibold" style="background: <?php echo RCN_GRADIENT; ?>;">Save Order</button>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="galleryGrid">
              <?php foreach ($rows as $g): ?>
                <div class="border rounded-xl overflow-hidden bg-white" draggable="true" data-id="<?php echo (int)$g['id']; ?>">
                  <div class="flex items-center justify-between px-4 py-2 border-b">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                      <input type="checkbox" class="select-checkbox" value="<?php echo (int)$g['id']; ?>">
                      Select
                    </label>
                    <span class="text-xs text-gray-500">ID: <?php echo (int)$g['id']; ?></span>
                  </div>
                  <img src="<?php echo url('uploads/gallery/' . esc_attr($g['image'])); ?>" alt="<?php echo esc_attr($g['caption'] ?? ''); ?>" class="w-full h-48 object-cover">
                <div class="p-4 flex items-center justify-between">
                  <div>
                    <?php if (!empty($g['caption'])): ?>
                      <div class="text-sm text-gray-800 font-medium"><?php echo esc_html($g['caption']); ?></div>
                    <?php else: ?>
                      <div class="text-xs text-gray-500">&nbsp;</div>
                    <?php endif; ?>
                    <?php if (!empty($g['category'])): ?>
                      <div class="text-xs text-gray-600 mt-1">Category: <?php echo esc_html($g['category']); ?></div>
                    <?php endif; ?>
                    <div class="text-xs text-gray-500 mt-1">Uploaded: <?php echo esc_html(date('M j, Y', strtotime($g['uploaded_at']))); ?></div>
                  </div>
                    <form method="post" onsubmit="return confirm('Delete this image?');">
                      <?php echo csrf_field(); ?>
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="<?php echo (int)$g['id']; ?>">
                      <button type="submit" class="px-3 py-2 rounded-lg border text-red-700 hover:bg-red-50">Delete</button>
                    </form>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </form>
          <script>
            (function(){
              const grid = document.getElementById('galleryGrid');
              let dragEl = null;
              grid.addEventListener('dragstart', (e) => {
                const el = e.target.closest('[draggable="true"]');
                if (!el) return;
                dragEl = el;
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', el.dataset.id);
              });
              grid.addEventListener('dragover', (e) => { e.preventDefault(); e.dataTransfer.dropEffect = 'move'; });
              grid.addEventListener('drop', (e) => {
                e.preventDefault();
                const target = e.target.closest('[draggable="true"]');
                if (!dragEl || !target || dragEl === target) return;
                const children = Array.from(grid.children);
                const dragIndex = children.indexOf(dragEl);
                const targetIndex = children.indexOf(target);
                if (dragIndex < targetIndex) {
                  grid.insertBefore(dragEl, target.nextSibling);
                } else {
                  grid.insertBefore(dragEl, target);
                }
              });
              document.getElementById('orderForm').addEventListener('submit', (e) => {
                const ids = Array.from(grid.querySelectorAll('[draggable="true"]').values()).map(el => el.dataset.id);
                document.getElementById('orderInput').value = ids.join(',');
              });
              // Bulk selection handling
              const bulkForm = document.getElementById('bulkForm');
              const clearBtn = document.getElementById('clearSelected');
              function getSelectedIds(){
                return Array.from(document.querySelectorAll('.select-checkbox:checked')).map(el => el.value);
              }
              bulkForm.addEventListener('submit', function(e){
                const ids = getSelectedIds();
                if (!ids.length) { e.preventDefault(); alert('Select at least one image.'); return; }
                document.getElementById('bulkIds').value = ids.join(',');
                bulkForm.querySelector('input[name="action"]').value = 'bulk_assign';
              });
              clearBtn.addEventListener('click', function(){
                const ids = getSelectedIds();
                if (!ids.length) { alert('Select at least one image.'); return; }
                // build a form submission for clear
                const form = document.createElement('form');
                form.method = 'post';
                form.innerHTML = `<?php echo str_replace('"','\\"', csrf_field()); ?>` +
                  '<input type="hidden" name="action" value="bulk_clear">' +
                  '<input type="hidden" name="ids" value="' + ids.join(',') + '">';
                document.body.appendChild(form);
                form.submit();
              });
            })();
          </script>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>