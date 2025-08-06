<?php
require __DIR__ . '/includes/vendor/autoload.php';

$api = new Razorpay\Api\Api('YOUR_TEST_KEY_ID', 'YOUR_TEST_KEY_SECRET');

try {
    $order = $api->order->create([
        'amount' => 100, // ₹1.00
        'currency' => 'INR',
        'receipt' => 'test_01'
    ]);
    print_r($order);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}