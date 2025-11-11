<?php
require_once __DIR__ . '/../config/security.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/constants.php';

require_login(['SuperAdmin', 'Admin']);

$page_title = 'Email Queue';

$type = isset($_GET['type']) ? trim($_GET['type']) : 'all';
$status = isset($_GET['status']) ? trim($_GET['status']) : 'pending';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 25;

$pdo = db();

$where = [];
$params = [];
if ($type !== 'all') { $where[] = 'type = ?'; $params[] = $type; }
if ($status !== 'all') { $where[] = 'status = ?'; $params[] = $status; }
$whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

// Count total
$countStmt = $pdo->prepare("SELECT COUNT(*) AS c FROM email_queue $whereSql");
$countStmt->execute($params);
$total = (int)($countStmt->fetch()['c'] ?? 0);

$pages = max(1, (int)ceil($total / $perPage));
$page = min($page, $pages);
$offset = ($page - 1) * $perPage;

// Fetch page
$stmt = $pdo->prepare("SELECT id, type, recipient, subject, status, attempts, last_attempt_at, created_at, sent_at, error FROM email_queue $whereSql ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$rows = $stmt->fetchAll();

// Stats by status
$stats = [
  'pending' => (int)$pdo->query("SELECT COUNT(*) FROM email_queue WHERE status='pending'")->fetchColumn(),
  'sent' => (int)$pdo->query("SELECT COUNT(*) FROM email_queue WHERE status='sent'")->fetchColumn(),
  'failed' => (int)$pdo->query("SELECT COUNT(*) FROM email_queue WHERE status='failed'")->fetchColumn(),
  'cancelled' => (int)$pdo->query("SELECT COUNT(*) FROM email_queue WHERE status='cancelled'")->fetchColumn(),
];

include __DIR__ . '/includes/admin-header.php';
?>

<main class="flex-1 p-6">
  <div class="max-w-7xl mx-auto">
    <?php if (defined('QUEUE_PAUSE_SENDING') && QUEUE_PAUSE_SENDING): ?>
      <div class="mb-4 rounded-xl border border-yellow-300 bg-yellow-50 text-yellow-800 px-4 py-3">
        <div class="flex items-center gap-3">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 9V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 17.01V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.29 3.85997L2.82002 17C2.64408 17.3039 2.55177 17.6531 2.55346 18.0085C2.55514 18.3639 2.65077 18.7122 2.83002 19.014C3.00927 19.3158 3.2642 19.5594 3.5675 19.719C3.8708 19.8785 4.21123 19.9481 4.55002 19.92H19.45C19.7888 19.9481 20.1292 19.8785 20.4325 19.719C20.7358 19.5594 20.9907 19.3158 21.17 19.014C21.3492 18.7122 21.4449 18.3639 21.4465 18.0085C21.4482 17.6531 21.3559 17.3039 21.18 17L13.71 3.85997C13.5324 3.56438 13.281 3.32625 12.9841 3.17089C12.6873 3.01553 12.3553 2.94942 12.02 2.98001C11.6848 3.0106 11.3653 3.13688 11.0959 3.34308C10.8265 3.54927 10.617 3.82629 10.49 4.13998L10.29 3.85997Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          <div>
            <div class="font-semibold">Email sending is paused</div>
            <div class="text-sm">Queue processing is temporarily disabled. You can resume in Settings → Email Queue.</div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Email Queue</h1>
      <div class="flex items-center gap-3 text-sm">
        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800">Pending: <?php echo $stats['pending']; ?></span>
        <span class="px-3 py-1 rounded-full bg-green-100 text-green-800">Sent: <?php echo $stats['sent']; ?></span>
        <span class="px-3 py-1 rounded-full bg-red-100 text-red-800">Failed: <?php echo $stats['failed']; ?></span>
        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800">Cancelled: <?php echo $stats['cancelled']; ?></span>
      </div>
    </div>

    <form method="get" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
        <select name="type" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-3 py-2 text-base" style="min-width:220px;">
          <?php $types = ['all','newsletter','newsletter_test','contact']; foreach ($types as $t): ?>
            <option value="<?php echo esc_attr($t); ?>" <?php echo $type===$t?'selected':''; ?>><?php echo ucfirst(str_replace('_',' ',$t)); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-3 py-2 text-base" style="min-width:200px;">
          <?php $statuses = ['all','pending','sent','failed','cancelled']; foreach ($statuses as $s): ?>
            <option value="<?php echo esc_attr($s); ?>" <?php echo $status===$s?'selected':''; ?>><?php echo ucfirst($s); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="flex items-end">
        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg text-white" style="background: <?php echo RCN_GRADIENT; ?>;">Apply</button>
      </div>
    </form>

    <div class="flex items-center gap-3 mb-4">
      <button type="button" id="bulkRetryFailed" class="inline-flex items-center px-4 py-2 rounded-lg border text-blue-700 hover:bg-blue-50">Retry all failed</button>
      <button type="button" id="bulkCancelPending" class="inline-flex items-center px-4 py-2 rounded-lg border text-red-700 hover:bg-red-50">Cancel all pending</button>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempts</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Attempt</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent At</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Error</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!$rows): ?>
              <tr>
                <td colspan="10" class="px-6 py-10 text-center text-gray-500">No queue items found.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($rows as $r): ?>
                <tr>
                  <td class="px-6 py-4 text-gray-900">#<?php echo (int)$r['id']; ?></td>
                  <td class="px-6 py-4 text-gray-700"><?php echo esc_html($r['type']); ?></td>
                  <td class="px-6 py-4 text-gray-700"><?php echo esc_html($r['recipient']); ?></td>
                  <td class="px-6 py-4 text-gray-700"><?php echo esc_html($r['subject']); ?></td>
                  <td class="px-6 py-4">
                    <?php if ($r['status']==='pending'): ?>
                      <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs">Pending</span>
                    <?php elseif ($r['status']==='sent'): ?>
                      <span class="px-2 py-1 rounded bg-green-100 text-green-800 text-xs">Sent</span>
                    <?php elseif ($r['status']==='failed'): ?>
                      <span class="px-2 py-1 rounded bg-red-100 text-red-800 text-xs">Failed</span>
                    <?php else: ?>
                      <span class="px-2 py-1 rounded bg-gray-100 text-gray-800 text-xs">Cancelled</span>
                    <?php endif; ?>
                  </td>
                  <td class="px-6 py-4 text-gray-700"><?php echo (int)$r['attempts']; ?></td>
                  <td class="px-6 py-4 text-gray-700"><?php echo esc_html($r['created_at'] ?? ''); ?></td>
                  <td class="px-6 py-4 text-gray-700"><?php echo esc_html($r['last_attempt_at'] ?? ''); ?></td>
                  <td class="px-6 py-4 text-gray-700"><?php echo esc_html($r['sent_at'] ?? ''); ?></td>
                  <td class="px-6 py-4 text-gray-700" style="max-width: 300px; overflow-wrap: anywhere;"><?php echo esc_html($r['error'] ?? ''); ?></td>
                  <td class="px-6 py-4">
                    <?php if ($r['status']==='failed'): ?>
                      <button type="button" class="retryBtn px-3 py-1 rounded border text-blue-700 hover:bg-blue-50" data-id="<?php echo (int)$r['id']; ?>">Retry</button>
                      <button type="button" class="cancelBtn px-3 py-1 rounded border text-red-700 hover:bg-red-50" data-id="<?php echo (int)$r['id']; ?>">Cancel</button>
                      <button type="button" class="deleteBtn px-3 py-1 rounded border text-gray-700 hover:bg-gray-50" data-id="<?php echo (int)$r['id']; ?>">Delete</button>
                      <button type="button" class="viewBtn px-3 py-1 rounded border text-gray-700 hover:bg-gray-50" data-id="<?php echo (int)$r['id']; ?>">View</button>
                    <?php elseif ($r['status']==='pending'): ?>
                      <button type="button" class="cancelBtn px-3 py-1 rounded border text-red-700 hover:bg-red-50" data-id="<?php echo (int)$r['id']; ?>">Cancel</button>
                      <button type="button" class="deleteBtn px-3 py-1 rounded border text-gray-700 hover:bg-gray-50" data-id="<?php echo (int)$r['id']; ?>">Delete</button>
                      <button type="button" class="viewBtn px-3 py-1 rounded border text-gray-700 hover:bg-gray-50" data-id="<?php echo (int)$r['id']; ?>">View</button>
                    <?php elseif ($r['status']==='cancelled'): ?>
                      <button type="button" class="deleteBtn px-3 py-1 rounded border text-gray-700 hover:bg-gray-50" data-id="<?php echo (int)$r['id']; ?>">Delete</button>
                      <button type="button" class="viewBtn px-3 py-1 rounded border text-gray-700 hover:bg-gray-50" data-id="<?php echo (int)$r['id']; ?>">View</button>
                    <?php else: ?>
                      <button type="button" class="resendBtn px-3 py-1 rounded border text-blue-700 hover:bg-blue-50" data-id="<?php echo (int)$r['id']; ?>">Resend</button>
                      <button type="button" class="viewBtn px-3 py-1 rounded border text-gray-700 hover:bg-gray-50" data-id="<?php echo (int)$r['id']; ?>">View</button>
                    <?php endif; ?>
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
            $base = url('admin/queue');
            $qs = ['type' => $type, 'status' => $status];
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
  (function(){
    const retryButtons = document.querySelectorAll('.retryBtn');
    const cancelButtons = document.querySelectorAll('.cancelBtn');
    const deleteButtons = document.querySelectorAll('.deleteBtn');
    const resendButtons = document.querySelectorAll('.resendBtn');
    const viewButtons = document.querySelectorAll('.viewBtn');
    const endpoint = '<?php echo url('admin/queue-action.php'); ?>';
    const typeSelect = document.querySelector('select[name="type"]');

    async function postAction(id, action){
      try {
        const fd = new FormData();
        fd.append('id', String(id));
        fd.append('action', action);
        const res = await fetch(endpoint, { method: 'POST', body: fd, credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
        const data = await res.json();
        if(res.ok && data.ok){
          window.notify && window.notify(data.message || 'Updated', 'success');
          // Simple reload to reflect latest state
          setTimeout(() => { window.location.reload(); }, 500);
        } else {
          window.notify && window.notify(data.message || 'Update failed', 'error');
        }
      } catch(e){
        window.notify && window.notify('Network error. Try again.', 'error');
      }
    }

    retryButtons.forEach(btn => btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-id');
      postAction(id, 'retry');
    }));
    cancelButtons.forEach(btn => btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-id');
      smartConfirm('Cancel this item? It will not be sent.').then(ok => { if (ok) postAction(id, 'cancel'); });
    }));
    deleteButtons.forEach(btn => btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-id');
      smartConfirm('Delete this queue item? This cannot be undone.').then(ok => { if (ok) postAction(id, 'delete'); });
    }));
    resendButtons.forEach(btn => btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-id');
      smartConfirm('Resend this email to the recipient?').then(ok => { if (ok) postAction(id, 'resend'); });
    }));
    viewButtons.forEach(btn => btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-id');
      viewPayload(id);
    }));

    async function postBulk(action){
      const confirmText = action === 'bulk_retry_failed'
        ? 'Retry all failed items? Attempts reset to 0.'
        : 'Cancel all pending items? They will not be sent.';
      const ok = await smartConfirm(confirmText);
      if (!ok) return;
      try {
        const fd = new FormData();
        fd.append('action', action);
        fd.append('confirm', 'yes');
        fd.append('limit', '200');
        if (typeSelect) fd.append('type', typeSelect.value);
        const res = await fetch(endpoint, { method: 'POST', body: fd, credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
        const data = await res.json();
        if(res.ok && data.ok){
          window.notify && window.notify(data.message || 'Bulk update done', 'success');
          setTimeout(() => { window.location.reload(); }, 500);
        } else {
          window.notify && window.notify(data.message || 'Bulk update failed', 'error');
        }
      } catch(e){
        window.notify && window.notify('Network error. Try again.', 'error');
      }
    }
    document.getElementById('bulkRetryFailed').addEventListener('click', () => postBulk('bulk_retry_failed'));
    document.getElementById('bulkCancelPending').addEventListener('click', () => postBulk('bulk_cancel_pending'));

    // Designed confirm dialog using SweetAlert if available, else custom modal fallback
    function smartConfirm(message){
      return new Promise(resolve => {
        if (window.Swal) {
          Swal.fire({
            title: 'Please confirm',
            html: `<div class="text-gray-700">${message}</div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#f97316', // mission orange vibe
            cancelButtonColor: '#6b7280', // gray
            focusCancel: true,
          }).then(r => resolve(!!r.isConfirmed));
          return;
        }
        // Custom minimal modal
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed';
        overlay.style.inset = '0';
        overlay.style.background = 'rgba(0,0,0,0.4)';
        overlay.style.zIndex = '9999';
        overlay.innerHTML = `
          <div class="flex items-center justify-center w-full h-full">
            <div class="bg-white rounded-xl shadow-xl border border-gray-200 w-full max-w-md mx-4">
              <div class="px-5 py-4 border-b"><div class="font-semibold text-gray-900">Please confirm</div></div>
              <div class="px-5 py-4 text-gray-700">${message}</div>
              <div class="px-5 py-4 flex justify-end gap-3">
                <button id="modalCancel" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Cancel</button>
                <button id="modalConfirm" class="px-4 py-2 rounded-lg text-white" style="background: <?php echo RCN_GRADIENT; ?>;">Confirm</button>
              </div>
            </div>
          </div>`;
        document.body.appendChild(overlay);
        const cleanup = () => overlay.remove();
        overlay.querySelector('#modalCancel').addEventListener('click', () => { cleanup(); resolve(false); });
        overlay.querySelector('#modalConfirm').addEventListener('click', () => { cleanup(); resolve(true); });
      });
    }

    function escapeHtml(str){
      return String(str || '').replace(/[&<>"']/g, function(m){
        return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'})[m];
      });
    }

    async function viewPayload(id){
      try {
        const fd = new FormData();
        fd.append('id', String(id));
        fd.append('action', 'get_payload');
        const res = await fetch(endpoint, { method: 'POST', body: fd, credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
        const data = await res.json();
        if (!res.ok || !data.ok) { window.notify && window.notify(data.message || 'Could not load payload', 'error'); return; }
        const item = data.item || {};
        const metaFormatted = item.meta ? escapeHtml(JSON.stringify(item.meta, null, 2)) : '—';
        const html = `
          <div class="text-left">
            <div class="mb-2 text-sm text-gray-600">#${item.id} • ${escapeHtml(item.type)} • <span class="uppercase">${escapeHtml(item.status)}</span></div>
            <div class="mb-3"><span class="font-semibold">Recipient:</span> ${escapeHtml(item.recipient)}</div>
            <div class="mb-3"><span class="font-semibold">Subject:</span> ${escapeHtml(item.subject)}</div>
            <div class="mb-3"><span class="font-semibold">Meta:</span>
              <pre class="mt-2 p-3 bg-gray-50 border rounded overflow-auto max-h-40 text-xs">${metaFormatted}</pre>
            </div>
            <div class="mb-2 font-semibold">Body:</div>
            <div class="p-3 bg-gray-50 border rounded overflow-auto max-h-64 text-sm"><pre style="white-space: pre-wrap">${escapeHtml(item.body)}</pre></div>
          </div>`;
        if (window.Swal) {
          Swal.fire({ title: 'Queue Item Details', html, width: 700, confirmButtonText: 'Close', confirmButtonColor: '#f97316' });
        } else {
          const overlay = document.createElement('div');
          overlay.style.position = 'fixed'; overlay.style.inset = '0'; overlay.style.background = 'rgba(0,0,0,0.4)'; overlay.style.zIndex = '9999';
          overlay.innerHTML = `
            <div class="flex items-center justify-center w-full h-full">
              <div class="bg-white rounded-xl shadow-xl border border-gray-200 w-full max-w-3xl mx-4">
                <div class="px-5 py-4 border-b"><div class="font-semibold text-gray-900">Queue Item Details</div></div>
                <div class="px-5 py-4 max-h-[70vh] overflow-y-auto">${html}</div>
                <div class="px-5 py-4 flex justify-end">
                  <button id="payloadClose" class="px-4 py-2 rounded-lg text-white" style="background: <?php echo RCN_GRADIENT; ?>;">Close</button>
                </div>
              </div>
            </div>`;
          document.body.appendChild(overlay);
          overlay.querySelector('#payloadClose').addEventListener('click', () => overlay.remove());
        }
      } catch (e) {
        window.notify && window.notify('Network error loading payload', 'error');
      }
    }
  })();
</script>