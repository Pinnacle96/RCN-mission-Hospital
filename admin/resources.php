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

function ensure_upload_dir(string $subdir): string {
  $base = rtrim(UPLOAD_DIR, '/\\') . DIRECTORY_SEPARATOR . $subdir;
  if (!is_dir($base)) {
    @mkdir($base, 0775, true);
  }
  return $base;
}

function save_uploaded_resource_file(string $field = 'file'): ?string {
  if (!isset($_FILES[$field]) || !is_array($_FILES[$field])) {
    return null;
  }
  $f = $_FILES[$field];
  if (($f['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
    return null; // no file selected
  }
  if ($f['error'] !== UPLOAD_ERR_OK) {
    throw new Exception('File upload failed with error code ' . (int)$f['error']);
  }
  if (($f['size'] ?? 0) > MAX_UPLOAD_BYTES) {
    throw new Exception('File is too large. Max ' . (int)(MAX_UPLOAD_BYTES / (1024 * 1024)) . 'MB');
  }
  $allowedExt = ['pdf','doc','docx','xls','xlsx','ppt','pptx','txt','zip','rar'];
  $name = $f['name'] ?? '';
  $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
  if (!in_array($ext, $allowedExt, true)) {
    throw new Exception('Invalid file type. Allowed: ' . implode(', ', $allowedExt));
  }
  $safeBase = preg_replace('/[^A-Za-z0-9._-]/', '_', pathinfo($name, PATHINFO_FILENAME));
  $unique = $safeBase . '_' . date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
  $targetDir = ensure_upload_dir('resources');
  $targetPath = $targetDir . DIRECTORY_SEPARATOR . $unique;
  if (!move_uploaded_file($f['tmp_name'], $targetPath)) {
    throw new Exception('Failed to save uploaded file.');
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
      $title = trim($_POST['title'] ?? '');
      $description = trim($_POST['description'] ?? '');
      $file_link = trim($_POST['file_link'] ?? '');
      $date = trim($_POST['date'] ?? '');
      if ($title === '' || $description === '' || $date === '') {
        throw new Exception('Please fill in all required fields.');
      }
      // Optional file upload (documents only)
      $uploaded = null;
      try {
        $uploaded = save_uploaded_resource_file('file');
      } catch (Throwable $e) {
        // Surface upload errors while keeping other validation
        throw $e;
      }
      if ($action === 'create') {
        $stmt = db()->prepare('INSERT INTO resources (title, description, file_link, file, date) VALUES (?,?,?,?,?)');
        $stmt->execute([$title, $description, $file_link ?: null, $uploaded ?: null, $date]);
        $notice = 'Resource created.';
        $action = 'list';
      } else {
        $id = (int)($_POST['id'] ?? 0);
        // If no new file uploaded, keep existing file value
        if ($uploaded === null) {
          $stmt = db()->prepare('UPDATE resources SET title=?, description=?, file_link=?, date=? WHERE id=?');
          $stmt->execute([$title, $description, $file_link ?: null, $date, $id]);
        } else {
          $stmt = db()->prepare('UPDATE resources SET title=?, description=?, file_link=?, file=?, date=? WHERE id=?');
          $stmt->execute([$title, $description, $file_link ?: null, $uploaded, $date, $id]);
        }
        $notice = 'Resource updated.';
        $action = 'list';
      }
    } elseif ($action === 'delete') {
      $id = (int)($_POST['id'] ?? 0);
      $stmt = db()->prepare('DELETE FROM resources WHERE id=?');
      $stmt->execute([$id]);
      $notice = 'Resource deleted.';
      $action = 'list';
    }
  }
} catch (Throwable $e) {
  $error = 'Error: ' . $e->getMessage();
}

function fetch_resource(int $id): array {
  $stmt = db()->prepare('SELECT * FROM resources WHERE id=? LIMIT 1');
  $stmt->execute([$id]);
  return $stmt->fetch() ?: ['id'=>0,'title'=>'','description'=>'','file_link'=>null,'file'=>null,'date'=>date('Y-m-d')];
}
?>
<div class="min-h-screen bg-gray-50/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Resources</h1>
          <p class="mt-2 text-sm text-gray-600">Create and manage downloadable resources</p>
        </div>
        <?php if ($action === 'list'): ?>
          <div class="flex items-center gap-3">
            <a href="<?php echo url('resources'); ?>" target="_blank"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 5H7C5.89543 5 5 5.89543 5 7V17C5 18.1046 5.89543 19 7 19H17C18.1046 19 19 18.1046 19 17V11" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M19 5L13 11" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              View Public Page
            </a>
            <a href="<?php echo url('admin/resources.php'); ?>?action=create"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
              style="background: <?php echo RCN_GRADIENT; ?>;">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              New Resource
            </a>
          </div>
        <?php else: ?>
          <a href="<?php echo url('admin/resources.php'); ?>"
            class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 12H5M12 19l-7-7 7-7" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Back to Resources
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
      <?php $rows = db()->query('SELECT * FROM resources ORDER BY date DESC, id DESC')->fetchAll(); ?>

      <?php if (empty($rows)): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No resources yet</h3>
          <p class="text-gray-500 mb-6">Create your first resource to share files.</p>
          <a href="<?php echo url('admin/resources.php'); ?>?action=create"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
            style="background: <?php echo RCN_GRADIENT; ?>;">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Create First Resource
          </a>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($rows as $r): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300">
              <div class="h-32 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v16m8-8H4" />
                </svg>
              </div>
              <div class="p-6">
                <h3 class="font-semibold text-gray-900 text-lg mb-2 line-clamp-2"><?php echo esc_html($r['title']); ?></h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo esc_html($r['description']); ?></p>
                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                  <span><?php echo esc_html($r['date']); ?></span>
                  <div class="flex items-center gap-3">
                    <?php if (!empty($r['file'])): ?>
                      <a class="text-blue-600 hover:underline" href="<?php echo esc_attr(BASE_PATH . 'uploads/resources/' . $r['file']); ?>" target="_blank">File</a>
                    <?php endif; ?>
                    <?php if (!empty($r['file_link'])): ?>
                      <a class="text-blue-600 hover:underline" href="<?php echo esc_attr($r['file_link']); ?>" target="_blank">External</a>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                  <a href="<?php echo url('admin/resources.php'); ?>?action=edit&id=<?php echo (int)$r['id']; ?>" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">Edit</a>
                  <form method="post" action="<?php echo url('admin/resources.php'); ?>?action=delete" onsubmit="return confirm('Delete this resource?')" class="flex-1">
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
      <?php $r = ($action === 'edit') ? fetch_resource((int)($_GET['id'] ?? 0)) : ['id'=>0,'title'=>'','description'=>'','file_link'=>null,'file'=>null,'date'=>date('Y-m-d')]; ?>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form method="post" class="space-y-4" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <?php if ($action === 'edit'): ?><input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>"><?php endif; ?>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Title</label>
            <input name="title" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo esc_attr($r['title']); ?>" required>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Description</label>
            <textarea name="description" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" rows="4" required><?php echo esc_html($r['description']); ?></textarea>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">File Link (optional)</label>
            <input name="file_link" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo esc_attr($r['file_link'] ?? ''); ?>">
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Upload File (optional)</label>
            <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
            <p class="mt-1 text-xs text-gray-500">Allowed: pdf, doc/docx, xls/xlsx, ppt/pptx, txt, zip/rar. Max <?php echo (int)(MAX_UPLOAD_BYTES / (1024 * 1024)); ?>MB.</p>
            <?php if (!empty($r['file'])): ?>
              <p class="mt-2 text-sm"><a class="text-blue-600 hover:underline" target="_blank" href="<?php echo esc_attr(BASE_PATH . 'uploads/resources/' . $r['file']); ?>">Current file</a></p>
            <?php endif; ?>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Date</label>
            <input name="date" type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo esc_attr($r['date']); ?>" required>
          </div>
          <div class="flex items-center justify-end gap-3">
            <a href="<?php echo url('admin/resources.php'); ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">Cancel</a>
            <button class="inline-flex items-center gap-2 px-6 py-2 rounded-lg text-white font-medium shadow-sm hover:shadow-md transition-all duration-200" type="submit" style="background: <?php echo RCN_GRADIENT; ?>;">
              <?php echo $action === 'create' ? 'Create Resource' : 'Update Resource'; ?>
            </button>
          </div>
        </form>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>