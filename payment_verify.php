<?php
// payment_verify.php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load dependencies
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/vendor/autoload.php';

// Verify payment
try {
    // Validate order ID
    if (empty($_GET['order_id'])) {
        throw new Exception("Order ID is required");
    }
    $order_id = (int)$_GET['order_id'];

    // Initialize Razorpay
    $api = new Razorpay\Api\Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    // Verify payment signature
    $success = true;
    $error = "Payment Failed";

    if (!empty($_POST['razorpay_payment_id']) && !empty($_POST['razorpay_signature'])) {
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        try {
            $api->utility->verifyPaymentSignature($attributes);
        } catch (Exception $e) {
            $success = false;
            $error = 'Payment verification failed: ' . $e->getMessage();
        }
    } else {
        $success = false;
        $error = 'Payment verification data missing';
    }

    // Start database transaction
    $pdo->beginTransaction();

    try {
        if ($success) {
            // Payment was successful - update order status
            $update_order_stmt = $pdo->prepare("
                UPDATE orders 
                SET payment_status = 'paid', 
                    status = 'processing',
                    payment_details = :payment_details
                WHERE id = :order_id AND user_id = :user_id
            ");
            
            $payment_details = json_encode([
                'payment_id' => $_POST['razorpay_payment_id'],
                'order_id' => $_SESSION['razorpay_order_id'],
                'amount' => $_SESSION['razorpay_amount'],
                'currency' => 'INR',
                'method' => $_POST['payment_method'] ?? 'card',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
            $update_order_stmt->execute([
                ':order_id' => $order_id,
                ':user_id' => $_SESSION['user_id'],
                ':payment_details' => $payment_details
            ]);
            
            // Create order tracking record
            $tracking_stmt = $pdo->prepare("
                INSERT INTO order_tracking (
                    order_id, tracking_number, carrier, status, estimated_delivery
                ) VALUES (?, ?, ?, ?, ?)
            ");
            
            $tracking_number = 'TRK' . strtoupper(uniqid());
            $delivery_date = date('Y-m-d', strtotime('+5 days'));
            $tracking_stmt->execute([
                $order_id,
                $tracking_number,
                'India Post',
                'processing',
                $delivery_date
            ]);
            
            // Update product stock and clear cart
            $cart_items_stmt = $pdo->prepare("
                SELECT ci.product_id, ci.quantity 
                FROM cart_items ci
                WHERE ci.user_id = ?
            ");
            $cart_items_stmt->execute([$_SESSION['user_id']]);
            $cart_items = $cart_items_stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($cart_items as $item) {
                $update_stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                $update_stmt->execute([$item['quantity'], $item['product_id']]);
            }
            
            // Clear the cart
            $clear_cart_stmt = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?");
            $clear_cart_stmt->execute([$_SESSION['user_id']]);
            
            $pdo->commit();
            
            // Redirect to success page
            header("Location: order_success.php?order_id=$order_id");
            exit();
        } else {
            // Payment failed - update order status
            $update_order_stmt = $pdo->prepare("
                UPDATE orders 
                SET payment_status = 'failed', 
                    status = 'failed',
                    payment_details = :payment_details
                WHERE id = :order_id AND user_id = :user_id
            ");
            
            $payment_details = json_encode([
                'error' => $error,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
            $update_order_stmt->execute([
                ':order_id' => $order_id,
                ':user_id' => $_SESSION['user_id'],
                ':payment_details' => $payment_details
            ]);
            
            $pdo->commit();
            
            // Redirect to failure page
            $_SESSION['checkout_error'] = $error;
            header("Location: checkout.php?error=payment_failed");
            exit();
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }

} catch (Exception $e) {
    // Log error and redirect to error page
    error_log('Payment Verification Error: ' . $e->getMessage());
    $_SESSION['checkout_error'] = "Payment processing error. Please contact support.";
    header("Location: checkout.php?error=payment_processing");
    exit();
}