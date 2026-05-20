<?php
// PayPal IPN listener: validates messages and stores donations/subscriptions
require_once __DIR__ . '/../../includes/constants.php';
require_once __DIR__ . '/../../includes/logger.php';
require_once __DIR__ . '/../../includes/payment_helpers.php';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  log_error('paypal_ipn', 'Invalid method', ['method' => $_SERVER['REQUEST_METHOD'] ?? '']);
  http_response_code(405);
  echo 'Method Not Allowed';
  exit;
}

// Capture raw POST data
$postData = $_POST;
// Build validation payload
$validationPayload = 'cmd=_notify-validate';
foreach ($postData as $key => $value) {
  $validationPayload .= '&' . urlencode($key) . '=' . urlencode($value);
}

// Choose endpoint
$ipnEndpoint = PAYPAL_USE_SANDBOX
  ? 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr'
  : 'https://ipnpb.paypal.com/cgi-bin/webscr';

// Validate with PayPal
$ch = curl_init($ipnEndpoint);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $validationPayload);
curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: Close', 'User-Agent: RCN-IPN-Listener']);
$res = curl_exec($ch);
$curlErr = curl_error($ch);
curl_close($ch);

if ($res !== 'VERIFIED') {
  log_error('paypal_ipn', 'IPN not verified', ['curl_error' => $curlErr ?: null, 'txn_type' => $postData['txn_type'] ?? null]);
  // Respond 200 to avoid retries, but ignore invalid messages
  http_response_code(200);
  echo 'INVALID';
  exit;
}

// Extract common fields
$txnType = $postData['txn_type'] ?? '';
$paymentStatus = $postData['payment_status'] ?? ($postData['status'] ?? '');
$payerEmail = $postData['payer_email'] ?? null;
$mcGross = isset($postData['mc_gross']) ? (float)$postData['mc_gross'] : null;
$mcCurrency = $postData['mc_currency'] ?? null;
$txnId = $postData['txn_id'] ?? null;
$subscrId = $postData['subscr_id'] ?? null;
$amount3 = isset($postData['amount3']) ? (float)$postData['amount3'] : null; // subscription amount

// Helper to store raw payload
$raw = json_encode($postData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$customRaw = $postData['custom'] ?? '';
$custom = json_decode($customRaw, true);
if (!is_array($custom)) {
  $custom = [];
}
$donationType = (($custom['type'] ?? '') === 'recurring' || in_array($txnType, ['subscr_signup', 'subscr_payment'], true)) ? 'recurring' : 'one_time';
$externalRef = $custom['reference'] ?? ($postData['invoice'] ?? ($subscrId ?: null));

try {
  if ($txnType === 'web_accept') {
    // One-time donation
    if ($mcGross !== null && $mcCurrency) {
      payment_record_donation([
        'gateway' => 'paypal',
        'type' => 'one_time',
        'amount' => $mcGross,
        'currency' => $mcCurrency,
        'email' => $payerEmail,
        'status' => payment_normalize_status($paymentStatus ?: 'Completed'),
        'transaction_id' => $txnId,
        'external_id' => $externalRef,
        'raw_payload' => $raw,
      ]);
      log_info('paypal_ipn', 'Donation recorded', ['type' => 'one_time', 'amount' => $mcGross, 'currency' => $mcCurrency, 'email' => $payerEmail, 'txn_id' => $txnId]);
    }
  } elseif ($txnType === 'subscr_signup') {
    // Subscription created
    payment_upsert_subscription([
      'gateway' => 'paypal',
      'external_id' => $subscrId ?: ($externalRef ?: ($txnId ?: '')),
      'plan_code' => $custom['plan_code'] ?? null,
      'amount' => $amount3,
      'currency' => $mcCurrency,
      'email' => $payerEmail,
      'status' => 'active',
      'raw_payload' => $raw,
    ]);
    log_info('paypal_ipn', 'Subscription signup', ['external_id' => $subscrId ?: $txnId, 'amount' => $amount3, 'currency' => $mcCurrency, 'email' => $payerEmail]);
  } elseif ($txnType === 'subscr_payment') {
    // Recurring payment occurred
    $amount = $mcGross ?? $amount3 ?? 0;
    $currency = $mcCurrency ?: 'USD';
    payment_record_donation([
      'gateway' => 'paypal',
      'type' => 'recurring',
      'amount' => $amount,
      'currency' => $currency,
      'email' => $payerEmail,
      'status' => payment_normalize_status($paymentStatus ?: 'Completed'),
      'transaction_id' => $txnId,
      'external_id' => $subscrId ?: $externalRef,
      'raw_payload' => $raw,
    ]);
    payment_upsert_subscription([
      'gateway' => 'paypal',
      'external_id' => $subscrId ?: ($externalRef ?: ($txnId ?: '')),
      'plan_code' => $custom['plan_code'] ?? null,
      'amount' => $amount,
      'currency' => $currency,
      'email' => $payerEmail,
      'status' => 'active',
      'raw_payload' => $raw,
    ]);
    log_info('paypal_ipn', 'Subscription payment', ['amount' => $amount, 'currency' => $currency, 'email' => $payerEmail, 'txn_id' => $txnId, 'external_id' => $subscrId]);
  } elseif ($txnType === 'subscr_cancel') {
    // Subscription canceled
    if ($subscrId) {
      payment_upsert_subscription([
        'gateway' => 'paypal',
        'external_id' => $subscrId,
        'plan_code' => $custom['plan_code'] ?? null,
        'amount' => $amount3,
        'currency' => $mcCurrency,
        'email' => $payerEmail,
        'status' => 'cancelled',
        'raw_payload' => $raw,
      ]);
      log_info('paypal_ipn', 'Subscription cancelled', ['external_id' => $subscrId, 'email' => $payerEmail]);
    }
  } else {
    // Other txn types can be logged for diagnostics
    payment_record_donation([
      'gateway' => 'paypal',
      'type' => $donationType,
      'amount' => $mcGross ?? 0,
      'currency' => $mcCurrency ?: 'USD',
      'email' => $payerEmail,
      'status' => $txnType ?: 'unknown',
      'transaction_id' => $txnId,
      'external_id' => $subscrId ?: $externalRef,
      'raw_payload' => $raw,
    ]);
    log_info('paypal_ipn', 'Unhandled IPN type recorded', ['txn_type' => $txnType, 'email' => $payerEmail, 'txn_id' => $txnId]);
  }
} catch (Throwable $e) {
  // Swallow errors to avoid IPN retries
  log_error('paypal_ipn', 'IPN processing error', ['error' => $e->getMessage(), 'txn_type' => $txnType, 'txn_id' => $txnId]);
}

http_response_code(200);
echo 'OK';
?>
