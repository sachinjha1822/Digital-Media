<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if order ID is provided
if (!isset($_GET['id'])) {
    header("Location: account.php");
    exit();
}

// Include database connection
require_once 'includes/db.php';

// Get user ID
$user_id = $_SESSION['user_id'];
$order_id = $_GET['id'];

// Verify the order belongs to the user
$stmt = $pdo->prepare("
    SELECT o.*, ot.tracking_number, ot.carrier, ot.status AS tracking_status, 
           ot.estimated_delivery, ot.shipped_date, ot.delivered_date, ot.tracking_url, ot.notes AS tracking_notes
    FROM orders o
    LEFT JOIN order_tracking ot ON o.id = ot.order_id
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    $_SESSION['error'] = "Order not found or doesn't belong to you";
    header("Location: account.php");
    exit();
}

// Get order items
$stmt = $pdo->prepare("
    SELECT oi.*, p.main_image
    FROM order_items oi
    LEFT JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get order status history
$stmt = $pdo->prepare("
    SELECT * FROM order_status_history
    WHERE order_id = ?
    ORDER BY created_at DESC
");
$stmt->execute([$order_id]);
$status_history = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Decode addresses
$shipping_address = json_decode($order['shipping_address'], true);
$billing_address = json_decode($order['billing_address'], true);

// Define the complete order workflow stages
// Define the complete order workflow stages - only once each
$status_stages = [
    'ordered' => [
        'display' => 'Ordered',
        'icon' => 'checkmark-circle-outline',
        'description' => 'Order has been placed',
        'date_field' => 'order_date'
    ],
    'confirmed' => [
        'display' => 'Confirmed',
        'icon' => 'checkmark-done-outline',
        'description' => 'Seller confirmed your order',
        'date_field' => null
    ],
    'packed' => [
        'display' => 'Packed',
        'icon' => 'cube-outline',
        'description' => 'Seller packed your items',
        'date_field' => null
    ],
    'shipped' => [
        'display' => 'Shipped',
        'icon' => 'boat-outline',
        'description' => 'Items have been shipped',
        'date_field' => 'shipped_date'
    ],
    'out_for_delivery' => [
        'display' => 'Out for Delivery',
        'icon' => 'car-outline',
        'description' => 'Items are out for delivery',
        'date_field' => null
    ],
    'delivered' => [
        'display' => 'Delivered',
        'icon' => 'checkmark-done-outline',
        'description' => 'Items have been delivered',
        'date_field' => 'delivered_date'
    ]
];

// Get dates from status history
$status_dates = [];
foreach ($status_history as $history) {
    $status_lower = strtolower(str_replace(' ', '_', $history['status']));
    if (!isset($status_dates[$status_lower])) {
        $status_dates[$status_lower] = $history['created_at'];
    }
}

// Build the timeline with actual dates
$status_timeline = [];
foreach ($status_stages as $status => $stage) {
    $date = null;
    
    // Get date from predefined field or status history
    if (!empty($stage['date_field']) && !empty($order[$stage['date_field']])) {
        $date = $order[$stage['date_field']];
    } elseif (isset($status_dates[$status])) {
        $date = $status_dates[$status];
    }
    
    $status_timeline[$status] = [
        'display' => $stage['display'],
        'icon' => $stage['icon'],
        'description' => $stage['description'],
        'date' => $date,
        'active' => false,
        'completed' => false
    ];
}

// Determine current status (use tracking status first, then order status)
$current_status = strtolower(str_replace(' ', '_', $order['tracking_status'] ?? $order['status'] ?? 'ordered'));

// Find current position in the workflow
$status_keys = array_keys($status_stages);
$current_position = array_search($current_status, $status_keys);

// If status not found (like 'processing'), default to first step
if ($current_position === false) {
    $current_position = 0;
    $current_status = 'ordered';
}

// Mark completed and active steps
foreach ($status_timeline as $status => &$data) {
    $status_pos = array_search($status, $status_keys);
    
    if ($status_pos !== false) {
        if ($status_pos < $current_position) {
            $data['completed'] = true;
        } elseif ($status_pos == $current_position) {
            $data['active'] = true;
        }
    }
}

// For cancelled orders - special case
if ($current_status === 'cancelled') {
    $status_timeline = [
        'ordered' => [
            'display' => 'Ordered',
            'icon' => 'checkmark-circle-outline',
            'description' => 'Your order was placed',
            'date' => $order['order_date'],
            'active' => true,
            'completed' => true
        ],
        'cancelled' => [
            'display' => 'Cancelled',
            'icon' => 'close-circle-outline',
            'description' => 'Order was cancelled',
            'date' => $status_dates['cancelled'] ?? null,
            'active' => true,
            'completed' => true
        ]
    ];
    $progress_width = 100;
} else {
    // Calculate progress percentage (0-100)
    $progress_width = ($current_position / (count($status_stages) - 1)) * 100;
}

// Set page title
$pageTitle = 'Order #' . $order['order_number'] . ' Details - Digital Media';

// Include header
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="./assets/css/style-prefix.css">
  <style>
    /* Order Tracking Progress Bar Styles */
    .tracking-progress {
        margin: 30px 0;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .progress-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--eerie-black);
    }
    
    .current-status {
        background: #f5f5f5;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-top: 20px;
    }
    
    .progress-steps::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
        height: 3px;
        background: #e0e0e0;
        z-index: 1;
    }
    
    .progress-bar {
        position: absolute;
        top: 15px;
        left: 0;
        height: 3px;
        background: var(--salmon-pink);
        z-index: 2;
        transition: width 0.3s ease;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 3;
        width: 16%;
    }
    
    .step-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        color: #9e9e9e;
    }
    
    .step.active .step-icon {
        background: var(--salmon-pink);
        color: white;
    }
    
    .step.completed .step-icon {
        background: #4caf50;
        color: white;
    }
    
    .step.cancelled .step-icon {
        background: #f44336;
        color: white;
    }
    
    .step-label {
        font-size: 12px;
        text-align: center;
        color: #9e9e9e;
        max-width: 80px;
    }
    
    .step.active .step-label,
    .step.completed .step-label {
        color: var(--eerie-black);
        font-weight: 500;
    }
    
    .step-date {
        font-size: 11px;
        color: #9e9e9e;
        margin-top: 4px;
        text-align: center;
    }
    
    .step.active .step-date,
    .step.completed .step-date {
        color: var(--eerie-black);
    }
    
    .step-description {
        font-size: 12px;
        color: #666;
        text-align: center;
        margin-top: 5px;
        display: none;
    }
    
    .step.active .step-description {
        display: block;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .progress-steps {
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 20px;
        }
        
        .step {
            flex: 1 0 60px;
        }
        
        .progress-steps::before,
        .progress-bar {
            display: none;
        }
        
        .step-description {
            display: none !important;
        }
    }
    
    /* Status badge styles */
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-processing {
        background-color: #FFF3CD;
        color: #856404;
    }
    
    .status-shipped {
        background-color: #CCE5FF;
        color: #004085;
    }
    
    .status-out-for-delivery {
        background-color: #D1ECF1;
        color: #0C5460;
    }
    
    .status-delivered {
        background-color: #D4EDDA;
        color: #155724;
    }
    
    .status-cancelled {
        background-color: #F8D7DA;
        color: #721C24;
    }
    
    
    /* Reuse the styles from order_success.php */
    .order-details-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .order-card {
        background: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--cultured);
    }
    
    .order-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--eerie-black);
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }
    
    .info-label {
        font-weight: 500;
        color: #666;
    }
    
    .info-value {
        font-weight: 500;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-processing {
        background-color: #FFF3CD;
        color: #856404;
    }
    
    .status-shipped {
        background-color: #CCE5FF;
        color: #004085;
    }
    
    .status-delivered {
        background-color: #D4EDDA;
        color: #155724;
    }
    
    .status-cancelled {
        background-color: #F8D7DA;
        color: #721C24;
    }
    
    .order-items-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    
    .order-items-table th {
        text-align: left;
        padding: 10px;
        background-color: var(--cultured);
        font-weight: 500;
    }
    
    .order-items-table td {
        padding: 15px 10px;
        border-bottom: 1px solid var(--cultured);
    }
    
    .item-image {
        width: 60px;
        height: 60px;
        object-fit: contain;
        border: 1px solid var(--cultured);
        border-radius: 4px;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 4px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: var(--transition-timing);
    }
    
    .btn-primary {
        background-color: var(--salmon-pink);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: var(--eerie-black);
    }
    
    .btn-outline {
        border: 1px solid var(--salmon-pink);
        color: var(--salmon-pink);
    }
    
    .btn-outline:hover {
        background-color: rgba(255, 111, 97, 0.1);
    }
    
    .btn-danger {
        background-color: #DC3545;
        color: white;
    }
    
    .btn-danger:hover {
        background-color: #BB2D3B;
    }
    
    .btn ion-icon {
        margin-right: 8px;
    }
    
    .address-section {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-top: 30px;
    }
    
    @media (min-width: 768px) {
        .address-section {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    .address-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .address-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--eerie-black);
        display: flex;
        align-items: center;
    }
    
    .address-title ion-icon {
        margin-right: 8px;
        color: var(--salmon-pink);
    }
    
    .status-history {
        margin-top: 30px;
    }
    
    .status-item {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid var(--cultured);
    }
    
    .status-item:last-child {
        border-bottom: none;
    }
    
    .status-icon {
        margin-right: 15px;
        font-size: 20px;
    }
    
    .status-content {
        flex: 1;
    }
    
    .status-message {
        font-weight: 500;
    }
    
    .status-date {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }
  </style>
</head>

<body>

  <!-- ORDER DETAILS MAIN CONTENT -->
  <main>
    <div class="order-details-container">
      <div class="order-card">
        <h1 class="order-title">Order #<?php echo htmlspecialchars($order['order_number']); ?></h1>
        
        <!-- Order Tracking Progress Bar -->
        <div class="tracking-progress">
            <div class="progress-header">
                <h3 class="progress-title">
                    <ion-icon name="cube-outline"></ion-icon>
                    Order Status
                </h3>
                <div class="current-status">
                    <span class="status-badge status-<?php echo $current_status; ?>">
                        <?php echo ucwords(str_replace('_', ' ', $current_status)); ?>
                    </span>
                </div>
            </div>
            
            <div class="progress-steps">
                <div class="progress-bar" style="width: <?php echo $progress_width; ?>%"></div>
                
                <?php foreach ($status_timeline as $status => $data): ?>
                    <div class="step <?php 
                        echo $data['active'] ? 'active' : ''; 
                        echo $data['completed'] ? ' completed' : '';
                    ?>">
                        <div class="step-icon">
                            <ion-icon name="<?php echo $data['icon']; ?>"></ion-icon>
                        </div>
                        <div class="step-label"><?php echo $data['display']; ?></div>
                        <?php if ($data['date']): ?>
                            <div class="step-date"><?php echo date('M j, Y', strtotime($data['date'])); ?></div>
                        <?php endif; ?>
                        <div class="step-description"><?php echo $data['description']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <?php if ($current_status === 'cancelled'): ?>
          <div style="padding: 15px; background: #f8d7da; color: #721c24; border-radius: 5px; margin-bottom: 20px;">
            <strong>Cancelled:</strong> This order has been cancelled.
          </div>
        <?php endif; ?>
        
        <div class="order-header">
          <div>
            <div class="info-row">
              <span class="info-label">Order Date:</span>
              <span class="info-value"><?php echo date('F j, Y g:i A', strtotime($order['order_date'])); ?></span>
            </div>
            <div class="info-row">
              <span class="info-label">Payment Method:</span>
              <span class="info-value">
                <?php 
                switch($order['payment_method']) {
                    case 'cod': echo 'Cash on Delivery'; break;
                    case 'credit_card': echo 'Credit/Debit Card'; break;
                    case 'upi': echo 'UPI Payment'; break;
                    case 'paypal': echo 'PayPal'; break;
                    default: echo htmlspecialchars($order['payment_method']);
                }
                ?>
              </span>
            </div>
          </div>
          
          <div>
            <div class="info-row">
              <span class="info-label">Order Status:</span>
              <span class="info-value">
                <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $current_status)); ?>">
                  <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $current_status))); ?>
                </span>
              </span>
            </div>
            <div class="info-row">
              <span class="info-label">Order Total:</span>
              <span class="info-value">₹<?php echo number_format($order['total_amount'], 2); ?></span>
            </div>
          </div>
        </div>
        
        <?php if ($order['tracking_number']): ?>
        <div class="tracking-section" style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <h3 style="margin-top: 0; color: var(--eerie-black);">
                <ion-icon name="cube-outline"></ion-icon>
                Shipping Information
            </h3>
            
            <div style="display: grid; grid-template-columns: max-content 1fr; gap: 10px 15px; align-items: center;">
                <?php if ($order['carrier']): ?>
                <div style="font-weight: 500;">Carrier:</div>
                <div><?php echo htmlspecialchars($order['carrier']); ?></div>
                <?php endif; ?>
                
                <div style="font-weight: 500;">Tracking Number:</div>
                <div><?php echo htmlspecialchars($order['tracking_number']); ?></div>
                
                <?php if ($order['tracking_status']): ?>
                <div style="font-weight: 500;">Status:</div>
                <div>
                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $order['tracking_status'])); ?>">
                        <?php echo htmlspecialchars($order['tracking_status']); ?>
                    </span>
                </div>
                <?php endif; ?>
                
                <?php if ($order['shipped_date']): ?>
                <div style="font-weight: 500;">Shipped Date:</div>
                <div><?php echo date('F j, Y', strtotime($order['shipped_date'])); ?></div>
                <?php endif; ?>
                
                <?php if ($order['estimated_delivery']): ?>
                <div style="font-weight: 500;">Estimated Delivery:</div>
                <div><?php echo date('F j, Y', strtotime($order['estimated_delivery'])); ?></div>
                <?php endif; ?>
                
                <?php if ($order['delivered_date']): ?>
                <div style="font-weight: 500;">Delivered Date:</div>
                <div><?php echo date('F j, Y', strtotime($order['delivered_date'])); ?></div>
                <?php endif; ?>
                
                <?php if ($order['tracking_url']): ?>
                <div style="font-weight: 500;">Tracking Link:</div>
                <div>
                    <a href="<?php echo htmlspecialchars($order['tracking_url']); ?>" 
                       target="_blank" 
                       style="color: var(--salmon-pink); text-decoration: none;">
                        Track Your Package
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if ($order['tracking_notes']): ?>
            <div style="margin-top: 15px; padding: 10px; background: white; border-radius: 5px;">
                <div style="font-weight: 500;">Notes:</div>
                <p><?php echo htmlspecialchars($order['tracking_notes']); ?></p>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <table class="order-items-table">
          <thead>
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($order_items as $item): ?>
            <tr>
              <td>
                <div style="display: flex; align-items: center;">
                  <img src="<?php echo htmlspecialchars($item['main_image']); ?>" 
                       alt="<?php echo htmlspecialchars($item['product_name']); ?>" 
                       class="item-image">
                  <div style="margin-left: 15px;">
                    <?php echo htmlspecialchars($item['product_name']); ?>
                  </div>
                </div>
              </td>
              <td>₹<?php echo number_format($item['price'], 2); ?></td>
              <td><?php echo htmlspecialchars($item['quantity']); ?></td>
              <td>₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" style="text-align: right; font-weight: 500;">Subtotal:</td>
              <td>₹<?php 
                $subtotal = array_reduce($order_items, function($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0);
                echo number_format($subtotal, 2);
              ?></td>
            </tr>
            <tr>
              <td colspan="3" style="text-align: right; font-weight: 500;">Shipping:</td>
              <td>₹<?php echo number_format($order['total_amount'] - $subtotal, 2); ?></td>
            </tr>
            <tr>
              <td colspan="3" style="text-align: right; font-weight: 600;">Total:</td>
              <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
            </tr>
          </tfoot>
        </table>
        
        <div class="address-section">
          <div class="address-card">
            <h2 class="address-title">
              <ion-icon name="location-outline"></ion-icon>
              Shipping Address
            </h2>
            <p>
              <strong><?php echo htmlspecialchars($shipping_address['first_name'] . ' ' . $shipping_address['last_name']); ?></strong><br>
              <?php echo htmlspecialchars($shipping_address['address_line1']); ?><br>
              <?php if (!empty($shipping_address['address_line2'])): ?>
                <?php echo htmlspecialchars($shipping_address['address_line2']); ?><br>
              <?php endif; ?>
              <?php echo htmlspecialchars($shipping_address['city'] . ', ' . $shipping_address['state'] . ' ' . $shipping_address['zip_code']); ?><br>
              <?php echo htmlspecialchars($shipping_address['country']); ?><br>
              Phone: <?php echo htmlspecialchars($shipping_address['phone']); ?>
            </p>
          </div>
          
          <div class="address-card">
            <h2 class="address-title">
              <ion-icon name="card-outline"></ion-icon>
              Billing Address
            </h2>
            <p>
              <strong><?php echo htmlspecialchars($billing_address['first_name'] . ' ' . $billing_address['last_name']); ?></strong><br>
              <?php echo htmlspecialchars($billing_address['address_line1']); ?><br>
              <?php if (!empty($billing_address['address_line2'])): ?>
                <?php echo htmlspecialchars($billing_address['address_line2']); ?><br>
              <?php endif; ?>
              <?php echo htmlspecialchars($billing_address['city'] . ', ' . $billing_address['state'] . ' ' . $billing_address['zip_code']); ?><br>
              <?php echo htmlspecialchars($billing_address['country']); ?><br>
              Phone: <?php echo htmlspecialchars($billing_address['phone']); ?>
            </p>
          </div>
        </div>
        
        <?php if (!empty($status_history)): ?>
        <div class="status-history">
          <h2 class="address-title">
            <ion-icon name="time-outline"></ion-icon>
            Order Status History
          </h2>
          
          <?php foreach ($status_history as $status): ?>
          <div class="status-item">
            <div class="status-icon">
              <ion-icon name="
                <?php 
                switch(strtolower($status['status'])) {
                    case 'processing': echo 'time-outline'; break;
                    case 'shipped': echo 'cube-outline'; break;
                    case 'delivered': echo 'checkmark-outline'; break;
                    case 'cancelled': echo 'close-outline'; break;
                    case 'out for delivery': echo 'car-outline'; break;
                    default: echo 'alert-circle-outline';
                }
                ?>
              "></ion-icon>
            </div>
            <div class="status-content">
              <div class="status-message">
                <?php echo htmlspecialchars($status['status']); ?>
                <?php if (!empty($status['notes'])): ?>
                  - <?php echo htmlspecialchars($status['notes']); ?>
                <?php endif; ?>
              </div>
              <div class="status-date">
                <?php echo date('F j, Y g:i A', strtotime($status['created_at'])); ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div class="action-buttons">
          <a href="account.php" class="btn btn-outline">
            <ion-icon name="arrow-back-outline"></ion-icon>
            Back to Orders
          </a>
          
          <?php if ($current_status === 'processing'): ?>
          <button class="btn btn-danger" id="cancel-order-btn">
            <ion-icon name="close-outline"></ion-icon>
            Cancel Order
          </button>
          <?php endif; ?>
          
          <?php if ($current_status === 'delivered'): ?>
          <button class="btn btn-primary" id="return-order-btn">
            <ion-icon name="return-up-back-outline"></ion-icon>
            Request Return
          </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <?php include('footer.php'); ?>

  <!-- IONICONS -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  
  <script>
    document.getElementById('cancel-order-btn')?.addEventListener('click', function() {
        if (confirm('Are you sure you want to cancel this order?')) {
            fetch('cancel_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'order_id=<?php echo $order['id']; ?>'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Order cancelled successfully');
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while cancelling the order');
            });
        }
    });
    
    document.getElementById('return-order-btn')?.addEventListener('click', function() {
        window.location.href = 'request_return.php?order_id=<?php echo $order['id']; ?>';
    });
  </script>
</body>
</html>