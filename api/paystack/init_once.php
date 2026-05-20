<?php
// Legacy endpoint preserved for backward compatibility.
$_POST['gateway'] = 'paystack';
$_POST['type'] = 'one_time';
$_POST['currency'] = $_POST['currency'] ?? 'NGN';
require __DIR__ . '/../payments/init.php';
