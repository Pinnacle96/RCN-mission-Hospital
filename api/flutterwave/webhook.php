<?php
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../../includes/logger.php';
require_once __DIR__ . '/../../includes/payment_helpers.php';

function flutterwave_webhook_signature_is_valid(string $rawBody): bool {
    if (!defined('FLUTTERWAVE_SECRET_HASH') || !FLUTTERWAVE_SECRET_HASH) {
        return false;
    }

    $signature = $_SERVER['HTTP_FLUTTERWAVE_SIGNATURE'] ?? '';
    if ($signature !== '') {
        $expected = hash_hmac('sha256', $rawBody, FLUTTERWAVE_SECRET_HASH);
        return hash_equals($expected, $signature);
    }

    $legacyHash = $_SERVER['HTTP_VERIF_HASH'] ?? '';
    return $legacyHash !== '' && hash_equals((string) FLUTTERWAVE_SECRET_HASH, $legacyHash);
}

$rawBody = payment_read_raw_body();
if (!flutterwave_webhook_signature_is_valid($rawBody)) {
    http_response_code(401);
    echo 'invalid signature';
    exit;
}

$event = json_decode($rawBody, true);
if (!is_array($event)) {
    http_response_code(400);
    echo 'invalid payload';
    exit;
}

$eventName = strtolower((string) ($event['event'] ?? ''));
$data = is_array($event['data'] ?? null) ? $event['data'] : [];

try {
    if ($eventName === 'charge.completed' && !empty($data['id'])) {
        $verified = payment_flutterwave_verify_transaction((string) $data['id'], null);
        $verifiedJson = is_array($verified['json']) ? $verified['json'] : [];
        $verifiedData = is_array($verifiedJson['data'] ?? null) ? $verifiedJson['data'] : [];
        if ($verified['ok'] && (($verifiedJson['status'] ?? '') === 'success') && !empty($verifiedData)) {
            $status = strtolower((string) ($verifiedData['status'] ?? ''));
            $type = (($verifiedData['meta']['type'] ?? 'one_time') === 'recurring') ? 'recurring' : 'one_time';
            $amount = (float) ($verifiedData['amount'] ?? 0);
            $currency = strtoupper((string) ($verifiedData['currency'] ?? 'USD'));
            $email = trim((string) ($verifiedData['customer']['email'] ?? ''));
            $reference = (string) ($verifiedData['tx_ref'] ?? '');
            $transactionId = isset($verifiedData['id']) ? (string) $verifiedData['id'] : null;

            payment_record_donation([
                'gateway' => 'flutterwave',
                'type' => $type,
                'amount' => $amount,
                'currency' => $currency,
                'email' => $email,
                'status' => payment_normalize_status($status),
                'transaction_id' => $transactionId,
                'external_id' => $reference,
                'raw_payload' => $verifiedJson,
            ]);

            if ($type === 'recurring' && $status === 'successful') {
                payment_upsert_subscription([
                    'gateway' => 'flutterwave',
                    'external_id' => payment_flutterwave_subscription_external_id($verifiedData),
                    'plan_code' => $verifiedData['payment_plan'] ?? ($verifiedData['meta']['plan_code'] ?? ''),
                    'amount' => $amount,
                    'currency' => $currency,
                    'email' => $email,
                    'status' => 'active',
                    'raw_payload' => $verifiedJson,
                ]);
            }
        }
    } elseif ($eventName === 'charge.failed') {
        payment_record_donation([
            'gateway' => 'flutterwave',
            'type' => (($data['meta']['type'] ?? 'one_time') === 'recurring') ? 'recurring' : 'one_time',
            'amount' => isset($data['amount']) ? (float) $data['amount'] : 0,
            'currency' => strtoupper((string) ($data['currency'] ?? 'USD')),
            'email' => $data['customer']['email'] ?? null,
            'status' => 'Failed',
            'transaction_id' => isset($data['id']) ? (string) $data['id'] : null,
            'external_id' => $data['tx_ref'] ?? null,
            'raw_payload' => $event,
        ]);
    } elseif ($eventName === 'subscription.cancelled') {
        payment_upsert_subscription([
            'gateway' => 'flutterwave',
            'external_id' => payment_flutterwave_subscription_external_id($data),
            'plan_code' => $data['payment_plan'] ?? ($data['meta']['plan_code'] ?? ''),
            'amount' => isset($data['amount']) ? (float) $data['amount'] : null,
            'currency' => strtoupper((string) ($data['currency'] ?? 'USD')),
            'email' => $data['customer']['email'] ?? null,
            'status' => 'cancelled',
            'raw_payload' => $event,
        ]);
    }

    log_info('flutterwave_webhook', 'Processed Flutterwave webhook', ['event' => $eventName, 'reference' => $data['tx_ref'] ?? null]);
    http_response_code(200);
    echo 'ok';
} catch (Throwable $e) {
    log_error('flutterwave_webhook', 'Webhook processing failed', ['event' => $eventName, 'error' => $e->getMessage()]);
    http_response_code(500);
    echo 'error';
}
