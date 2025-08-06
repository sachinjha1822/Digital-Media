<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Details - Digital Media</title>
  
  <!-- Favicon -->
  <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<style>
  
  /* Product Details Container */
.product-details-container {
  display: flex;
  gap: 2rem;
  flex-wrap: wrap;
  margin-bottom: 3rem;
}

/* Gallery Section */
.product-gallery {
  flex: 1 1 40%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.thumbnail-images {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.thumbnail-images img {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border: 2px solid #ddd;
  cursor: pointer;
  border-radius: 0.5rem;
  transition: border 0.3s;
}

.thumbnail-images img:hover,
.thumbnail-images img.active {
  border-color: #4f46e5;
}

.main-image img {
  width: 100%;
  max-width: 400px;
  border-radius: 1rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Product Info */
.product-info {
  flex: 1 1 55%;
  padding: 1rem;
  background-color: #fff;
  border-radius: 1rem;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.06);
}

.product-title {
  font-size: 2rem;
  margin-bottom: 0.5rem;
}

.product-rating {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.stars {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 2px; /* Optional spacing between stars */
}

.stars ion-icon {
  color: #fbbf24;
  font-size: 1rem; /* Adjust as needed */
}

.price-box {
  display: flex;
  align-items: center;
  gap: 1rem;
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.price {
  font-weight: 700;
  color: #22c55e;
}

.discount {
  color: #ef4444;
  font-weight: bold;
}

/* Product Description */
.product-description p {
  margin-bottom: 1rem;
}

.features {
  list-style: disc;
  padding-left: 1.5rem;
  margin-bottom: 1rem;
}

/* Actions */
.product-actions {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.quantity-selector {
  display: flex;
  align-items: center;
  border: 1px solid #ccc;
  border-radius: 0.5rem;
  overflow: hidden;
}

.quantity-selector button {
  background-color: #f3f4f6;
  border: none;
  padding: 0.5rem 1rem;
  cursor: pointer;
}

.quantity-selector input {
  width: 40px;
  text-align: center;
  border: none;
}

/* Buttons */
.btn-add-to-cart,
.btn-wishlist {
  background: linear-gradient(135deg, #4caf50, #81c784);
  color: white;
  padding: 0.6rem 1rem;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.9rem;
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  transition: transform 0.2s, box-shadow 0.2s;
}

.btn-add-to-cart:hover,
.btn-wishlist:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Product Meta */
.product-meta {
  font-size: 0.9rem;
  color: #6b7280;
}

.meta-item {
  margin-bottom: 0.5rem;
}

/* Tabs */
.product-tabs {
  margin-top: 3rem;
}

.tab-buttons {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.tab-btn {
  background: #f3f4f6;
  padding: 0.5rem 1rem;
  border-radius: 1rem;
  cursor: pointer;
  border: none;
}

.tab-btn.active {
  background-color: #4f46e5;
  color: white;
}

.tab-content {
  display: none;
}

.tab-content.active {
  display: block;
  background-color: #fff;
  padding: 1rem;
  border-radius: 1rem;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}

/* Specs Table */
.specs-table {
  width: 100%;
  border-collapse: collapse;
}

.specs-table th,
.specs-table td {
  padding: 0.5rem;
  text-align: left;
  border-bottom: 1px solid #e5e7eb;
}
#related-products {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 1.5rem;
  padding: 1rem 0;
}

@media (min-width: 576px) {
  #related-products {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 768px) {
  #related-products {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (min-width: 992px) {
  #related-products {
    grid-template-columns: repeat(4, 1fr);
  }
}
.review-rating {
  display: flex;
  gap: 4px;           /* space between stars */
  color: #fbbf24;     /* gold/yellow color for stars */
  font-size: 1.2rem;  /* size of the stars */
  align-items: center; /* vertically center stars if mixed with text */
}

/* Review Form Styles */
.review-form {
  margin-top: 2rem;
  padding: 1.5rem;
  background-color: #f9fafb;
  border-radius: 0.5rem;
}

.review-form h4 {
  margin-bottom: 1rem;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.form-control {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
}

.star-rating {
  display: flex;
  gap: 0.5rem;
}

.star-rating input {
  display: none;
}

.star-rating label {
  font-size: 1.5rem;
  color: #d1d5db;
  cursor: pointer;
}

.star-rating input:checked ~ label {
  color: #fbbf24;
}

.star-rating label:hover,
.star-rating label:hover ~ label {
  color: #fbbf24;
}

.btn-submit-review {
  background-color: #4f46e5;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.375rem;
  cursor: pointer;
}

.btn-submit-review:hover {
  background-color: #4338ca;
}

/* File Upload Styles */
.file-upload-section {
  margin-top: 2rem;
  padding: 1.5rem;
  background-color: #f9fafb;
  border-radius: 0.5rem;
}

.file-upload-section h3 {
  margin-bottom: 1rem;
}

.upload-container {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.upload-box {
  border: 2px dashed #d1d5db;
  border-radius: 0.5rem;
  padding: 1.5rem;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s;
}

.upload-box:hover {
  border-color: #4f46e5;
  background-color: #f0f0ff;
}

.upload-box input[type="file"] {
  display: none;
}

.upload-box label {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
}

.upload-icon {
  font-size: 2rem;
  color: #4f46e5;
}

.upload-text {
  font-weight: 500;
}

.file-info {
  font-size: 0.875rem;
  color: #6b7280;
  margin-top: 0.5rem;
}

.note-text {
  font-size: 0.875rem;
  color: #6b7280;
  margin-top: 1rem;
  font-style: italic;
}

/* Preview Images */
.preview-container {
  display: flex;
  gap: 1rem;
  margin-top: 1rem;
}

.preview-image {
  position: relative;
  width: 100px;
  height: 100px;
  border-radius: 0.5rem;
  overflow: hidden;
}

.preview-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.remove-image {
  position: absolute;
  top: 0.25rem;
  right: 0.25rem;
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  border-radius: 50%;
  width: 1.25rem;
  height: 1.25rem;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

/* Printing Options */
.printing-options {
  margin-top: 1rem;
}

.option-group {
  margin-bottom: 1rem;
}

.option-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.option-select {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .product-details-container {
    flex-direction: column;
  }
  
  .product-gallery,
  .product-info {
    flex: 1 1 100%;
  }
  
  .tab-buttons {
    flex-wrap: wrap;
  }
}
/* Add these new styles */
  .highlight-upload {
    animation: highlight 2s ease-in-out;
    border-color: #ef4444 !important;
  }
  
  @keyframes highlight {
    0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
    50% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
    100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
  }
  
  .tab-content {
    scroll-margin-top: 100px; /* Adjust based on your header height */
  }

  /* Review Styles */
.review {
  background-color: #fff;
  border-radius: 0.5rem;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.review-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.5rem;
}

.review-author {
  font-weight: 600;
  font-size: 1.1rem;
}

.review-date {
  color: #6b7280;
  font-size: 0.875rem;
  margin-bottom: 0.75rem;
}

.review-content {
  line-height: 1.6;
}

.review-title {
  font-weight: 500;
  margin-bottom: 0.5rem;
}
/* Loading Spinner */
.spinner {
  display: inline-block;
  width: 20px;
  height: 20px;
  border: 3px solid rgba(255,255,255,.3);
  border-radius: 50%;
  border-top-color: #fff;
  animation: spin 1s ease-in-out infinite;
  margin-right: 10px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>

<body>
 <!-- Notification Container (will be created dynamically) -->
  
  <div class="overlay" data-overlay></div>
  <!-- MAIN CONTENT -->
  <main>
    <!-- PRODUCT DETAILS SECTION -->
    <section class="product-details">
      <div class="container">
        <div class="product-details-container">
          <!-- Product Gallery -->
          <div class="product-gallery">
            <div class="thumbnail-images" id="thumbnail-container">
              <!-- Thumbnails will be dynamically inserted here -->
            </div>
            <div class="main-image">
              <img src="" alt="Product Image" id="main-product-image">
            </div>
          </div>

          <!-- Product Info -->
          <div class="product-info">
            <h1 class="product-title" id="product-title">Loading...</h1>
            <div class="product-rating">
              <div class="stars" id="product-rating-stars">
                <!-- Stars will be dynamically inserted here -->
              </div>
              <span class="rating-count" id="review-count">(0 reviews)</span>
            </div>

            <div class="price-box">
              <p class="price" id="product-price">₹0.00</p>
              <del id="original-price"></del>
              <span class="discount" id="discount-badge"></span>
            </div>

            <div class="product-description">
              <p id="product-description">Loading product description...</p>
              <ul class="features" id="product-features">
                <!-- Features will be dynamically inserted here -->
              </ul>
            </div>

            <div class="product-actions">
              <div class="quantity-selector">
                <button class="quantity-minus">-</button>
                <input type="number" value="1" min="1" class="quantity-input">
                <button class="quantity-plus">+</button>
              </div>
              <button class="btn-add-to-cart" id="add-to-cart-btn">
                <ion-icon name="bag-handle-outline"></ion-icon> Add to Cart
              </button>
              <button class="btn-wishlist" id="add-to-wishlist-btn">
                <ion-icon name="heart-outline"></ion-icon>
              </button>
            </div>

            <div class="product-meta">
              <div class="meta-item">
                <span class="meta-label">Category:</span>
                <a href="#" class="meta-value" id="product-category">PVC Cards</a>
              </div>
              <div class="meta-item">
                <span class="meta-label">Availability:</span>
                <span class="meta-value in-stock" id="availability">In Stock</span>
              </div>
              <div class="meta-item">
                <span class="meta-label">SKU:</span>
                <span class="meta-value" id="product-sku">Loading...</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Product Tabs -->
        <div class="product-tabs">
          <div class="tab-buttons">
            <button class="tab-btn active" data-tab="description">Description</button>
            <button class="tab-btn" data-tab="specifications">Specifications</button>
            <button class="tab-btn" data-tab="printing-options">Printing Options</button>
            <button class="tab-btn" data-tab="reviews">Reviews</button>
          </div>

          <div class="tab-content active" id="description">
            <h3>Product Description</h3>
            <p id="full-description">Loading detailed description...</p>
          </div>

          <div class="tab-content" id="specifications">
            <h3>Product Specifications</h3>
            <table class="specs-table" id="specs-table">
              <!-- Specifications will be dynamically inserted here -->
            </table>
          </div>

          <div class="tab-content" id="printing-options">
            <h3>Upload Your Design</h3>
            <div class="file-upload-section">
              <div class="upload-container">
                <div class="upload-box" id="front-upload-box">
                  <input type="file" id="front-file" accept="image/*,.pdf,.psd,.ai,.eps">
                  <label for="front-file">
                    <ion-icon name="cloud-upload-outline" class="upload-icon"></ion-icon>
                    <span class="upload-text">Upload Front Side</span>
                    <span class="file-info">JPG, PNG, PDF, PSD, AI, EPS (Max 10MB)</span>
                  </label>
                  <div class="preview-container" id="front-preview"></div>
                </div>
                
                <div class="upload-box" id="back-upload-box">
                  <input type="file" id="back-file" accept="image/*,.pdf,.psd,.ai,.eps">
                  <label for="back-file">
                    <ion-icon name="cloud-upload-outline" class="upload-icon"></ion-icon>
                    <span class="upload-text">Upload Back Side</span>
                    <span class="file-info">JPG, PNG, PDF, PSD, AI, EPS (Max 10MB)</span>
                  </label>
                  <div class="preview-container" id="back-preview"></div>
                </div>
                
                <p class="note-text">Note: If you have a single file for both front and back sides, upload it in the Front Side section.</p>
              </div>
              
              <div class="printing-options">
                <h4>Printing Options</h4>
                <div class="option-group">
                  <label for="finish-type">Finish Type:</label>
                  <select id="finish-type" class="option-select">
                    <option value="matte">Matte</option>
                    <option value="glossy">Glossy</option>
                    <option value="semi-gloss">Semi-Gloss</option>
                  </select>
                </div>
                
                <div class="option-group">
                  <label for="corner-style">Corner Style:</label>
                  <select id="corner-style" class="option-select">
                    <option value="square">Square Corners</option>
                    <option value="rounded">Rounded Corners</option>
                  </select>
                </div>
                
                <div class="option-group">
                  <label for="hologram">Hologram Overlay:</label>
                  <select id="hologram" class="option-select">
                    <option value="none">None</option>
                    <option value="standard">Standard Hologram</option>
                    <option value="premium">Premium Hologram (+₹50)</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-content" id="reviews">
            <h3>Customer Reviews</h3>
            <div id="reviews-container">
              <!-- Reviews will be dynamically inserted here -->
            </div>
            
            <!-- Review Form -->
            <div class="review-form">
              <h4>Write a Review</h4>
              <form id="submit-review-form">
                <div class="form-group">
                  <label for="review-name">Your Name</label>
                  <input type="text" id="review-name" class="form-control" required>
                </div>
                
                <div class="form-group">
                  <label for="review-email">Your Email</label>
                  <input type="email" id="review-email" class="form-control" required>
                </div>
                
                <div class="form-group">
                  <label>Rating</label>
                  <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" required>
                    <label for="star5"><ion-icon name="star"></ion-icon></label>
                    
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4"><ion-icon name="star"></ion-icon></label>
                    
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3"><ion-icon name="star"></ion-icon></label>
                    
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2"><ion-icon name="star"></ion-icon></label>
                    
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1"><ion-icon name="star"></ion-icon></label>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="review-title">Review Title</label>
                  <input type="text" id="review-title" class="form-control" required>
                </div>
                
                <div class="form-group">
                  <label for="review-content">Your Review</label>
                  <textarea id="review-content" class="form-control" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn-submit-review" id="submit-review-btn">
                  Submit Review
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- RELATED PRODUCTS SECTION -->
    <section class="related-products">
      <div class="container">
        <h2 class="section-title">More PVC Cards</h2>
        <div class="product-grid" id="related-products" class="product-scroll">
          <!-- Related products will be dynamically inserted here -->
        </div>
      </div>
    </section>
  </main>

  <!-- CUSTOM JS -->
  <script src="./assets/js/script.js"></script>
  
  <!-- Product Data and Script -->
  <script>
    // Product Database
    const products = {
      "driving-license": {
        id: "driving-license",
        title: "PVC Driving License",
        price: 49,
        originalPrice: 99,
        images: [
          "./assets/images/products/PVC Cards/driving-license.jpg",
          "./assets/images/products/PVC Cards/Driving Lincence card.jpeg",
          "./assets/images/products/PVC Cards/driving license-3.jpg"
        ],
        description: "High quality PVC driving license printing with hologram and all security features included.",
        fullDescription: "Our PVC Driving License is a high-quality replica that includes all the security features of an original license. Made from durable PVC material, this card is designed to last. The printing is done using high-resolution techniques to ensure all details are crisp and clear. The card includes a hologram overlay for added security and authenticity.",
        features: [
          "Premium quality PVC material",
          "Hologram security feature",
          "UV printing for authenticity",
          "Standard ID card size (CR80)"
        ],
        specifications: {
          "Material": "Premium PVC",
          "Size": "Standard CR80 (85.6 × 54 mm)",
          "Printing": "Full color both sides",
          "Finish": "Matte/Glossy (optional)",
          "Security Features": "Hologram, UV printing",
          "Production Time": "3-5 business days"
        },
        category: "pvc-cards",
        sku: "PVC-DL-001",
        stock: 50,
        rating: 4.5,
        reviewCount: 24,
        reviews: [
          {
            author: "Rahul Sharma",
            rating: 5,
            date: "15 June 2023",
            content: "Excellent quality! The card looks exactly like the real one. Very happy with my purchase."
          },
          {
            author: "Priya Patel",
            rating: 4,
            date: "2 July 2023",
            content: "Good product, but delivery took longer than expected."
          }
        ],
        badge: "51%"
      },
      "pan-card": {
        id: "pan-card",
        title: "PVC PAN Card",
        price: 49,
        originalPrice: 99,
        images: [
          "./assets/images/products/PVC Cards/Pan Card.jpeg",
          "./assets/images/products/PVC Cards/Pan Card.jpeg"
        ],
        description: "High quality PVC PAN card printing with all security features.",
        fullDescription: "Our PVC PAN Card is a premium quality replica with all security features. Perfect for identification purposes and official use.",
        features: [
          "Premium PVC material",
          "Hologram security",
          "UV printing",
          "Standard size"
        ],
        specifications: {
          "Material": "Premium PVC",
          "Size": "Standard CR80 (85.6 × 54 mm)",
          "Printing": "Full color",
          "Finish": "Matte",
          "Security Features": "Hologram",
          "Production Time": "3-5 business days"
        },
        category: "pvc-cards",
        sku: "PVC-PAN-002",
        stock: 35,
        rating: 4,
        reviewCount: 18,
        badge: "51%"
      },
      "voter-id": {
        id: "voter-id",
        title: "PVC Voter ID Card",
        price: 49,
        originalPrice: 99,
        images: [
          "./assets/images/products/PVC Cards/Voter I'd Card.jpeg"
        ],
        description: "Authentic looking PVC Voter ID card with security features.",
        fullDescription: "Our PVC Voter ID card is designed to look exactly like the original with all security features included.",
        features: [
          "Premium PVC material",
          "Hologram security",
          "UV printing",
          "Standard size"
        ],
        specifications: {
          "Material": "Premium PVC",
          "Size": "Standard CR80 (85.6 × 54 mm)",
          "Printing": "Full color both sides",
          "Finish": "Matte",
          "Security Features": "Hologram, UV printing",
          "Production Time": "3-5 business days"
        },
        category: "pvc-cards",
        sku: "PVC-VOTER-003",
        stock: 42,
        rating: 3.5,
        reviewCount: 12,
        badge: "sale"
      },
      "aadhar-card": {
        id: "aadhar-card",
        title: "PVC Aadhar Card",
        price: 49,
        originalPrice: 99,
        images: [
          "./assets/images/products/PVC Cards/Adhar Card.jpeg"
        ],
        description: "High quality PVC Aadhar card replica with security features.",
        fullDescription: "Our PVC Aadhar card is a premium quality replica with all the security features of the original.",
        features: [
          "Premium PVC material",
          "Hologram security",
          "UV printing",
          "QR code support",
          "Standard size"
        ],
        specifications: {
          "Material": "Premium PVC",
          "Size": "Standard CR80 (85.6 × 54 mm)",
          "Printing": "Full color both sides",
          "Finish": "Matte/Glossy",
          "Security Features": "Hologram, UV printing, QR code",
          "Production Time": "3-5 business days"
        },
        category: "pvc-cards",
        sku: "PVC-AADHAR-004",
        stock: 28,
        rating: 4.2,
        reviewCount: 21
      },
      "ration-card": {
        id: "ration-card",
        title: "PVC Ration Card",
        price: 49,
        originalPrice: 99,
        images: [
          "./assets/images/products/PVC Cards/Ration Card.jpg"
        ],
        description: "Durable PVC ration card with official design elements.",
        fullDescription: "Our PVC Ration Card is designed to be durable and long-lasting with all official design elements included.",
        features: [
          "Premium PVC material",
          "Hologram security",
          "UV printing",
          "Standard size"
        ],
        specifications: {
          "Material": "Premium PVC",
          "Size": "Standard CR80 (85.6 × 54 mm)",
          "Printing": "Full color both sides",
          "Finish": "Matte",
          "Security Features": "Hologram",
          "Production Time": "3-5 business days"
        },
        category: "pvc-cards",
        sku: "PVC-RATION-005",
        stock: 15,
        rating: 4,
        reviewCount: 8,
        badge: "new"
      },
      "apaar-card": {
  id: "apaar-card",
  title: "PVC APAAR Card",
  price: 49,
  originalPrice: 99,
  images: [
    "./assets/images/products/PVC Cards/APAAR Card.jpeg"
  ],
  description: "Durable PVC APAAR card with school identity integration.",
  fullDescription: "Our PVC APAAR Card is designed for students with secure printing, school branding, and a unique identity code. Made using durable material with high-resolution color printing.",
  features: [
    "Student identity format",
    "UV and QR security printing",
    "Standard CR80 card size",
    "Glossy finish"
  ],
  specifications: {
    "Material": "Premium PVC",
    "Size": "Standard CR80 (85.6 × 54 mm)",
    "Printing": "Full color both sides",
    "Finish": "Glossy",
    "Security Features": "QR Code, UV Markings",
    "Production Time": "3-5 business days"
  },
  category: "pvc-cards",
  sku: "PVC-APAAR-006",
  stock: 33,
  rating: 4.3,
  reviewCount: 10,
  badge: "new"
},

"sram-card": {
  id: "sram-card",
  title: "PVC SRAM Card",
  price: 49,
  originalPrice: 99,
  images: [
    "./assets/images/products/PVC Cards/Sram Card.jpeg"
  ],
  description: "Official PVC SRAM Card with detailed data print and government format.",
  fullDescription: "Our PVC SRAM Card ensures official compliance and durable printing. Perfect for identification and verification purposes with a professional look and feel.",
  features: [
    "Government-format printing",
    "Matte finish",
    "High-resolution detail print",
    "Standard size"
  ],
  specifications: {
    "Material": "Premium PVC",
    "Size": "Standard CR80 (85.6 × 54 mm)",
    "Printing": "Full color",
    "Finish": "Matte",
    "Security Features": "Barcode, UV Markings",
    "Production Time": "3-5 business days"
  },
  category: "pvc-cards",
  sku: "PVC-SRAM-007",
  stock: 22,
  rating: 4.1,
  reviewCount: 9,
  badge: "hot"
  },

"vehicle-card": {
  id: "vehicle-card",
  title: "PVC Vehicle Registration Card",
  price: 49,
  originalPrice: 99,
  images: [
    "./assets/images/products/PVC Cards/Vehicle card.jpeg"
  ],
  description: "PVC copy of vehicle registration with all essential features.",
  fullDescription: "This PVC Vehicle Registration Card is printed on high-quality material to replicate original RC documents. Designed for long-lasting durability with all legal details included.",
  features: [
    "Vehicle owner details",
    "Official registration format",
    "UV and hologram security",
    "Water-resistant finish"
  ],
  specifications: {
    "Material": "Premium PVC",
    "Size": "Standard CR80 (85.6 × 54 mm)",
    "Printing": "Full color both sides",
    "Finish": "Matte/Glossy (optional)",
    "Security Features": "Hologram, UV print",
    "Production Time": "3-5 business days"
  },
  category: "pvc-cards",
  sku: "PVC-RC-008",
  stock: 18,
  rating: 4.4,
  reviewCount: 13,
  badge: "51%"
  },
  "wedding-card": {
    id: "wedding-card",
    title: "PVC Wedding Invitation Card",
    price: 49,
    originalPrice: 99,
    images: [
      "./assets/images/products/PVC Cards/wedding-invitation.jpg",
      "./assets/images/products/PVC Cards/wedding-invitation.jpg"
    ],
    description: "Stylish and durable wedding invitation printed on premium PVC.",
    fullDescription: "Our PVC Wedding Invitation Card offers an elegant way to invite guests to your special day. Printed on premium-quality PVC material, these cards are water-resistant, long-lasting, and make a great impression. Perfect for couples looking for a modern and memorable way to announce their wedding.",
    features: [
      "Premium waterproof PVC",
      "Elegant design with vibrant printing",
      "Customizable text and layout",
      "Long-lasting and durable finish"
    ],
    specifications: {
      "Material": "High-quality PVC",
      "Size": "Custom or CR80 (85.6 × 54 mm)",
      "Printing": "Full color both sides",
      "Finish": "Glossy/Matte options",
      "Production Time": "3-5 business days"
    },
    category: "pvc-wedding-card",
    sku: "PVC-WED-009",
    stock: 40,
    rating: 4.7,
    reviewCount: 32,
    badge: "new",
    badgeClass: "angle pink"
  },
  "visiting-card": {
    id: "visiting-card",
    title: "PVC Visiting Card",
    price: 49,
    originalPrice: 99,
    images: [
      "./assets/images/products/PVC Cards/visiting-card.jpg",
      "./assets/images/products/PVC Cards/visiting-card.jpg"
    ],
    description: "Professional-grade PVC visiting card for business use.",
    fullDescription: "Our PVC Visiting Cards are printed in full color on durable material to ensure a lasting impression. Ideal for professionals who want a premium business identity.",
    features: [
      "Premium PVC material",
      "Glossy finish",
      "Full color printing",
      "Compact and stylish"
    ],
    specifications: {
      "Material": "Premium PVC",
      "Size": "Standard CR80 (85.6 × 54 mm)",
      "Printing": "Full color both sides",
      "Finish": "Glossy",
      "Production Time": "3-5 business days"
    },
    category: "pvc-visiting-card",
    sku: "PVC-VISIT-010",
    stock: 38,
    rating: 4.4,
    reviewCount: 19,
    badge: "",
    badgeClass: ""
  },
  "school-card": {
    id: "school-card",
    title: "PVC School ID Card",
    price: 49,
    originalPrice: 99,
    images: [
      "./assets/images/products/PVC Cards/School Card.jpg",
      "./assets/images/products/PVC Cards/School Card.jpg"
    ],
    description: "Durable PVC school identity card for students.",
    fullDescription: "Our PVC School ID Cards are perfect for schools and institutions seeking professional-grade identification for students and staff. Water-resistant and tamper-proof.",
    features: [
      "Student photo and info print",
      "Premium PVC quality",
      "Custom school branding",
      "Standard ID format"
    ],
    specifications: {
      "Material": "Premium PVC",
      "Size": "CR80 standard",
      "Printing": "Full color",
      "Finish": "Matte/Glossy",
      "Production Time": "3-5 business days"
    },
    category: "pvc-school-card",
    sku: "PVC-SCHOOL-011",
    stock: 30,
    rating: 4.1,
    reviewCount: 14,
    badge: "51%",
    badgeClass: ""
  },
  "epfo-card": {
    id: "epfo-card",
    title: "PVC EPFO Card",
    price: 49,
    originalPrice: 99,
    images: [
      "./assets/images/products/PVC Cards/epfo-uan-pvc-card.jpg",
      "./assets/images/products/PVC Cards/epfo-uan-pvc-card.jpg"
    ],
    description: "PVC card version of your EPFO UAN for easy access and ID.",
    fullDescription: "The PVC EPFO Card securely displays your UAN and essential employee provident fund information in a portable, tamper-proof format.",
    features: [
      "Displays UAN info",
      "Official card layout",
      "High durability",
      "Waterproof and long-lasting"
    ],
    specifications: {
      "Material": "Premium PVC",
      "Size": "CR80 Standard",
      "Printing": "Full color",
      "Finish": "Matte",
      "Production Time": "3-5 business days"
    },
    category: "pvc-epfo-card",
    sku: "PVC-EPFO-012",
    stock: 27,
    rating: 4,
    reviewCount: 10,
    badge: "",
    badgeClass: ""
  },
  "covid19-card": {
    id: "covid19-card",
    title: "PVC Covid19 Vaccination Card",
    price: 49,
    originalPrice: 99,
    images: [
      "./assets/images/products/PVC Cards/Covid19.jpg",
      "./assets/images/products/PVC Cards/Covid19.jpg"
    ],
    description: "PVC version of your Covid-19 vaccination proof.",
    fullDescription: "Easily carry your Covid-19 vaccination proof in PVC card format. Compact, durable, and easy to keep in your wallet.",
    features: [
      "Vaccination details printed",
      "Waterproof and fade-resistant",
      "Full color on both sides",
      "Compact wallet-size"
    ],
    specifications: {
      "Material": "Durable PVC",
      "Size": "CR80",
      "Printing": "Full color",
      "Finish": "Matte",
      "Production Time": "3-5 business days"
    },
    category: "pvc-covid19-card",
    sku: "PVC-COVID-013",
    stock: 34,
    rating: 3.8,
    reviewCount: 11,
    badge: "sale",
    badgeClass: "angle black"
  },
  "business-card": {
    id: "business-card",
    title: "PVC Business Card",
    price: 45,
    originalPrice: 99,
    images: [
      "./assets/images/products/PVC Cards/business-card-holder.jpg",
      "./assets/images/products/PVC Cards/business-card-holder.jpg"
    ],
    description: "Professional PVC business card for networking and branding.",
    fullDescription: "Make a bold impression with our premium PVC Business Cards. Ideal for entrepreneurs and corporate professionals.",
    features: [
      "Custom logo and details",
      "Glossy or matte finish",
      "Durable PVC material",
      "Premium branding tool"
    ],
    specifications: {
      "Material": "PVC",
      "Size": "Standard CR80",
      "Printing": "Full color both sides",
      "Finish": "Glossy/Matte",
      "Production Time": "3-5 business days"
    },
    category: "pvc-business-card",
    sku: "PVC-BIZ-014",
    stock: 50,
    rating: 4.3,
    reviewCount: 17,
    badge: "",
    badgeClass: ""
  },
  "ayushman-card": {
    id: "ayushman-card",
    title: "PVC Ayushman Bharat Card",
    price: 49,
    originalPrice: 99,
    images: [
      "./assets/images/products/PVC Cards/ayushman-bharat.png",
      "./assets/images/products/PVC Cards/ayushman-bharat.png"
    ],
    description: "PVC replica of Ayushman Bharat health card with QR.",
    fullDescription: "This PVC Ayushman Bharat Card offers a handy and sturdy version of your government-issued health card with all necessary features and QR code.",
    features: [
      "Ayushman Bharat official format",
      "Printed QR code",
      "Waterproof and strong",
      "Easy to carry"
    ],
    specifications: {
      "Material": "Premium PVC",
      "Size": "CR80 (85.6 × 54 mm)",
      "Printing": "Full color",
      "Finish": "Glossy",
      "Production Time": "3-5 business days"
    },
    category: "pvc-ayushman-card",
    sku: "PVC-AYUSH-015",
    stock: 29,
    rating: 4.5,
    reviewCount: 22,
    badge: "new",
    badgeClass: "angle pink"
  }
  };

// Related products
const relatedProducts = [
  "pan-card", "voter-id", "aadhar-card", "ration-card", "apaar-card",
  "sram-card", "vehicle-card", "wedding-card", "visiting-card",
  "school-card", "epfo-card", "covid19-card", "business-card", "ayushman-card"
];

// API Service Class
class ApiService {
  constructor(baseUrl = '/api') {
    this.baseUrl = baseUrl;
  }
  
  async get(endpoint, params = {}) {
    const url = new URL(`${this.baseUrl}/${endpoint}`);
    Object.entries(params).forEach(([key, value]) => {
      url.searchParams.append(key, value);
    });
    
    const response = await fetch(url);
    return this._handleResponse(response);
  }
  
  async post(endpoint, data = {}) {
    const response = await fetch(`${this.baseUrl}/${endpoint}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    });
    return this._handleResponse(response);
  }
  
  async postFormData(endpoint, formData) {
    const response = await fetch(`${this.baseUrl}/${endpoint}`, {
      method: 'POST',
      body: formData
    });
    return this._handleResponse(response);
  }
  
  async _handleResponse(response) {
    if (!response.ok) {
      const error = await response.json().catch(() => ({}));
      throw new Error(error.message || 'Request failed');
    }
    return response.json();
  }
}

// App State Management
const AppState = {
  cart: {
    items: [],
    count: 0
  },
  wishlist: {
    items: [],
    count: 0
  },
  currentProduct: null,
  api: new ApiService(),
  
  init() {
    this.loadCart();
    this.loadWishlist();
  },
  
  loadCart() {
    // In a real app, this would load from API/localStorage
    this.cart = {
      items: [],
      count: 0
    };
  },
  
  loadWishlist() {
    // In a real app, this would load from API/localStorage
    this.wishlist = {
      items: [],
      count: 0
    };
  },
  
  async addToCart(productId, quantity, formData) {
    try {
      const data = await this.api.postFormData('cart/add.php', formData);
      this.cart.count += quantity;
      this.updateCartUI();
      return data;
    } catch (error) {
      console.error('Error adding to cart:', error);
      throw error;
    }
  },
  
  async addToWishlist(productId) {
    try {
      const data = await this.api.post('wishlist/add.php', { product_id: productId });
      this.wishlist.count += 1;
      this.updateWishlistUI();
      return data;
    } catch (error) {
      console.error('Error adding to wishlist:', error);
      throw error;
    }
  },
  
  async fetchReviews(productId) {
    try {
      return await this.api.get('reviews/get.php', { product_id: productId });
    } catch (error) {
      console.error('Error fetching reviews:', error);
      return [];
    }
  },
  
  async submitReview(productId, reviewData) {
    try {
      return await this.api.post('reviews/submit.php', {
        product_id: productId,
        ...reviewData
      });
    } catch (error) {
      console.error('Error submitting review:', error);
      throw error;
    }
  },
  
  updateCartUI() {
    document.querySelectorAll('.header-user-actions .count').forEach(el => {
      el.textContent = this.cart.count;
    });
  },
  
  updateWishlistUI() {
    document.querySelectorAll('.wishlist-count').forEach(el => {
      el.textContent = this.wishlist.count;
    });
  }
};

// Notification System
class NotificationSystem {
  static show(message, type = 'success') {
    const existing = document.querySelector('.notification');
    if (existing) {
      existing.classList.add('slide-out');
      existing.addEventListener('animationend', () => existing.remove());
    }
    
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `<span>${message}</span>`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.classList.add('slide-out');
      notification.addEventListener('animationend', () => notification.remove());
    }, 3000);
  }
}

// Product Gallery
class ProductGallery {
  constructor(containerId) {
    this.container = document.getElementById(containerId);
    if (!this.container) return;
    
    this.mainImage = this.container.querySelector('.main-product-image');
    this.thumbnails = this.container.querySelectorAll('.thumbnail');
    this.currentIndex = 0;
    
    this.init();
  }
  
  init() {
    this.thumbnails.forEach((thumb, index) => {
      thumb.addEventListener('click', () => this.showImage(index));
      thumb.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') this.showImage(index);
      });
    });
    
    // Keyboard navigation
    this.container.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowRight') {
        this.showImage((this.currentIndex + 1) % this.thumbnails.length);
      } else if (e.key === 'ArrowLeft') {
        this.showImage((this.currentIndex - 1 + this.thumbnails.length) % this.thumbnails.length);
      }
    });
  }
  
  showImage(index) {
    this.currentIndex = index;
    const newSrc = this.thumbnails[index].dataset.large;
    this.mainImage.src = newSrc;
    this.mainImage.alt = `Product image ${index + 1}`;
    
    // Update active thumbnail
    this.thumbnails.forEach(t => {
      t.classList.remove('active');
      t.setAttribute('aria-current', 'false');
    });
    this.thumbnails[index].classList.add('active');
    this.thumbnails[index].setAttribute('aria-current', 'true');
    this.thumbnails[index].focus();
  }
}

// File Upload Handler
class FileUploadHandler {
  static setup(inputId, previewContainerId) {
    const input = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewContainerId);
    const uploadBox = document.getElementById(`${inputId}-box`);
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    
    if (!input || !previewContainer) return;
    
    input.addEventListener('change', function(e) {
      previewContainer.innerHTML = '';
      
      if (this.files && this.files.length > 0) {
        uploadBox.style.display = 'none';
        
        Array.from(this.files).forEach((file, index) => {
          if (file.size > MAX_FILE_SIZE) {
            NotificationSystem.show(`File ${file.name} is too large (max 5MB)`, 'error');
            return;
          }
          
          const previewDiv = document.createElement('div');
          previewDiv.className = 'preview-image';
          
          if (file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = (e) => {
              previewDiv.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <button class="remove-image" data-file-index="${index}" aria-label="Remove image">
                  <ion-icon name="close-outline"></ion-icon>
                </button>
              `;
              previewContainer.appendChild(previewDiv);
              FileUploadHandler.setupRemoveButton(input, previewDiv, index);
            };
            reader.readAsDataURL(file);
          } else {
            previewDiv.innerHTML = `
              <div class="file-preview">
                <ion-icon name="document-outline"></ion-icon>
                <span>${file.name}</span>
                <button class="remove-image" data-file-index="${index}" aria-label="Remove file">
                  <ion-icon name="close-outline"></ion-icon>
                </button>
              </div>
            `;
            previewContainer.appendChild(previewDiv);
            FileUploadHandler.setupRemoveButton(input, previewDiv, index);
          }
        });
      }
    });
  }
  
  static setupRemoveButton(input, previewDiv, index) {
    const removeBtn = previewDiv.querySelector('.remove-image');
    removeBtn.addEventListener('click', () => {
      const files = Array.from(input.files);
      files.splice(index, 1);
      
      const dataTransfer = new DataTransfer();
      files.forEach(file => dataTransfer.items.add(file));
      input.files = dataTransfer.files;
      
      previewDiv.remove();
      
      if (files.length === 0) {
        document.getElementById(`${input.id}-box`).style.display = 'block';
      }
    });
  }
}

// Review System
class ReviewSystem {
  static renderStars(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    let starsHTML = '';
    
    for (let i = 0; i < fullStars; i++) {
      starsHTML += '<ion-icon name="star" aria-hidden="true"></ion-icon>';
    }
    
    if (hasHalfStar) {
      starsHTML += '<ion-icon name="star-half-outline" aria-hidden="true"></ion-icon>';
    }
    
    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    for (let i = 0; i < emptyStars; i++) {
      starsHTML += '<ion-icon name="star-outline" aria-hidden="true"></ion-icon>';
    }
    
    return `<span class="sr-only">Rating: ${rating} out of 5 stars</span>${starsHTML}`;
  }
  
  static renderReviews(reviews) {
    const container = document.getElementById('reviews-container');
    if (!container) return;
    
    if (!reviews || reviews.length === 0) {
      container.innerHTML = '<p>No reviews yet. Be the first to review this product!</p>';
      return;
    }
    
    const totalRatings = reviews.reduce((sum, review) => sum + review.rating, 0);
    const averageRating = totalRatings / reviews.length;
    
    document.getElementById('product-rating-stars').innerHTML = this.renderStars(averageRating);
    document.getElementById('review-count').textContent = `(${reviews.length} reviews)`;
    
    container.innerHTML = reviews.map(review => `
      <div class="review" id="review-${review.id}">
        <div class="review-header">
          <div class="review-author">${this.sanitizeHTML(review.author_name || review.author)}</div>
          <div class="review-rating">
            ${this.renderStars(review.rating)}
            ${review.verified ? '<span class="verified-badge">Verified Purchase</span>' : ''}
          </div>
        </div>
        <div class="review-date">Posted on ${review.date || review.created_at}</div>
        ${review.title ? `<div class="review-title">${this.sanitizeHTML(review.title)}</div>` : ''}
        <div class="review-content">
          <p>${this.sanitizeHTML(review.content)}</p>
        </div>
      </div>
    `).join('');
  }
  
  static sanitizeHTML(str) {
    if (!str) return '';
    const temp = document.createElement('div');
    temp.textContent = str;
    return temp.innerHTML;
  }
}

// Product Details Page Controller
class ProductDetailsPage {
  constructor() {
    this.state = AppState;
    this.state.init();
    this.product = null;
    this.urlParams = new URLSearchParams(window.location.search);
    this.productId = this.urlParams.get('id');
    
    this.init();
  }
  
  async init() {
    await this.loadProduct();
    this.setupEventListeners();
  }
  
  async loadProduct() {
    this.product = products[this.productId];
    
    if (!this.product) {
      this.showProductNotFound();
      return;
    }
    
    document.title = `${this.product.title} - Digital Media`;
    this.renderProductDetails();
    this.setupProductGallery();
    FileUploadHandler.setup('front-file', 'front-preview');
    FileUploadHandler.setup('back-file', 'back-preview');
    
    // Load reviews
    const reviews = await this.state.fetchReviews(this.productId);
    ReviewSystem.renderReviews(reviews);
    
    // Render related products
    this.renderRelatedProducts();
  }
  
  renderProductDetails() {
    const { product } = this;
    
    document.getElementById('product-title').textContent = product.title;
    document.getElementById('product-price').textContent = this.formatPrice(product.price);
    
    if (product.originalPrice) {
      document.getElementById('original-price').textContent = this.formatPrice(product.originalPrice);
      document.getElementById('discount-badge').textContent = 
        `${this.calculateDiscount(product.price, product.originalPrice)}% off`;
    } else {
      document.getElementById('original-price').style.display = 'none';
      document.getElementById('discount-badge').style.display = 'none';
    }
    
    document.getElementById('product-description').textContent = product.description;
    document.getElementById('full-description').textContent = product.fullDescription;
    document.getElementById('product-category').textContent = 
      product.category.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    document.getElementById('product-category').href = `products.html?category=${product.category}`;
    document.getElementById('product-sku').textContent = product.sku;
    document.getElementById('availability').textContent = `In Stock (${product.stock}+)`;
    
    // Features
    const featuresContainer = document.getElementById('product-features');
    featuresContainer.innerHTML = product.features.map(feature => 
      `<li><ion-icon name="checkmark-circle-outline"></ion-icon> ${feature}</li>`
    ).join('');
    
    // Specifications
    const specsTable = document.getElementById('specs-table');
    specsTable.innerHTML = Object.entries(product.specifications).map(([key, value]) => 
      `<tr><td>${key}</td><td>${value}</td></tr>`
    ).join('');
  }
  
  setupProductGallery() {
    if (!this.product.images || this.product.images.length === 0) return;
    
    const mainImage = document.getElementById('main-product-image');
    const thumbnailContainer = document.getElementById('thumbnail-container');
    
    mainImage.src = this.product.images[0];
    mainImage.alt = this.product.title;
    
    thumbnailContainer.innerHTML = this.product.images.map((image, index) => `
      <img src="${image}" alt="${this.product.title} ${index + 1}" 
           class="thumbnail ${index === 0 ? 'active' : ''}" 
           data-large="${image}"
           tabindex="0"
           ${index === 0 ? 'aria-current="true"' : ''}>
    `).join('');
    
    new ProductGallery('product-gallery');
  }
  
  renderRelatedProducts() {
    const container = document.getElementById('related-products');
    if (!container) return;
    
    container.innerHTML = relatedProducts
      .filter(id => id !== this.productId)
      .map(id => {
        const product = products[id];
        if (!product) return '';
        
        return `
          <div class="showcase">
            <div class="showcase-banner">
              <img src="${product.images[0]}" alt="${product.title}" width="300" class="product-img default">
              <img src="${product.images[0]}" alt="${product.title}" width="300" class="product-img hover">
              ${product.badge ? `
                <p class="showcase-badge ${product.badge === 'sale' ? 'angle black' : 
                  product.badge === 'new' ? 'angle pink' : ''}">
                  ${product.badge === 'sale' ? 'sale' : product.badge === 'new' ? 'new' : product.badge}
                </p>
              ` : ''}
              <div class="showcase-actions">
                <button class="btn-action" onclick="AppState.addToWishlist('${product.id}')" aria-label="Add to wishlist">
                  <ion-icon name="heart-outline"></ion-icon>
                </button>
                <button class="btn-action" onclick="window.location.href='product-details.html?id=${product.id}'" aria-label="View details">
                  <ion-icon name="eye-outline"></ion-icon>
                </button>
                <button class="btn-action" aria-label="Compare">
                  <ion-icon name="repeat-outline"></ion-icon>
                </button>
                <button class="btn-action" onclick="AppState.addToCart('${product.id}', 1, new FormData())" aria-label="Add to cart">
                  <ion-icon name="bag-add-outline"></ion-icon>
                </button>
              </div>
            </div>
            <div class="showcase-content">
              <a href="products.html?category=${product.category}" class="showcase-category">
                ${product.category.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')}
              </a>
              <a href="product-details.html?id=${product.id}">
                <h3 class="showcase-title">${product.title}</h3>
              </a>
              <div class="showcase-rating">
                ${ReviewSystem.renderStars(product.rating)}
              </div>
              <div class="price-box">
                <p class="price">${this.formatPrice(product.price)}</p>
                ${product.originalPrice ? `<del>${this.formatPrice(product.originalPrice)}</del>` : ''}
              </div>
            </div>
          </div>
        `;
      }).join('');
  }
  
  showProductNotFound() {
    document.querySelector('.product-details-container').innerHTML = `
      <div class="product-not-found">
        <h2>Product Not Found</h2>
        <p>The product you're looking for doesn't exist or has been removed.</p>
        <a href="products.html" class="btn">Browse Products</a>
      </div>
    `;
    document.querySelector('.product-tabs').style.display = 'none';
  }
  
  setupEventListeners() {
    if (!this.product) return;
    
    // Quantity Selector
    const quantityInput = document.querySelector('.quantity-input');
    const quantityMinus = document.querySelector('.quantity-minus');
    const quantityPlus = document.querySelector('.quantity-plus');
    
    if (quantityMinus) {
      quantityMinus.addEventListener('click', () => {
        let value = parseInt(quantityInput.value) || 1;
        if (value > 1) quantityInput.value = value - 1;
      });
    }
    
    if (quantityPlus) {
      quantityPlus.addEventListener('click', () => {
        let value = parseInt(quantityInput.value) || 1;
        quantityInput.value = value + 1;
      });
    }
    
    // Tab Switching
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
      button.addEventListener('click', () => {
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        button.classList.add('active');
        const tabId = button.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active');
      });
    });
    
    // Add to Cart
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    if (addToCartBtn) {
      addToCartBtn.addEventListener('click', async () => {
        const quantity = parseInt(quantityInput.value) || 1;
        const frontFile = document.getElementById('front-file').files[0];
        
        if (!frontFile) {
          NotificationSystem.show('Please upload front design file', 'error');
          document.querySelector('.tab-btn[data-tab="printing-options"]').click();
          document.getElementById('printing-options').scrollIntoView({ behavior: 'smooth' });
          
          const frontUploadBox = document.getElementById('front-upload-box');
          frontUploadBox.classList.add('highlight-upload');
          setTimeout(() => frontUploadBox.classList.remove('highlight-upload'), 2000);
          return;
        }
        
        const formData = new FormData();
        formData.append('product_id', this.product.id);
        formData.append('quantity', quantity);
        formData.append('front_file', frontFile);
        
        const backFile = document.getElementById('back-file').files[0];
        if (backFile) formData.append('back_file', backFile);
        
        formData.append('finish_type', document.getElementById('finish-type').value);
        formData.append('corner_style', document.getElementById('corner-style').value);
        formData.append('hologram', document.getElementById('hologram').value);
        
        try {
          await this.state.addToCart(this.product.id, quantity, formData);
          NotificationSystem.show(`Added ${quantity} item(s) to cart`, 'success');
        } catch (error) {
          NotificationSystem.show(error.message || 'Failed to add to cart', 'error');
        }
      });
    }
    
    // Add to Wishlist
    const addToWishlistBtn = document.getElementById('add-to-wishlist-btn');
    if (addToWishlistBtn) {
      addToWishlistBtn.addEventListener('click', async () => {
        try {
          await this.state.addToWishlist(this.product.id);
          NotificationSystem.show('Added to wishlist!', 'success');
        } catch (error) {
          NotificationSystem.show(
            error.message || 'Failed to add to wishlist', 
            error.message.includes('already') ? 'warning' : 'error'
          );
        }
      });
    }
    
    // Review Form
    const reviewForm = document.getElementById('submit-review-form');
    if (reviewForm) {
      reviewForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submit-review-btn');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner"></span> Submitting...';
        
        const reviewData = {
          name: document.getElementById('review-name').value,
          email: document.getElementById('review-email').value,
          rating: document.querySelector('input[name="rating"]:checked').value,
          title: document.getElementById('review-title').value,
          content: document.getElementById('review-content').value
        };
        
        try {
          const result = await this.state.submitReview(this.product.id, reviewData);
          if (result.success) {
            const reviews = await this.state.fetchReviews(this.product.id);
            ReviewSystem.renderReviews(reviews);
            NotificationSystem.show('Thank you for your review!', 'success');
            reviewForm.reset();
            
            setTimeout(() => {
              const newReview = document.getElementById(`review-${result.review.id}`);
              if (newReview) newReview.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
          }
        } catch (error) {
          NotificationSystem.show(error.message || 'Failed to submit review', 'error');
        } finally {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnText;
        }
      });
    }
  }
  
  formatPrice(price) {
    return `₹${price.toFixed(2)}`;
  }
  
  calculateDiscount(price, originalPrice) {
    return Math.round(((originalPrice - price) / originalPrice) * 100);
  }
}

// Initialize the page when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  window.AppState = AppState;
  window.NotificationSystem = NotificationSystem;
  new ProductDetailsPage();
});
  </script>

  <!-- IONICONS -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="./assets/js/product.js"></script>
  <?php require_once 'footer.php'; ?>
</body>
</html>