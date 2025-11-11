<?php
require_once __DIR__ . '/../config/security.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/constants.php';

require_login(['SuperAdmin', 'Admin']);

$page_title = 'Newsletter Subscribers';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : 'all';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 25;

$allowedStatuses = ['all', 'confirmed', 'pending', 'unsubscribed'];
if (!in_array($status, $allowedStatuses, true)) {
  $status = 'all';
}

$pdo = db();

// Build filters
$where = [];
$params = [];
if ($q !== '') {
  $where[] = 'email LIKE ?';
  $params[] = "%$q%";
}
if ($status === 'confirmed') {
  $where[] = 'confirmed_at IS NOT NULL AND unsubscribed_at IS NULL';
} elseif ($status === 'pending') {
  $where[] = 'confirmed_at IS NULL AND unsubscribed_at IS NULL';
} elseif ($status === 'unsubscribed') {
  $where[] = 'unsubscribed_at IS NOT NULL';
}
$whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

// Count total
$countStmt = $pdo->prepare("SELECT COUNT(*) AS c FROM newsletter_subscribers $whereSql");
$countStmt->execute($params);
$total = (int)($countStmt->fetch()['c'] ?? 0);

$pages = max(1, (int)ceil($total / $perPage));
$page = min($page, $pages);
$offset = ($page - 1) * $perPage;

// CSV export
if (isset($_GET['export']) && $_GET['export'] === '1') {
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="newsletter_subscribers.csv"');
  $out = fopen('php://output', 'w');
  fputcsv($out, ['Email', 'Source', 'Created At', 'Confirmed At', 'Unsubscribed At']);
  $stmt = $pdo->prepare("SELECT email, source, created_at, confirmed_at, unsubscribed_at FROM newsletter_subscribers $whereSql ORDER BY created_at DESC");
  $stmt->execute($params);
  while ($row = $stmt->fetch()) {
    fputcsv($out, [
      $row['email'],
      $row['source'] ?? '',
      $row['created_at'] ?? '',
      $row['confirmed_at'] ?? '',
      $row['unsubscribed_at'] ?? '',
    ]);
  }
  fclose($out);
  exit;
}

// Fetch page
$stmt = $pdo->prepare("SELECT id, email, source, created_at, confirmed_at, unsubscribed_at FROM newsletter_subscribers $whereSql ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$rows = $stmt->fetchAll();

include __DIR__ . '/includes/admin-header.php';
?>

<main class="flex-1 p-6">
  <div class="max-w-6xl mx-auto">
    <!-- Compose Newsletter -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm mb-8">
      <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-lg font-semibold">Compose Newsletter</h2>
        <span class="text-sm text-gray-500">Sends to confirmed, not-unsubscribed subscribers</span>
      </div>
      <form id="composeForm" class="p-6 grid grid-cols-1 gap-6">
        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700">Subject</label>
          <input type="text" name="subject" class="w-full rounded-xl border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500 text-base" placeholder="Write a clear, concise subject line" required />
          <p class="text-xs text-gray-500">Subject appears as the email title.</p>
        </div>
        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700">Message</label>
          <textarea name="body" rows="10" class="w-full rounded-xl border-gray-300 px-3 py-3 focus:border-blue-500 focus:ring-blue-500 text-base" placeholder="Compose your message. Use line breaks for paragraphs." required style="min-height: 220px;"></textarea>
          <p class="text-xs text-gray-500">We’ll format this into a professional email with your logo.</p>
        </div>
        <div class="flex items-center gap-3">
          <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg text-white" style="background: <?php echo RCN_GRADIENT; ?>;">Send Newsletter</button>
          <button type="button" id="previewBtn" class="inline-flex items-center px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100">Preview Recipients</button>
          <div class="ml-auto flex items-center gap-2">
            <input type="email" id="testEmail" placeholder="your.email@example.com" class="rounded-lg border-gray-300 px-3 py-2 text-sm" style="min-width: 240px;" />
            <button type="button" id="sendTestBtn" class="inline-flex items-center px-3 py-2 rounded-lg border text-gray-700 hover:bg-gray-100">Send Test Email</button>
          </div>
        </div>
        <p class="text-sm text-gray-500">Each email includes your logo and a unique unsubscribe link.</p>
      </form>
    </div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Newsletter Subscribers</h1>
      <a class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white" style="background: <?php echo RCN_GRADIENT; ?>;" href="<?php echo url('admin/newsletter?' . http_build_query(['q' => $q, 'status' => $status, 'export' => '1'])); ?>">
        Export CSV
      </a>
    </div>

    <form method="get" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Search by email</label>
        <input type="text" name="q" value="<?php echo esc_attr($q); ?>" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-3 py-2 text-base" placeholder="e.g. john@doe.com" style="min-width:280px;" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-3 py-2 text-base" style="min-width:200px;">
          <option value="all" <?php echo $status==='all'?'selected':''; ?>>All</option>
          <option value="confirmed" <?php echo $status==='confirmed'?'selected':''; ?>>Confirmed</option>
          <option value="pending" <?php echo $status==='pending'?'selected':''; ?>>Pending</option>
          <option value="unsubscribed" <?php echo $status==='unsubscribed'?'selected':''; ?>>Unsubscribed</option>
        </select>
      </div>
      <div class="flex items-end">
        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg text-white" style="background: <?php echo RCN_GRADIENT; ?>;">Apply</button>
      </div>
    </form>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Confirmed</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unsubscribed</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!$rows): ?>
              <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-500">No subscribers found.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($rows as $r): ?>
                <tr data-id="<?php echo (int)$r['id']; ?>">
                  <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"><?php echo esc_html($r['email']); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?php echo esc_html($r['source'] ?? ''); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?php echo esc_html($r['created_at'] ?? ''); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?php echo esc_html($r['confirmed_at'] ?? ''); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-gray-700"><?php echo esc_html($r['unsubscribed_at'] ?? ''); ?></td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <button type="button" class="deleteBtn px-3 py-1 rounded border text-red-600 hover:bg-red-50">Delete</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <div class="px-6 py-4 bg-gray-50 flex items-center justify-between">
        <div class="text-sm text-gray-600">Page <?php echo $page; ?> of <?php echo $pages; ?> (<?php echo $total; ?> total)</div>
        <div class="flex items-center gap-2">
          <?php
            $base = url('admin/newsletter');
            $qs = ['q' => $q, 'status' => $status];
            $prevUrl = $page > 1 ? ($base . '?' . http_build_query($qs + ['page' => $page - 1])) : null;
            $nextUrl = $page < $pages ? ($base . '?' . http_build_query($qs + ['page' => $page + 1])) : null;
          ?>
          <a class="px-3 py-1 rounded border <?php echo $prevUrl? 'text-gray-700 hover:bg-gray-100':'text-gray-400 cursor-not-allowed'; ?>" href="<?php echo $prevUrl ?: '#'; ?>">Prev</a>
          <a class="px-3 py-1 rounded border <?php echo $nextUrl? 'text-gray-700 hover:bg-gray-100':'text-gray-400 cursor-not-allowed'; ?>" href="<?php echo $nextUrl ?: '#'; ?>">Next</a>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>

