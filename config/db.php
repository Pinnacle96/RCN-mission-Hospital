<?php
require_once __DIR__ . '/../includes/constants.php';

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }
    return $pdo;
}

function audit_log(?int $userId, string $action): void {
    try {
        $pdo = db();
        $stmt = $pdo->prepare('INSERT INTO audit_logs (user_id, action, timestamp) VALUES (?, ?, NOW())');
        $stmt->execute([$userId, $action]);
    } catch (Throwable $e) {
        // Suppress audit log failures to avoid user-facing errors
    }
}