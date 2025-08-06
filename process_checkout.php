<?php
// process_checkout.php

// 1. Initialize session and error handling
ob_start();
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Validate request method and CSRF token
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(['status' => 'error', 'message' => 'Invalid request method']));
}

if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die(json_encode(['status' => 'error', 'message' => 'CSRF token validation failed']));
}

// 3. Load dependencies
try {
    require __DIR__ . '/includes/db.php';
    require __DIR__ . '/includes/config.php';
    require __DIR__ . '/includes/vendor/autoload.php';
} catch (Exception $e) {
    die(json_encode([
        'status' => 'error', 
        'message' => 'System configuration error',
        'error' => $e->getMessage()
    ]));
}

// 4. Process checkout
try {
    // Validate user session
    if (empty($_SESSION['user_id'])) {
        throw new Exception("User not logged in");
    }
    $user_id = $_SESSION['user_id'];

    // Validate required fields
    $required_fields = ['first_name', 'last_name', 'email', 'phone', 'payment_method', 'shipping_method'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Validate payment method
    $allowed_payment_methods = ['upi', 'credit_card', 'paypal', 'cod'];
    if (!in_array($_POST['payment_method'], $allowed_payment_methods)) {
        throw new Exception("Invalid payment method selected");
    }

    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email address");
    }

    // Start database transaction
    $pdo->beginTransaction();

    try {
        // Get cart items with product details (locked for update)
        $stmt = $pdo->prepare("
            SELECT 
                c.id as cart_item_id, 
                p.id as product_id, 
                p.name as product_name,
                p.price,
                c.quantity,
                p.stock,
                IFNULL(p.tax_rate, 0) as tax_rate,
                IFNULL(p.discount_price, 0) as discount_rate
            FROM cart_items c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
            FOR UPDATE
        ");
        $stmt->execute([$user_id]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($cartItems)) {
            $pdo->rollBack();
            throw new Exception("Your cart is empty");
        }

        // Calculate order totals
        $subtotal = 0;
        $total_tax = 0;
        $total_discount = 0;
        
        foreach ($cartItems as &$item) {
            // Check stock
            if ($item['quantity'] > $item['stock']) {
                $pdo->rollBack();
                throw new Exception("Product '{$item['product_name']}' only has {$item['stock']} items available");
            }
            
            // Calculate line totals
            $item['line_total'] = $item['price'] * $item['quantity'];
            $item['tax_amount'] = $item['line_total'] * ($item['tax_rate'] / 100);
            $item['discount_amount'] = $item['line_total'] * ($item['discount_rate'] / 100);
            
            // Update order totals
            $subtotal += $item['line_total'];
            $total_tax += $item['tax_amount'];
            $total_discount += $item['discount_amount'];
        }

        // Apply coupon if valid
        $coupon_discount = 0;
        if (!empty($_POST['coupon_code']) && $_POST['coupon_code'] === 'DISCOUNT10') {
            $coupon_discount = $subtotal * 0.10;
            $total_discount += $coupon_discount;
        }

        // Calculate shipping
        $shipping_cost = 40.00; // Default
        if ($_POST['shipping_method'] === 'india_post_ems') {
            $shipping_cost = 60.00;
        } elseif ($_POST['shipping_method'] === 'dtdc') {
            $shipping_cost = 100.00;
        }

        // Calculate final total and convert to paise (integer)
        $grand_total_inr = $subtotal + $shipping_cost + $total_tax - $total_discount;
        $grand_total_paise = (int)round($grand_total_inr * 100);

        // Validate amount is positive integer
        if ($grand_total_paise <= 0) {
            $pdo->rollBack();
            throw new Exception("Invalid order amount");
        }

        // Generate order number and tracking number
        $order_number = 'ORD-' . strtoupper(uniqid());
        $tracking_number = 'TRK-' . strtoupper(bin2hex(random_bytes(8)));

        // Prepare address data
        $address_data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'] ?? '',
            'city' => $_POST['city'] ?? '',
            'state' => $_POST['state'] ?? '',
            'zip' => $_POST['zip'] ?? '',
            'country' => $_POST['country'] ?? 'India'
        ];

        // Handle Cash on Delivery differently
        if ($_POST['payment_method'] === 'cod') {
            // Create order record with payment_status = 'pending'
            $order_stmt = $pdo->prepare("
                INSERT INTO orders (
                    user_id, order_number, status, total_amount, 
                    payment_method, payment_status,
                    shipping_address, billing_address, shipping_method
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $order_stmt->execute([
                $user_id,
                $order_number,
                'processing', // For COD, we can set to processing immediately
                $grand_total_inr,
                $_POST['payment_method'],
                'pending',
                json_encode($address_data, JSON_UNESCAPED_UNICODE),
                json_encode($address_data, JSON_UNESCAPED_UNICODE),
                $_POST['shipping_method']
            ]);
            
            $order_id = $pdo->lastInsertId();
            
            // Store cart items as order items
            $order_item_stmt = $pdo->prepare("
                INSERT INTO order_items (
                    order_id, product_id, product_name, 
                    quantity, price, tax_amount, discount_amount
                ) VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            foreach ($cartItems as $item) {
                $order_item_stmt->execute([
                    $order_id,
                    $item['product_id'],
                    $item['product_name'],
                    $item['quantity'],
                    $item['price'],
                    $item['tax_amount'],
                    $item['discount_amount']
                ]);
                
                // Update product stock
                $update_stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                $update_stmt->execute([$item['quantity'], $item['product_id']]);
            }
            
            // Clear the cart
            $clear_cart_stmt = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?");
            $clear_cart_stmt->execute([$user_id]);
            
            // Create order tracking record
            $tracking_stmt = $pdo->prepare("
                INSERT INTO order_tracking (
                    order_id, tracking_number, status, estimated_delivery
                ) VALUES (?, ?, ?, ?)
            ");
            
            $delivery_date = date('Y-m-d', strtotime('+5 days'));
            $tracking_stmt->execute([
                $order_id,
                $tracking_number,
                'processing',
                $delivery_date
            ]);
            
            $pdo->commit();
            
            echo json_encode([
                'status' => 'success',
                'order_id' => $order_id,
                'order_number' => $order_number,
                'tracking_number' => $tracking_number,
                'redirect' => 'order_success.php?order_id=' . $order_id
            ]);
            exit();
        }

        // For online payments, create order with pending status
        $order_stmt = $pdo->prepare("
            INSERT INTO orders (
                user_id, order_number, status, total_amount, 
                payment_method, payment_status,
                shipping_address, billing_address, shipping_method
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $order_stmt->execute([
            $user_id,
            $order_number,
            'pending_payment', // Initial status
            $grand_total_inr, // Store in rupees
            $_POST['payment_method'],
            'pending',
            json_encode($address_data, JSON_UNESCAPED_UNICODE),
            json_encode($address_data, JSON_UNESCAPED_UNICODE),
            $_POST['shipping_method']
        ]);
        
        $order_id = $pdo->lastInsertId();
        
        // Store cart items as order items
        $order_item_stmt = $pdo->prepare("
            INSERT INTO order_items (
                order_id, product_id, product_name, 
                quantity, price, tax_amount, discount_amount
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($cartItems as $item) {
            $order_item_stmt->execute([
                $order_id,
                $item['product_id'],
                $item['product_name'],
                $item['quantity'],
                $item['price'],
                $item['tax_amount'],
                $item['discount_amount']
            ]);
        }

        // Create order tracking record (for online payments)
        $tracking_stmt = $pdo->prepare("
            INSERT INTO order_tracking (
                order_id, tracking_number, status, estimated_delivery
            ) VALUES (?, ?, ?, ?)
        ");
        
        $delivery_date = date('Y-m-d', strtotime('+5 days'));
        $tracking_stmt->execute([
            $order_id,
            $tracking_number,
            'payment_pending',
            $delivery_date
        ]);

        // Initialize Razorpay
        $api = new Razorpay\Api\Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

        // Create Razorpay order
        $razorpayOrder = $api->order->create([
            'receipt' => $order_number,
            'amount' => $grand_total_paise, // in paise (integer)
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        // Store necessary data in session for verification later
        $_SESSION['razorpay_order_id'] = $razorpayOrder->id;
        $_SESSION['db_order_id'] = $order_id;
        $_SESSION['razorpay_amount'] = $grand_total_paise;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['tracking_number'] = $tracking_number;

        // Prepare Razorpay checkout response
        $response = [
            'status' => 'razorpay_redirect',
            'order_id' => $order_id,
            'order_number' => $order_number,
            'tracking_number' => $tracking_number,
            'razorpay_order_id' => $razorpayOrder->id,
            'amount' => $grand_total_paise,
            'currency' => 'INR',
            'key' => RAZORPAY_KEY_ID,
            'name' => "Digital Media",
            'description' => "Order #$order_number",
            'prefill' => [
                'name' => $_POST['first_name'] . ' ' . $_POST['last_name'],
                'email' => $_POST['email'],
                'contact' => $_POST['phone']
            ],
            'method' => ($_POST['payment_method'] === 'upi') ? 'upi' : 'card',
            'callback_url' => 'payment_verify.php?order_id=' . $order_id
        ];

        // Commit the transaction since we've stored all necessary data
        $pdo->commit();

        // Return the response
        echo json_encode($response);
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }

} catch (Exception $e) {
    // Ensure no output has been sent
    if (ob_get_level() > 0) {
        ob_end_clean();
    }
    
    error_log('Checkout Error: ' . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Checkout failed: ' . $e->getMessage()
    ]);
    exit();
}