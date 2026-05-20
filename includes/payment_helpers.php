<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/logger.php';

function payment_json_response(bool $ok, array $data = [], int $statusCode = 200): void {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode(['ok' => $ok, 'data' => $data]);
    exit;
}

function payment_read_raw_body(): string {
    $raw = file_get_contents('php://input');
    return is_string($raw) ? $raw : '';
}

function payment_current_origin(): string {
    if (defined('SITE_URL') && SITE_URL) {
        return rtrim((string) SITE_URL, '/');
    }
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    return $scheme . '://' . $host;
}

function payment_absolute_url(string $path): string {
    $base = payment_current_origin();
    $relative = function_exists('url') ? url($path) : ('/' . ltrim($path, '/'));
    return rtrim($base, '/') . '/' . ltrim($relative, '/');
}

function payment_build_return_url(string $gateway, string $status, string $reference = '', array $extra = []): string {
    $params = array_merge([
        'gateway' => $gateway,
        'status' => $status,
    ], $reference !== '' ? ['reference' => $reference] : [], $extra);
    return payment_absolute_url('thank-you.php?' . http_build_query($params));
}

function payment_build_cancel_url(string $gateway, string $reference = ''): string {
    $params = [
        'cancel' => 1,
        'gateway' => $gateway,
    ];
    if ($reference !== '') {
        $params['reference'] = $reference;
    }
    return payment_absolute_url('thank-you.php?' . http_build_query($params));
}

function payment_generate_reference(string $prefix): string {
    $safePrefix = preg_replace('/[^a-z0-9_]+/i', '_', trim($prefix)) ?: 'pay';
    return strtolower($safePrefix) . '_' . time() . '_' . bin2hex(random_bytes(4));
}

function payment_gateway_matrix(): array {
    return [
        'one_time' => [
            'NGN' => ['paystack', 'flutterwave', 'paypal'],
            'USD' => ['flutterwave', 'paypal', 'paystack'],
            'GBP' => ['flutterwave', 'paypal'],
            'EUR' => ['flutterwave', 'paypal'],
        ],
        'recurring' => [
            'NGN' => ['flutterwave', 'paystack', 'paypal'],
            'USD' => ['flutterwave', 'paypal', 'paystack'],
            'GBP' => ['flutterwave', 'paypal'],
            'EUR' => ['flutterwave', 'paypal'],
        ],
    ];
}

function payment_is_supported(string $gateway, string $type, string $currency): bool {
    $matrix = payment_gateway_matrix();
    $type = strtolower($type);
    $currency = strtoupper($currency);
    return isset($matrix[$type][$currency]) && in_array(strtolower($gateway), $matrix[$type][$currency], true);
}

function payment_http_json(string $method, string $url, array $headers = [], ?array $payload = null): array {
    $ch = curl_init($url);
    $httpHeaders = $headers;
    if ($payload !== null) {
        $httpHeaders[] = 'Content-Type: application/json';
    }
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => strtoupper($method),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $httpHeaders,
        CURLOPT_TIMEOUT => 45,
        CURLOPT_CONNECTTIMEOUT => 20,
    ]);
    if ($payload !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    }
    $raw = curl_exec($ch);
    $error = curl_error($ch);
    $statusCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'ok' => $error === '' && $statusCode >= 200 && $statusCode < 300,
        'status_code' => $statusCode,
        'error' => $error,
        'raw' => $raw === false ? '' : $raw,
        'json' => is_string($raw) ? json_decode($raw, true) : null,
    ];
}

function payment_find_existing_donation(PDO $pdo, string $gateway, ?string $transactionId, ?string $externalId): ?array {
    if ($transactionId) {
        $stmt = $pdo->prepare('SELECT * FROM donations WHERE gateway = ? AND transaction_id = ? ORDER BY id DESC LIMIT 1');
        $stmt->execute([$gateway, $transactionId]);
        $row = $stmt->fetch();
        if ($row) {
            return $row;
        }
    }
    if ($externalId) {
        $stmt = $pdo->prepare('SELECT * FROM donations WHERE gateway = ? AND external_id = ? ORDER BY id DESC LIMIT 1');
        $stmt->execute([$gateway, $externalId]);
        $row = $stmt->fetch();
        if ($row) {
            return $row;
        }
    }
    return null;
}

