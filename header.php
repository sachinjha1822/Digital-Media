<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartCount = 0;
if (isset($_SESSION['user_id'])) {
    require_once 'includes/db.php';
    $stmt = $pdo->prepare("SELECT SUM(quantity) FROM cart_items WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $cartCount = (int) $stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="https://info.digitalmedia.net.in/">
    <meta property="og:type" content="website">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Digital Media'; ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/style-prefix.css">
    <link rel="stylesheet" href="./assets/css/style.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
      rel="stylesheet">

    <!-- IONICONS -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <style>
    .action-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    border: 1px solid var(--cultured);
    background: white;
    color: var(--eerie-black);
}

/* Advanced Alert Notification */
.alert-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    background: #4CAF50;
    color: white;
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 9999;
    transform: translateX(120%);
    transition: transform 0.3s ease-in-out;
    display: flex;
    align-items: center;
    max-width: 800px;
}

.alert-notification.show {
    transform: translateX(0);
}

.alert-notification.error {
    background: #f44336;
}

.alert-notification.warning {
    background: #ff9800;
}

.alert-notification.info {
    background: #2196F3;
}

.alert-notification i {
    font-size: 20px;
    margin-right: 10px;
}

/* Mobile Phones */
@media (max-width: 767px) {
    .alert-notification {
        max-width: 100%;
        left: 10px;
        right: 10px;
    }
}


    </style>
</head>

