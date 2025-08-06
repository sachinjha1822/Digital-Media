<?php
// payment-success.php

session_start();

require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/vendor/autoload.php';

// Verify payment
try {
    if (empty($_SESSION['razorpay_data'])) {
        throw new Exception("Invalid payment session");
    }

    $order_id = $_GET['order_id'] ?? null;
    $razorpay_payment_id = $_POST['razorpay_payment_id'] ?? null;
    $razorpay_order_id = $_POST['razorpay_order_id'] ?? null;
    $razorpay_signature = $_POST['razorpay_signature'] ?? null;

    if (empty($order_id) || empty($razorpay_payment_id) || empty($razorpay_signature)) {
        throw new Exception("Missing payment verification data");
    }

    // Verify session data matches
    if ($_SESSION['razorpay_data']['order_id'] != $order_id || 
        $_SESSION['razorpay_data']['razorpay_order_id'] != $razorpay_order_id) {
        throw new Exception("Payment session mismatch");
    }

    // Verify signature
    $api = new Razorpay\Api\Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
    
    $attributes = [
        'razorpay_order_id' => $razorpay_order_id,
        'razorpay_payment_id' => $razorpay_payment_id,
        'razorpay_signature' => $razorpay_signature
    ];

    $api->utility->verifyPaymentSignature($attributes);

    // Update order status
    $pdo->beginTransaction();
    
    $stmt = $pdo->prepare("
        UPDATE orders SET 
            status = 'completed',
            payment_status = 'paid',
            razorpay_payment_id = ?,
            razorpay_signature = ?,
            completed_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$razorpay_payment_id, $razorpay_signature, $order_id]);

    // Insert payment record
    $payment_stmt = $pdo->prepare("
        INSERT INTO payments (
            order_id, payment_method, amount, 
            transaction_id, status, raw_response
        ) VALUES (?, ?, ?, ?, ?, ?)
    ");
    $payment_stmt->execute([
        $order_id,
        'razorpay',
        $_SESSION['razorpay_data']['amount'] / 100,
        $razorpay_payment_id,
        'completed',
        json_encode($_POST)
    ]);

    $pdo->commit();

    // Clear session data
    unset($_SESSION['razorpay_data']);

    // Redirect to success page
    header("Location: order_success.php?order_id=" . $order_id);
    exit();

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log('Payment Verification Error: ' . $e->getMessage());
    header("Location: payment_failed.php?order_id=" . ($order_id ?? '') . "&error=" . urlencode($e->getMessage()));
    exit();
}