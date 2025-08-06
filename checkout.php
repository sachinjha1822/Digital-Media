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
// Include configuration
require_once __DIR__ . '/includes/config.php';

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Set page title
$pageTitle = 'Checkout - Digital Media';

// Include header
include('header.php');

$user_id = $_SESSION['user_id'];

// Fetch cart items from database
$stmt = $pdo->prepare("
    SELECT c.id AS cart_id, c.quantity, p.id AS product_id, p.name, p.price, p.main_image
    FROM cart_items c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate subtotal
$subtotal = array_reduce($cartItems, function($carry, $item) {
    return $carry + ($item['price'] * $item['quantity']);
}, 0);

// Default shipping cost
$shippingCost = 40.00;
$taxRate = 0.00; // 0% tax
$discount = 0.00;

// Calculate total
$total = $subtotal + $shippingCost + ($subtotal * $taxRate) - $discount;

// Get user details if available
$userDetails = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT first_name, last_name, email, phone FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Display errors if they exist
$errorHtml = '';
if (isset($_SESSION['checkout_errors'])) {
    $errorHtml = '<div class="alert alert-danger">';
    foreach ($_SESSION['checkout_errors'] as $error) {
        $errorHtml .= htmlspecialchars($error) . '<br>';
    }
    $errorHtml .= '</div>';
    unset($_SESSION['checkout_errors']);
}
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
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <style>
    .checkout-container {
        padding: 40px 0;
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    @media (max-width: 991px) {
        .checkout-container {
            grid-template-columns: 1fr;
            padding: 20px;
        }
        
        .order-summary {
            order: 2;
            margin-top: 30px;
        }
        
        .checkout-form {
            order: 1;
        }
    }

    .checkout-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--eerie-black);
        display: flex;
        align-items: center;
    }

    .checkout-title ion-icon {
        margin-right: 10px;
        color: var(--salmon-pink);
    }

    .checkout-section {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .section-title ion-icon {
        margin-right: 8px;
        color: var(--salmon-pink);
        font-size: 18px;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--cultured);
        border-radius: 4px;
        font-size: 14px;
        transition: var(--transition-timing);
    }

    .form-control:focus {
        border-color: var(--salmon-pink);
        outline: none;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
    }

    @media (min-width: 768px) {
        .form-row {
            grid-template-columns: 1fr 1fr;
        }
    }

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        margin-bottom: 15px;
    }

    .payment-method {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 12px;
        border: 1px solid var(--cultured);
        border-radius: 4px;
        cursor: pointer;
        transition: var(--transition-timing);
        text-align: center;
        min-height: 80px;
        justify-content: center;
    }

    .payment-method:hover {
        border-color: var(--salmon-pink);
    }

    .payment-method.active {
        border-color: var(--salmon-pink);
        background-color: rgba(255, 111, 97, 0.05);
    }

    .payment-method input {
        margin-bottom: 8px;
    }

    .payment-method-icon {
        font-size: 20px;
        color: var(--salmon-pink);
        margin-bottom: 5px;
    }

    .payment-method-label {
        font-weight: 500;
        font-size: 13px;
    }

    .shipping-methods {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 10px;
        margin-top: 15px;
    }

    .shipping-method {
        display: flex;
        flex-direction: column;
        padding: 12px;
        border: 1px solid var(--cultured);
        border-radius: 4px;
        cursor: pointer;
        transition: var(--transition-timing);
    }

    .shipping-method:hover {
        border-color: var(--salmon-pink);
    }

    .shipping-method.active {
        border-color: var(--salmon-pink);
        background-color: rgba(255, 111, 97, 0.05);
    }

    .shipping-method input {
        margin-right: 8px;
    }

    .shipping-method-info {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .shipping-method-icon {
        margin-right: 8px;
        font-size: 18px;
        color: var(--salmon-pink);
    }

    .shipping-method-name {
        font-weight: 500;
        font-size: 13px;
    }

    .shipping-method-price {
        font-weight: 600;
        color: var(--salmon-pink);
        font-size: 14px;
        text-align: right;
    }

    .delivery-time {
        font-size: 11px;
        color: #666;
        margin-top: 3px;
    }

    .order-summary {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        position: sticky;
        top: 20px;
        height: fit-content;
    }

    .summary-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .summary-title ion-icon {
        margin-right: 8px;
        color: var(--salmon-pink);
        font-size: 18px;
    }

    .summary-items {
        max-height: 200px;
        overflow-y: auto;
        margin-bottom: 15px;
        border-bottom: 1px solid var(--cultured);
        padding-bottom: 15px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 13px;
    }
    .summary-total-item.discount {
        color: var(--salmon-pink);
    }

    .summary-item-name {
        display: flex;
        align-items: center;
    }

    .summary-item-name ion-icon {
        margin-right: 6px;
        font-size: 14px;
        color: var(--salmon-pink);
    }

    .summary-price {
        font-weight: 500;
    }

    .summary-totals {
        margin-top: 10px;
    }

    .summary-total-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .summary-total {
        font-weight: 600;
        font-size: 16px;
        border-top: 1px solid var(--cultured);
        padding-top: 12px;
        margin-top: 12px;
    }

    .checkout-btn {
        width: 100%;
        padding: 12px;
        background-color: var(--salmon-pink);
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 15px;
        transition: var(--transition-timing);
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .checkout-btn ion-icon {
        margin-left: 8px;
    }

    .checkout-btn:hover {
        background-color: var(--eerie-black);
    }

    .back-to-cart {
        display: inline-flex;
        align-items: center;
        margin-top: 15px;
        color: var(--salmon-pink);
        font-weight: 500;
        text-decoration: none;
        font-size: 14px;
        transition: var(--transition-timing);
    }

    .back-to-cart:hover {
        color: var(--eerie-black);
    }

    .back-to-cart ion-icon {
        margin-right: 6px;
    }
    
    .secure-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 15px;
        color: var(--salmon-pink);
        font-size: 12px;
    }
    
    .secure-checkout ion-icon {
        margin-right: 5px;
    }

    .credit-card-form {
        margin-top: 15px;
        padding: 15px;
        background-color: rgba(255, 111, 97, 0.05);
        border-radius: 8px;
        border: 1px dashed var(--salmon-pink);
    }

    .coupon-code {
        display: flex;
        margin-top: 15px;
    }

    .coupon-code input {
        flex: 1;
        padding: 10px 12px;
        border: 1px solid var(--cultured);
        border-radius: 4px 0 0 4px;
        font-size: 13px;
    }

    .coupon-code button {
        padding: 10px 15px;
        background-color: var(--salmon-pink);
        color: white;
        border: none;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
        font-weight: 500;
        font-size: 13px;
    }

    .coupon-code button:hover {
        background-color: var(--eerie-black);
    }
    /* Previous styles remain the same */
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    
    .spinner {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        vertical-align: middle;
        border: 0.2em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border 0.75s linear infinite;
        margin-left: 0.5rem;
    }
    
    @keyframes spinner-border {
        to { transform: rotate(360deg); }
    }
    
    .form-label.required:after {
        content: " *";
        color: red;
    }
    
    button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
</style>
</head>

<body>

  <div class="overlay" data-overlay></div>

  <!-- CHECKOUT MAIN CONTENT -->
  <main>
    <div class="container">
      <div class="checkout-container">
        <!-- Checkout Form -->
        <div class="checkout-form">
          <h1 class="checkout-title">
            <ion-icon name="cart-outline"></ion-icon>
            Checkout
          </h1>
          
          <?php echo $errorHtml; ?>
          
          <form id="checkout-form">
              <?php echo '<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">';?>
              
          <!-- Billing Address Section -->
          <div class="checkout-section">
            <h2 class="section-title">
              <ion-icon name="location-outline"></ion-icon>
              Billing Address
            </h2>
            
              <div class="form-row">
                <div class="form-group">
                  <label for="first-name" class="form-label required">First Name</label>
                  <input type="text" id="first-name" name="first_name" class="form-control" required
                    value="<?php echo isset($userDetails['first_name']) ? htmlspecialchars($userDetails['first_name']) : ''; ?>">
                </div>
                
                <div class="form-group">
                  <label for="last-name" class="form-label required">Last Name</label>
                  <input type="text" id="last-name" name="last_name" class="form-control" required
                    value="<?php echo isset($userDetails['last_name']) ? htmlspecialchars($userDetails['last_name']) : ''; ?>">
                </div>
              </div>
              
              <div class="form-group">
                <label for="email" class="form-label required">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required
                  value="<?php echo isset($userDetails['email']) ? htmlspecialchars($userDetails['email']) : ''; ?>">
              </div>
              
              <div class="form-group">
                <label for="phone" class="form-label required">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="form-control" required
                  value="<?php echo isset($userDetails['phone']) ? htmlspecialchars($userDetails['phone']) : ''; ?>">
              </div>
              
              <div class="form-group">
                <label for="address" class="form-label required">Street Address</label>
                <input type="text" id="address" name="address" class="form-control" required>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="city" class="form-label required">City</label>
                  <input type="text" id="city" name="city" class="form-control" required>
                </div>
                
                <div class="form-group">
                  <label for="state" class="form-label required">State</label>
                  <input type="text" id="state" name="state" class="form-control" required>
                </div>
              </div>
              
              <div class="form-row">
                <div class="form-group">
                  <label for="zip" class="form-label required">ZIP Code</label>
                  <input type="text" id="zip" name="zip" class="form-control" required>
                </div>
                
                <div class="form-group">
                  <label for="country" class="form-label required">Country</label>
                  <select id="country" name="country" class="form-control" required>
                    <option value="">Select Country</option>
                    <option value="IN" selected>India</option>
                    <option value="US">United States</option>
                    <option value="UK">United Kingdom</option>
                    <option value="CA">Canada</option>
                  </select>
                </div>
              </div>
          </div>
          
          <!-- Shipping Method Section -->
          <div class="checkout-section">
            <h2 class="section-title">
              <ion-icon name="rocket-outline"></ion-icon>
              Shipping Method
            </h2>
            
            <div class="shipping-methods">
              <label class="shipping-method active">
                <input type="radio" name="shipping_method" value="india_post" checked>
                <div class="shipping-method-info">
                  <ion-icon name="mail-outline" class="shipping-method-icon"></ion-icon>
                  <span class="shipping-method-name">India Post Register</span>
                </div>
                <div class="delivery-time">5-7 business days</div>
                <div class="shipping-method-price">₹40.00</div>
              </label>
              
              <label class="shipping-method">
                <input type="radio" name="shipping_method" value="india_post_ems">
                <div class="shipping-method-info">
                  <ion-icon name="flash-outline" class="shipping-method-icon"></ion-icon>
                  <span class="shipping-method-name">India Post EMS</span>
                </div>
                <div class="delivery-time">2-3 business days</div>
                <div class="shipping-method-price">₹60.00</div>
              </label>
              
              <label class="shipping-method">
                <input type="radio" name="shipping_method" value="dtdc">
                <div class="shipping-method-info">
                  <ion-icon name="car-outline" class="shipping-method-icon"></ion-icon>
                  <span class="shipping-method-name">DTDC Courier</span>
                </div>
                <div class="delivery-time">3-5 business days</div>
                <div class="shipping-method-price">₹100.00</div>
              </label>
            </div>
          </div>
          
          <!-- Payment Method Section -->
          <div class="checkout-section">
            <h2 class="section-title">
              <ion-icon name="card-outline"></ion-icon>
              Payment Method
            </h2>

            <div class="payment-methods">
              <label class="payment-method active">
                <input type="radio" name="payment_method" value="credit_card" checked>
                <ion-icon name="card-outline" class="payment-method-icon"></ion-icon>
                <span class="payment-method-label">Credit/Debit Card</span>
              </label>

              <label class="payment-method">
                <input type="radio" name="payment_method" value="upi">
                <ion-icon name="wallet-outline" class="payment-method-icon"></ion-icon>
                <span class="payment-method-label">UPI Payment</span>
              </label>

              <label class="payment-method">
                <input type="radio" name="payment_method" value="cod">
                <ion-icon name="cash-outline" class="payment-method-icon"></ion-icon>
                <span class="payment-method-label">Cash on Delivery</span>
              </label>

              <label class="payment-method">
                <input type="radio" name="payment_method" value="paypal">
                <ion-icon name="logo-paypal" class="payment-method-icon"></ion-icon>
                <span class="payment-method-label">PayPal</span>
              </label>
            </div>
            
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
            <input type="hidden" name="razorpay_signature" id="razorpay_signature">

            <!-- Credit Card Form -->
            <div class="credit-card-form">
              <div class="form-group">
                <label for="card-number" class="form-label required">Card Number</label>
                <input type="text" id="card-number" name="card_number" class="form-control" placeholder="1234 5678 9012 3456">
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="card-expiry" class="form-label required">Expiry Date</label>
                  <input type="text" id="card-expiry" name="card_expiry" class="form-control" placeholder="MM/YY">
                </div>

                <div class="form-group">
                  <label for="card-cvv" class="form-label required">CVV</label>
                  <input type="text" id="card-cvv" name="card_cvv" class="form-control" placeholder="123">
                </div>
              </div>

              <div class="form-group">
                <label for="card-name" class="form-label required">Name on Card</label>
                <input type="text" id="card-name" name="card_name" class="form-control" placeholder="John Doe">
              </div>
            </div>
          </div>
          
          <a href="cart.php" class="back-to-cart">
            <ion-icon name="arrow-back-outline"></ion-icon>
            Back to Cart
          </a>
        </div>
        
        <!-- Order Summary -->
        <div class="order-summary">
          <h2 class="summary-title">
            <ion-icon name="receipt-outline"></ion-icon>
            Order Summary
          </h2>
          
          <div class="summary-items">
            <?php foreach ($cartItems as $item): ?>
            <div class="summary-item">
              <div class="summary-item-name">
                <ion-icon name="<?php 
                  if (stripos($item['name'], 'card') !== false) {
                    echo 'card-outline';
                  } elseif (stripos($item['name'], 'shirt') !== false || stripos($item['name'], 't-shirt') !== false) {
                    echo 'shirt-outline';
                  } elseif (stripos($item['name'], 'invitation') !== false) {
                    echo 'mail-open-outline';
                  } else {
                    echo 'cube-outline';
                  }
                ?>"></ion-icon>
                <span><?php echo htmlspecialchars($item['name']); ?> x<?php echo $item['quantity']; ?></span>
              </div>
              <span class="summary-price">₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
            </div>
            <?php endforeach; ?>
          </div>
          
          <div class="summary-totals">
            <div class="summary-total-item">
              <span>Subtotal</span>
              <span>₹<?php echo number_format($subtotal, 2); ?></span>
            </div>
            
            <div class="summary-total-item">
              <span>Shipping</span>
              <span>₹<?php echo number_format($shippingCost, 2); ?></span>
            </div>
            
            <div class="summary-total-item">
              <span>Tax (<?php echo ($taxRate * 100); ?>%)</span>
              <span>₹<?php echo number_format($subtotal * $taxRate, 2); ?></span>
            </div>
            
            <?php if ($discount > 0): ?>
            <div class="summary-total-item discount">
              <span>Discount</span>
              <span>-₹<?php echo number_format($discount, 2); ?></span>
            </div>
            <?php endif; ?>
            
            <div class="summary-total-item summary-total">
              <span>Total</span>
              <span>₹<?php echo number_format($total, 2); ?></span>
            </div>
          </div>
          
          <div class="coupon-code">
            <input type="text" name="coupon_code" placeholder="Enter coupon code">
            <button type="button" id="apply-coupon">Apply</button>
          </div>
          
          <button type="submit" class="checkout-btn" id="submit-btn">
            Place Order
            <ion-icon name="lock-closed-outline"></ion-icon>
          </button>
          </form>
          
          <div class="secure-checkout">
            <ion-icon name="shield-checkmark-outline"></ion-icon>
            <span>100% Secure Checkout</span>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <?php include('footer.php'); ?>

  <!-- Razorpay Integration -->
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

  <!-- IONICONS -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Payment method selection
    const paymentMethods = document.querySelectorAll('.payment-method');
    const shippingMethods = document.querySelectorAll('.shipping-method');
    const couponButton = document.getElementById('apply-coupon');
    const creditCardForm = document.querySelector('.credit-card-form');
    const checkoutForm = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('submit-btn');
    const originalBtnText = submitBtn.innerHTML;
    
    // Payment method selection
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            paymentMethods.forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            
            // Show credit card form only for card payment
            if (this.querySelector('input').value === 'credit_card') {
                creditCardForm.style.display = 'block';
            } else {
                creditCardForm.style.display = 'none';
            }
        });
    });
    
    // Shipping method selection
    shippingMethods.forEach(method => {
        method.addEventListener('click', function() {
            shippingMethods.forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            
            // Get the shipping price from the method
            const priceText = this.querySelector('.shipping-method-price').textContent;
            const price = parseFloat(priceText.replace(/[^\d.]/g, ''));
            updateShippingCost(price);
        });
    });
    
    // Coupon code application
    if (couponButton) {
        couponButton.addEventListener('click', function() {
            const couponCode = document.querySelector('input[name="coupon_code"]').value.trim();
            if (couponCode === 'DISCOUNT10') {
                alert('Coupon applied successfully! 10% discount added.');
                updateOrderTotal();
            } else {
                alert('Invalid coupon code');
            }
        });
    }
    
    // Form submission handler
    checkoutForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Processing <span class="spinner"></span>';
            
            // Validate form
            if (!validateForm()) {
                throw new Error('Please fill all required fields');
            }
            
            // Prepare form data
            const formData = new FormData(checkoutForm);
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            formData.append('payment_method', paymentMethod);
            
            // Submit to server
            const response = await fetch('process_checkout.php', {
                method: 'POST',
                body: formData
            });
            
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                throw new Error(`Server returned invalid response: ${text.substring(0, 100)}`);
            }
            
            const data = await response.json();
            
            // Handle response
            if (data.status === 'success') {
                window.location.href = `order_success.php?order_id=${data.order_id}`;
            } 
            else if (data.status === 'razorpay_redirect') {
                await handleRazorpayPayment(data);
            }
            else if (data.status === 'upi_redirect') {
                await handleUpiPayment(data);
            }
            else if (data.status === 'paypal_redirect') {
                window.location.href = data.approval_url;
            } 
            else {
                throw new Error(data.message || 'Unknown response from server');
            }
        } catch (error) {
            console.error('Checkout Error:', error);
            alert(`Error: ${error.message}`);
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });
    
    // Update shipping cost in order summary
    function updateShippingCost(cost) {
        const shippingItems = document.querySelectorAll('.summary-total-item');
        
        shippingItems.forEach(item => {
            if (item.textContent.includes('Shipping')) {
                item.querySelector('span:last-child').textContent = '₹' + cost.toFixed(2);
                updateOrderTotal();
            }
        });
    }
    
    // Update order total
    function updateOrderTotal() {
        let subtotal = <?php echo $subtotal; ?>;
        let shippingCost = 0;
        let discount = 0;
        
        // Get current shipping cost
        const shippingItems = document.querySelectorAll('.summary-total-item');
        shippingItems.forEach(item => {
            if (item.textContent.includes('Shipping')) {
                const costText = item.querySelector('span:last-child').textContent;
                shippingCost = parseFloat(costText.replace(/[^\d.]/g, ''));
            }
        });
        
        // Check for discount
        const couponCode = document.querySelector('input[name="coupon_code"]').value.trim();
        if (couponCode === 'DISCOUNT10') {
            discount = subtotal * 0.10;
            // Update discount display
            let discountElement = document.querySelector('.summary-total-item.discount');
            if (!discountElement) {
                discountElement = document.createElement('div');
                discountElement.className = 'summary-total-item discount';
                discountElement.innerHTML = '<span>Discount (10%)</span><span>-₹' + discount.toFixed(2) + '</span>';
                const shippingElement = document.querySelector('.summary-total-item:nth-child(2)');
                shippingElement.after(discountElement);
            } else {
                discountElement.querySelector('span:last-child').textContent = '-₹' + discount.toFixed(2);
            }
        } else {
            // Remove discount if coupon is invalid
            const discountElement = document.querySelector('.summary-total-item.discount');
            if (discountElement) {
                discountElement.remove();
            }
        }
        
        const tax = subtotal * <?php echo $taxRate; ?>;
        const total = subtotal + shippingCost + tax - discount;
        
        // Update total display
        document.querySelector('.summary-total span:last-child').textContent = '₹' + total.toFixed(2);
    }
    
    // Handle Razorpay payment
    async function handleRazorpayPayment(data) {
        return new Promise((resolve, reject) => {
            const options = {
                key: data.key,
                amount: data.amount,
                currency: data.currency,
                order_id: data.razorpay_order_id,
                name: "Digital Media",
                description: `Order #${data.order_id}`,
                handler: function(response) {
                    // Store payment details in hidden fields
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                    
                    // Create verification flag
                    const verifiedInput = document.createElement('input');
                    verifiedInput.type = 'hidden';
                    verifiedInput.name = 'payment_verified';
                    verifiedInput.value = '1';
                    checkoutForm.appendChild(verifiedInput);
                    
                    // Submit form to complete checkout
                    checkoutForm.submit();
                    resolve();
                },
                prefill: data.prefill || {
                    name: "<?php echo htmlspecialchars($userDetails['first_name'] . ' ' . $userDetails['last_name']); ?>",
                    email: "<?php echo htmlspecialchars($userDetails['email']); ?>",
                    contact: "<?php echo htmlspecialchars($userDetails['phone']); ?>"
                },
                theme: {
                    color: "#F37254"
                },
                method: {
                    upi: data.method === 'upi',
                    card: data.method !== 'upi'
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();
            
            rzp.on('payment.failed', function(response) {
                reject(new Error(response.error.description || 'Payment failed. Please try again.'));
            });
        });
    }
    
    // Handle UPI payment
    async function handleUpiPayment(data) {
        return new Promise((resolve, reject) => {
            // In a real implementation, you would integrate with a UPI SDK here
            // For demonstration, we'll show a confirmation dialog
            
            const upiId = prompt(`Please enter your UPI ID to pay ₹${data.amount}\n\nExample: 1234567890@upi`, '');
            
            if (upiId) {
                // Simulate successful UPI payment
                setTimeout(() => {
                    // Create hidden fields with payment details
                    const upiInput = document.createElement('input');
                    upiInput.type = 'hidden';
                    upiInput.name = 'upi_payment_id';
                    upiInput.value = 'UPI' + Date.now();
                    checkoutForm.appendChild(upiInput);
                    
                    const verifiedInput = document.createElement('input');
                    verifiedInput.type = 'hidden';
                    verifiedInput.name = 'payment_verified';
                    verifiedInput.value = '1';
                    checkoutForm.appendChild(verifiedInput);
                    
                    // Submit form to complete checkout
                    checkoutForm.submit();
                    resolve();
                }, 2000);
            } else {
                reject(new Error('UPI payment cancelled'));
            }
        });
    }
    
    // Form validation
    function validateForm() {
        let isValid = true;
        
        // Validate required fields
        document.querySelectorAll('[required]').forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = 'red';
                isValid = false;
            } else {
                field.style.borderColor = '';
            }
        });
        
        // Validate credit card if selected
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        if (paymentMethod === 'credit_card') {
            const cardNumber = document.getElementById('card-number').value.replace(/\s/g, '');
            const cardExpiry = document.getElementById('card-expiry').value;
            const cardCvv = document.getElementById('card-cvv').value;
            
            if (!/^\d{12,19}$/.test(cardNumber)) {
                alert('Please enter a valid card number');
                isValid = false;
            }
            
            if (!/^\d{2}\/\d{2}$/.test(cardExpiry)) {
                alert('Please enter a valid expiry date (MM/YY)');
                isValid = false;
            }
            
            if (!/^\d{3,4}$/.test(cardCvv)) {
                alert('Please enter a valid CVV');
                isValid = false;
            }
        }
        
        return isValid;
    }
});
  </script>
  <!-- CUSTOM JS -->
<script src="./assets/js/script.js"></script>
</body>
</html>