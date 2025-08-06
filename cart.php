<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle AJAX actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    try {
        switch ($_POST['action']) {
            case 'update_quantity':
                $cart_id = $_POST['cart_id'];
                $quantity = (int)$_POST['quantity'];
                if ($quantity < 1) throw new Exception('Quantity must be at least 1');
                $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ? AND user_id = ?");
                $stmt->execute([$quantity, $cart_id, $user_id]);
                echo json_encode(['success' => true]);
                exit();
            case 'remove_item':
                $cart_id = $_POST['cart_id'];
                $stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = ? AND user_id = ?");
                $stmt->execute([$cart_id, $user_id]);
                echo json_encode(['success' => true]);
                exit();
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit();
    }
}

// Get cart items with product details
$stmt = $pdo->prepare("
    SELECT c.id AS cart_id, c.quantity, p.id AS product_id, p.name, p.price, p.main_image, 
           (p.price * c.quantity) AS subtotal,
           c.front_file, c.back_file, c.finish_type, c.corner_style, c.hologram
    FROM cart_items c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate totals (without tax - tax will be calculated in checkout)
$subtotal = array_sum(array_column($cartItems, 'subtotal'));
$total = $subtotal; // No tax in cart, will be added in checkout
?>

<?php require_once 'header.php'; ?>

<!-- CART MAIN CONTENT -->
<div class="overlay" data-overlay></div>
<main>
  <div class="container cart-container">
    <h1 class="cart-title">Your Shopping Cart</h1>
    <div class="cart-content">
    <?php if (count($cartItems) > 0): ?>
      <table class="cart-table">
        <thead>
          <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr>
        </thead>
        <tbody>
          <?php foreach ($cartItems as $item): ?>
          <tr data-cart-id="<?= $item['cart_id'] ?>">
            <td>
              <img src="<?= htmlspecialchars($item['main_image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="80">
              <?= htmlspecialchars($item['name']) ?>
              <?php if ($item['front_file'] || $item['back_file']): ?>
                <div class="printing-options">
                  <small>Finish: <?= ucfirst($item['finish_type']) ?></small><br>
                  <small>Corners: <?= ucfirst(str_replace('-', ' ', $item['corner_style'])) ?></small><br>
                  <small>Hologram: <?= ucfirst($item['hologram']) ?></small><br>
                </div>
              <?php endif; ?>
            </td>
            <td>₹<?= number_format($item['price'], 2) ?></td>
            <td>
              <button class="quantity-btn minus">-</button>
              <input type="number" class="quantity-input" min="1" value="<?= $item['quantity'] ?>" data-cart-id="<?= $item['cart_id'] ?>" style="width:50px;">
              <button class="quantity-btn plus">+</button>
            </td>
            <td class="subtotal">₹<?= number_format($item['subtotal'], 2) ?></td>
            <td><button class="remove-btn" data-cart-id="<?= $item['cart_id'] ?>">Remove</button></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="cart-summary">
    <p>Subtotal: ₹<?= number_format($subtotal, 2) ?></p>
    <p><strong>Total: ₹<?= number_format($total, 2) ?></strong></p>
    <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
</div>
<?php else: ?>
      <div class="empty-cart">
        <div class="empty-cart-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="10" cy="20.5" r="1"/><circle cx="18" cy="20.5" r="1"/>
            <path d="M2.5 2.5h3l2.7 12.4a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6l1.6-8.4H7.1"/>
          </svg>
        </div>
        <h2 class="empty-cart-title">Your cart is empty</h2>
        <p class="empty-cart-text">Looks like you haven't added anything to your cart yet</p>
        <a href="products.php" class="empty-cart-btn">Browse Products</a>
      </div>
    <?php endif; ?>
    </div>
  </div>
</main>

<style>
.cart-container {
    padding: 2rem 1rem;
    max-width: 1200px;
    margin: 0 auto;
}

.cart-title {
    font-size: 2rem;
    margin-bottom: 2rem;
    text-align: center;
    color: #333;
    text-align: center;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 2rem;
}

.cart-table th {
    text-align: left;
    padding: 1rem;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.cart-table td {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
    vertical-align: middle;
}

.product-info {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.product-info img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
}

.product-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.printing-options {
    margin-top: 0.5rem;
    font-size: 0.9rem;
    color: #666;
}

.printing-option {
    margin-bottom: 0.3rem;
}

.design-preview {
    margin-top: 0.5rem;
}

.design-preview img {
    max-width: 100px;
    max-height: 100px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.quantity-control {
    display: flex;
    align-items: center;
}

.quantity-btn {
    width: 30px;
    height: 30px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    cursor: pointer;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-input {
    width: 50px;
    height: 30px;
    text-align: center;
    margin: 0 5px;
    border: 1px solid #dee2e6;
}

.remove-btn {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    font-size: 1.2rem;
}

.remove-btn:hover {
    color: #c82333;
}

.cart-actions {
    display: flex;
    justify-content: space-between;
    margin-bottom: 2rem;
}

.continue-shopping {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #007bff;
    text-decoration: none;
}

.continue-shopping:hover {
    text-decoration: underline;
}

.clear-cart-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
}

.clear-cart-btn:hover {
    background: #c82333;
}

.cart-summary {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 4px;
}

.summary-title {
    margin-top: 0;
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.summary-total {
    font-weight: bold;
    font-size: 1.1rem;
    border-bottom: none;
    margin-bottom: 1.5rem;
}

.checkout-btn {
    display: block;
    width: 100%;
    padding: 0.75rem;
    background: #28a745;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
}

.checkout-btn:hover {
    background: #218838;
}
.empty-cart {
  text-align: center;
  padding: 80px 20px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  margin: 20px 0;
}

.empty-cart-icon {
  margin-bottom: 20px;
  color: #ddd;
}

.empty-cart-icon svg {
  width: 80px;
  height: 80px;
}

.empty-cart-title {
  font-size: 24px;
  margin-bottom: 10px;
  color: #333;
}

.empty-cart-text {
  color: #777;
  margin-bottom: 25px;
  font-size: 16px;
}

.empty-cart-btn {
  display: inline-block;
  padding: 12px 30px;
  background-color: #28a745;
  color: white;
  text-decoration: none;
  border-radius: 4px;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

.empty-cart-btn:hover {
  background-color: #218838;
}

@media (max-width: 768px) {
    .cart-table thead {
        display: none;
    }
    
    .cart-table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }
    
    .cart-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 1rem;
        border-bottom: none;
    }
    
    .cart-table td::before {
        content: attr(data-label);
        font-weight: bold;
        margin-right: 1rem;
    }
    
    .product-info {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .quantity-control {
        justify-content: flex-end;
    }
    
    .cart-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .continue-shopping, .clear-cart-btn {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Update quantity buttons
  document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.parentElement.querySelector('.quantity-input');
      let val = parseInt(input.value);
      if (btn.classList.contains('plus')) val++;
      else if (val > 1) val--;
      input.value = val;
      updateQuantity(input.dataset.cartId, val);
    });
  });

  // Quantity input manual change
  document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', () => {
      if (input.value < 1) input.value = 1;
      updateQuantity(input.dataset.cartId, parseInt(input.value));
    });
  });

  // Remove item buttons
  document.querySelectorAll('.remove-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      if (confirm('Remove this item from cart?')) {
        removeItem(btn.dataset.cartId).then(() => {
          btn.closest('tr').remove();
          updateCartTotals();
        });
      }
    });
  });

  function updateQuantity(cartId, quantity) {
    return fetch('cart.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `action=update_quantity&cart_id=${cartId}&quantity=${quantity}`
    })
    .then(res => res.json())
    .then(data => {
      if (!data.success) throw new Error(data.message || 'Failed to update quantity');
      updateCartTotals();
    })
    .catch(err => alert(err.message));
  }

  function removeItem(cartId) {
    return fetch('cart.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `action=remove_item&cart_id=${cartId}`
    })
    .then(res => res.json())
    .then(data => {
      if (!data.success) throw new Error(data.message || 'Failed to remove item');
    });
  }

  function updateCartTotals() {
    let subtotal = 0;
    document.querySelectorAll('tbody tr').forEach(row => {
        const price = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace('₹', ''));
        const quantity = parseInt(row.querySelector('.quantity-input').value);
        const total = price * quantity;
        row.querySelector('.subtotal').textContent = `₹${total.toFixed(2)}`;
        subtotal += total;
    });
    
    // Update summary without tax
    document.querySelector('.cart-summary p:nth-child(1)').textContent = `Subtotal: ₹${subtotal.toFixed(2)}`;
    document.querySelector('.cart-summary p:nth-child(2)').textContent = `Total: ₹${subtotal.toFixed(2)}`;
    updateCartCount();
}

  function updateCartCount() {
    fetch('api/cart/count.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.header-user-actions .count, .mobile-bottom-navigation .count').forEach(el => {
                    el.textContent = data.count;
                });
            }
        });
}

  updateCartTotals();
});
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="./assets/js/product.js"></script>
<!-- CUSTOM JS -->
<script src="./assets/js/script.js"></script>

<?php require_once 'footer.php'; ?>