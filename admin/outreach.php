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
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 6;

function handle_upload(?array $file): ?string {
  if (!$file || !isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) return null;
  if ($file['size'] > MAX_UPLOAD_BYTES) throw new Exception('File too large.');
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime = finfo_file($finfo, $file['tmp_name']);
  finfo_close($finfo);
  $allowed = ['image/jpeg','image/png','image/webp'];
  if (!in_array($mime, $allowed, true)) throw new Exception('Unsupported file type.');
  $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
  $name = 'outreach_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
  $dest = UPLOAD_DIR . $name;
  if (!move_uploaded_file($file['tmp_name'], $dest)) throw new Exception('Upload failed.');
  return $name;
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
      $image = null;
      if (!empty($_FILES['image']['name'])) {
        $image = handle_upload($_FILES['image']);
      }
      if ($action === 'create') {
        $stmt = db()->prepare('INSERT INTO outreach_reports (title, description, file_link, image, date) VALUES (?,?,?,?,?)');
        $stmt->execute([$title, $description, $file_link ?: null, $image, $date]);
        $notice = 'Outreach report created.';
        $action = 'list';
      } else {
        $id = (int)($_POST['id'] ?? 0);
        if ($image) {
          $stmt = db()->prepare('UPDATE outreach_reports SET title=?, description=?, file_link=?, image=?, date=? WHERE id=?');
          $stmt->execute([$title, $description, $file_link ?: null, $image, $date, $id]);
        } else {
          $stmt = db()->prepare('UPDATE outreach_reports SET title=?, description=?, file_link=?, date=? WHERE id=?');
          $stmt->execute([$title, $description, $file_link ?: null, $date, $id]);
        }
        $notice = 'Outreach report updated.';
        $action = 'list';
      }
    } elseif ($action === 'delete') {
      $id = (int)($_POST['id'] ?? 0);
      $stmt = db()->prepare('DELETE FROM outreach_reports WHERE id=?');
      $stmt->execute([$id]);
      $notice = 'Outreach report deleted.';
      $action = 'list';
    }
  }
} catch (Throwable $e) {
  $error = 'Error: ' . $e->getMessage();
}

