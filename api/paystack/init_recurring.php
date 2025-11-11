<?php
// Initialize a Paystack transaction for recurring plan payments
// Expects POST: email, amount(optional, in NGN), plan(optional)

header('Content-Type: application/json');

require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../../includes/logger.php';

function respond($ok, $data = []) {
    http_response_code($ok ? 200 : 400);
    echo json_encode(['ok' => $ok, 'data' => $data]);
    exit;
}

if (!defined('PAYSTACK_SECRET_KEY') || !PAYSTACK_SECRET_KEY) {
    log_error('paystack_payment', 'Secret key not configured');
    respond(false, ['error' => 'PAYSTACK_SECRET_KEY not configured']);
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$amountNgn = isset($_POST['amount']) ? (int)$_POST['amount'] : 0; // amount in NGN
$plan = isset($_POST['plan']) ? trim($_POST['plan']) : '';

if (!$email || !preg_match('/.+@.+\..+/', $email)) {
    log_error('paystack_payment', 'Invalid email', ['email' => $email]);
    respond(false, ['error' => 'Valid email is required']);
}

// Build payload for Paystack initialize
$reference = 'rcn_' . time() . '_' . bin2hex(random_bytes(4));
$payload = [
    'email' => $email,
    'reference' => $reference,
];
log_info('paystack_payment', 'Init recurring request', ['email' => $email, 'amount_ngn' => $amountNgn, 'plan' => $plan, 'reference' => $reference]);

// If a plan is provided, let Paystack handle recurring billing
if ($plan) {
    $payload['plan'] = $plan;
}

// First payment amount (optional). Paystack expects kobo.
if ($amountNgn > 0) {
    $payload['amount'] = $amountNgn * 100;
}

// Callback URL if configured
if (defined('PAYSTACK_CALLBACK_URL') && PAYSTACK_CALLBACK_URL) {
    $payload['callback_url'] = PAYSTACK_CALLBACK_URL;
}

$ch = curl_init('https://api.paystack.co/transaction/initialize');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . PAYSTACK_SECRET_KEY,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
$resp = curl_exec($ch);
if ($resp === false) {
    log_error('paystack_payment', 'cURL error on init_recurring', ['error' => curl_error($ch)]);
    respond(false, ['error' => 'cURL error: ' . curl_error($ch)]);
}
curl_close($ch);

$json = json_decode($resp, true);
if (!$json || empty($json['status'])) {
    log_error('paystack_payment', 'Invalid response from Paystack', ['raw' => $resp]);
    respond(false, ['error' => 'Invalid response from Paystack', 'raw' => $resp]);
}

if ($json['status'] === true && isset($json['data']['authorization_url'])) {
    log_info('paystack_payment', 'Init recurring success', ['authorization_url' => $json['data']['authorization_url'], 'reference' => $reference]);
    respond(true, [
        'authorization_url' => $json['data']['authorization_url'],
        'reference' => $reference
    ]);
}

log_error('paystack_payment', 'Init recurring failed', ['message' => $json['message'] ?? 'Unable to initialize transaction', 'reference' => $reference]);
respond(false, ['error' => $json['message'] ?? 'Unable to initialize transaction']);