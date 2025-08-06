<?php 
$pageTitle = "Digital Media - Personalized Printing Services";
require_once 'header.php'; 
?>

<!-- MAIN CONTENT -->
<div class="overlay" data-overlay></div>
<main>
  <!-- HERO BANNER -->
  <div class="banner">
    <div class="container">
      <div class="slider-container has-scrollbar">
        <div class="slider-item">
          <img
            src="./assets/images/banner-cards.jpg"
            alt="High Quality PVC Cards"
            class="banner-img"
          />
          <div class="banner-content">
            <p class="banner-subtitle">Premium Quality</p>
            <h2 class="banner-title">PVC Cards Printing</h2>
            <p class="banner-text">Starting at <b>₹49</b>.00</p>
            <a href="products.php?category=pvc-cards" class="banner-btn">Order Now</a>
          </div>
        </div>
        <div class="slider-item">
          <img
            src="./assets/images/banner-printing.png"
            alt="Your Trusted Partner for Personalized Printing"
            class="banner-img"
          />
          <div class="banner-content">
            <p class="banner-subtitle">Your Trusted Partner</p>
            <h2 class="banner-title">Personalized Printing Services</h2>
            <p class="banner-text">Starting at <b>₹99</b>.00</p>
            <a href="#" class="banner-btn" id="printing-services-btn">Order Now</a>
          </div>
        </div>

        <div class="slider-item">
          <img
            src="./assets/images/banner-tshirts.jpg"
            alt="Custom Printed T-Shirts"
            class="banner-img"
          />
          <div class="banner-content">
            <p class="banner-subtitle">Custom Designs</p>
            <h2 class="banner-title">Printed T-Shirts & Mugs</h2>
            <p class="banner-text">Starting at <b>₹299</b>.00</p>
            <a href="#" class="banner-btn" id="tshirts-btn">Order Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- WhatsApp Floating Button -->
  <div class="whatsapp-float" id="whatsappFloat">
    <a
      href="https://wa.me/919934940864?text=Hi%20Digital%20Media,%20I%27m%20interested%20in%20your%20printing%20services."
      target="_blank"
      rel="noopener noreferrer"
    >
      <img src="./assets/images/whatsapp.png" alt="WhatsApp" />
      <button class="close-btn" onclick="closeWhatsApp()">×</button>
    </a>
  </div>
  
  <!-- CATEGORIES -->
  <div class="category">
    <div class="container">
      <div class="category-item-container has-scrollbar">
        <div class="category-item">
          <div class="category-img-box">
            <img
              src="./assets/images/icons/id-card.jpg"
              alt="PVC Cards"
              width="75"
              height="70"
            />
          </div>
          <div class="category-content-box">
            <div class="category-content-flex">
              <h3 class="category-item-title">PVC Cards</h3>
              <p class="category-item-amount">(25)</p>
            </div>
            <a href="products.php?category=pvc-cards" class="category-btn"
              >Show all</a
            >
          </div>
        </div>

        <div class="category-item">
          <div class="category-img-box">
            <img
              src="./assets/images/icons/tshirt.jpg"
              alt="T-Shirts"
              width="70"
            />
          </div>
          <div class="category-content-box">
            <div class="category-content-flex">
              <h3 class="category-item-title">T-Shirts</h3>
              <p class="category-item-amount">(18)</p>
            </div>
            <a href="#" class="category-btn" id="tshirts-category-btn">Show all</a>
          </div>
        </div>

        <div class="category-item">
          <div class="category-img-box">
            <img
              src="./assets/images/icons/mug.jpg"
              alt="Mugs"
              width="70"
            />
          </div>
          <div class="category-content-box">
            <div class="category-content-flex">
              <h3 class="category-item-title">Mugs</h3>
              <p class="category-item-amount">(15)</p>
            </div>
            <a href="#" class="category-btn" id="mugs-category-btn">Show all</a>
          </div>
        </div>

        <div class="category-item">
          <div class="category-img-box">
            <img
              src="./assets/images/icons/pillow.jpg"
              alt="Pillows"
              width="70"
            />
          </div>
          <div class="category-content-box">
            <div class="category-content-flex">
              <h3 class="category-item-title">Pillows</h3>
              <p class="category-item-amount">(12)</p>
            </div>
            <a href="#" class="category-btn" id="pillows-category-btn">Show all</a>
          </div>
        </div>

        <div class="category-item">
          <div class="category-img-box">
            <img
              src="./assets/images/icons/visiting-card.jpg"
              alt="Visiting Cards"
              width="80"
            />
          </div>
          <div class="category-content-box">
            <div class="category-content-flex">
              <h3 class="category-item-title">Visiting Cards</h3>
              <p class="category-item-amount">(20)</p>
            </div>
            <a href="#" class="category-btn" id="visiting-category-btn">Show all</a>
          </div>
        </div>

        <div class="category-item">
          <div class="category-img-box">
            <img
              src="./assets/images/icons/invitation.jpg"
              alt="Invitation Cards"
              width="70"
            />
          </div>
          <div class="category-content-box">
            <div class="category-content-flex">
              <h3 class="category-item-title">Invitation Cards</h3>
              <p class="category-item-amount">(15)</p>
            </div>
            <a href="#" class="category-btn" id="invitation-category-btn">Show all</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- PRODUCT GRID -->
  <div class="product-container">
    <div class="container">
      <div class="sidebar has-scrollbar" data-mobile-menu>
        <div class="sidebar-category">
          <div class="sidebar-top">
            <h2 class="sidebar-title">Category</h2>
            <button class="sidebar-close-btn" data-mobile-menu-close-btn>
              <ion-icon name="close-outline"></ion-icon>
            </button>
          </div>

          <ul class="sidebar-menu-category-list">
            <li class="sidebar-menu-category">
              <button class="sidebar-accordion-menu" data-accordion-btn>
                <div class="menu-title-flex">
                  <img
                    src="./assets/images/icons/id-card.svg"
                    alt="PVC Cards"
                    width="20"
                    height="20"
                    class="menu-title-img"
                  />
                  <p class="menu-title">PVC Cards</p>
                </div>
                <div>
                  <ion-icon name="add-outline" class="add-icon"></ion-icon>
                  <ion-icon
                    name="remove-outline"
                    class="remove-icon"
                  ></ion-icon>
                </div>
              </button>
              <ul class="sidebar-submenu-category-list" data-accordion>
                <li class="sidebar-submenu-category">
                  <a href="products.php?category=driving-license" class="sidebar-submenu-title">
                    <p class="product-name">Driving License</p>
                    <data value="50" class="stock" title="Available Stock"
                      >50</data
                    >
                  </a>
                </li>
                <li class="sidebar-submenu-category">
                  <a href="products.php?category=pan-card" class="sidebar-submenu-title">
                    <p class="product-name">PAN Card</p>
                    <data value="45" class="stock" title="Available Stock"
                      >45</data
                    >
                  </a>
                </li>
                <li class="sidebar-submenu-category">
                  <a href="products.php?category=voter-id" class="sidebar-submenu-title">
                    <p class="product-name">Voter ID</p>
                    <data value="40" class="stock" title="Available Stock"
                      >40</data
                    >
                  </a>
                </li>
                <li class="sidebar-submenu-category">
                  <a href="products.php?category=invitation-cards" class="sidebar-submenu-title">
                    <p class="product-name">Invitation Cards</p>
                    <data value="35" class="stock" title="Available Stock"
                      >35</data
                    >
                  </a>
                </li>
              </ul>
            </li>

            <li class="sidebar-menu-category">
              <button class="sidebar-accordion-menu" data-accordion-btn>
                <div class="menu-title-flex">
                  <img
                    src="./assets/images/icons/tshirt.svg"
                    alt="Custom Printing"
                    class="menu-title-img"
                    width="20"
                    height="20"
                  />
                  <p class="menu-title">Custom Printing</p>
                </div>
                <div>
                  <ion-icon name="add-outline" class="add-icon"></ion-icon>
                  <ion-icon
                    name="remove-outline"
                    class="remove-icon"
                  ></ion-icon>
                </div>
              </button>
              <ul class="sidebar-submenu-category-list" data-accordion>
                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title" id="sidebar-tshirts">
                    <p class="product-name">T-Shirts</p>
                    <data value="60" class="stock" title="Available Stock"
                      >60</data
                    >
                  </a>
                </li>
                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title" id="sidebar-mugs">
                    <p class="product-name">Mugs</p>
                    <data value="45" class="stock" title="Available Stock"
                      >45</data
                    >
                  </a>
                </li>
                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title" id="sidebar-pillows">
                    <p class="product-name">Pillows</p>
                    <data value="30" class="stock" title="Available Stock"
                      >30</data
                    >
                  </a>
                </li>
                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title" id="sidebar-caps">
                    <p class="product-name">Caps</p>
                    <data value="25" class="stock" title="Available Stock"
                      >25</data
                    >
                  </a>
                </li>
              </ul>
            </li>

            <li class="sidebar-menu-category">
              <button class="sidebar-accordion-menu" data-accordion-btn>
                <div class="menu-title-flex">
                  <img
                    src="./assets/images/icons/business.svg"
                    alt="Business Essentials"
                    class="menu-title-img"
                    width="20"
                    height="20"
                  />
                  <p class="menu-title">Business Essentials</p>
                </div>
                <div>
                  <ion-icon name="add-outline" class="add-icon"></ion-icon>
                  <ion-icon
                    name="remove-outline"
                    class="remove-icon"
                  ></ion-icon>
                </div>
              </button>
              <ul class="sidebar-submenu-category-list" data-accordion>
                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title" id="sidebar-visiting">
                    <p class="product-name">Visiting Cards</p>
                    <data value="55" class="stock" title="Available Stock"
                      >55</data
                    >
                  </a>
                </li>
                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title" id="sidebar-letterheads">
                    <p class="product-name">Letterheads</p>
                    <data value="40" class="stock" title="Available Stock"
                      >40</data
                    >
                  </a>
                </li>
                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title" id="sidebar-brochures">
                    <p class="product-name">Brochures</p>
                    <data value="35" class="stock" title="Available Stock"
                      >35</data
                    >
                  </a>
                </li>
                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title" id="sidebar-flyers">
                    <p class="product-name">Flyers</p>
                    <data value="50" class="stock" title="Available Stock"
                      >50</data
                    >
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>

        <div class="product-showcase">
          <h3 class="showcase-heading">best sellers</h3>
          <div class="showcase-wrapper">
            <div class="showcase-container" id="productShowcase">
              <!-- Products will be inserted here dynamically -->
            </div>
          </div>
        </div>
      </div>

      <div class="product-box">
        <!-- Product Grid using existing CSS -->
        <div class="product-main">
          <div class="product-grid" id="pvc-products-container">
            <!-- Product cards will be injected here -->
          </div>
        </div>

        <!-- NEW ARRIVALS -->
        <div class="product-minimal">
          <div class="product-showcase">
            <h2 class="title">New Arrivals</h2>
            <div class="showcase-wrapper has-scrollbar">
              <div class="showcase-container">
                <div class="showcase">
                  <a href="products.php?category=pan-card" class="showcase-img-box">
                    <img
                      src="./assets/images/products/pan-card.jpg"
                      alt="PVC PAN Card"
                      width="70"
                      class="showcase-img"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="products.php?category=pan-card">
                      <h4 class="showcase-title">PVC PAN Card</h4>
                    </a>
                    <a href="products.php?category=pan-card" class="showcase-category">PVC Cards</a>
                    <div class="price-box">
                      <p class="price">₹49.00</p>
                      <del>₹99.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/custom-mug.jpg"
                      alt="Custom Printed Mug"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Custom Printed Mug</h4>
                    </a>
                    <a href="#" class="showcase-category"
                      >Custom Printing</a
                    >
                    <div class="price-box">
                      <p class="price">₹299.00</p>
                      <del>₹349.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/Visitig Card/2.jpg"
                      alt="Premium Visiting Cards"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Premium Visiting Cards</h4>
                    </a>
                    <a href="#" class="showcase-category">Business</a>
                    <div class="price-box">
                      <p class="price">₹49.00</p>
                      <del>₹99.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/custom-pillow.jpg"
                      alt="Custom Printed Pillow"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Custom Printed Pillow</h4>
                    </a>
                    <a href="#" class="showcase-category"
                      >Custom Printing</a
                    >
                    <div class="price-box">
                      <p class="price">₹499.00</p>
                      <del>₹599.00</del>
                    </div>
                  </div>
                </div>
              </div>

              <div class="showcase-container">
                <div class="showcase">
                  <a href="products.php?category=voter-id" class="showcase-img-box">
                    <img
                      src="./assets/images/products/PVC Cards/Voter I'd Card.jpeg"
                      alt="PVC Voter ID Card"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">PVC Voter ID Card</h4>
                    </a>
                    <a href="#" class="showcase-category">PVC Cards</a>
                    <div class="price-box">
                      <p class="price">₹49.00</p>
                      <del>₹99.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/custom-cap.jpg"
                      alt="Custom Printed Cap"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Custom Printed Cap</h4>
                    </a>
                    <a href="#" class="showcase-category"
                      >Custom Printing</a
                    >
                    <div class="price-box">
                      <p class="price">₹349.00</p>
                      <del>₹399.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/brochure.jpg"
                      alt="Business Brochures"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Business Brochures</h4>
                    </a>
                    <a href="#" class="showcase-category">Business</a>
                    <div class="price-box">
                      <p class="price">₹49.00</p>
                      <del>₹99.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/letterhead.jpg"
                      alt="Company Letterheads"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Company Letterheads</h4>
                    </a>
                    <a href="#" class="showcase-category">Business</a>
                    <div class="price-box">
                      <p class="price">₹49.00</p>
                      <del>₹99.00</del>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- TRENDING PRODUCTS -->
          <div class="product-showcase">
            <h2 class="title">Trending Products</h2>
            <div class="showcase-wrapper has-scrollbar">
              <div class="showcase-container">
                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/photo-mug.jpg"
                      alt="Photo Printed Mug"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Photo Printed Mug</h4>
                    </a>
                    <a href="#" class="showcase-category"
                      >Custom Printing</a
                    >
                    <div class="price-box">
                      <p class="price">₹349.00</p>
                      <del>₹399.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/designer-tshirt.jpg"
                      alt="Designer Printed T-Shirt"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">
                        Designer Printed T-Shirt
                      </h4>
                    </a>
                    <a href="#" class="showcase-category"
                      >Custom Printing</a
                    >
                    <div class="price-box">
                      <p class="price">₹449.00</p>
                      <del>₹499.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/Visitig Card/1.jpg"
                      alt="Premium Visiting Card"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Premium Visiting Card</h4>
                    </a>
                    <a href="#" class="showcase-category">Business</a>
                    <div class="price-box">
                      <p class="price">₹49.00</p>
                      <del>₹99.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/custom-pillow-2.jpg"
                      alt="Custom Printed Pillow"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Custom Printed Pillow</h4>
                    </a>
                    <a href="#" class="showcase-category"
                      >Custom Printing</a
                    >
                    <div class="price-box">
                      <p class="price">₹599.00</p>
                      <del>₹699.00</del>
                    </div>
                  </div>
                </div>
              </div>

              <div class="showcase-container">
                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/designer-mug.jpg"
                      alt="Designer Printed Mug"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Designer Printed Mug</h4>
                    </a>
                    <a href="#" class="showcase-category"
                      >Custom Printing</a
                    >
                    <div class="price-box">
                      <p class="price">₹399.00</p>
                      <del>₹449.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/photo-tshirt.jpg"
                      alt="Photo Printed T-Shirt"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Photo Printed T-Shirt</h4>
                    </a>
                    <a href="#" class="showcase-category"
                      >Custom Printing</a
                    >
                    <div class="price-box">
                      <p class="price">₹499.00</p>
                      <del>₹549.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/Visitig Card/5.jpg"
                      alt="Business Card Holder"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">Business Card Holder</h4>
                    </a>
                    <a href="#" class="showcase-category">Business</a>
                    <div class="price-box">
                      <p class="price">₹49.00</p>
                      <del>₹99.00</del>
                    </div>
                  </div>
                </div>

                <div class="showcase">
                  <a href="#" class="showcase-img-box">
                    <img
                      src="./assets/images/products/custom-keychain.jpg"
                      alt="Custom Printed Keychain"
                      class="showcase-img"
                      width="70"
                    />
                  </a>
                  <div class="showcase-content">
                    <a href="#">
                      <h4 class="showcase-title">
                        Custom Printed Keychain
                      </h4>
                    </a>
                    <a href="#" class="showcase-category"
                      >Custom Printing</a
                    >
                    <div class="price-box">
                      <p class="price">₹149.00</p>
                      <del>₹199.00</del>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- PRODUCT FEATURED -->
        <div class="product-featured">
          <h2 class="title">Deal of the day</h2>
          <div class="showcase-wrapper has-scrollbar">
            <div class="showcase-container">
              <div class="showcase">
                <div class="showcase-banner">
                  <img
                    src="./assets/images/products/PVC Cards/Driving Lincence card.jpeg"
                    alt="PVC Driving License"
                    class="showcase-img"
                  />
                </div>
                <div class="showcase-content">
                  <div class="showcase-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star-half-outline"></ion-icon>
                  </div>
                  <a href="#">
                    <h3 class="showcase-title">PVC Driving License</h3>
                  </a>
                  <p class="showcase-desc">
                    High quality PVC driving license printing with hologram
                    and all security features included.
                  </p>
                  <div class="price-box">
                    <p class="price">₹49.00</p>
                    <del>₹99.00</del>
                  </div>
                  <a href="product-details.php?id=driving-license"
                    ><button class="add-cart-btn" id="add-to-cart-btn">add to cart</button></a
                  >
                  <div class="showcase-status">
                    <div class="wrapper">
                      <p>already sold: <b>50</b></p>
                      <p>available: <b>30</b></p>
                    </div>
                    <div class="showcase-status-bar"></div>
                  </div>
                  <div class="countdown-box">
                    <p class="countdown-desc">Hurry Up! Offer ends in:</p>
                    <div class="countdown">
                      <div class="countdown-content">
                        <p class="display-number">01</p>
                        <p class="display-text">Days</p>
                      </div>
                      <div class="countdown-content">
                        <p class="display-number">12</p>
                        <p class="display-text">Hours</p>
                      </div>
                      <div class="countdown-content">
                        <p class="display-number">45</p>
                        <p class="display-text">Min</p>
                      </div>
                      <div class="countdown-content">
                        <p class="display-number">30</p>
                        <p class="display-text">Sec</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="showcase-container">
              <div class="showcase">
                <div class="showcase-banner">
                  <img
                    src="./assets/images/products/featured-tshirt.jpg"
                    alt="Custom Printed T-Shirt"
                    class="showcase-img"
                  />
                </div>
                <div class="showcase-content">
                  <div class="showcase-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star-outline"></ion-icon>
                  </div>
                  <h3 class="showcase-title">
                    <a href="#" class="showcase-title"
                      >Custom Printed T-Shirt</a
                    >
                  </h3>
                  <p class="showcase-desc">
                    Premium quality custom printed t-shirts with your
                    designs. 100% cotton fabric.
                  </p>
                  <div class="price-box">
                    <p class="price">₹399.00</p>
                    <del>₹499.00</del>
                  </div>
                  <a><button class="add-cart-btn" id="printing-services-btn">add to cart</button></a>
                  <div class="showcase-status">
                    <div class="wrapper">
                      <p>already sold: <b>35</b></p>
                      <p>available: <b>25</b></p>
                    </div>
                    <div class="showcase-status-bar"></div>
                  </div>
                  <div class="countdown-box">
                    <p class="countdown-desc">Hurry Up! Offer ends in:</p>
                    <div class="countdown">
                      <div class="countdown-content">
                        <p class="display-number">01</p>
                        <p class="display-text">Days</p>
                      </div>
                      <div class="countdown-content">
                        <p class="display-number">12</p>
                        <p class="display-text">Hours</p>
                      </div>
                      <div class="countdown-content">
                        <p class="display-number">45</p>
                        <p class="display-text">Min</p>
                      </div>
                      <div class="countdown-content">
                        <p class="display-number">30</p>
                        <p class="display-text">Sec</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php require_once 'footer.php'; ?>
<script src="./assets/js/product.js"></script>
<!-- CUSTOM JS -->
<script src="./assets/js/script.js"></script>

</body>