<body>
    <!-- HEADER -->
    <header>
      <div class="header-top">
        <div class="container">
          <ul class="header-social-container">
            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>
            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>
            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>
            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-linkedin"></ion-icon>
              </a>
            </li>
          </ul>

          <div class="header-alert-news">
            <p>
              <b>Free Shipping</b>
              This Week Order Over - ₹49
            </p>
          </div>

          <div class="header-top-actions">
            <select name="currency">
              <option value="inr">INR ₹</option>
            </select>
            <select name="language">
              <option value="en-US">English</option>
            </select>
          </div>
        </div>
      </div>

      <div class="header-main">
        <div class="container">
          <a href="index.php" class="header-logo">
            <img
              src="./assets/images/logo/logo.png"
              alt="Digital Media's logo"
              width="240"
              height="100"
            />
          </a>

          <div class="header-search-container">
            <input
              type="search"
              id="search-input"
              class="search-field"
              placeholder="Enter your product name..."
            />
            <div id="suggestions" class="search-suggestions"></div>
            <button id="search-button" class="search-btn">
              <ion-icon name="search-outline"></ion-icon>
            </button>
          </div>

          <div class="header-user-actions">
            <?php if(isset($_SESSION['user_id'])): ?>
              <a href="account.php" class="action-btn" title="My Account">
                <ion-icon name="person-outline"></ion-icon>
                <span class="user-name"><?= htmlspecialchars($_SESSION['user_first_name']) ?></span>
              </a>
              <a href="wishlist.php" class="action-btn" title="Wishlist">
                <ion-icon name="heart-outline"></ion-icon>
                <span class="count"><?= $_SESSION['wishlist_count'] ?? 0 ?></span>
              </a>
              <a href="cart.php" class="action-btn" title="Cart">
                <ion-icon name="bag-handle-outline"></ion-icon>
                <span class="count" id="cart-count"><?= $cartCount ?></span>
              </a>
              <a href="logout.php" class="action-btn" title="Logout">
                <ion-icon name="log-out-outline"></ion-icon>
              </a>
            <?php else: ?>
              <a href="login.php" class="action-btn" title="Login">
                <ion-icon name="log-in-outline"></ion-icon>
              </a>
              <a href="login.php" class="action-btn" title="Wishlist (Login Required)">
                <ion-icon name="heart-outline"></ion-icon>
                <span class="count">0</span>
              </a>
              <a href="login.php" class="action-btn" title="Cart (Login Required)">
                <ion-icon name="bag-handle-outline"></ion-icon>
                <span class="count">0</span>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <nav class="desktop-navigation-menu">
        <div class="container">
          <ul class="desktop-menu-category-list">
            <li class="menu-category">
              <a href="index.php" class="menu-title">Home</a>
            </li>

            <li class="menu-category">
              <a href="#" class="menu-title">Categories</a>
              <div class="dropdown-panel">
                <ul class="dropdown-panel-list">
                  <li class="menu-title">
                    <a href="products.php?category=pvc-cards">PVC Cards</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=driving-license">Driving License</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=pan-card">PAN Card</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=voter-id">Voter ID</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=invitation-cards">Invitation Cards</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=pvc-cards">
                      <img src="./assets/images/pvc-cards-banner.jpg" alt="PVC Cards Collection" width="100" height="80">
                    </a>
                  </li>
                </ul>

                <ul class="dropdown-panel-list">
                  <li class="menu-title">
                    <a href="products.php?category=custom-printing">Custom Printing</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=t-shirts">T-Shirts</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=mugs">Mugs</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=pillows">Pillows</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=caps">Caps</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=custom-printing">
                      <img src="./assets/images/custom-printing-banner.jpg" alt="Custom Printing" width="250" height="119">
                    </a>
                  </li>
                </ul>

                <ul class="dropdown-panel-list">
                  <li class="menu-title">
                    <a href="products.php?category=business-essentials">Business Essentials</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=visiting-cards">Visiting Cards</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=letterheads">Letterheads</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=brochures">Brochures</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=flyers">Flyers</a>
                  </li>
                  <li class="panel-list-item">
                    <a href="products.php?category=business-essentials">
                      <img src="./assets/images/business-essentials-banner.jpg" alt="Business Essentials" width="250" height="119">
                    </a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="menu-category">
              <a href="products.php?category=pvc-cards" class="menu-title">PVC Cards</a>
              <ul class="dropdown-list">
                <li class="dropdown-item">
                  <a href="products.php?category=driving-license">Driving License</a>
                </li>
                <li class="dropdown-item">
                  <a href="products.php?category=pan-card">PAN Card</a>
                </li>
                <li class="dropdown-item">
                  <a href="products.php?category=voter-id">Voter ID</a>
                </li>
                <li class="dropdown-item">
                  <a href="products.php?category=invitation-cards">Invitation Cards</a>
                </li>
              </ul>
            </li>

            <li class="menu-category">
              <a href="products.php?category=custom-printing" class="menu-title">Custom Printing</a>
              <ul class="dropdown-list">
                <li class="dropdown-item">
                  <a href="products.php?category=t-shirts">T-Shirts</a>
                </li>
                <li class="dropdown-item">
                  <a href="products.php?category=mugs">Mugs</a>
                </li>
                <li class="dropdown-item">
                  <a href="products.php?category=pillows">Pillows</a>
                </li>
                <li class="dropdown-item">
                  <a href="products.php?category=caps">Caps</a>
                </li>
              </ul>
            </li>

            <li class="menu-category">
              <a href="products.php?category=business-essentials" class="menu-title">Business</a>
              <ul class="dropdown-list">
                <li class="dropdown-item">
                  <a href="products.php?category=visiting-cards">Visiting Cards</a>
                </li>
                <li class="dropdown-item">
                  <a href="products.php?category=letterheads">Letterheads</a>
                </li>
                <li class="dropdown-item">
                  <a href="products.php?category=brochures">Brochures</a>
                </li>
                <li class="dropdown-item">
                  <a href="products.php?category=flyers">Flyers</a>
                </li>
              </ul>
            </li>

            <li class="menu-category">
              <a href="blog.php" class="menu-title">Blog</a>
            </li>

            <li class="menu-category">
              <a href="offers.php" class="menu-title">Hot Offers</a>
            </li>
          </ul>
        </div>
      </nav>

      <div class="mobile-bottom-navigation">
        <button class="action-btn" data-mobile-menu-open-btn>
          <ion-icon name="menu-outline"></ion-icon>
        </button>
        <a href="cart.php" class="action-btn">
          <ion-icon name="bag-handle-outline"></ion-icon>
          <span class="count">0</span>
        </a>
        <a href="index.php" class="action-btn">
          <ion-icon name="home-outline"></ion-icon>
        </a>
        <a href="wishlist.php" class="action-btn">
          <ion-icon name="heart-outline"></ion-icon>
          <span class="count">0</span>
        </a>
        <a href="account.php" class="action-btn" title="Profile">
          <ion-icon name="person-outline"></ion-icon>
        </a>
      </div>

      <nav class="mobile-navigation-menu has-scrollbar" data-mobile-menu>
        <div class="menu-top">
          <h2 class="menu-title">Menu</h2>
          <button class="menu-close-btn" data-mobile-menu-close-btn>
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>

        <ul class="mobile-menu-category-list">
          <li class="menu-category">
            <a href="index.php" class="menu-title">Home</a>
          </li>

          <li class="menu-category">
            <button class="accordion-menu" data-accordion-btn>
              <p class="menu-title">PVC Cards</p>
              <div>
                <ion-icon name="add-outline" class="add-icon"></ion-icon>
                <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
              </div>
            </button>
            <ul class="submenu-category-list" data-accordion>
              <li class="submenu-category">
                <a href="products.php?category=driving-license" class="submenu-title">Driving License</a>
              </li>
              <li class="submenu-category">
                <a href="products.php?category=pan-card" class="submenu-title">PAN Card</a>
              </li>
              <li class="submenu-category">
                <a href="products.php?category=voter-id" class="submenu-title">Voter ID</a>
              </li>
              <li class="submenu-category">
                <a href="products.php?category=invitation-cards" class="submenu-title">Invitation Cards</a>
              </li>
            </ul>
          </li>

          <li class="menu-category">
            <button class="accordion-menu" data-accordion-btn>
              <p class="menu-title">Custom Printing</p>
              <div>
                <ion-icon name="add-outline" class="add-icon"></ion-icon>
                <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
              </div>
            </button>
            <ul class="submenu-category-list" data-accordion>
              <li class="submenu-category">
                <a href="products.php?category=t-shirts" class="submenu-title">T-Shirts</a>
              </li>
              <li class="submenu-category">
                <a href="products.php?category=mugs" class="submenu-title">Mugs</a>
              </li>
              <li class="submenu-category">
                <a href="products.php?category=pillows" class="submenu-title">Pillows</a>
              </li>
              <li class="submenu-category">
                <a href="products.php?category=caps" class="submenu-title">Caps</a>
              </li>
            </ul>
          </li>

          <li class="menu-category">
            <button class="accordion-menu" data-accordion-btn>
              <p class="menu-title">Business</p>
              <div>
                <ion-icon name="add-outline" class="add-icon"></ion-icon>
                <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
              </div>
            </button>
            <ul class="submenu-category-list" data-accordion>
              <li class="submenu-category">
                <a href="products.php?category=visiting-cards" class="submenu-title">Visiting Cards</a>
              </li>
              <li class="submenu-category">
                <a href="products.php?category=letterheads" class="submenu-title">Letterheads</a>
              </li>
              <li class="submenu-category">
                <a href="products.php?category=brochures" class="submenu-title">Brochures</a>
              </li>
              <li class="submenu-category">
                <a href="products.php?category=flyers" class="submenu-title">Flyers</a>
              </li>
            </ul>
          </li>

          <li class="menu-category">
            <a href="blog.php" class="menu-title">Blog</a>
          </li>

          <li class="menu-category">
            <a href="offers.php" class="menu-title">Hot Offers</a>
          </li>
        </ul>

        <div class="menu-bottom">
          <ul class="menu-category-list">
            <li class="menu-category">
              <button class="accordion-menu" data-accordion-btn>
                <p class="menu-title">Language</p>
                <ion-icon name="caret-back-outline" class="caret-back"></ion-icon>
              </button>
              <ul class="submenu-category-list" data-accordion>
                <li class="submenu-category">
                  <a href="#" class="submenu-title">English</a>
                </li>
                
              </ul>
            </li>

            <li class="menu-category">
              <button class="accordion-menu" data-accordion-btn>
                <p class="menu-title">Currency</p>
                <ion-icon name="caret-back-outline" class="caret-back"></ion-icon>
              </button>
              <ul class="submenu-category-list" data-accordion>
                <li class="submenu-category">
                  <a href="#" class="submenu-title">INR ₹</a>
                </li>
              </ul>
            </li>
          </ul>

          <ul class="menu-social-container">
            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>
            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>
            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>
            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-linkedin"></ion-icon>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <main>
    <script>
