<?php
require_once __DIR__ . '/../../config/security.php';
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../../includes/logger.php';
require_once __DIR__ . '/../../includes/payment_helpers.php';

function payment_redirect_with_result(string $gateway, string $status, string $reference = '', array $extra = []): void {
    header('Location: ' . payment_build_return_url($gateway, $status, $reference, $extra));
    exit;
}

$gateway = strtolower(trim((string) ($_GET['gateway'] ?? '')));
if (!in_array($gateway, ['paystack', 'flutterwave'], true)) {
    header('Location: ' . payment_build_return_url('unknown', 'failed'));
    exit;
}

if ($gateway === 'paystack') {
    $reference = trim((string) ($_GET['reference'] ?? ''));
    if ($reference === '') {
        payment_redirect_with_result('paystack', 'failed');
    }

    $verified = payment_paystack_verify_transaction($reference);
    $json = is_array($verified['json']) ? $verified['json'] : [];
    $data = is_array($json['data'] ?? null) ? $json['data'] : [];
    if (!$verified['ok'] || empty($json['status']) || empty($data)) {
        log_error('paystack_payment', 'Callback verification failed', ['reference' => $reference, 'response' => $verified]);
        payment_redirect_with_result('paystack', 'failed', $reference);
    }

    $resultStatus = strtolower((string) ($data['status'] ?? 'failed'));
    $type = (($data['metadata']['type'] ?? 'one_time') === 'recurring') ? 'recurring' : 'one_time';
    $amount = ((float) ($data['amount'] ?? 0)) / 100;
    $currency = strtoupper((string) ($data['currency'] ?? 'NGN'));
    $email = trim((string) ($data['customer']['email'] ?? ''));
    $transactionId = isset($data['id']) ? (string) $data['id'] : null;

    payment_record_donation([
        'gateway' => 'paystack',
        'type' => $type,
        'amount' => $amount,
        'currency' => $currency,
        'email' => $email,
        'status' => payment_normalize_status($resultStatus),
        'transaction_id' => $transactionId,
        'external_id' => $reference,
        'raw_payload' => $json,
    ]);

    if ($type === 'recurring' && $resultStatus === 'success') {
        payment_upsert_subscription([
            'gateway' => 'paystack',
            'external_id' => payment_paystack_subscription_external_id($data),
            'plan_code' => $data['plan']['plan_code'] ?? ($data['metadata']['plan_code'] ?? ''),
            'amount' => $amount,
            'currency' => $currency,
            'email' => $email,
            'status' => 'active',
            'raw_payload' => $json,
        ]);
    }

    payment_redirect_with_result('paystack', $resultStatus === 'success' ? 'success' : $resultStatus, $reference);
}

$transactionId = trim((string) ($_GET['transaction_id'] ?? ''));
$txRef = trim((string) ($_GET['tx_ref'] ?? ''));
if ($transactionId === '' && $txRef === '') {
    payment_redirect_with_result('flutterwave', 'failed');
}

$verified = payment_flutterwave_verify_transaction($transactionId !== '' ? $transactionId : null, $txRef !== '' ? $txRef : null);
$json = is_array($verified['json']) ? $verified['json'] : [];
$data = is_array($json['data'] ?? null) ? $json['data'] : [];
if (!$verified['ok'] || (($json['status'] ?? '') !== 'success') || empty($data)) {
    log_error('flutterwave_payment', 'Callback verification failed', ['transaction_id' => $transactionId, 'tx_ref' => $txRef, 'response' => $verified]);
    payment_redirect_with_result('flutterwave', 'failed', $txRef);
}

$resultStatus = strtolower((string) ($data['status'] ?? 'failed'));
$reference = trim((string) ($data['tx_ref'] ?? $txRef));
$type = (($data['meta']['type'] ?? 'one_time') === 'recurring') ? 'recurring' : 'one_time';
$amount = (float) ($data['amount'] ?? 0);
$currency = strtoupper((string) ($data['currency'] ?? 'USD'));
$email = trim((string) ($data['customer']['email'] ?? ''));
$storedTransactionId = isset($data['id']) ? (string) $data['id'] : ($transactionId !== '' ? $transactionId : null);

payment_record_donation([
    'gateway' => 'flutterwave',
    'type' => $type,
    'amount' => $amount,
    'currency' => $currency,
    'email' => $email,
    'status' => payment_normalize_status($resultStatus),
    'transaction_id' => $storedTransactionId,
    'external_id' => $reference,
    'raw_payload' => $json,
]);

if ($type === 'recurring' && $resultStatus === 'successful') {
    payment_upsert_subscription([
        'gateway' => 'flutterwave',
        'external_id' => payment_flutterwave_subscription_external_id($data),
        'plan_code' => $data['payment_plan'] ?? ($data['meta']['plan_code'] ?? ''),
        'amount' => $amount,
        'currency' => $currency,
        'email' => $email,
        'status' => 'active',
        'raw_payload' => $json,
    ]);
}

payment_redirect_with_result('flutterwave', $resultStatus === 'successful' ? 'success' : $resultStatus, $reference);
