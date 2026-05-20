<?php
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../../includes/logger.php';
require_once __DIR__ . '/../../includes/payment_helpers.php';

function paystack_webhook_signature_is_valid(string $rawBody): bool {
    $signature = $_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] ?? '';
    if ($signature === '' || !defined('PAYSTACK_SECRET_KEY') || !PAYSTACK_SECRET_KEY) {
        return false;
    }
    $expected = hash_hmac('sha512', $rawBody, PAYSTACK_SECRET_KEY);
    return hash_equals($expected, $signature);
}

$rawBody = payment_read_raw_body();
if (!paystack_webhook_signature_is_valid($rawBody)) {
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
    if ($eventName === 'charge.success' && !empty($data['reference'])) {
        $reference = (string) $data['reference'];
        $verified = payment_paystack_verify_transaction($reference);
        $verifiedJson = is_array($verified['json']) ? $verified['json'] : [];
        $verifiedData = is_array($verifiedJson['data'] ?? null) ? $verifiedJson['data'] : [];
        if ($verified['ok'] && !empty($verifiedJson['status']) && !empty($verifiedData)) {
            $metadata = payment_paystack_metadata($verifiedData);
            $type = (($metadata['type'] ?? 'one_time') === 'recurring') ? 'recurring' : 'one_time';
            $amount = ((float) ($verifiedData['amount'] ?? 0)) / 100;
            $currency = strtoupper((string) ($verifiedData['currency'] ?? 'NGN'));
            $email = trim((string) ($verifiedData['customer']['email'] ?? ''));
            $transactionId = isset($verifiedData['id']) ? (string) $verifiedData['id'] : null;

            payment_record_donation([
                'gateway' => 'paystack',
                'type' => $type,
                'amount' => $amount,
                'currency' => $currency,
                'email' => $email,
                'status' => 'Completed',
                'transaction_id' => $transactionId,
                'external_id' => $reference,
                'raw_payload' => $verifiedJson,
            ]);

            if ($type === 'recurring') {
                $subscription = payment_paystack_subscription_from_transaction(array_merge($verifiedData, $data), $verifiedJson);
                if ($subscription) {
                    payment_upsert_subscription($subscription);
                }
            }
        }
    } elseif ($eventName === 'invoice.payment_failed' && !empty($data['subscription']['subscription_code'])) {
        payment_upsert_subscription([
            'gateway' => 'paystack',
            'external_id' => payment_paystack_subscription_external_id($data),
            'plan_code' => $data['plan']['plan_code'] ?? '',
            'amount' => isset($data['amount']) ? ((float) $data['amount']) / 100 : null,
            'currency' => $data['currency'] ?? null,
            'email' => $data['customer']['email'] ?? null,
            'status' => 'past_due',
            'raw_payload' => $event,
        ]);
    } elseif ($eventName === 'subscription.create' && !empty($data['subscription_code'])) {
        payment_upsert_subscription([
            'gateway' => 'paystack',
            'external_id' => payment_paystack_subscription_external_id($data),
            'plan_code' => $data['plan']['plan_code'] ?? '',
            'amount' => isset($data['plan']['amount']) ? ((float) $data['plan']['amount']) / 100 : null,
            'currency' => $data['plan']['currency'] ?? null,
            'email' => $data['customer']['email'] ?? null,
            'status' => 'active',
            'raw_payload' => $event,
        ]);
    } elseif ($eventName === 'subscription.disable' && !empty($data['subscription_code'])) {
        payment_upsert_subscription([
            'gateway' => 'paystack',
            'external_id' => payment_paystack_subscription_external_id($data),
            'plan_code' => $data['plan']['plan_code'] ?? '',
            'amount' => isset($data['plan']['amount']) ? ((float) $data['plan']['amount']) / 100 : null,
            'currency' => $data['plan']['currency'] ?? null,
            'email' => $data['customer']['email'] ?? null,
            'status' => 'cancelled',
            'raw_payload' => $event,
        ]);
    }

    log_info('paystack_webhook', 'Processed Paystack webhook', ['event' => $eventName, 'reference' => $data['reference'] ?? null]);
    http_response_code(200);
    echo 'ok';
} catch (Throwable $e) {
    log_error('paystack_webhook', 'Webhook processing failed', ['event' => $eventName, 'error' => $e->getMessage()]);
    http_response_code(500);
    echo 'error';
}
