<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../config/csrf.php'; ?>
<?php require_login(['SuperAdmin','Admin','Editor']); ?>
<?php include __DIR__ . '/includes/admin-header.php'; ?>
<?php require_once __DIR__ . '/../includes/constants.php'; ?>
<?php
$action = $_GET['action'] ?? 'list';
$error = '';
$notice = '';

function ensure_upload_dir_testimonials(): string {
  $base = rtrim(UPLOAD_DIR, '/\\') . DIRECTORY_SEPARATOR . 'testimonials';
  if (!is_dir($base)) {
    @mkdir($base, 0775, true);
  }
  return $base;
}

function save_uploaded_photo(string $field = 'photo'): ?string {
  if (!isset($_FILES[$field]) || !is_array($_FILES[$field])) {
    return null;
  }
  $f = $_FILES[$field];
  if (($f['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
    return null; // no file selected
  }
  if ($f['error'] !== UPLOAD_ERR_OK) {
    throw new Exception('Image upload failed with error code ' . (int)$f['error']);
  }
  if (($f['size'] ?? 0) > MAX_UPLOAD_BYTES) {
    throw new Exception('Image is too large. Max ' . (int)(MAX_UPLOAD_BYTES / (1024 * 1024)) . 'MB');
  }
  $allowedExt = ['jpg','jpeg','png','webp'];
  $name = $f['name'] ?? '';
  $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
  if (!in_array($ext, $allowedExt, true)) {
    throw new Exception('Invalid image type. Allowed: ' . implode(', ', $allowedExt));
  }
  $safeBase = preg_replace('/[^A-Za-z0-9._-]/', '_', pathinfo($name, PATHINFO_FILENAME));
  $unique = 'testimonial_' . $safeBase . '_' . date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
  $targetDir = ensure_upload_dir_testimonials();
  $targetPath = $targetDir . DIRECTORY_SEPARATOR . $unique;
  if (!move_uploaded_file($f['tmp_name'], $targetPath)) {
    throw new Exception('Failed to save uploaded image.');
  }
  return $unique; // store only the basename
}

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!csrf_validate($token)) {
      throw new Exception('Invalid request.');
    }
    if (($action === 'create') || ($action === 'edit')) {
      $name = trim($_POST['name'] ?? '');
      $role = trim($_POST['role'] ?? '');
      $message = trim($_POST['message'] ?? '');
      $is_active = isset($_POST['is_active']) ? 1 : 0;
      $sort_order = (int)($_POST['sort_order'] ?? 0);
      if ($name === '' || $message === '') {
        throw new Exception('Please fill in required fields (Name, Message).');
      }
      $uploaded = null;
      try {
        $uploaded = save_uploaded_photo('photo');
      } catch (Throwable $e) {
        if (!empty($e->getMessage())) throw $e;
      }
      if ($action === 'create') {
        $stmt = db()->prepare('INSERT INTO testimonials (name, role, message, photo, is_active, sort_order) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$name, $role ?: null, $message, $uploaded ?: null, $is_active, $sort_order]);
        $notice = 'Testimonial created.';
        $action = 'list';
      } else {
        $id = (int)($_POST['id'] ?? 0);
        if ($uploaded === null) {
          $stmt = db()->prepare('UPDATE testimonials SET name=?, role=?, message=?, is_active=?, sort_order=? WHERE id=?');
          $stmt->execute([$name, $role ?: null, $message, $is_active, $sort_order, $id]);
        } else {
          $stmt = db()->prepare('UPDATE testimonials SET name=?, role=?, message=?, photo=?, is_active=?, sort_order=? WHERE id=?');
          $stmt->execute([$name, $role ?: null, $message, $uploaded, $is_active, $sort_order, $id]);
        }
        $notice = 'Testimonial updated.';
        $action = 'list';
      }
    } elseif ($action === 'delete') {
      $id = (int)($_POST['id'] ?? 0);
      $stmt = db()->prepare('DELETE FROM testimonials WHERE id=?');
      $stmt->execute([$id]);
      $notice = 'Testimonial deleted.';
      $action = 'list';
    }
  }
} catch (Throwable $e) {
  $error = 'Error: ' . $e->getMessage();
}

