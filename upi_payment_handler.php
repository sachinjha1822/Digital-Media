<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/config.php';

if (empty($_SESSION['pending_upi_order'])) {
    header("Location: checkout.php");
    exit();
}

$order_id = $_SESSION['pending_upi_order']['order_id'];
$user_id = $_SESSION['pending_upi_order']['user_id'];
$amount = $_SESSION['pending_upi_order']['amount'];

try {
    $pdo->beginTransaction();
    
    // Verify payment (in a real app, you would verify with your payment gateway)
    $is_payment_successful = true; // This should be replaced with actual verification
    
    if ($is_payment_successful) {
        // Update order status
        $stmt = $pdo->prepare("UPDATE orders SET status = 'processing', payment_status = 'paid' WHERE id = ?");
        $stmt->execute([$order_id]);
        
        // Add status history
        $status_stmt = $pdo->prepare("INSERT INTO order_status_history (order_id, status) VALUES (?, ?)");
        $status_stmt->execute([$order_id, 'processing']);
        
        // Generate tracking info
        $tracking_number = 'TRK-' . strtoupper(bin2hex(random_bytes(8)));
        
        // Get shipping method from order
        $order_stmt = $pdo->prepare("SELECT payment_method FROM orders WHERE id = ?");
        $order_stmt->execute([$order_id]);
        $order = $order_stmt->fetch();
        
        $carrier = ($order['payment_method'] === 'dtdc') ? 'DTDC' : 
                  ($order['payment_method'] === 'india_post_ems' ? 'India Post EMS' : 'India Post');
        
        $delivery_days = ($order['payment_method'] === 'dtdc') ? 5 : 
                        ($order['payment_method'] === 'india_post_ems' ? 3 : 7);
        $estimated_delivery = date('Y-m-d', strtotime("+$delivery_days days"));
        
        // Insert tracking info
        $tracking_stmt = $pdo->prepare("
            INSERT INTO order_tracking (
                order_id, tracking_number, carrier, 
                status, estimated_delivery
            ) VALUES (?, ?, ?, ?, ?)
        ");
        $tracking_stmt->execute([
            $order_id,
            $tracking_number,
            $carrier,
            'processing',
            $estimated_delivery
        ]);
        
        // Clear the cart
        $clear_cart_stmt = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?");
        $clear_cart_stmt->execute([$user_id]);
        
        $pdo->commit();
        
        // Clear session and redirect to success page
        unset($_SESSION['pending_upi_order']);
        header("Location: order_success.php?order_id=" . $order_id);
        exit();
    } else {
        // Payment failed
        $pdo->rollBack();
        header("Location: checkout.php?payment_error=upi");
        exit();
    }
} catch (Exception $e) {
    $pdo->rollBack();
    error_log('UPI Payment Error: ' . $e->getMessage());
    header("Location: checkout.php?payment_error=system");
    exit();
}