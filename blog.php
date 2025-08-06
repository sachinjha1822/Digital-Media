<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Digital Media</title>
    <style>
        .dm-blog-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .dm-blog-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .dm-blog-header h1 {
            font-size: 2.5rem;
            color: #4f46e5;
            margin-bottom: 1rem;
        }
        
        .dm-blog-header p {
            font-size: 1.1rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .dm-blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .dm-blog-card {
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        
        .dm-blog-card:hover {
            transform: translateY(-5px);
        }
        
        .dm-blog-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }
        
        .dm-blog-content {
            padding: 1.5rem;
        }
        
        .dm-blog-category {
            display: inline-block;
            background: #e0e7ff;
            color: #4f46e5;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        
        .dm-blog-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #333;
        }
        
        .dm-blog-excerpt {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .dm-blog-meta {
            display: flex;
            justify-content: space-between;
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .dm-read-more {
            color: #4f46e5;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        
        .dm-read-more ion-icon {
            margin-left: 0.25rem;
        }
        
        .dm-blog-pagination {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
            gap: 0.5rem;
        }
        
        .dm-page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 0.25rem;
            background: white;
            color: #4f46e5;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .dm-page-link.active {
            background: #4f46e5;
            color: white;
        }
        
        @media (max-width: 768px) {
            .dm-blog-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dm-blog-container">
        <div class="dm-blog-header">
            <h1>Digital Media Blog</h1>
            <p>Industry insights, design tips, and company updates from our team of experts</p>
        </div>
        
        <div class="dm-blog-grid">
            <div class="dm-blog-card">
                <div class="dm-blog-image" style="background-image: url('./assets/images/blog/design-trends.jpg');"></div>
                <div class="dm-blog-content">
                    <span class="dm-blog-category">Design Tips</span>
                    <h3 class="dm-blog-title">2024 Design Trends for Print Materials</h3>
                    <p class="dm-blog-excerpt">Discover the emerging design trends that will dominate business cards, brochures, and other print materials this year.</p>
                    <div class="dm-blog-meta">
                        <span>March 15, 2024</span>
                        <a href="blog-post.html" class="dm-read-more">Read More <ion-icon name="arrow-forward-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
            
            <div class="dm-blog-card">
                <div class="dm-blog-image" style="background-image: url('./assets/images/blog/eco-printing.jpg');"></div>
                <div class="dm-blog-content">
                    <span class="dm-blog-category">Sustainability</span>
                    <h3 class="dm-blog-title">Eco-Friendly Printing: Our Commitment</h3>
                    <p class="dm-blog-excerpt">Learn about the sustainable practices we've implemented to reduce our environmental impact.</p>
                    <div class="dm-blog-meta">
                        <span>February 28, 2024</span>
                        <a href="blog-post.html" class="dm-read-more">Read More <ion-icon name="arrow-forward-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
            
            <div class="dm-blog-card">
                <div class="dm-blog-image" style="background-image: url('./assets/images/blog/branding.jpg');"></div>
                <div class="dm-blog-content">
                    <span class="dm-blog-category">Branding</span>
                    <h3 class="dm-blog-title">How Consistent Branding Boosts Recognition</h3>
                    <p class="dm-blog-excerpt">Case studies showing how cohesive branding across print and digital increases customer recall by up to 80%.</p>
                    <div class="dm-blog-meta">
                        <span>February 10, 2024</span>
                        <a href="blog-post.html" class="dm-read-more">Read More <ion-icon name="arrow-forward-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
            
            <div class="dm-blog-card">
                <div class="dm-blog-image" style="background-image: url('./assets/images/blog/paper-guide.jpg');"></div>
                <div class="dm-blog-content">
                    <span class="dm-blog-category">Resources</span>
                    <h3 class="dm-blog-title">Ultimate Guide to Paper Stocks</h3>
                    <p class="dm-blog-excerpt">Everything you need to know about different paper weights, finishes, and their best uses.</p>
                    <div class="dm-blog-meta">
                        <span>January 22, 2024</span>
                        <a href="blog-post.html" class="dm-read-more">Read More <ion-icon name="arrow-forward-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
            
            <div class="dm-blog-card">
                <div class="dm-blog-image" style="background-image: url('./assets/images/blog/team-building.jpg');"></div>
                <div class="dm-blog-content">
                    <span class="dm-blog-category">Company News</span>
                    <h3 class="dm-blog-title">Our Team's Creative Retreat 2024</h3>
                    <p class="dm-blog-excerpt">A look at our annual team retreat focused on innovation and collaboration.</p>
                    <div class="dm-blog-meta">
                        <span>January 5, 2024</span>
                        <a href="blog-post.html" class="dm-read-more">Read More <ion-icon name="arrow-forward-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
            
            <div class="dm-blog-card">
                <div class="dm-blog-image" style="background-image: url('./assets/images/blog/printing-tech.jpg');"></div>
                <div class="dm-blog-content">
                    <span class="dm-blog-category">Technology</span>
                    <h3 class="dm-blog-title">New Printing Technology We're Excited About</h3>
                    <p class="dm-blog-excerpt">An inside look at the advanced printing equipment we've recently added to our facility.</p>
                    <div class="dm-blog-meta">
                        <span>December 18, 2023</span>
                        <a href="blog-post.html" class="dm-read-more">Read More <ion-icon name="arrow-forward-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="dm-blog-pagination">
            <a href="#" class="dm-page-link active">1</a>
            <a href="#" class="dm-page-link">2</a>
            <a href="#" class="dm-page-link">3</a>
            <a href="#" class="dm-page-link">
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </a>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php require_once 'footer.php'; ?>
</body>
</html>