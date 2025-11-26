<?php require_once __DIR__ . '/../../config/security.php'; ?>
<?php
$target = url('trips.php') . '?view=upcoming';
header('Location: ' . $target, true, 302);
exit;
?>
