<?php
require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../includes/logger.php';
require_once __DIR__ . '/../includes/payment_helpers.php';

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    echo 'CLI only';
    exit;
}

payment_ensure_subscription_schema();

$pdo = db();
$limit = 25;
$now = (new DateTimeImmutable('now'))->format('Y-m-d H:i:s');
$stmt = $pdo->prepare("SELECT * FROM subscriptions WHERE gateway = 'paystack' AND authorization_code IS NOT NULL AND authorization_code <> '' AND amount IS NOT NULL AND amount > 0 AND email IS NOT NULL AND email <> '' AND next_charge_at IS NOT NULL AND next_charge_at <= ? AND status IN ('active', 'past_due', 'pending') ORDER BY next_charge_at ASC LIMIT {$limit}");
$stmt->execute([$now]);
$rows = $stmt->fetchAll();

if (!$rows) {
    log_info('paystack_recurring_cron', 'No Paystack recurring subscriptions due', ['checked_at' => $now]);
    echo "No due subscriptions.\n";
    exit;
}

$processed = 0;

foreach ($rows as $row) {
    $processed++;
    $reference = payment_generate_reference('paystack_renewal');
    $metadata = [
        'gateway' => 'paystack',
        'type' => 'recurring',
        'currency' => strtoupper((string) ($row['currency'] ?? 'NGN')),
        'amount' => (float) ($row['amount'] ?? 0),
        'email' => (string) ($row['email'] ?? ''),
        'subscription_external_id' => (string) $row['external_id'],
        'plan_code' => (string) (($row['plan_code'] ?? '') ?: 'flex_monthly'),
        'source' => 'cron',
    ];

    try {
        $response = payment_paystack_charge_authorization(
            (string) $row['email'],
            (string) $row['authorization_code'],
            (float) $row['amount'],
            strtoupper((string) ($row['currency'] ?? 'NGN')),
            $reference,
            $metadata
        );

        $json = is_array($response['json']) ? $response['json'] : [];
        $data = is_array($json['data'] ?? null) ? $json['data'] : [];
        $transactionStatus = strtolower((string) ($data['status'] ?? 'failed'));
        $normalizedStatus = payment_normalize_status($transactionStatus);

        payment_record_donation([
            'gateway' => 'paystack',
            'type' => 'recurring',
            'amount' => (float) $row['amount'],
            'currency' => strtoupper((string) ($row['currency'] ?? 'NGN')),
            'email' => (string) $row['email'],
            'status' => $response['ok'] && !empty($json['status']) ? $normalizedStatus : 'Failed',
            'transaction_id' => isset($data['id']) ? (string) $data['id'] : null,
            'external_id' => $reference,
            'raw_payload' => $response['ok'] ? $json : ['stage' => 'charge_authorization_failed', 'response' => $response],
        ]);

        if ($response['ok'] && !empty($json['status']) && $transactionStatus === 'success') {
            payment_upsert_subscription([
                'gateway' => 'paystack',
                'external_id' => (string) $row['external_id'],
                'plan_code' => (string) (($row['plan_code'] ?? '') ?: 'flex_monthly'),
                'authorization_code' => (string) $row['authorization_code'],
                'authorization_signature' => (string) ($row['authorization_signature'] ?? ''),
                'amount' => (float) $row['amount'],
                'currency' => strtoupper((string) ($row['currency'] ?? 'NGN')),
                'email' => (string) $row['email'],
                'status' => 'active',
                'next_charge_at' => payment_schedule_next_monthly_charge((string) ($data['transaction_date'] ?? $now)),
                'last_charge_at' => $data['transaction_date'] ?? $now,
                'last_payment_reference' => $reference,
                'raw_payload' => $json,
            ]);
            log_info('paystack_recurring_cron', 'Recurring charge succeeded', ['external_id' => $row['external_id'], 'reference' => $reference]);
            continue;
        }

        $retryAt = (new DateTimeImmutable('now'))->modify('+1 day')->format('Y-m-d H:i:s');
        $status = in_array($transactionStatus, ['pending', 'ongoing'], true) ? 'pending' : 'past_due';

        payment_upsert_subscription([
            'gateway' => 'paystack',
            'external_id' => (string) $row['external_id'],
            'plan_code' => (string) (($row['plan_code'] ?? '') ?: 'flex_monthly'),
            'authorization_code' => (string) $row['authorization_code'],
            'authorization_signature' => (string) ($row['authorization_signature'] ?? ''),
            'amount' => (float) $row['amount'],
            'currency' => strtoupper((string) ($row['currency'] ?? 'NGN')),
            'email' => (string) $row['email'],
            'status' => $status,
            'next_charge_at' => $retryAt,
            'last_payment_reference' => $reference,
            'raw_payload' => $response['ok'] ? $json : ['stage' => 'charge_authorization_failed', 'response' => $response],
        ]);

        log_error('paystack_recurring_cron', 'Recurring charge did not complete successfully', [
            'external_id' => $row['external_id'],
            'reference' => $reference,
            'status' => $transactionStatus,
        ]);
    } catch (Throwable $e) {
        $retryAt = (new DateTimeImmutable('now'))->modify('+1 day')->format('Y-m-d H:i:s');
        payment_upsert_subscription([
            'gateway' => 'paystack',
            'external_id' => (string) $row['external_id'],
            'plan_code' => (string) (($row['plan_code'] ?? '') ?: 'flex_monthly'),
            'authorization_code' => (string) $row['authorization_code'],
            'authorization_signature' => (string) ($row['authorization_signature'] ?? ''),
            'amount' => (float) $row['amount'],
            'currency' => strtoupper((string) ($row['currency'] ?? 'NGN')),
            'email' => (string) $row['email'],
            'status' => 'past_due',
            'next_charge_at' => $retryAt,
            'raw_payload' => ['stage' => 'exception', 'message' => $e->getMessage()],
        ]);
        log_error('paystack_recurring_cron', 'Recurring charge exception', [
            'external_id' => $row['external_id'],
            'error' => $e->getMessage(),
        ]);
    }
}

echo "Processed {$processed} Paystack recurring subscription(s).\n";
