<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'includes/db.php';
require_once 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch wishlist items with complete product details
$stmt = $pdo->prepare("
    SELECT 
        w.id AS wishlist_id,
        w.added_at,
        p.id AS product_id,
        p.name AS title,
        p.price,
        p.discount_price,
        p.main_image AS image,
        p.rating,
        p.review_count,
        p.category_id,
        p.stock,
        p.tax_rate,
        p.original_price
    FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id = ?
    ORDER BY w.added_at DESC
");

$stmt->execute([$_SESSION['user_id']]);
$wishlist_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update wishlist count in session
$_SESSION['wishlist_count'] = count($wishlist_items);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Wishlist - Digital Media</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./assets/css/style-prefix.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    .wishlist-container {
      padding: 40px 0;
    }
    
    .wishlist-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 30px;
      color: var(--eerie-black);
      text-align: center;
    }
    
    .wishlist-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
    }
    
    .wishlist-item {
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      transition: var(--transition-timing);
      position: relative;
    }
    
    .wishlist-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .wishlist-img-box {
      position: relative;
      overflow: hidden;
      height: 200px;
    }
    
    .wishlist-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    
    .wishlist-item:hover .wishlist-img {
      transform: scale(1.05);
    }
    
    .wishlist-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background-color: var(--salmon-pink);
      color: white;
      padding: 5px 10px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 500;
    }
    
    .wishlist-content {
      padding: 20px;
    }
    
    .wishlist-category {
      font-size: 12px;
      color: var(--sonic-silver);
      margin-bottom: 5px;
    }
    
    .wishlist-product-title {
      font-weight: 600;
      margin-bottom: 10px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .wishlist-rating {
      color: var(--sandy-brown);
      margin-bottom: 10px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .price-box {
      display: flex;
      gap: 10px;
      align-items: center;
      margin-top: 15px;
    }
    
    .current-price {
      font-weight: 600;
      color: var(--eerie-black);
      font-size: 18px;
    }
    
    .original-price {
      text-decoration: line-through;
      color: var(--sonic-silver);
      font-size: 14px;
    }
    
    .discount-badge {
      background-color: var(--salmon-pink);
      color: white;
      padding: 2px 8px;
      border-radius: 4px;
      font-size: 12px;
    }
    
    .wishlist-actions {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }
    
    .wishlist-btn {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      cursor: pointer;
      transition: var(--transition-timing);
    }
    
    .wishlist-add-cart {
      background-color: var(--salmon-pink);
      color: white;
      flex-grow: 1;
      border-radius: 4px;
      width: auto;
      padding: 0 15px;
    }
    
    .wishlist-remove {
      background-color: var(--cultured);
      color: var(--sonic-silver);
    }
    
    .wishlist-btn:hover {
      opacity: 0.8;
    }
    
    .empty-wishlist {
      text-align: center;
      padding: 80px 0;
    }
    
    .empty-wishlist-icon {
      font-size: 60px;
      color: var(--cultured);
      margin-bottom: 20px;
    }
    
    .empty-wishlist-title {
      font-size: 20px;
      margin-bottom: 15px;
    }
    
    .empty-wishlist-text {
      color: var(--sonic-silver);
      margin-bottom: 25px;
    }
    
    .empty-wishlist-btn {
      padding: 12px 30px;
      background-color: var(--salmon-pink);
      color: white;
      border: none;
      border-radius: 4px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition-timing);
    }
    
    .empty-wishlist-btn:hover {
      background-color: var(--eerie-black);
    }
    
    .stock-status {
      font-size: 12px;
      margin-top: 5px;
    }
    
    .in-stock {
      color: var(--forest-green);
    }
    
    .out-of-stock {
      color: var(--salmon-pink);
    }
    
    @media (max-width: 768px) {
      .wishlist-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 15px;
      }
    }
  </style>
</head>