function fetch_testimonial(int $id): array {
  $stmt = db()->prepare('SELECT * FROM testimonials WHERE id=? LIMIT 1');
  $stmt->execute([$id]);
  return $stmt->fetch() ?: ['id'=>0,'name'=>'','role'=>'','message'=>'','photo'=>null,'is_active'=>1,'sort_order'=>0];
}
?>
<div class="min-h-screen bg-gray-50/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Testimonials</h1>
          <p class="mt-2 text-sm text-gray-600">Create and manage public testimonials for the homepage</p>
        </div>
        <?php if ($action === 'list'): ?>
          <div class="flex items-center gap-3">
            <a href="<?php echo url(''); ?>" target="_blank"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 5H7C5.89543 5 5 5.89543 5 7V17C5 18.1046 5.89543 19 7 19H17C18.1046 19 19 18.1046 19 17V11" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M19 5L13 11" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              View Homepage
            </a>
            <a href="<?php echo url('admin/testimonials.php'); ?>?action=create"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
              style="background: <?php echo RCN_GRADIENT; ?>;">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              New Testimonial
            </a>
          </div>
        <?php else: ?>
          <a href="<?php echo url('admin/testimonials.php'); ?>"
            class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 12H5M12 19l-7-7 7-7" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Back to Testimonials
          </a>
        <?php endif; ?>
      </div>
    </div>

    <?php if ($action === 'list'): ?>
      <?php if (!empty($notice)): ?>
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3">
          <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
          <div class="text-green-700 font-medium"><?php echo esc_html($notice); ?></div>
        </div>
      <?php elseif (!empty($error)): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-center gap-3">
          <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
          <div class="text-red-700 font-medium"><?php echo esc_html($error); ?></div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
      <?php $rows = db()->query('SELECT * FROM testimonials ORDER BY sort_order ASC, id DESC')->fetchAll(); ?>

      <?php if (empty($rows)): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.582 8-10 8S1 16.418 1 12 5.582 4 11 4s10 3.582 10 8z" />
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No testimonials yet</h3>
          <p class="text-gray-500 mb-6">Create your first testimonial for the homepage slider.</p>
          <a href="<?php echo url('admin/testimonials.php'); ?>?action=create"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
            style="background: <?php echo RCN_GRADIENT; ?>;">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Create First Testimonial
          </a>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($rows as $r): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300">
              <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                  <div class="h-14 w-14 rounded-full bg-gray-100 overflow-hidden flex items-center justify-center">
                    <?php if (!empty($r['photo'])): ?>
                      <img src="<?php echo esc_attr(BASE_PATH . 'uploads/testimonials/' . $r['photo']); ?>" alt="Photo" class="h-14 w-14 object-cover">
                    <?php else: ?>
                      <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5.121 17.804A13.937 13.937 0 0112 15c2.497 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                    <?php endif; ?>
                  </div>
                  <div>
                    <div class="font-semibold text-gray-900"><?php echo esc_html($r['name']); ?></div>
                    <div class="text-sm text-gray-500"><?php echo esc_html($r['role'] ?? ''); ?></div>
                  </div>
                </div>
                <p class="text-gray-700 leading-relaxed mb-4">“<?php echo esc_html($r['message']); ?>”</p>
                <div class="flex items-center justify-between text-sm text-gray-500">
                  <span class="inline-flex items-center gap-2 px-2 py-1 rounded-lg <?php echo ($r['is_active'] ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600'); ?>">
                    <?php echo $r['is_active'] ? 'Active' : 'Hidden'; ?>
                  </span>
                  <span>Order: <?php echo (int)$r['sort_order']; ?></span>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 mt-4">
                  <a href="<?php echo url('admin/testimonials.php'); ?>?action=edit&id=<?php echo (int)$r['id']; ?>" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">Edit</a>
                  <form method="post" action="<?php echo url('admin/testimonials.php'); ?>?action=delete" onsubmit="return confirm('Delete this testimonial?')" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
                    <button class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-red-300 text-red-700 font-medium hover:bg-red-50 transition-colors duration-200" type="submit">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    <?php elseif ($action === 'create' || $action === 'edit'): ?>
      <?php $r = ($action === 'edit') ? fetch_testimonial((int)($_GET['id'] ?? 0)) : ['id'=>0,'name'=>'','role'=>'','message'=>'','photo'=>null,'is_active'=>1,'sort_order'=>0]; ?>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form method="post" class="space-y-4" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <?php if ($action === 'edit'): ?><input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>"><?php endif; ?>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Name</label>
            <input name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo esc_attr($r['name']); ?>" required>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Role (optional)</label>
            <input name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo esc_attr($r['role'] ?? ''); ?>">
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Message</label>
            <textarea name="message" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" rows="4" required><?php echo esc_html($r['message']); ?></textarea>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Photo (optional)</label>
            <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
            <p class="mt-1 text-xs text-gray-500">Allowed: jpg, jpeg, png, webp. Max <?php echo (int)(MAX_UPLOAD_BYTES / (1024 * 1024)); ?>MB.</p>
            <?php if (!empty($r['photo'])): ?>
              <p class="mt-2 text-sm"><a class="text-blue-600 hover:underline" target="_blank" href="<?php echo esc_attr(BASE_PATH . 'uploads/testimonials/' . $r['photo']); ?>">Current photo</a></p>
            <?php endif; ?>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm mb-1 text-gray-700">Sort Order</label>
              <input name="sort_order" type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo (int)$r['sort_order']; ?>">
            </div>
            <div class="flex items-center">
              <input id="is_active" name="is_active" type="checkbox" class="mr-2" <?php echo ($r['is_active'] ? 'checked' : ''); ?>>
              <label for="is_active" class="text-sm text-gray-700">Active (show on homepage)</label>
            </div>
          </div>
          <div class="flex items-center justify-end gap-3">
            <a href="<?php echo url('admin/testimonials.php'); ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">Cancel</a>
            <button class="inline-flex items-center gap-2 px-6 py-2 rounded-lg text-white font-medium shadow-sm hover:shadow-md transition-all duration-200" type="submit" style="background: <?php echo RCN_GRADIENT; ?>;">
              <?php echo $action === 'create' ? 'Create Testimonial' : 'Update Testimonial'; ?>
            </button>
          </div>
        </form>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>