<?php
require_once __DIR__ . '/includes/admin-header.php';
require_once __DIR__ . '/../config/db.php';

$pdo = db();
$stmt = $pdo->query('SELECT id, gateway, type, amount, currency, email, status, transaction_id, external_id, created_at FROM donations ORDER BY created_at DESC LIMIT 200');
$rows = $stmt->fetchAll();
?>

<main class="flex-1">
  <div class="px-6 py-6">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Donations</h1>
        <p class="text-gray-600">Tracked PayPal and other gateway donations</p>
      </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gateway</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Currency</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Txn ID</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscr Ref</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            <?php if ($rows): foreach ($rows as $r): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo (int)$r['id']; ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['gateway']); ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['type']); ?></td>
                <td class="px-4 py-3 text-sm text-gray-900 font-semibold"><?php echo number_format((float)$r['amount'], 2); ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['currency']); ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['email'] ?? ''); ?></td>
                <td class="px-4 py-3 text-sm">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs <?php echo ($r['status'] === 'Completed' || $r['status'] === 'active') ? 'bg-green-100 text-green-700' : (($r['status'] === 'Pending') ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700'); ?>">
                    <?php echo esc_html($r['status']); ?>
                  </span>
                </td>
                <td class="px-4 py-3 text-xs font-mono text-gray-600"><?php echo esc_html($r['transaction_id'] ?? ''); ?></td>
                <td class="px-4 py-3 text-xs font-mono text-gray-600"><?php echo esc_html($r['external_id'] ?? ''); ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['created_at']); ?></td>
              </tr>
            <?php endforeach; else: ?>
              <tr>
                <td colspan="10" class="px-4 py-6 text-center text-gray-500">No donations recorded yet.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>