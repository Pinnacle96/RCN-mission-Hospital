<?php
$page_title = 'Thank You - RCN Mission Hospital';
$page_description = 'Your generosity helps us bring healing and hope. Thank you for partnering with our mission.';
?>
<?php $hero_enable = false; ?>
<?php include __DIR__ . '/includes/header.php'; ?>

<?php
$status = strtolower($_GET['status'] ?? ($_GET['st'] ?? ''));
$gateway = strtolower($_GET['gateway'] ?? ($_GET['g'] ?? ''));
$reference = $_GET['reference'] ?? ($_GET['tx'] ?? '');
$is_cancel = isset($_GET['cancel']);

$title = $is_cancel ? 'Payment Cancelled' : ($status === 'success' || $status === 'completed' ? 'Thank You!' : 'Payment Status');
$subtitle = $is_cancel
  ? 'You can try again anytime, or contact us for assistance.'
  : (($status === 'success' || $status === 'completed')
    ? 'Your support enables medical missions and community transformation.'
    : 'If you completed a payment, you should receive a confirmation shortly.');
?>

<section class="bg-gradient-to-br from-green-50 to-white py-16">
  <div class="max-w-4xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
      <div class="flex items-center gap-3 mb-4">
        <?php if ($is_cancel): ?>
          <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-100 text-red-600">
            &#10007;
          </span>
        <?php elseif ($status === 'success' || $status === 'completed'): ?>
          <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-100 text-green-600">
            &#10003;
          </span>
        <?php else: ?>
          <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-600">i</span>
        <?php endif; ?>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900"><?php echo esc_html($title); ?></h1>
      </div>
      <p class="text-gray-600 mb-6"><?php echo esc_html($subtitle); ?></p>

      <div class="grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
          <div class="text-sm text-gray-500">Gateway</div>
          <div class="font-medium text-gray-900"><?php echo $gateway ? esc_html(strtoupper($gateway)) : '—'; ?></div>
        </div>
        <div class="space-y-2">
          <div class="text-sm text-gray-500">Reference</div>
          <div class="font-mono text-gray-900"><?php echo $reference ? esc_html($reference) : '—'; ?></div>
        </div>
        <div class="space-y-2">
          <div class="text-sm text-gray-500">Status</div>
          <div class="font-medium text-gray-900"><?php echo $is_cancel ? 'Cancelled' : ($status ? esc_html(ucfirst($status)) : '—'); ?></div>
        </div>
      </div>

      <div class="mt-8 flex flex-wrap gap-3">
        <a href="<?php echo url('partners'); ?>" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Return to Donate</a>
        <a href="<?php echo url('contact'); ?>" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Contact Support</a>
      </div>
    </div>
  </div>
</section>

<script>
  // Show a toast on load for quick feedback
  document.addEventListener('DOMContentLoaded', function() {
    var status = '<?php echo $is_cancel ? 'cancelled' : ($status || ''); ?>';
    var Toast;
    function initToast(){
      if (!window.Swal) {
        var s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
        s.onload = show;
        document.head.appendChild(s);
      } else {
        show();
      }
    }
    function show(){
      Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2500, timerProgressBar: true });
      if (status === 'cancelled') {
        Toast.fire({ icon: 'error', title: 'Payment cancelled' });
      } else if (status.toLowerCase() === 'success' || status.toLowerCase() === 'completed') {
        Toast.fire({ icon: 'success', title: 'Thank you! Payment completed' });
      }
    }
    initToast();
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>