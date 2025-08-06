<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'includes/db.php';

// Fetch user data
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: logout.php");
    exit();
}

// Decode addresses if they exist
$shipping_address = [];
$billing_address = [];

if (!empty($user['shipping_address'])) {
    $shipping_address = json_decode($user['shipping_address'], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $shipping_address = [];
    }
}

if (!empty($user['billing_address'])) {
    $billing_address = json_decode($user['billing_address'], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $billing_address = [];
    }
}

// Fetch user's orders (latest 5)
$orders_stmt = $pdo->prepare("
    SELECT o.*, ot.tracking_number, ot.carrier, ot.status AS tracking_status, 
           ot.estimated_delivery, ot.tracking_url, ot.updated_at AS status_updated
    FROM orders o
    LEFT JOIN order_tracking ot ON o.id = ot.order_id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
    LIMIT 5
");
$orders_stmt->execute([$user_id]);
$orders = $orders_stmt->fetchAll(PDO::FETCH_ASSOC);

// Set page title
$pageTitle = "My Account - Digital Media";

// Include header
require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./assets/css/style-prefix.css">
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    /* Add these new styles for avatar upload */
    .avatar-upload-container {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .avatar-preview {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #eee;
    }

    .avatar-upload-btn {
        padding: 8px 15px;
        background: #f0f0f0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .avatar-upload-btn:hover {
        background: #e0e0e0;
    }

    .avatar-file-input {
        display: none;
    }
  .tracking-progress {
      margin-top: 20px;
    }
    
    .progress-steps {
      display: flex;
      justify-content: space-between;
      position: relative;
      margin-bottom: 30px;
    }
    
    .progress-steps::before {
      content: '';
      position: absolute;
      top: 15px;
      left: 0;
      right: 0;
      height: 4px;
      background: #e0e0e0;
      z-index: 1;
    }
    
    .progress-bar {
      position: absolute;
      top: 15px;
      left: 0;
      height: 4px;
      background: var(--salmon-pink);
      z-index: 2;
      transition: width 0.5s ease;
    }
    
    .step {
      display: flex;
      flex-direction: column;
      align-items: center;
      z-index: 3;
    }
    
    .step-icon {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: #e0e0e0;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 8px;
      color: white;
      font-weight: bold;
    }
    
    .step.active .step-icon {
      background: var(--salmon-pink);
    }
    
    .step.completed .step-icon {
      background: var(--salmon-pink);
    }
    
    .step.completed .step-icon::after {
      content: '✓';
    }
    
    .step-label {
      font-size: 12px;
      color: #757575;
      text-align: center;
    }
    
    .step.active .step-label,
    .step.completed .step-label {
      color: var(--eerie-black);
      font-weight: 500;
    }
    
    .tracking-details {
      margin-top: 20px;
      padding: 15px;
      background: #f5f5f5;
      border-radius: 8px;
    }
    
    .tracking-detail {
      display: flex;
      margin-bottom: 10px;
    }
    
    .tracking-time {
      width: 100px;
      color: #757575;
    }
    
    .tracking-event {
      flex: 1;
      font-weight: 500;
    }
    
    .tracking-status {
      font-weight: bold;
      margin-bottom: 15px;
      color: var(--salmon-pink);
    }
    
    .carrier-info {
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid #e0e0e0;
    }
    /* Profile Page Styles */
    .profile-container {
      padding: 30px 0;
    }

    .profile-content {
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .profile-section {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .profile-header {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 30px;
    }

    .profile-avatar {
      position: relative;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      overflow: hidden;
    }

    .profile-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .edit-avatar-btn {
      position: absolute;
      bottom: 0;
      right: 0;
      background: var(--salmon-pink);
      color: white;
      border: none;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .profile-info {
      flex: 1;
    }

    .profile-name {
      font-size: 24px;
      margin-bottom: 5px;
      color: var(--eerie-black);
    }

    .profile-email, .profile-phone {
      font-size: 14px;
      color: var(--davys-gray);
      margin-bottom: 5px;
    }

    .detail-item {
      margin-bottom: 20px;
    }

    .detail-title {
      font-size: 18px;
      color: var(--eerie-black);
      margin-bottom: 10px;
      padding-bottom: 5px;
      border-bottom: 1px solid var(--cultured);
    }

    .detail-content p {
      margin-bottom: 8px;
      color: var(--davys-gray);
    }

    .edit-btn {
      background: var(--salmon-pink);
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      margin-top: 10px;
      cursor: pointer;
      font-size: 14px;
    }

    .profile-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 30px;
    }

    .edit-profile-btn {
      background: var(--salmon-pink);
      color: white;
      border: none;
    }

    .change-password-btn {
      background: var(--sandy-brown);
      color: white;
      border: none;
    }

    .logout-btn {
      background: var(--bittersweet);
      color: white;
      border: none;
    }

    .order-history-section {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .section-title {
      font-size: 20px;
      margin-bottom: 20px;
      color: var(--eerie-black);
    }

    .order-card {
      border: 1px solid var(--cultured);
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
    }

    .order-header {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 1px solid var(--cultured);
    }

    .order-id, .order-date, .order-status {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 14px;
    }

    .order-id span, .order-date span, .order-status span {
      color: var(--davys-gray);
    }

    .order-status strong {
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 12px;
    }

    .status-shipped {
      background: #e1f5fe;
      color: #0288d1;
    }

    .status-delivered {
      background: #e8f5e9;
      color: #388e3c;
    }

    .order-items {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 15px;
    }

    .order-item {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .order-item img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 5px;
    }

    .item-details h4 {
      font-size: 15px;
      margin-bottom: 5px;
      color: var(--eerie-black);
    }

    .item-details p {
      font-size: 13px;
      color: var(--davys-gray);
      margin-bottom: 3px;
    }

    .order-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 10px;
      border-top: 1px solid var(--cultured);
    }

    .order-total {
      font-size: 16px;
    }

    .order-total strong {
      color: var(--salmon-pink);
    }

    .order-actions {
      display: flex;
      gap: 10px;
    }

    .track-order-btn, .view-details-btn {
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 13px;
      cursor: pointer;
    }

    .track-order-btn {
      background: var(--sandy-brown);
      color: white;
      border: none;
    }

    .view-details-btn {
      background: white;
      color: var(--eerie-black);
      border: 1px solid var(--cultured);
    }

    .view-all-orders {
      text-align: center;
      margin-top: 20px;
    }

    .view-all-btn {
      padding: 10px 20px;
      background: var(--salmon-pink);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    /* Alert Styles */
    .alert {
      position: fixed;
      top: 20px;
      right: 20px;
      min-width: 250px;
      padding: 15px 20px;
      border-radius: 5px;
      font-weight: 500;
      text-align: center;
      z-index: 9999;
      box-shadow: 0 2px 10px rgba(0,0,0,0.15);
      opacity: 0.95;
      transition: opacity 0.5s ease;
    }

    .success-alert {
      background-color: #4caf50;
      color: white;
    }

    .error-alert {
      background-color: #f44336;
      color: white;
    }

    /* Modal Styles */
    .modal {
      position: fixed;
      z-index: 1001;
      left: 0; 
      top: 0; 
      right: 0; 
      bottom: 0;
      background: rgba(0,0,0,0.5);
      display: flex; 
      justify-content: center; 
      align-items: center;
    }
    
    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 8px;
      max-width: 400px;
      width: 100%;
      position: relative;
    }
    
    .close-btn {
      position: absolute;
      top: 8px; 
      right: 12px;
      font-size: 24px;
      cursor: pointer;
    }
    
    .modal form label {
      display: block;
      margin-top: 10px;
    }
    
    .modal form input {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
    }
    
    .modal form button {
      margin-top: 20px;
      padding: 10px;
      width: 100%;
      background: #ff6b6b;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    
    .modal form button:hover {
      background: #e55a5a;
    }

    /* Responsive Styles */
    @media (min-width: 768px) {
      .profile-content {
        flex-direction: row;
      }
      
      .profile-section {
        flex: 1;
      }
      
      .order-history-section {
        flex: 2;
      }
    }

    @media (max-width: 767px) {
      .profile-header {
        flex-direction: column;
        text-align: center;
      }
      
      .order-header {
        flex-direction: column;
        gap: 8px;
      }
      
      .order-footer {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
      }
    }


/* Modal Styles */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  z-index: 1000;
  justify-content: center;
  align-items: center;
  overflow-y: auto;
}

.modal-content {
  background: white;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
  padding: 25px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  position: relative;
}

.close-btn {
  position: absolute;
  top: 15px;
  right: 20px;
  font-size: 24px;
  cursor: pointer;
  color: #666;
  transition: color 0.2s;
}

.close-btn:hover {
  color: #333;
}

.modal h2 {
  margin-top: 0;
  margin-bottom: 20px;
  color: #333;
  font-size: 22px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  color: #555;
}

.form-group input {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 15px;
}

.form-row {
  display: flex;
  gap: 15px;
}

.form-row .form-group {
  flex: 1;
}

.modal-submit-btn {
  width: 100%;
  padding: 12px;
  background: var(--salmon-pink);
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  margin-top: 10px;
  transition: background 0.2s;
}

.modal-submit-btn:hover {
  background: #ff6b6b;
}

.form-note {
  display: block;
  margin-top: 5px;
  font-size: 13px;
  color: #777;
}

.address-section {
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid #eee;
}

.address-section h3 {
  margin-top: 0;
  margin-bottom: 15px;
  font-size: 18px;
  color: #444;
}

/* Responsive adjustments */
@media (max-width: 480px) {
  .modal-content {
    width: 95%;
    padding: 20px 15px;
  }
  
  .form-row {
    flex-direction: column;
    gap: 0;
  }
}
.tracking-header {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.tracking-header h3 {
    margin-top: 0;
    color: #333;
}

.current-status {
    font-size: 16px;
    margin: 10px 0;
}

.status-badge {
    background: var(--salmon-pink);
    color: white;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 14px;
}

.tracking-event {
    display: flex;
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px dashed #eee;
}

.tracking-time {
    width: 100px;
    color: #666;
    font-size: 14px;
}

.tracking-description {
    flex: 1;
    font-weight: 500;
}

.carrier-info {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eee;
    font-size: 14px;
}

.carrier-info p {
    margin: 5px 0;
}

.tracking-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.tracking-actions .btn {
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

.contact-support {
    background: #4a90e2;
    color: white;
    border: none;
}

.report-issue {
    background: white;
    color: #e74c3c;
    border: 1px solid #e74c3c;
}
  </style>
</head>

<body>
  <!-- MAIN CONTENT -->
  <div class="overlay" data-overlay></div>
  <main>
    <div class="profile-container">
      <div class="container">
        <div class="profile-content">
          <!-- User Profile Section -->
          <div class="profile-section">
            <div class="profile-header">
              <div class="profile-avatar">
                <img src="<?php echo isset($user['avatar']) ? htmlspecialchars($user['avatar']) : './assets/images/profile-avatar.jpg'; ?>" alt="User Avatar" class="avatar-preview">
                <button class="edit-avatar-btn" onclick="document.getElementById('editProfileModal').style.display='flex'">
                  <ion-icon name="camera-outline"></ion-icon>
                </button>
              </div>
              <div class="profile-info">
                <h2 class="profile-name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h2>
                <p class="profile-email"><?php echo htmlspecialchars($user['email']); ?></p>
                <p class="profile-phone"><?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : 'N/A'; ?></p>
              </div>
            </div>

            <div class="profile-details">
              <div class="detail-item">
                <h3 class="detail-title">Account Information</h3>
                <div class="detail-content">
                  <p><strong>Member Since:</strong> <?php echo isset($user['created_at']) ? date('F j, Y', strtotime($user['created_at'])) : 'N/A'; ?></p>
                  <p><strong>Last Login:</strong> <?php echo isset($user['last_login']) ? date('F j, Y, g:i a', strtotime($user['last_login'])) : 'N/A'; ?></p>
                  <p><strong>Orders:</strong> <?php echo count($orders); ?></p>
                </div>
              </div>

              <div class="detail-item">
              <h3 class="detail-title">Shipping Address</h3>
              <div class="detail-content">
                <?php if (!empty($shipping_address)): ?>
                  <p><?php echo htmlspecialchars($shipping_address['address_line1'] ?? ''); ?></p>
                  <?php if (!empty($shipping_address['address_line2'])): ?>
                    <p><?php echo htmlspecialchars($shipping_address['address_line2']); ?></p>
                  <?php endif; ?>
                  <p><?php echo htmlspecialchars(
                    ($shipping_address['city'] ?? '') . ', ' . 
                    ($shipping_address['state'] ?? '') . ' ' . 
                    ($shipping_address['zip_code'] ?? '')
                  ); ?></p>
                  <p><?php echo htmlspecialchars($shipping_address['country'] ?? ''); ?></p>
                <?php else: ?>
                  <p>No shipping address saved</p>
                <?php endif; ?>
                <button class="edit-btn" onclick="openEditAddressModal()">Edit Address</button>
              </div>
            </div>

            <div class="detail-item">
              <h3 class="detail-title">Billing Address</h3>
              <div class="detail-content">
                <?php if (!empty($billing_address)): ?>
                  <p><?php echo htmlspecialchars($billing_address['address_line1'] ?? ''); ?></p>
                  <?php if (!empty($billing_address['address_line2'])): ?>
                    <p><?php echo htmlspecialchars($billing_address['address_line2']); ?></p>
                  <?php endif; ?>
                  <p><?php echo htmlspecialchars(
                    ($billing_address['city'] ?? '') . ', ' . 
                    ($billing_address['state'] ?? '') . ' ' . 
                    ($billing_address['zip_code'] ?? '')
                  ); ?></p>
                  <p><?php echo htmlspecialchars($billing_address['country'] ?? ''); ?></p>
                <?php else: ?>
                  <p>No billing address saved</p>
                <?php endif; ?>
                <button class="edit-btn" onclick="openEditAddressModal()">Edit Address</button>
              </div>
            </div>
            </div>

            <div class="profile-actions">
              <button class="action-btn edit-profile-btn">
                <ion-icon name="create-outline"></ion-icon>
                Edit Profile
              </button>
              <button class="action-btn change-password-btn">
                <ion-icon name="lock-closed-outline"></ion-icon>
                Change Password
              </button>
              <a href="logout.php" class="action-btn logout-btn">
                <ion-icon name="log-out-outline"></ion-icon>
                Logout
              </a>
            </div>
          </div>

          <!-- Order History Section -->
          <div class="order-history-section">
            <h2 class="section-title">Order History</h2>
            
            <?php if (count($orders) > 0): ?>
              <?php foreach ($orders as $order): 
                // Decode order shipping address
                $order_shipping_address = json_decode($order['shipping_address'], true);
              ?>
                <div class="order-card">
                  <div class="order-header">
                    <div class="order-id">
                      <span>Order #:</span>
                      <strong><?php echo htmlspecialchars($order['order_number']); ?></strong>
                    </div>
                    <div class="order-date">
                      <span>Date:</span>
                      <strong><?php echo date('F j, Y', strtotime($order['order_date'])); ?></strong>
                    </div>
                    <div class="order-status">
                      <span>Status:</span>
                      <strong class="status-<?php echo strtolower($order['tracking_status']); ?>">
                        <?php echo htmlspecialchars($order['tracking_status']); ?>
                      </strong>
                    </div>
                  </div>
                  
                  <div class="order-items">
                    <?php 
                    // Fetch order items
                    $stmt = $pdo->prepare("
                      SELECT oi.*, p.main_image
                      FROM order_items oi
                      LEFT JOIN products p ON oi.product_id = p.id
                      WHERE oi.order_id = ?
                    ");
                    $stmt->execute([$order['id']]);
                    $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($order_items as $item): ?>
                      <div class="order-item">
                        <img src="<?php echo htmlspecialchars($item['main_image']); ?>" 
                             alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                        <div class="item-details">
                          <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                          <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                          <p>₹<?php echo number_format($item['price'], 2); ?> each</p>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                  
                  <div class="order-footer">
                    <div class="order-total">
                      <span>Total:</span>
                      <strong>₹<?php echo number_format($order['total_amount'], 2); ?></strong>
                    </div>
                    <div class="order-actions">
                      <?php if ($order['tracking_number']): ?>
                        <?php if (!empty($order['tracking_url'])): ?>
                          <a href="<?php echo htmlspecialchars($order['tracking_url']); ?>" 
                             class="track-order-btn" target="_blank">
                            Track Order
                          </a>
                        <?php else: ?>
                          <button class="track-order-btn" 
        onclick="showTrackingInfo(
            '<?php echo $order['id']; ?>',
            '<?php echo htmlspecialchars($order['tracking_number']); ?>',
            '<?php echo htmlspecialchars($order['tracking_status']); ?>'
        )">
    Track Order
</button>
                        <?php endif; ?>
                      <?php endif; ?>
                      <a href="order_details.php?id=<?php echo $order['id']; ?>" class="view-details-btn">
                        View Details
                      </a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              
              <div class="view-all-orders">
                <a href="orders.php" class="view-all-btn">View All Orders</a>
              </div>
            <?php else: ?>
              <p>You haven't placed any orders yet.</p>
              <a href="products.php" class="btn btn-primary" style="margin-top: 15px;">
                Start Shopping
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

   <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert success-alert"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert error-alert"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Tracking Info Modal -->
    <div id="trackingInfoModal" class="modal" style="display:none;">
      <div class="modal-content">
        <span class="close-btn" onclick="closeModal('trackingInfoModal')">&times;</span>
        <h2>Tracking Information</h2>
        <div id="trackingInfoContent">
          <!-- Content will be inserted here by JavaScript -->
        </div>
      </div>
    </div>


    <!-- Edit Profile Modal -->
            <div id="editProfileModal" class="modal" style="display:none;">
              <div class="modal-content">
                <span class="close-btn" onclick="closeModal('editProfileModal')">&times;</span>
                <h2>Edit Profile</h2>
                <form id="editProfileForm" method="post" action="update_profile.php" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Profile Picture</label>
                    <div class="avatar-upload-container">
                      <img id="avatarPreview" src="<?php echo isset($user['avatar']) ? htmlspecialchars($user['avatar']) : './assets/images/profile-avatar.jpg'; ?>" 
                           class="avatar-preview">
                      <input type="file" name="avatar" id="avatarInput" accept="image/*" class="avatar-file-input">
                      <button type="button" onclick="document.getElementById('avatarInput').click()" 
                              class="avatar-upload-btn">
                        Change Photo
                      </button>
                    </div>
                    <small class="form-note">Max size: 2MB (JPEG, PNG, GIF, WEBP)</small>
                  </div>
                  
                  <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                  </div>
                  
                  <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                  </div>
                  
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required readonly>
                    <small class="form-note">Email cannot be changed</small>
                  </div>
                  
                  <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                  </div>
                  
                  <button type="submit" class="modal-submit-btn">Save Changes</button>
                </form>
              </div>
            </div>


<!-- Change Password Modal -->
<div id="changePasswordModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal('changePasswordModal')">&times;</span>
    <h2>Change Password</h2>
    <form id="changePasswordForm" method="post" action="change_password.php">
      <div class="form-group">
        <label>Current Password</label>
        <input type="password" name="current_password" required>
      </div>
      
      <div class="form-group">
        <label>New Password</label>
        <input type="password" name="new_password" required>
      </div>
      
      <div class="form-group">
        <label>Confirm New Password</label>
        <input type="password" name="confirm_new_password" required>
      </div>
      
      <button type="submit" class="modal-submit-btn">Change Password</button>
    </form>
  </div>
</div>

<!-- Edit Address Modal -->
<div id="editAddressModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal('editAddressModal')">&times;</span>
    <h2>Edit Addresses</h2>
    <form method="post" action="update-address.php">
      <!-- Shipping Address -->
      <div class="address-section">
        <h3>Shipping Address</h3>
        <div class="form-group">
          <input type="text" name="shipping_line1" placeholder="Address Line 1" value="<?= htmlspecialchars($shipping_address['address_line1'] ?? '') ?>">
        </div>
        <div class="form-group">
          <input type="text" name="shipping_line2" placeholder="Address Line 2" value="<?= htmlspecialchars($shipping_address['address_line2'] ?? '') ?>">
        </div>
        <div class="form-row">
          <div class="form-group">
            <input type="text" name="shipping_city" placeholder="City" value="<?= htmlspecialchars($shipping_address['city'] ?? '') ?>">
          </div>
          <div class="form-group">
            <input type="text" name="shipping_state" placeholder="State" value="<?= htmlspecialchars($shipping_address['state'] ?? '') ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <input type="text" name="shipping_zip" placeholder="ZIP Code" value="<?= htmlspecialchars($shipping_address['zip_code'] ?? '') ?>">
          </div>
          <div class="form-group">
            <input type="text" name="shipping_country" placeholder="Country" value="<?= htmlspecialchars($shipping_address['country'] ?? '') ?>">
          </div>
        </div>
      </div>

      <!-- Billing Address -->
      <div class="address-section">
        <h3>Billing Address</h3>
        <div class="form-group">
          <input type="text" name="billing_line1" placeholder="Address Line 1" value="<?= htmlspecialchars($billing_address['address_line1'] ?? '') ?>">
        </div>
        <div class="form-group">
          <input type="text" name="billing_line2" placeholder="Address Line 2" value="<?= htmlspecialchars($billing_address['address_line2'] ?? '') ?>">
        </div>
        <div class="form-row">
          <div class="form-group">
            <input type="text" name="billing_city" placeholder="City" value="<?= htmlspecialchars($billing_address['city'] ?? '') ?>">
          </div>
          <div class="form-group">
            <input type="text" name="billing_state" placeholder="State" value="<?= htmlspecialchars($billing_address['state'] ?? '') ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <input type="text" name="billing_zip" placeholder="ZIP Code" value="<?= htmlspecialchars($billing_address['zip_code'] ?? '') ?>">
          </div>
          <div class="form-group">
            <input type="text" name="billing_country" placeholder="Country" value="<?= htmlspecialchars($billing_address['country'] ?? '') ?>">
          </div>
        </div>
      </div>

      <button type="submit" class="modal-submit-btn">Save Changes</button>
    </form>
  </div>
</div>


    <script>
    // Image preview for avatar upload
      document.getElementById('avatarInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          // Client-side validation
          const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
          const maxSize = 2 * 1024 * 1024; // 2MB
          
          if (!allowedTypes.includes(file.type)) {
            alert('Only JPG, PNG, GIF, and WEBP images are allowed.');
            return;
          }
          
          if (file.size > maxSize) {
            alert('Image size must be less than 2MB.');
            return;
          }
          
          const reader = new FileReader();
          reader.onload = function(event) {
            document.getElementById('avatarPreview').src = event.target.result;
          };
          reader.readAsDataURL(file);
        }
      });
      // Close modal function
      function closeModal(id) {
        document.getElementById(id).style.display = 'none';
      }

      // Show tracking information with progress bar
    function showTrackingInfo(orderNumber, trackingNumber, currentStatus) {
    const modal = document.getElementById('trackingInfoModal');
    const content = document.getElementById('trackingInfoContent');
    
    // Status steps (in order)
    const statusSteps = [
        {id: 'Ordered', label: 'Order Placed'},
        {id: 'confirmed', label: 'Confirmed'},
        {id: 'packed', label: 'Packed'},
        {id: 'shipped', label: 'Shipped'},
        {id: 'out_for_delivery', label: 'Out for Delivery'},
        {id: 'delivered', label: 'Delivered'}
    ];
    
    // Find current step index
    let currentStepIndex = statusSteps.findIndex(step => step.id === currentStatus.toLowerCase());
    if (currentStepIndex === -1) currentStepIndex = 0;
    
    // Calculate progress percentage
    const progressPercent = (currentStepIndex / (statusSteps.length - 1)) * 100;
    
    // Generate HTML
    content.innerHTML = `
        <div class="tracking-header">
            <h3>Order #${orderNumber}</h3>
            <p><strong>Tracking Number:</strong> ${trackingNumber}</p>
            <p class="current-status">Current Status: <span class="status-badge">${statusSteps[currentStepIndex].label}</span></p>
        </div>
        
        <div class="tracking-progress">
            <div class="progress-steps">
                <div class="progress-bar" style="width: ${progressPercent}%"></div>
                
                ${statusSteps.map((step, index) => `
                    <div class="step ${index < currentStepIndex ? 'completed' : ''} ${index === currentStepIndex ? 'active' : ''}">
                        <div class="step-icon">${index + 1}</div>
                        <div class="step-label">${step.label}</div>
                    </div>
                `).join('')}
            </div>
        </div>
        
        <div class="tracking-details">
            <h4>Tracking History</h4>
            
            <div class="tracking-event">
                <div class="tracking-time">${new Date().toLocaleDateString()}</div>
                <div class="tracking-description">${statusSteps[currentStepIndex].label}</div>
            </div>
            
            ${currentStepIndex > 0 ? `
            <div class="tracking-event">
                <div class="tracking-time">${new Date(Date.now() - 86400000).toLocaleDateString()}</div>
                <div class="tracking-description">${statusSteps[currentStepIndex - 1].label}</div>
            </div>
            ` : ''}
            
            <div class="carrier-info">
                <p><strong>Carrier:</strong> Standard Shipping</p>
                <p><strong>Estimated Delivery:</strong> ${new Date(Date.now() + 3 * 86400000).toLocaleDateString()}</p>
            </div>
        </div>
        
        <div class="tracking-actions">
            <button class="btn contact-support">Contact Support</button>
            ${currentStatus.toLowerCase() !== 'delivered' ? 
                '<button class="btn report-issue">Report Issue</button>' : ''}
        </div>
    `;
    
    modal.style.display = 'flex';
}
      // Open edit address modal
      function openEditAddressModal() {
        document.getElementById('editAddressModal').style.display = 'flex';
      }


      // Open modals
      document.querySelector('.edit-profile-btn')?.addEventListener('click', function() {
        document.getElementById('editProfileModal').style.display = 'flex';
      });

      document.querySelector('.change-password-btn')?.addEventListener('click', function() {
        document.getElementById('changePasswordModal').style.display = 'flex';
      });

      // Auto-hide alerts
      window.addEventListener('DOMContentLoaded', () => {
        const alerts = document.querySelectorAll('.alert');
        
        alerts.forEach(alert => {
          setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
          }, 3000);
        });
      });
    </script>

  </main>

  <?php require_once 'footer.php'; ?>
  <!-- CUSTOM JS -->
<script src="./assets/js/script.js"></script>
</body>
</html>