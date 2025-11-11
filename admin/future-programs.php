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

try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!csrf_validate($token)) {
      throw new Exception('Invalid request.');
    }
    if (($action === 'create') || ($action === 'edit')) {
      $title = trim($_POST['title'] ?? '');
      $description = trim($_POST['description'] ?? '');
      $start_date = trim($_POST['start_date'] ?? '');
      $end_date = trim($_POST['end_date'] ?? '');
      if ($title === '' || $description === '') {
        throw new Exception('Please fill in title and description.');
      }
      if ($action === 'create') {
        $stmt = db()->prepare('INSERT INTO future_programs (title, description, start_date, end_date) VALUES (?,?,?,?)');
        $stmt->execute([$title, $description, $start_date ?: null, $end_date ?: null]);
        $notice = 'Program created.';
        $action = 'list';
      } else {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = db()->prepare('UPDATE future_programs SET title=?, description=?, start_date=?, end_date=? WHERE id=?');
        $stmt->execute([$title, $description, $start_date ?: null, $end_date ?: null, $id]);
        $notice = 'Program updated.';
        $action = 'list';
      }
    } elseif ($action === 'delete') {
      $id = (int)($_POST['id'] ?? 0);
      $stmt = db()->prepare('DELETE FROM future_programs WHERE id=?');
      $stmt->execute([$id]);
      $notice = 'Program deleted.';
      $action = 'list';
    }
  }
} catch (Throwable $e) {
  $error = 'Error: ' . $e->getMessage();
}

function fetch_program(int $id): array {
  $stmt = db()->prepare('SELECT * FROM future_programs WHERE id=? LIMIT 1');
  $stmt->execute([$id]);
  return $stmt->fetch() ?: ['id'=>0,'title'=>'','description'=>'','start_date'=>null,'end_date'=>null];
}
?>
<div class="min-h-screen bg-gray-50/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Future Programs</h1>
          <p class="mt-2 text-sm text-gray-600">Plan and manage upcoming programs</p>
        </div>
        <?php if ($action === 'list'): ?>
          <div class="flex items-center gap-3">
            <a href="<?php echo url('future-programs'); ?>" target="_blank"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 5H7C5.89543 5 5 5.89543 5 7V17C5 18.1046 5.89543 19 7 19H17C18.1046 19 19 18.1046 19 17V11" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M19 5L13 11" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              View Public Page
            </a>
            <a href="<?php echo url('admin/future-programs.php'); ?>?action=create"
              class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
              style="background: <?php echo RCN_GRADIENT; ?>;">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              New Program
            </a>
          </div>
        <?php else: ?>
          <a href="<?php echo url('admin/future-programs.php'); ?>"
            class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 12H5M12 19l-7-7 7-7" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Back to Programs
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
      <?php $rows = db()->query('SELECT * FROM future_programs ORDER BY id DESC')->fetchAll(); ?>

      <?php if (empty($rows)): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No programs yet</h3>
          <p class="text-gray-500 mb-6">Plan your first future program.</p>
          <a href="<?php echo url('admin/future-programs.php'); ?>?action=create"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
            style="background: <?php echo RCN_GRADIENT; ?>;">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Create First Program
          </a>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($rows as $r): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300">
              <div class="h-32 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="p-6">
                <h3 class="font-semibold text-gray-900 text-lg mb-1 line-clamp-2"><?php echo esc_html($r['title']); ?></h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo esc_html($r['description']); ?></p>
                <div class="text-sm text-gray-500 mb-4">
                  <?php echo esc_html($r['start_date'] ?? ''); ?>
                  <?php if (!empty($r['end_date'])): ?> - <?php echo esc_html($r['end_date']); ?><?php endif; ?>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                  <a href="<?php echo url('admin/future-programs.php'); ?>?action=edit&id=<?php echo (int)$r['id']; ?>" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">Edit</a>
                  <form method="post" action="<?php echo url('admin/future-programs.php'); ?>?action=delete" onsubmit="return confirm('Delete this program?')" class="flex-1">
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
      <?php $r = ($action === 'edit') ? fetch_program((int)($_GET['id'] ?? 0)) : ['id'=>0,'title'=>'','description'=>'','start_date'=>null,'end_date'=>null]; ?>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form method="post" class="space-y-4">
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
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm mb-1 text-gray-700">Start Date (optional)</label>
              <input name="start_date" type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo esc_attr($r['start_date'] ?? ''); ?>">
            </div>
            <div>
              <label class="block text-sm mb-1 text-gray-700">End Date (optional)</label>
              <input name="end_date" type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200" value="<?php echo esc_attr($r['end_date'] ?? ''); ?>">
            </div>
          </div>
          <div class="flex items-center justify-end gap-3">
            <a href="<?php echo url('admin/future-programs.php'); ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">Cancel</a>
            <button class="inline-flex items-center gap-2 px-6 py-2 rounded-lg text-white font-medium shadow-sm hover:shadow-md transition-all duration-200" type="submit" style="background: <?php echo RCN_GRADIENT; ?>;">
              <?php echo $action === 'create' ? 'Create Program' : 'Update Program'; ?>
            </button>
          </div>
        </form>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/includes/admin-footer.php'; ?>