<body>
  <div class="overlay" data-overlay></div>
  <main>
    <!-- WISHLIST MAIN CONTENT -->
    <div class="container wishlist-container">
      <h1 class="wishlist-title">Your Wishlist</h1>
      
      <div class="wishlist-content">
        <?php if (!empty($wishlist_items)): ?>
          <div class="wishlist-grid">
            <?php foreach ($wishlist_items as $item): ?>
              <div class="wishlist-item" data-product-id="<?= htmlspecialchars($item['product_id']) ?>">
                <div class="wishlist-img-box">
                  <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="wishlist-img">
                  <?php if ($item['discount_price'] < $item['price']): ?>
                    <span class="wishlist-badge">Sale</span>
                  <?php endif; ?>
                </div>
                <div class="wishlist-content">
                  <h3 class="wishlist-product-title"><?= htmlspecialchars($item['title']) ?></h3>
                  <div class="wishlist-rating">
                    <?php
                    $fullStars = floor($item['rating']);
                    $hasHalfStar = ($item['rating'] - $fullStars) >= 0.5;
                    
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $fullStars) {
                            echo '<ion-icon name="star"></ion-icon>';
                        } elseif ($i == $fullStars + 1 && $hasHalfStar) {
                            echo '<ion-icon name="star-half-outline"></ion-icon>';
                        } else {
                            echo '<ion-icon name="star-outline"></ion-icon>';
                        }
                    }
                    ?>
                    <span>(<?= $item['review_count'] ?>)</span>
                  </div>
                  
                  <div class="price-box">
                    <?php if ($item['discount_price'] < $item['price']): ?>
                      <span class="current-price">₹<?= number_format($item['discount_price'], 2) ?></span>
                      <span class="original-price">₹<?= number_format($item['price'], 2) ?></span>
                      <span class="discount-badge">
                        <?= round(($item['price'] - $item['discount_price']) / $item['price'] * 100) ?>% OFF
                      </span>
                    <?php else: ?>
                      <span class="current-price">₹<?= number_format($item['price'], 2) ?></span>
                    <?php endif; ?>
                  </div>
                  
                  <div class="stock-status <?= $item['stock'] > 0 ? 'in-stock' : 'out-of-stock' ?>">
                    <?= $item['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?>
                  </div>
                  
                  <div class="wishlist-actions">
                    <button class="wishlist-btn wishlist-add-cart">
                      <ion-icon name="bag-handle-outline"></ion-icon>
                      <span>Add to Cart</span>
                    </button>
                    <button class="wishlist-btn wishlist-remove">
                      <ion-icon name="heart-dislike-outline"></ion-icon>
                    </button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="empty-wishlist">
            <div class="empty-wishlist-icon">
              <ion-icon name="heart-dislike-outline"></ion-icon>
            </div>
            <h2 class="empty-wishlist-title">Your wishlist is empty</h2>
            <p class="empty-wishlist-text">Looks like you haven't added anything to your wishlist yet</p>
            <a href="index.php" class="empty-wishlist-btn">Browse Products</a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <?php require_once 'footer.php'; ?>

  <!-- CUSTOM JS -->
  <script src="./assets/js/script.js"></script>

  <!-- IONICONS -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Remove from wishlist functionality
      document.querySelectorAll('.wishlist-remove').forEach(btn => {
        btn.addEventListener('click', function() {
          const item = this.closest('.wishlist-item');
          const productId = item.dataset.productId;
          
          fetch('includes/remove_from_wishlist.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ product_id: productId })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              item.remove();
              // Update wishlist count in header
              document.querySelectorAll('.wishlist-count').forEach(el => {
                el.textContent = parseInt(el.textContent) - 1;
              });
              
              // Show empty state if last item
              if (document.querySelectorAll('.wishlist-item').length === 0) {
                document.querySelector('.wishlist-grid').innerHTML = `
                  <div class="empty-wishlist">
                    <div class="empty-wishlist-icon">
                      <ion-icon name="heart-dislike-outline"></ion-icon>
                    </div>
                    <h2 class="empty-wishlist-title">Your wishlist is empty</h2>
                    <p class="empty-wishlist-text">Looks like you haven't added anything to your wishlist yet</p>
                    <a href="index.php" class="empty-wishlist-btn">Browse Products</a>
                  </div>
                `;
              }
            }
          });
        });
      });
      
      // Add to cart functionality
      document.querySelectorAll('.wishlist-add-cart').forEach(btn => {
        btn.addEventListener('click', function() {
          const item = this.closest('.wishlist-item');
          const productId = item.dataset.productId;
          
          fetch('includes/add_to_cart.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 
              product_id: productId,
              quantity: 1 
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Product added to cart!');
              // Update cart count in header
              document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = parseInt(el.textContent) + 1;
              });
            } else {
              alert(data.message || 'Failed to add to cart');
            }
          });
        });
      });
    });
  </script>
</body>
</html>