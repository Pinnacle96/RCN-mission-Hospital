<?php
require_once __DIR__ . '/../config/security.php';
require_once __DIR__ . '/../config/db.php';

// Log logout action if a user is currently logged in
$user = $_SESSION['user'] ?? null;
if ($user && isset($user['id'])) {
    audit_log((int)$user['id'], 'logout');
}

// Clear all session data
$_SESSION = [];

// Delete session cookie if set
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'] ?? '/',
        $params['domain'] ?? '',
        !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        true
    );
}

// Destroy the session
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Prevent caching of authenticated pages after logout
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

// Redirect to admin login
header('Location: ' . url('admin/login.php'));
exit;