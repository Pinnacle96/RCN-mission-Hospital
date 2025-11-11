<?php
require_once __DIR__ . '/../includes/constants.php';

// Production error suppression
ini_set('display_errors', '0');
error_reporting(0);

// Start secure session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'cookie_samesite' => 'Lax',
    ]);
}

// Security headers
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdn.tiny.cloud https://cdn.jsdelivr.net https://www.google.com https://www.gstatic.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.tiny.cloud; img-src 'self' data: https://cdn.tiny.cloud; font-src 'self' https://fonts.gstatic.com data:; connect-src 'self' https://cdn.tiny.cloud https://api.tiny.cloud https://sp.tinymce.com https://www.google.com https://www.gstatic.com; frame-src 'self' blob:;");

// Session timeout
if (!empty($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['last_activity'] = time();

// Helpers
function esc_html(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function esc_attr(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function url(string $path): string {
    $base = defined('BASE_PATH') ? BASE_PATH : '/';
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function require_login(array $roles = []): void {
    $user = current_user();
    if (!$user) {
        header('Location: ' . url('admin/login.php'));
        exit;
    }
    if ($roles && !in_array($user['role'], $roles, true)) {
        http_response_code(403);
        echo 'Forbidden';
        exit;
    }
}

function verify_recaptcha(?string $token): bool {
    if (empty(RECAPTCHA_SECRET_KEY) || empty($token)) {
        return true; // Treat as pass if not configured
    }
    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode(RECAPTCHA_SECRET_KEY) . '&response=' . urlencode($token));
    if (!$response) return false;
    $data = json_decode($response, true);
    return is_array($data) && !empty($data['success']) && ($data['score'] ?? 0) >= 0.5;
}

function password_hash_secure(string $password): string {
    return password_hash($password, PASSWORD_BCRYPT);
}

function password_verify_secure(string $password, string $hash): bool {
    return password_verify($password, $hash);
}