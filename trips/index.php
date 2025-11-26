<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php
// Redirect directory access to the public trips listing; preserve view if provided
$view = strtolower(trim($_GET['view'] ?? 'upcoming'));
if (!in_array($view, ['upcoming','past'], true)) { $view = 'upcoming'; }
header('Location: ' . (url('trips.php') . '?view=' . $view), true, 302);
exit;
?>
