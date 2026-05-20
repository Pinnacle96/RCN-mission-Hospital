<?php
// Copy this file to includes/config.local.php on the production server.
// The deployment workflow excludes config.local.php so live secrets are preserved.

define('SITE_URL', 'https://your-domain.example');

// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');

// Email / SMTP
define('SMTP_HOST', 'smtp.zoho.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@example.com');
define('SMTP_PASS', 'your-app-password');
define('CONTACT_RECIPIENT', 'your-email@example.com');

// PayPal
define('PAYPAL_BUSINESS_EMAIL', 'billing@example.com');
define('PAYPAL_RETURN_URL', '/thank-you');
define('PAYPAL_CANCEL_URL', '/partners');
define('PAYPAL_HOSTED_BUTTON_ID', '');
define('PAYPAL_USE_SANDBOX', false);

// Paystack
define('PAYSTACK_PUBLIC_KEY', '');
define('PAYSTACK_SECRET_KEY', '');
define('PAYSTACK_PLAN_CODE_NGN_MONTHLY', '');
define('PAYSTACK_PLAN_CODE_USD_MONTHLY', '');
define('PAYSTACK_CALLBACK_URL', 'https://your-domain.example/api/payments/verify.php?gateway=paystack');

// Flutterwave
define('FLUTTERWAVE_PUBLIC_KEY', '');
define('FLUTTERWAVE_SECRET_KEY', '');
define('FLUTTERWAVE_SECRET_HASH', '');
define('FLUTTERWAVE_PLAN_ID_NGN_MONTHLY', '');
define('FLUTTERWAVE_PLAN_ID_USD_MONTHLY', '');
define('FLUTTERWAVE_PLAN_ID_GBP_MONTHLY', '');
define('FLUTTERWAVE_PLAN_ID_EUR_MONTHLY', '');

// Queue / logging
define('QUEUE_PAUSE_SENDING', false);
define('QUEUE_MAX_ATTEMPTS_NEWSLETTER', 5);
define('QUEUE_MAX_ATTEMPTS_NEWSLETTER_TEST', 5);
define('QUEUE_MAX_ATTEMPTS_CONTACT', 5);
define('LOG_MAX_BYTES', 2097152);
define('LOG_MAX_FILES', 5);