function payment_record_donation(array $input): void {
    $pdo = db();
    $gateway = strtolower((string) ($input['gateway'] ?? ''));
    $type = ($input['type'] ?? 'one_time') === 'recurring' ? 'recurring' : 'one_time';
    $amount = (float) ($input['amount'] ?? 0);
    $currency = strtoupper((string) ($input['currency'] ?? ''));
    $email = isset($input['email']) ? trim((string) $input['email']) : null;
    $status = trim((string) ($input['status'] ?? 'Pending')) ?: 'Pending';
    $transactionId = isset($input['transaction_id']) && $input['transaction_id'] !== '' ? (string) $input['transaction_id'] : null;
    $externalId = isset($input['external_id']) && $input['external_id'] !== '' ? (string) $input['external_id'] : null;
    $payload = $input['raw_payload'] ?? null;
    if (is_array($payload) || is_object($payload)) {
        $payload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    $payload = is_string($payload) ? $payload : null;

    $existing = payment_find_existing_donation($pdo, $gateway, $transactionId, $externalId);
    if ($existing) {
        $stmt = $pdo->prepare('UPDATE donations SET type = ?, amount = ?, currency = ?, email = ?, status = ?, transaction_id = ?, external_id = ?, raw_payload = ? WHERE id = ?');
        $stmt->execute([$type, $amount, $currency, $email, $status, $transactionId, $externalId, $payload, $existing['id']]);
        return;
    }

    $stmt = $pdo->prepare('INSERT INTO donations (gateway, type, amount, currency, email, status, transaction_id, external_id, raw_payload) VALUES (?,?,?,?,?,?,?,?,?)');
    $stmt->execute([$gateway, $type, $amount, $currency, $email, $status, $transactionId, $externalId, $payload]);
}

function payment_update_donation_status(string $gateway, string $externalId, string $status, $payload = null): void {
    $pdo = db();
    if (is_array($payload) || is_object($payload)) {
        $payload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    $payload = is_string($payload) ? $payload : null;
    $stmt = $pdo->prepare('UPDATE donations SET status = ?, raw_payload = COALESCE(?, raw_payload) WHERE gateway = ? AND external_id = ?');
    $stmt->execute([$status, $payload, strtolower($gateway), $externalId]);
}

function payment_upsert_subscription(array $input): void {
    $pdo = db();
    $gateway = strtolower((string) ($input['gateway'] ?? ''));
    $externalId = trim((string) ($input['external_id'] ?? ''));
    if ($externalId === '') {
        return;
    }
    $planCode = isset($input['plan_code']) ? trim((string) $input['plan_code']) : null;
    $amount = isset($input['amount']) ? (float) $input['amount'] : null;
    $currency = isset($input['currency']) ? strtoupper((string) $input['currency']) : null;
    $email = isset($input['email']) ? trim((string) $input['email']) : null;
    $status = trim((string) ($input['status'] ?? 'active')) ?: 'active';
    $payload = $input['raw_payload'] ?? null;
    if (is_array($payload) || is_object($payload)) {
        $payload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    $payload = is_string($payload) ? $payload : null;

    $stmt = $pdo->prepare('INSERT INTO subscriptions (gateway, external_id, plan_code, amount, currency, email, status, raw_payload) VALUES (?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE gateway = VALUES(gateway), plan_code = VALUES(plan_code), amount = VALUES(amount), currency = VALUES(currency), email = VALUES(email), status = VALUES(status), raw_payload = VALUES(raw_payload)');
    $stmt->execute([$gateway, $externalId, $planCode, $amount, $currency, $email, $status, $payload]);
}

function payment_normalize_status(string $value): string {
    $normalized = strtolower(trim($value));
    if (in_array($normalized, ['success', 'successful', 'completed', 'complete'], true)) {
        return 'Completed';
    }
    if (in_array($normalized, ['active'], true)) {
        return 'active';
    }
    if (in_array($normalized, ['cancelled', 'canceled'], true)) {
        return 'cancelled';
    }
    if (in_array($normalized, ['failed', 'error'], true)) {
        return 'Failed';
    }
    if (in_array($normalized, ['pending'], true)) {
        return 'Pending';
    }
    return $value !== '' ? $value : 'Pending';
}

function payment_paystack_plan_for_currency(string $currency): string {
    $currency = strtoupper($currency);
    if ($currency === 'USD' && defined('PAYSTACK_PLAN_CODE_USD_MONTHLY')) {
        return (string) PAYSTACK_PLAN_CODE_USD_MONTHLY;
    }
    if ($currency === 'NGN' && defined('PAYSTACK_PLAN_CODE_NGN_MONTHLY')) {
        return (string) PAYSTACK_PLAN_CODE_NGN_MONTHLY;
    }
    return '';
}

function payment_flutterwave_plan_for_currency(string $currency): string {
    $currency = strtoupper($currency);
    $map = [
        'NGN' => defined('FLUTTERWAVE_PLAN_ID_NGN_MONTHLY') ? (string) FLUTTERWAVE_PLAN_ID_NGN_MONTHLY : '',
        'USD' => defined('FLUTTERWAVE_PLAN_ID_USD_MONTHLY') ? (string) FLUTTERWAVE_PLAN_ID_USD_MONTHLY : '',
        'GBP' => defined('FLUTTERWAVE_PLAN_ID_GBP_MONTHLY') ? (string) FLUTTERWAVE_PLAN_ID_GBP_MONTHLY : '',
        'EUR' => defined('FLUTTERWAVE_PLAN_ID_EUR_MONTHLY') ? (string) FLUTTERWAVE_PLAN_ID_EUR_MONTHLY : '',
    ];
    return $map[$currency] ?? '';
}

function payment_paystack_subscription_external_id(array $data): string {
    $customerCode = $data['customer']['customer_code'] ?? ($data['customer_code'] ?? '');
    $planCode = $data['plan']['plan_code'] ?? ($data['metadata']['plan_code'] ?? '');
    if ($customerCode && $planCode) {
        return 'paystack:' . $customerCode . ':' . $planCode;
    }
    if (!empty($data['subscription']['subscription_code'])) {
        return 'paystack:' . (string) $data['subscription']['subscription_code'];
    }
    if (!empty($data['subscription_code'])) {
        return 'paystack:' . (string) $data['subscription_code'];
    }
    return (string) ($data['reference'] ?? '');
}

function payment_flutterwave_subscription_external_id(array $data): string {
    $email = $data['customer']['email'] ?? '';
    $planCode = $data['payment_plan'] ?? ($data['meta']['plan_code'] ?? '');
    if ($email && $planCode) {
        return 'flutterwave:' . $email . ':' . $planCode;
    }
    return (string) ($data['tx_ref'] ?? '');
}

function payment_paystack_verify_transaction(string $reference): array {
    return payment_http_json(
        'GET',
        'https://api.paystack.co/transaction/verify/' . rawurlencode($reference),
        ['Authorization: Bearer ' . PAYSTACK_SECRET_KEY]
    );
}

function payment_flutterwave_verify_transaction(?string $transactionId = null, ?string $txRef = null): array {
    if ($transactionId) {
        return payment_http_json(
            'GET',
            'https://api.flutterwave.com/v3/transactions/' . rawurlencode($transactionId) . '/verify',
            ['Authorization: Bearer ' . FLUTTERWAVE_SECRET_KEY]
        );
    }
    if ($txRef) {
        return payment_http_json(
            'GET',
            'https://api.flutterwave.com/v3/transactions/verify_by_reference?tx_ref=' . rawurlencode($txRef),
            ['Authorization: Bearer ' . FLUTTERWAVE_SECRET_KEY]
        );
    }
    return ['ok' => false, 'status_code' => 400, 'error' => 'Missing transaction identifier', 'raw' => '', 'json' => null];
}
