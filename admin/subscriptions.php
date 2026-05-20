<?php
require_once __DIR__ . '/includes/admin-header.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/payment_helpers.php';

payment_ensure_subscription_schema();
$pdo = db();
$gatewayFilter = trim((string) ($_GET['gateway'] ?? ''));
$currencyFilter = trim((string) ($_GET['currency'] ?? ''));
$statusFilter = trim((string) ($_GET['status'] ?? ''));

$where = [];
$params = [];
if ($gatewayFilter !== '') {
  $where[] = 'gateway = ?';
  $params[] = $gatewayFilter;
}
if ($currencyFilter !== '') {
  $where[] = 'currency = ?';
  $params[] = strtoupper($currencyFilter);
}
if ($statusFilter !== '') {
  $where[] = 'status = ?';
  $params[] = $statusFilter;
}

$sql = 'SELECT id, gateway, external_id, plan_code, amount, currency, email, status, next_charge_at, last_charge_at, created_at, updated_at FROM subscriptions';
if ($where) {
  $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY created_at DESC LIMIT 200';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

$summarySql = 'SELECT COUNT(*) AS total_rows, SUM(CASE WHEN status = \'active\' THEN 1 ELSE 0 END) AS active_rows FROM subscriptions';
if ($where) {
  $summarySql .= ' WHERE ' . implode(' AND ', $where);
}
$summaryStmt = $pdo->prepare($summarySql);
$summaryStmt->execute($params);
$summary = $summaryStmt->fetch() ?: ['total_rows' => 0, 'active_rows' => 0];

$gatewayStatsSql = 'SELECT gateway, COUNT(*) AS total_rows FROM subscriptions';
if ($where) {
  $gatewayStatsSql .= ' WHERE ' . implode(' AND ', $where);
}
$gatewayStatsSql .= ' GROUP BY gateway ORDER BY total_rows DESC';
$gatewayStatsStmt = $pdo->prepare($gatewayStatsSql);
$gatewayStatsStmt->execute($params);
$gatewayStats = $gatewayStatsStmt->fetchAll();

$currencyStatsSql = 'SELECT currency, COUNT(*) AS total_rows FROM subscriptions';
if ($where) {
  $currencyStatsSql .= ' WHERE ' . implode(' AND ', $where);
}
$currencyStatsSql .= ' GROUP BY currency ORDER BY total_rows DESC';
$currencyStatsStmt = $pdo->prepare($currencyStatsSql);
$currencyStatsStmt->execute($params);
$currencyStats = $currencyStatsStmt->fetchAll();
?>

<main class="flex-1">
  <div class="px-6 py-6">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Subscriptions</h1>
        <p class="text-gray-600">Recurring giving records across all configured gateways</p>
      </div>
    </div>

    <form method="get" class="mb-6 grid md:grid-cols-4 gap-4 bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Gateway</label>
        <select name="gateway" class="w-full rounded-xl border border-gray-300 px-4 py-3">
          <option value="">All gateways</option>
          <option value="paypal" <?php echo $gatewayFilter === 'paypal' ? 'selected' : ''; ?>>PayPal</option>
          <option value="paystack" <?php echo $gatewayFilter === 'paystack' ? 'selected' : ''; ?>>Paystack</option>
          <option value="flutterwave" <?php echo $gatewayFilter === 'flutterwave' ? 'selected' : ''; ?>>Flutterwave</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
        <select name="currency" class="w-full rounded-xl border border-gray-300 px-4 py-3">
          <option value="">All currencies</option>
          <?php foreach (['NGN', 'USD', 'GBP', 'EUR'] as $code): ?>
            <option value="<?php echo esc_attr($code); ?>" <?php echo strtoupper($currencyFilter) === $code ? 'selected' : ''; ?>><?php echo esc_html($code); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
        <select name="status" class="w-full rounded-xl border border-gray-300 px-4 py-3">
          <option value="">All statuses</option>
          <?php foreach (['active', 'pending', 'pending_authorization', 'past_due', 'cancelled'] as $state): ?>
            <option value="<?php echo esc_attr($state); ?>" <?php echo $statusFilter === $state ? 'selected' : ''; ?>><?php echo esc_html($state); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="flex items-end gap-3">
        <button type="submit" class="px-5 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700">Filter</button>
        <a href="<?php echo url('admin/subscriptions.php'); ?>" class="px-5 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">Reset</a>
      </div>
    </form>

    <div class="grid lg:grid-cols-3 gap-4 mb-6">
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="text-sm text-gray-500 mb-1">Visible Subscription Rows</div>
        <div class="text-3xl font-bold text-gray-900"><?php echo number_format((int) ($summary['total_rows'] ?? 0)); ?></div>
        <p class="text-sm text-gray-500 mt-2">Based on the current filter selection.</p>
      </div>
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="text-sm text-gray-500 mb-1">Active Rows</div>
        <div class="text-3xl font-bold text-gray-900"><?php echo number_format((int) ($summary['active_rows'] ?? 0)); ?></div>
        <p class="text-sm text-gray-500 mt-2">Useful for checking how many recurring profiles remain live.</p>
      </div>
      <div class="rounded-2xl border border-purple-200 bg-purple-50 p-5 shadow-sm">
        <div class="text-sm font-medium text-purple-900 mb-2">Reconciliation Note</div>
        <p class="text-sm text-purple-800">Recurring billing may update after the donor leaves checkout. Use the latest `Updated` timestamp and gateway webhooks when validating subscription state.</p>
      </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-4 mb-6">
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="text-sm font-medium text-gray-700 mb-3">Rows By Gateway</div>
        <div class="flex flex-wrap gap-2">
          <?php if ($gatewayStats): foreach ($gatewayStats as $item): ?>
            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-2 text-sm text-gray-700">
              <?php echo esc_html(ucfirst((string) $item['gateway'])); ?>: <?php echo number_format((int) $item['total_rows']); ?>
            </span>
          <?php endforeach; else: ?>
            <span class="text-sm text-gray-500">No gateway data for this filter.</span>
          <?php endif; ?>
        </div>
      </div>
      <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="text-sm font-medium text-gray-700 mb-3">Rows By Currency</div>
        <div class="flex flex-wrap gap-2">
          <?php if ($currencyStats): foreach ($currencyStats as $item): ?>
            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-2 text-sm text-gray-700">
              <?php echo esc_html((string) ($item['currency'] ?: '—')); ?>: <?php echo number_format((int) $item['total_rows']); ?>
            </span>
          <?php endforeach; else: ?>
            <span class="text-sm text-gray-500">No currency data for this filter.</span>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gateway</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">External ID</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Currency</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Charge</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Charge</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            <?php if ($rows): foreach ($rows as $r): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo (int)$r['id']; ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['gateway']); ?></td>
                <td class="px-4 py-3 text-xs font-mono text-gray-600"><?php echo esc_html($r['external_id']); ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['plan_code'] ?? ''); ?></td>
                <td class="px-4 py-3 text-sm text-gray-900 font-semibold"><?php echo $r['amount'] !== null ? number_format((float)$r['amount'], 2) : '-'; ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['currency'] ?? ''); ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['email'] ?? ''); ?></td>
                <td class="px-4 py-3 text-sm">
                  <span class="inline-flex items-center px-2 py-1 rounded text-xs <?php echo ($r['status'] === 'active') ? 'bg-green-100 text-green-700' : (($r['status'] === 'cancelled') ? 'bg-red-100 text-red-700' : (($r['status'] === 'past_due') ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-700')); ?>">
                    <?php echo esc_html($r['status']); ?>
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['next_charge_at'] ?? ''); ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['last_charge_at'] ?? ''); ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['created_at']); ?></td>
                <td class="px-4 py-3 text-sm text-gray-700"><?php echo esc_html($r['updated_at']); ?></td>
              </tr>
            <?php endforeach; else: ?>
              <tr>
                <td colspan="12" class="px-4 py-6 text-center text-gray-500">No subscriptions recorded yet.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