// Function to show advanced alert message
function showAlert(message, type = 'info') {
    // Create notification element
    const alert = document.createElement('div');
    alert.className = `alert-notification ${type}`;
    
    // Add icon based on type
    let icon = '';
    switch(type) {
        case 'error':
            icon = '<ion-icon name="close-circle"></ion-icon>';
            break;
        case 'warning':
            icon = '<ion-icon name="warning"></ion-icon>';
            break;
        case 'success':
            icon = '<ion-icon name="checkmark-circle"></ion-icon>';
            break;
        default:
            icon = '<ion-icon name="information-circle"></ion-icon>';
    }
    
    alert.innerHTML = `${icon}<span>${message}</span>`;
    document.body.appendChild(alert);
    
    // Trigger the show animation
    setTimeout(() => {
        alert.classList.add('show');
    }, 10);
    
    // Remove after 3 seconds
    setTimeout(() => {
        alert.classList.remove('show');
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 3000);
}

// Close WhatsApp button functionality
function closeWhatsApp() {
    document.getElementById('whatsappFloat').style.display = 'none';
}

// Add click event listeners for non-implemented sections
document.addEventListener('DOMContentLoaded', function() {
    // Category buttons
    const nonCardCategories = [
        'tshirts-category-btn', 'mugs-category-btn', 'pillows-category-btn',
        'visiting-category-btn', 'invitation-category-btn'
    ];
    
    nonCardCategories.forEach(id => {
        const btn = document.getElementById(id);
        if (btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                showAlert('This feature is coming soon! Currently we only accept PVC Card orders.', 'warning');
            });
        }
    });

    // Sidebar links
    const sidebarLinks = [
        'sidebar-tshirts', 'sidebar-mugs', 'sidebar-pillows', 'sidebar-caps',
        'sidebar-visiting', 'sidebar-letterheads', 'sidebar-brochures', 'sidebar-flyers'
    ];
    
    sidebarLinks.forEach(id => {
        const link = document.getElementById(id);
        if (link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showAlert('This feature is coming soon! Currently we only accept PVC Card orders.', 'warning');
            });
        }
    });

    // Product links
    const productLinks = [
        'printing-services-btn', 'tshirts-btn', 'new-mug', 'new-visiting', 'new-pillow',
        'new-cap', 'new-brochure', 'new-letterhead', 'trending-mug', 'trending-tshirt',
        'trending-visiting', 'trending-pillow', 'trending-mug2', 'trending-tshirt2',
        'trending-business', 'trending-keychain', 'featured-tshirt'
    ];
    
    productLinks.forEach(id => {
        const link = document.getElementById(id);
        if (link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showAlert('This feature is coming soon! Currently we only accept PVC Card orders.', 'warning');
            });
        }
    });

    // Blog and Offers links
    const blogLinks = document.querySelectorAll('a[href="offers.php"]');
    blogLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            showAlert('This feature is coming soon! Currently we only accept PVC Card orders.', 'info');
        });
    });
});
</script>