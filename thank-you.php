<?php
$page_title = 'Thank You - RCN Mission Hospital';
$page_description = 'Your generosity helps us bring healing and hope. Thank you for partnering with our mission.';
require_once __DIR__ . '/config/db.php';
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/includes/header.php'; ?>

<?php
$status = strtolower(trim((string) ($_GET['status'] ?? ($_GET['st'] ?? ''))));
$gateway = strtolower(trim((string) ($_GET['gateway'] ?? ($_GET['g'] ?? ''))));
$reference = trim((string) ($_GET['reference'] ?? ($_GET['tx'] ?? '')));
$isCancel = isset($_GET['cancel']);
$isSuccess = in_array($status, ['success', 'completed'], true);
$isFailed = in_array($status, ['failed', 'error'], true);

$record = null;
if ($gateway !== '' && $reference !== '') {
  try {
    $pdo = db();
    $stmt = $pdo->prepare('SELECT gateway, type, amount, currency, email, status, transaction_id, external_id, created_at FROM donations WHERE gateway = ? AND (external_id = ? OR transaction_id = ?) ORDER BY id DESC LIMIT 1');
    $stmt->execute([$gateway, $reference, $reference]);
    $record = $stmt->fetch() ?: null;
  } catch (Throwable $e) {
    $record = null;
  }
}

$displayGateway = $gateway !== '' ? ucfirst($gateway) : 'Payment Gateway';
$displayStatus = $isCancel ? 'Cancelled' : ($record['status'] ?? ($status !== '' ? ucfirst($status) : 'Processing'));

$title = 'Payment Status';
$subtitle = 'If you completed a payment, we are verifying and recording it securely.';
$tips = [
  'You can return to the partner page at any time to start a new donation.',
  'If you have any concern, please contact the team and share your payment reference.',
];

if ($isCancel) {
  $title = 'Payment Cancelled';
  $subtitle = 'No worries. You can try again now or choose a different gateway or currency.';
  $tips = [
    'Your payment was cancelled before final confirmation.',
    'Try a different gateway if the previous one did not suit your card or currency.',
  ];
} elseif ($isSuccess) {
  $title = 'Thank You For Giving';
  $subtitle = 'Your support helps fund medical outreach, compassionate care, and mission work in communities that need it most.';
  $tips = [
    'A successful redirect means the payment has been confirmed or is already recorded for follow-up.',
    'Please keep your reference until you see your card or wallet statement update.',
  ];
} elseif ($isFailed) {
  $title = 'Payment Was Not Completed';
  $subtitle = 'The gateway did not return a successful confirmation for this attempt.';
  $tips = [
    'You can retry with the same currency using another gateway.',
    'If your bank shows a debit but this page still shows failure, contact support with the reference below.',
  ];
}

$gatewayNoteMap = [
  'paypal' => 'PayPal donations are tracked through IPN. For recurring gifts, later charges may confirm after this page.',
  'paystack' => 'Paystack payments are verified again on the server before final recording.',
  'flutterwave' => 'Flutterwave payments may complete asynchronously for some methods, so webhook confirmation remains active in the background.',
];
$gatewayNote = $gatewayNoteMap[$gateway] ?? 'Your donation status is being handled through our secure payment workflow.';
?>

<section class="bg-gradient-to-br from-slate-50 via-white to-blue-50 py-16">
  <div class="max-w-5xl mx-auto px-4">
    <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-8">
      <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">
        <div class="flex items-center gap-3 mb-4">
          <?php if ($isCancel): ?>
            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-100 text-red-600">&#10007;</span>
          <?php elseif ($isSuccess): ?>
            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 text-green-600">&#10003;</span>
          <?php elseif ($isFailed): ?>
            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 text-amber-700">!</span>
          <?php else: ?>
            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 text-blue-600">i</span>
          <?php endif; ?>
          <div>
            <h1 class="text-3xl font-bold text-slate-900"><?php echo esc_html($title); ?></h1>
            <p class="text-slate-600 mt-1"><?php echo esc_html($subtitle); ?></p>
          </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-5 mt-8">
          <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-sm text-slate-500 mb-1">Gateway</div>
            <div class="font-semibold text-slate-900"><?php echo esc_html($displayGateway); ?></div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-sm text-slate-500 mb-1">Reference</div>
            <div class="font-mono text-sm text-slate-900 break-all"><?php echo $reference !== '' ? esc_html($reference) : '—'; ?></div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-sm text-slate-500 mb-1">Status</div>
            <div class="font-semibold text-slate-900"><?php echo esc_html($displayStatus); ?></div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-sm text-slate-500 mb-1">Email</div>
            <div class="text-slate-900"><?php echo esc_html($record['email'] ?? '—'); ?></div>
          </div>
          <?php if ($record): ?>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
              <div class="text-sm text-slate-500 mb-1">Amount</div>
              <div class="font-semibold text-slate-900"><?php echo esc_html(($record['currency'] ?? '') . ' ' . number_format((float) ($record['amount'] ?? 0), 2)); ?></div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
              <div class="text-sm text-slate-500 mb-1">Donation Type</div>
              <div class="text-slate-900"><?php echo esc_html($record['type'] ?? '—'); ?></div>
            </div>
          <?php endif; ?>
        </div>

        <div class="mt-8 rounded-2xl border border-blue-200 bg-blue-50 px-5 py-4 text-sm text-blue-900">
          <?php echo esc_html($gatewayNote); ?>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
          <a href="<?php echo url('partners'); ?>" class="inline-flex items-center px-5 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700">Return To Donate</a>
          <a href="<?php echo url('contact'); ?>" class="inline-flex items-center px-5 py-3 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50">Contact Support</a>
        </div>
      </div>

      <div class="space-y-6">
        <div class="bg-slate-950 text-white rounded-3xl p-7 shadow-xl">
          <div class="text-sm uppercase tracking-[0.2em] text-blue-200 mb-3">Next Steps</div>
          <div class="space-y-3 text-slate-200">
            <?php foreach ($tips as $tip): ?>
              <div class="rounded-2xl bg-white/10 px-4 py-3"><?php echo esc_html($tip); ?></div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-7 shadow-lg">
          <h2 class="text-xl font-bold text-slate-900 mb-4">Need Help Reconciling A Payment?</h2>
          <div class="space-y-3 text-sm text-slate-600">
            <p>When you contact the team, include the payment reference shown on this page.</p>
            <p>If you used a card or wallet, your bank statement may show a slightly different gateway transaction label.</p>
            <p>If you donated by recurring method, future charges may be recorded after this initial confirmation page.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var status = '<?php echo $isCancel ? 'cancelled' : ($isSuccess ? 'success' : ($isFailed ? 'failed' : ($status ?: 'processing'))); ?>';
    function showToast() {
      if (!window.Swal) return;
      var Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2600, timerProgressBar: true });
      if (status === 'cancelled') {
        Toast.fire({ icon: 'error', title: 'Payment cancelled' });
      } else if (status === 'success') {
        Toast.fire({ icon: 'success', title: 'Thank you for your support' });
      } else if (status === 'failed') {
        Toast.fire({ icon: 'warning', title: 'Payment not completed' });
      }
    }

    if (!window.Swal) {
      var s = document.createElement('script');
      s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
      s.onload = showToast;
      document.head.appendChild(s);
    } else {
      showToast();
    }
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
