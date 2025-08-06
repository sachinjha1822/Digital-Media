<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$order_id = $_POST['order_id'];
$user_id = $_SESSION['user_id'];

// Verify order belongs to user and is cancellable
$stmt = $pdo->prepare("
    SELECT id FROM orders 
    WHERE id = ? AND user_id = ? AND status = 'Processing'
");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Order not found or cannot be cancelled']);
    exit();
}

try {
    $pdo->beginTransaction();
    
    // Update order status
    $stmt = $pdo->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ?");
    $stmt->execute([$order_id]);
    
    // Add status history
    $stmt = $pdo->prepare("
        INSERT INTO order_status_history 
        (order_id, status, notes)
        VALUES (?, 'Cancelled', 'Order cancelled by customer')
    ");
    $stmt->execute([$order_id]);
    
    // Update tracking status
    $stmt = $pdo->prepare("
        UPDATE order_tracking 
        SET status = 'Cancelled', notes = 'Order cancelled by customer'
        WHERE order_id = ?
    ");
    $stmt->execute([$order_id]);
    
    $pdo->commit();
    
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>