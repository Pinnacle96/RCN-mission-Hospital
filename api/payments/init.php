<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/security.php';
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../../includes/logger.php';
require_once __DIR__ . '/../../includes/payment_helpers.php';

function payment_init_input(): array {
    $json = json_decode(payment_read_raw_body(), true);
    if (is_array($json)) {
        return $json;
    }
    return $_POST;
}

function payment_init_fail(string $message, array $context = []): void {
    log_error('payment_init', $message, $context);
    payment_json_response(false, ['error' => $message], 400);
}

$input = payment_init_input();
$gateway = strtolower(trim((string) ($input['gateway'] ?? '')));
$type = strtolower(trim((string) ($input['type'] ?? 'one_time')));
$type = $type === 'recurring' ? 'recurring' : 'one_time';
$currency = strtoupper(trim((string) ($input['currency'] ?? '')));
$amount = isset($input['amount']) ? (float) $input['amount'] : 0;
$email = trim((string) ($input['email'] ?? ''));
$fullName = trim((string) ($input['name'] ?? 'Donor'));

if (!in_array($gateway, ['paystack', 'flutterwave'], true)) {
    payment_init_fail('Unsupported gateway selected.', ['gateway' => $gateway]);
}
if (!in_array($currency, ['NGN', 'USD', 'GBP', 'EUR'], true)) {
    payment_init_fail('Unsupported currency selected.', ['currency' => $currency]);
}
if (!payment_is_supported($gateway, $type, $currency)) {
    payment_init_fail('This gateway does not support the selected donation type and currency.', ['gateway' => $gateway, 'type' => $type, 'currency' => $currency]);
}
if (!preg_match('/.+@.+\..+/', $email)) {
    payment_init_fail('A valid email address is required.');
}
if ($amount <= 0) {
    payment_init_fail('A valid donation amount is required.', ['amount' => $amount]);
}

$reference = payment_generate_reference($gateway . '_' . $type);
$metadata = [
    'gateway' => $gateway,
    'type' => $type,
    'currency' => $currency,
    'full_name' => $fullName,
    'reference' => $reference,
];

if ($gateway === 'paystack') {
    if (!defined('PAYSTACK_SECRET_KEY') || !PAYSTACK_SECRET_KEY) {
        payment_init_fail('Paystack is not configured yet.');
    }

    $payload = [
        'email' => $email,
        'amount' => (int) round($amount * 100),
        'currency' => $currency,
        'reference' => $reference,
        'callback_url' => payment_absolute_url('api/payments/verify.php?gateway=paystack'),
        'metadata' => $metadata,
    ];

    if ($type === 'recurring') {
        $planCode = payment_paystack_plan_for_currency($currency);
        if ($planCode === '') {
            payment_init_fail('Paystack recurring is not configured for the selected currency.', ['currency' => $currency]);
        }
        $metadata['plan_code'] = $planCode;
        $payload['plan'] = $planCode;
        $payload['metadata'] = $metadata;
    }

    payment_record_donation([
        'gateway' => $gateway,
        'type' => $type,
        'amount' => $amount,
        'currency' => $currency,
        'email' => $email,
        'status' => 'Pending',
        'transaction_id' => null,
        'external_id' => $reference,
        'raw_payload' => ['stage' => 'initialized', 'metadata' => $metadata],
    ]);

    $response = payment_http_json(
        'POST',
        'https://api.paystack.co/transaction/initialize',
        ['Authorization: Bearer ' . PAYSTACK_SECRET_KEY],
        $payload
    );

    if (!$response['ok'] || !is_array($response['json']) || empty($response['json']['status']) || empty($response['json']['data']['authorization_url'])) {
        payment_update_donation_status('paystack', $reference, 'Failed', ['stage' => 'initialize_failed', 'response' => $response]);
        payment_init_fail('Unable to initialize Paystack payment.', ['response' => $response]);
    }

    log_info('payment_init', 'Paystack checkout initialized', ['reference' => $reference, 'currency' => $currency, 'type' => $type]);
    payment_json_response(true, [
        'redirect_url' => $response['json']['data']['authorization_url'],
        'reference' => $reference,
        'gateway' => 'paystack',
    ]);
}

if (!defined('FLUTTERWAVE_SECRET_KEY') || !FLUTTERWAVE_SECRET_KEY) {
    payment_init_fail('Flutterwave is not configured yet.');
}

$payload = [
    'tx_ref' => $reference,
    'amount' => number_format($amount, 2, '.', ''),
    'currency' => $currency,
    'redirect_url' => payment_absolute_url('api/payments/verify.php?gateway=flutterwave'),
    'customer' => [
        'email' => $email,
        'name' => $fullName,
    ],
    'customizations' => [
        'title' => APP_NAME . ' Donation',
        'description' => $type === 'recurring' ? 'Monthly partnership donation' : 'One-time partnership donation',
        'logo' => payment_absolute_url('assets/images/logo.png'),
    ],
    'meta' => $metadata,
];

if ($type === 'recurring') {
    $planId = payment_flutterwave_plan_for_currency($currency);
    if ($planId === '') {
        payment_init_fail('Flutterwave recurring is not configured for the selected currency.', ['currency' => $currency]);
    }
    $metadata['plan_code'] = $planId;
    $payload['payment_plan'] = $planId;
    $payload['meta'] = $metadata;
}

payment_record_donation([
    'gateway' => $gateway,
    'type' => $type,
    'amount' => $amount,
    'currency' => $currency,
    'email' => $email,
    'status' => 'Pending',
    'transaction_id' => null,
    'external_id' => $reference,
    'raw_payload' => ['stage' => 'initialized', 'metadata' => $metadata],
]);

$response = payment_http_json(
    'POST',
    'https://api.flutterwave.com/v3/payments',
    ['Authorization: Bearer ' . FLUTTERWAVE_SECRET_KEY],
    $payload
);

if (!$response['ok'] || !is_array($response['json']) || (($response['json']['status'] ?? '') !== 'success') || empty($response['json']['data']['link'])) {
    payment_update_donation_status('flutterwave', $reference, 'Failed', ['stage' => 'initialize_failed', 'response' => $response]);
    payment_init_fail('Unable to initialize Flutterwave payment.', ['response' => $response]);
}

log_info('payment_init', 'Flutterwave checkout initialized', ['reference' => $reference, 'currency' => $currency, 'type' => $type]);
payment_json_response(true, [
    'redirect_url' => $response['json']['data']['link'],
    'reference' => $reference,
    'gateway' => 'flutterwave',
]);
