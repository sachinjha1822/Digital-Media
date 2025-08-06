
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digital Media - Personalized Printing Services</title>

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
  /* Product Grid Layout */
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); /* Responsive grid */
  gap: 1.5rem;
  padding: 1rem 0;
}

/* Responsive Adjustments */
@media (min-width: 576px) {
  .product-grid {
    grid-template-columns: repeat(2, 1fr); /* Small tablets */
  }
}

@media (min-width: 768px) {
  .product-grid {
    grid-template-columns: repeat(3, 1fr); /* Tablets and phones landscape */
  }
}

@media (min-width: 992px) {
  .product-grid {
    grid-template-columns: repeat(4, 1fr); /* Desktops */
  }
}

</style>

</head>

<body>
    <?php require_once 'header.php'; ?>
  <div class="overlay" data-overlay></div>

  <!-- MAIN CONTENT -->
 <main>
  <?php
  // Get the category from the URL
  $category = isset($_GET['category']) ? $_GET['category'] : 'all';
  
  // Set the page title based on category
  $pageTitle = "Our Products";
  switch($category) {
    case 'pvc-cards':
      $pageTitle = "PVC Cards Collection";
      break;
    case 'custom-printing':
      $pageTitle = "Custom Printing Services";
      break;
    case 'business-essentials':
      $pageTitle = "Business Essentials";
      break;
    // Add more cases as needed
  }
  ?>
  
  <!-- Dynamic Category Section -->
  <div class="product-main">
    <div class="container">
      <div class="pvc-category-header">
        <h1 class="pvc-category-title"><?php echo htmlspecialchars($pageTitle); ?></h1>
        <div class="pvc-category-filter">
          <select id="pvc-sort">
            <option value="popular">Sort by: Popular</option>
            <option value="price-low">Price: Low to High</option>
            <option value="price-high">Price: High to Low</option>
            <option value="newest">Newest First</option>
          </select>
          <select id="pvc-filter">
            <option value="all">All Products</option>
            <option value="driving-license" <?php echo ($category == 'driving-license') ? 'selected' : ''; ?>>Driving License</option>
            <option value="pan-card" <?php echo ($category == 'pan-card') ? 'selected' : ''; ?>>PAN Card</option>
            <option value="voter-id" <?php echo ($category == 'voter-id') ? 'selected' : ''; ?>>Voter ID</option>
            <option value="aadhar-card" <?php echo ($category == 'aadhar-card') ? 'selected' : ''; ?>>Aadhar Card</option>
            <option value="ration-card" <?php echo ($category == 'ration-card') ? 'selected' : ''; ?>>Ration Card</option>
            <option value="apaar-card" <?php echo ($category == 'apaar-card') ? 'selected' : ''; ?>>APAAR Card</option>
            <option value="sram-card" <?php echo ($category == 'sram-card') ? 'selected' : ''; ?>>SRAM Card</option>
            <option value="vehicle-card" <?php echo ($category == 'vehicle-card') ? 'selected' : ''; ?>>Vehicle Card</option>
          </select>
        </div>
      </div>

      <!-- Product Grid -->
      <div class="product-main">
        <div class="product-grid" id="pvc-products-container">
          <?php
          // This is where you would typically fetch products from a database
          // For now, we'll use placeholder content
          echo "<p>Displaying products for category: " . htmlspecialchars($category) . "</p>";
          
          // In a real application, you would have a database query here
          // For example:
          // $products = getProductsByCategory($category);
          // foreach ($products as $product) {
          //     displayProductCard($product);
          // }
          ?>
        </div>
      </div>
    </div>
  </div>
</main>

  <!-- CUSTOM JS -->
  <script src="./assets/js/script.js"></script>
  
  <script src="./assets/js/product.js"></script>

  <!-- IONICONS -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
<?php require_once 'footer.php'; ?>
</html>