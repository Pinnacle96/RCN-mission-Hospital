<?php
// Legacy endpoint preserved for backward compatibility.
$_POST['gateway'] = 'paystack';
$_POST['type'] = 'recurring';
$_POST['currency'] = $_POST['currency'] ?? 'NGN';
require __DIR__ . '/../payments/init.php';
