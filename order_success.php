<?php
// order_success.php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if order ID is provided
if (empty($_GET['order_id'])) {
    header("Location: account.php");
    exit();
}

$order_id = (int)$_GET['order_id'];

// Load database connection
require __DIR__ . '/includes/db.php';

// Get order details
try {
    $stmt = $pdo->prepare("
        SELECT o.*, ot.tracking_number, ot.status as tracking_status, ot.estimated_delivery
        FROM orders o
        LEFT JOIN order_tracking ot ON o.id = ot.order_id
        WHERE o.id = ? AND o.user_id = ?
    ");
    $stmt->execute([$order_id, $_SESSION['user_id']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        throw new Exception("Order not found");
    }

    // Get order items
    $items_stmt = $pdo->prepare("
        SELECT oi.*, p.main_image
        FROM order_items oi
        LEFT JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?
    ");
    $items_stmt->execute([$order_id]);
    $order_items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Decode addresses
    $shipping_address = json_decode($order['shipping_address'], true);
    $billing_address = json_decode($order['billing_address'], true);

} catch (Exception $e) {
    // Handle error
    error_log("Order Success Error: " . $e->getMessage());
    header("Location: account.php?error=order_not_found");
    exit();
}

// Set page title
$pageTitle = "Order Confirmation - Digital Media";

// Include header
require __DIR__ . '/header.php';
?>

<div class="container">
    <div class="order-confirmation">
        <div class="confirmation-header">
            <h1>
                <ion-icon name="checkmark-circle-outline"></ion-icon>
                Thank You For Your Order!
            </h1>
            <p class="order-number">Order #<?php echo htmlspecialchars($order['order_number']); ?></p>
            <p>We've sent a confirmation email to <?php echo htmlspecialchars($shipping_address['email']); ?></p>
        </div>

        <div class="confirmation-details">
            <div class="order-summary">
                <h2>Order Summary</h2>
                <div class="summary-items">
                    <?php foreach ($order_items as $item): ?>
                    <div class="summary-item">
                        <div class="item-image">
                            <img src="<?php echo htmlspecialchars($item['main_image']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['product_name']); ?>" width="60">
                        </div>
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                            <p>Quantity: <?php echo $item['quantity']; ?></p>
                            <p>Price: ₹<?php echo number_format($item['price'], 2); ?></p>
                        </div>
                        <div class="item-total">
                            ₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="order-totals">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span>₹<?php echo number_format($order['total_amount'], 2); ?></span>
                    </div>
                    <div class="total-row">
                        <span>Shipping:</span>
                        <span>₹<?php echo number_format($order['shipping_cost'] ?? 40.00, 2); ?></span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total:</span>
                        <span>₹<?php echo number_format($order['total_amount'] + ($order['shipping_cost'] ?? 40.00), 2); ?></span>
                    </div>
                </div>
            </div>

            <div class="order-status">
                <h2>Order Status</h2>
                <div class="status-card">
                    <div class="status-icon">
                        <ion-icon name="<?php 
                            switch($order['tracking_status']) {
                                case 'processing': echo 'time-outline'; break;
                                case 'shipped': echo 'car-outline'; break;
                                case 'delivered': echo 'checkmark-done-outline'; break;
                                default: echo 'time-outline';
                            }
                        ?>"></ion-icon>
                    </div>
                    <div class="status-details">
                        <h3><?php echo ucfirst($order['tracking_status']); ?></h3>
                        <?php if ($order['tracking_status'] === 'processing'): ?>
                            <p>Your order is being prepared for shipment</p>
                        <?php elseif ($order['tracking_status'] === 'shipped'): ?>
                            <p>Your order is on the way</p>
                        <?php elseif ($order['tracking_status'] === 'delivered'): ?>
                            <p>Your order has been delivered</p>
                        <?php else: ?>
                            <p>Your order has been received</p>
                        <?php endif; ?>
                        
                        <?php if (!empty($order['tracking_number'])): ?>
                            <p>Tracking Number: <?php echo htmlspecialchars($order['tracking_number']); ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($order['estimated_delivery'])): ?>
                            <p>Estimated Delivery: <?php echo date('F j, Y', strtotime($order['estimated_delivery'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="customer-actions">
            <a href="account.php" class="btn btn-primary">
                <ion-icon name="person-outline"></ion-icon>
                View Order in Account
            </a>
            <a href="products.php" class="btn btn-secondary">
                <ion-icon name="cart-outline"></ion-icon>
                Continue Shopping
            </a>
        </div>
    </div>
</div>

<style>
.order-confirmation {
    max-width: 1000px;
    margin: 40px auto;
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
}

.confirmation-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.confirmation-header h1 {
    font-size: 28px;
    color: #4CAF50;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 10px;
}

.confirmation-header h1 ion-icon {
    font-size: 32px;
}

.order-number {
    font-size: 18px;
    color: #666;
    margin-bottom: 10px;
}

.confirmation-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 40px;
}

@media (max-width: 768px) {
    .confirmation-details {
        grid-template-columns: 1fr;
    }
}

.order-summary, .order-status {
    background: #f9f9f9;
    border-radius: 8px;
    padding: 20px;
}

.order-summary h2, .order-status h2 {
    font-size: 20px;
    margin-top: 0;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.summary-items {
    margin-bottom: 20px;
}

.summary-item {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.summary-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.item-image img {
    border-radius: 5px;
}

.item-details h3 {
    margin: 0 0 5px 0;
    font-size: 16px;
}

.item-details p {
    margin: 0;
    font-size: 14px;
    color: #666;
}

.item-total {
    margin-left: auto;
    font-weight: 600;
}

.order-totals {
    margin-top: 20px;
    border-top: 1px solid #eee;
    padding-top: 20px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.total-row.grand-total {
    font-weight: bold;
    font-size: 18px;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.status-card {
    display: flex;
    gap: 15px;
    align-items: center;
}

.status-icon ion-icon {
    font-size: 40px;
    color: #4CAF50;
}

.status-details h3 {
    margin: 0 0 5px 0;
    font-size: 18px;
}

.status-details p {
    margin: 0;
    font-size: 14px;
    color: #666;
}

.customer-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 30px;
}

@media (max-width: 576px) {
    .customer-actions {
        flex-direction: column;
    }
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #4CAF50;
    color: white;
}

.btn-primary:hover {
    background: #3e8e41;
}

.btn-secondary {
    background: #2196F3;
    color: white;
}

.btn-secondary:hover {
    background: #0b7dda;
}
</style>

<?php require __DIR__ . '/footer.php'; ?>