function fetch_report(int $id): array {
  $stmt = db()->prepare('SELECT * FROM outreach_reports WHERE id=? LIMIT 1');
  $stmt->execute([$id]);
  return $stmt->fetch() ?: ['id'=>0,'title'=>'','description'=>'','file_link'=>null,'date'=>date('Y-m-d')];
}
?>
<div class="min-h-screen bg-gray-50/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Outreach Reports</h1>
          <p class="mt-2 text-sm text-gray-600">Create and manage outreach reports</p>
        </div>
        <?php if ($action === 'list'): ?>
          <div class="flex items-center gap-3">
            <a href="<?php echo url('outreach-report'); ?>" target="_blank"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 5H7C5.89543 5 5 5.89543 5 7V17C5 18.1046 5.89543 19 7 19H17C18.1046 19 19 18.1046 19 17V11" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M19 5L13 11" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              View Public Page
            </a>
            <a href="<?php echo url('admin/outreach.php'); ?>?action=create"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
              style="background: <?php echo RCN_GRADIENT; ?>;">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              New Report
            </a>
          </div>
        <?php else: ?>
          <a href="<?php echo url('admin/outreach.php'); ?>"
            class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 12H5M12 19l-7-7 7-7" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Back to Reports
          </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Alert Messages -->
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
      <?php
      try {
        $count = (int)db()->query('SELECT COUNT(*) FROM outreach_reports')->fetchColumn();
        $pages = max(1, (int)ceil($count / $perPage));
        if ($page > $pages) $page = $pages;
        $offset = ($page - 1) * $perPage;
        $rows = db()->query('SELECT * FROM outreach_reports ORDER BY date DESC, id DESC LIMIT ' . (int)$perPage . ' OFFSET ' . (int)$offset)->fetchAll();
      } catch (Throwable $e) {
        $rows = [];
        $pages = 1;
      }
      ?>

      <?php if (empty($rows)): ?>
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No outreach reports yet</h3>
          <p class="text-gray-500 mb-6">Get started by creating your first report.</p>
          <a href="<?php echo url('admin/outreach.php'); ?>?action=create"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
            style="background: <?php echo RCN_GRADIENT; ?>;">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Create First Report
          </a>
        </div>
      <?php else: ?>
        <!-- Reports Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($rows as $r): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 group">
              <?php if (!empty($r['image'])): ?>
                <div class="h-48 bg-gray-200 overflow-hidden">
                  <img src="<?php echo url('uploads/' . $r['image']); ?>" alt="<?php echo esc_attr($r['title']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
              <?php else: ?>
                <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                  <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              <?php endif; ?>

              <div class="p-6">
                <h3 class="font-semibold text-gray-900 text-lg mb-2 group-hover:text-blue-600 transition-colors"><?php echo esc_html($r['title']); ?></h3>
                <p class="text-gray-600 text-sm mb-4"><?php
                  if (!function_exists('excerpt_plain')) {
                    function excerpt_plain(string $html, int $limit = 160): string {
                      $text = trim(preg_replace('/\s+/u', ' ', strip_tags($html)));
                      if (mb_strlen($text) <= $limit) return $text;
                      $cut = mb_substr($text, 0, $limit);
                      $cut = preg_replace('/\s+\S*$/u', '', $cut);
                      return rtrim($cut) . '…';
                    }
                  }
                  echo esc_html(excerpt_plain($r['description'], 160));
                ?></p>

                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                  <span><?php echo esc_html($r['date']); ?></span>
                  <?php if (!empty($r['file_link'])): ?>
                    <a class="text-blue-600 hover:underline" href="<?php echo esc_attr($r['file_link']); ?>" target="_blank">Attachment</a>
                  <?php endif; ?>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                  <a href="<?php echo url('admin/outreach.php'); ?>?action=edit&id=<?php echo (int)$r['id']; ?>" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Edit
                  </a>
                  <form method="post" action="<?php echo url('admin/outreach.php'); ?>?action=delete" onsubmit="return confirm('Delete this report?')" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
                    <button class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-red-300 text-red-700 font-medium hover:bg-red-50 transition-colors duration-200" type="submit">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 7H18M10 11V17M14 11V17M5 7L6 19C6.05524 19.6078 6.31372 20.1843 6.73679 20.6365C7.15987 21.0886 7.72486 21.3903 8.34545 21.5H15.6546C16.2751 21.3903 16.8401 21.0886 17.2632 20.6365C17.6863 20.1843 17.9448 19.6078 18 19L19 7" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Delete
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <?php if (($pages ?? 1) > 1): ?>
          <div class="mt-8 flex items-center justify-center gap-2">
            <?php if ($page > 1): ?>
              <a href="<?php echo url('admin/outreach.php'); ?>?page=<?php echo (int)($page - 1); ?>" class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Prev</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
              <a href="<?php echo url('admin/outreach.php'); ?>?page=<?php echo (int)$i; ?>" class="px-3 py-2 rounded-lg <?php echo $i === $page ? 'bg-gray-900 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50'; ?>"><?php echo (int)$i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $pages): ?>
              <a href="<?php echo url('admin/outreach.php'); ?>?page=<?php echo (int)($page + 1); ?>" class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Next</a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    <?php elseif ($action === 'create' || $action === 'edit'): ?>
      <?php $r = ($action === 'edit') ? fetch_report((int)($_GET['id'] ?? 0)) : ['id'=>0,'title'=>'','description'=>'','file_link'=>null,'image'=>null,'date'=>date('Y-m-d')]; ?>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form method="post" enctype="multipart/form-data" class="space-y-4" id="outreachForm">
          <?php echo csrf_field(); ?>
          <?php if ($action === 'edit'): ?><input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>"><?php endif; ?>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Title</label>
            <input name="title" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo esc_attr($r['title']); ?>" required>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Description</label>
            <textarea name="description" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" rows="4" required><?php echo $r['description']; ?></textarea>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">File Link (optional)</label>
            <input name="file_link" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo esc_attr($r['file_link'] ?? ''); ?>">
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Image (JPEG/PNG/WebP, max <?php echo (int)(MAX_UPLOAD_BYTES / (1024 * 1024)); ?>MB)</label>
            <input name="image" type="file" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            <?php if (!empty($r['image'])): ?>
              <p class="text-sm mt-1">Current: <a class="text-blue-600 hover:underline" href="<?php echo url('uploads/' . esc_attr($r['image'])); ?>" target="_blank">View</a></p>
            <?php endif; ?>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-700">Date</label>
            <input name="date" type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo esc_attr($r['date']); ?>" required>
          </div>
          <div class="flex items-center justify-end gap-3">
            <a href="<?php echo url('admin/outreach.php'); ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
              Cancel
            </a>
            <button class="inline-flex items-center gap-2 px-6 py-2 rounded-lg text-white font-medium shadow-sm hover:shadow-md transition-all duration-200" type="submit" style="background: <?php echo RCN_GRADIENT; ?>;">
              <?php echo $action === 'create' ? 'Create Report' : 'Update Report'; ?>
            </button>
          </div>
        </form>
      </div>
      <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
      <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
      <script>
        (function(){
          var textarea = document.querySelector('textarea[name=description]');
          if (!textarea) return;
          var container = document.createElement('div');
          container.id = 'quillOutreach';
          container.style.height = '400px';
          container.className = 'bg-white';
          textarea.parentNode.insertBefore(container, textarea.nextSibling);
          textarea.style.display = 'none';
          var quill = new Quill('#quillOutreach', {
            theme: 'snow',
            modules: { toolbar: [[{ header: [1,2,3,false] }], ['bold','italic','underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['link','image'], ['clean']] }
          });
          quill.root.innerHTML = textarea.value || '';
          var form = document.getElementById('outreachForm');
          var sync = function(){ textarea.value = quill.root.innerHTML; };
          quill.on('text-change', sync);
          if (form) { form.addEventListener('submit', function(){ sync(); }); }
        })();
      </script>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>