<script>
  // Robust message helper: uses toast if available, otherwise alerts; never throws
  function safeNotify(message, type) {
    try {
      if (window.notify) {
        window.notify(message, type || 'info');
      } else {
        alert(message);
      }
    } catch (_) {
      alert(message);
    }
  }

  // Safe JSON parser for endpoints that may return non-JSON on error
  async function getJsonSafe(res) {
    try {
      return await res.json();
    } catch (_) {
      return {};
    }
  }

  // Send newsletter
  (function(){
    const form = document.getElementById('composeForm');
    const previewBtn = document.getElementById('previewBtn');
    const sendTestBtn = document.getElementById('sendTestBtn');
    const testEmailInput = document.getElementById('testEmail');
    if (!form) return;
    const endpoint = '<?php echo url('admin/newsletter-send.php'); ?>';
    const testEndpoint = '<?php echo url('admin/newsletter-test.php'); ?>';
    async function submitSend(preview) {
      const fd = new FormData(form);
      if (preview) fd.append('preview', '1');
      const btn = form.querySelector('button[type="submit"]');
      btn.disabled = true;
      btn.textContent = preview ? 'Previewing…' : 'Sending…';
      try {
        const res = await fetch(endpoint, {
          method: 'POST',
          body: fd,
          credentials: 'same-origin',
          headers: { 'Accept': 'application/json' }
        });
        const data = await getJsonSafe(res);
        const success = res.ok && (data.ok === true || typeof data.count === 'number' || typeof data.queued === 'number');
        if (success) {
          if (preview) {
            safeNotify('Recipients: ' + (data.count ?? 0), 'success');
          } else {
            const q = (typeof data.queued === 'number') ? data.queued : (data.ok === true ? (data.queued ?? 0) : 0);
            safeNotify(`Queued: ${q} emails. Delivery starts soon.`, 'success');
          }
        } else {
          safeNotify(data.message || 'Failed to send newsletter.', 'error');
        }
      } catch (e) {
        safeNotify('Network error. Please try again.', 'error');
      } finally {
        btn.disabled = false;
        btn.textContent = 'Send Newsletter';
      }
    }
    form.addEventListener('submit', function(e){ e.preventDefault(); submitSend(false); });
    previewBtn && previewBtn.addEventListener('click', function(){ submitSend(true); });
    sendTestBtn && sendTestBtn.addEventListener('click', async function(){
      const fd = new FormData(form);
      const recipient = (testEmailInput?.value || '').trim();
      if (!recipient) { safeNotify('Enter a test email address.', 'error'); return; }
      fd.append('recipient', recipient);
      const btn = sendTestBtn;
      btn.disabled = true; btn.textContent = 'Queuing…';
      try {
        const res = await fetch(testEndpoint, {
          method: 'POST',
          body: fd,
          credentials: 'same-origin',
          headers: { 'Accept': 'application/json' }
        });
        const data = await getJsonSafe(res);
        const success = res.ok && (data.ok === true || typeof data.queued === 'number');
        if (success) {
          safeNotify('Test email queued for ' + recipient, 'success');
        } else {
          safeNotify(data.message || 'Failed to queue test email.', 'error');
        }
      } catch (e) {
        safeNotify('Network error. Please try again.', 'error');
      } finally {
        btn.disabled = false; btn.textContent = 'Send Test Email';
      }
    });
  })();

  // Delete subscriber (robust init, with fallback and session credentials)
  document.addEventListener('DOMContentLoaded', function(){
    const buttons = document.querySelectorAll('.deleteBtn');
    const endpoint = '<?php echo url('admin/newsletter-delete.php'); ?>';
    let modal = null, confirmBtn = null, cancelBtn = null, currentRow = null, currentId = null, modalTitle = null, modalText = null;

    function showModal(row) {
      currentRow = row;
      currentId = row?.getAttribute('data-id') || null;
      if (!currentId) return;
      if (!modal) {
        // Fallback: simple confirm if modal missing
        if (confirm('Delete this subscriber? This cannot be undone.')) {
          performDelete();
        }
        return;
      }
      const emailCell = row.querySelector('td:first-child');
      if (emailCell) {
        modalText && (modalText.textContent = 'This will permanently remove ' + emailCell.textContent.trim() + ' and any pending confirmations. This cannot be undone.');
      }
      modal.classList.remove('hidden');
      modal.classList.remove('opacity-0');
      modal.classList.add('opacity-100');
    }

    function hideModal() {
      if (!modal) return;
      modal.classList.add('opacity-0');
      modal.classList.remove('opacity-100');
      setTimeout(() => { modal.classList.add('hidden'); }, 150);
      currentRow = null;
      currentId = null;
    }

    async function performDelete() {
      if (!currentId) return;
      const fd = new FormData();
      fd.append('id', currentId);
      const originalText = confirmBtn ? confirmBtn.textContent : '';
      if (confirmBtn) { confirmBtn.disabled = true; confirmBtn.textContent = 'Deleting…'; }
      try {
        const res = await fetch(endpoint, {
          method: 'POST',
          body: fd,
          credentials: 'same-origin',
          headers: { 'Accept': 'application/json' }
        });
        let data = {};
        try { data = await res.json(); } catch (_) { data = {}; }
        if (res.ok && data.ok) {
          window.notify && window.notify('Subscriber deleted.', 'success');
          currentRow && currentRow.remove();
          hideModal();
        } else {
          window.notify && window.notify((data && data.message) || 'Delete failed.', 'error');
        }
      } catch (e) {
        window.notify && window.notify('Network error. Please try again.', 'error');
      } finally {
        if (confirmBtn) { confirmBtn.disabled = false; confirmBtn.textContent = originalText; }
      }
    }

    function initModal() {
      modal = document.getElementById('confirmDeleteModal');
      confirmBtn = document.getElementById('confirmDeleteYes');
      cancelBtn = document.getElementById('confirmDeleteCancel');
      modalTitle = document.getElementById('confirmDeleteTitle');
      modalText = document.getElementById('confirmDeleteText');
      if (!modal || !confirmBtn || !cancelBtn) return;
      cancelBtn.addEventListener('click', hideModal);
      modal.addEventListener('click', function(e){ if (e.target === modal) hideModal(); });
      confirmBtn.addEventListener('click', function(){ performDelete(); });
    }

    initModal();
    buttons.forEach(btn => {
      btn.addEventListener('click', function(){
        const tr = btn.closest('tr');
        if (!tr) return;
        showModal(tr);
      });
    });
  });
</script>

<!-- Delete Confirmation Modal -->
<div id="confirmDeleteModal" class="fixed inset-0 z-50 bg-black/40 hidden opacity-0 transition-opacity">
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-gray-200">
      <div class="px-6 pt-6">
        <h3 id="confirmDeleteTitle" class="text-lg font-semibold text-gray-900">Delete Subscriber?</h3>
        <p id="confirmDeleteText" class="mt-2 text-sm text-gray-600">This will permanently remove the subscriber and any pending confirmations. This cannot be undone.</p>
      </div>
      <div class="px-6 py-4 flex items-center justify-end gap-3">
        <button id="confirmDeleteCancel" type="button" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Cancel</button>
        <button id="confirmDeleteYes" type="button" class="inline-flex items-center px-4 py-2 rounded-lg text-white" style="background: <?php echo RCN_GRADIENT; ?>;">Delete</button>
      </div>
    </div>
  </div>
</div>