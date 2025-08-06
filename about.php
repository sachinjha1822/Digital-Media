<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Digital Media</title>
    <style>
        /* Main Styles */
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
            color: #333;
            line-height: 1.7;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #4f46e5, #8b5cf6);
            color: white;
            padding: 4rem 2rem;
            border-radius: 1rem;
            text-align: center;
            margin-bottom: 3rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .hero-section h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .hero-section p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }
        
        /* Section Styles */
        .section {
            margin-bottom: 4rem;
        }
        
        .section-title {
            font-size: 2rem;
            color: #4f46e5;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: #4f46e5;
            border-radius: 2px;
        }
        
        /* Our Story */
        .story-timeline {
            position: relative;
            padding-left: 2rem;
            margin-left: 1rem;
        }
        
        .story-timeline:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 4px;
            background: #e0e7ff;
            border-radius: 2px;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
            padding-left: 2rem;
        }
        
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        
        .timeline-item:before {
            content: '';
            position: absolute;
            top: 0;
            left: -2.3rem;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #4f46e5;
            border: 4px solid #c7d2fe;
        }
        
        .timeline-year {
            font-weight: 700;
            color: #4f46e5;
            margin-bottom: 0.5rem;
        }
        
        /* Team Section */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .team-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .team-card:hover {
            transform: translateY(-5px);
        }
        
        .team-image {
            height: 250px;
            background-size: cover;
            background-position: center;
        }
        
        .team-info {
            padding: 1.5rem;
        }
        
        .team-name {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }
        
        .team-position {
            color: #6b7280;
            margin-bottom: 1rem;
        }
        
        /* Stats Section */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
            margin-top: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 2rem 1rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #4f46e5;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 1rem;
        }
        
        /* Values Section */
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .value-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .value-icon {
            font-size: 2rem;
            color: #4f46e5;
            margin-bottom: 1rem;
        }
        
        .value-title {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        /* CTA Section */
        .cta-section {
            background: #f9fafb;
            padding: 4rem 2rem;
            border-radius: 1rem;
            text-align: center;
            margin-top: 3rem;
        }
        
        .cta-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }
        
        .cta-button {
            display: inline-block;
            background: #4f46e5;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s ease;
            margin-top: 1rem;
        }
        
        .cta-button:hover {
            background: #4338ca;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 3rem 1rem;
            }
            
            .hero-section h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="about-container">
        <!-- Hero Section -->
        <section class="hero-section">
            <h1>Your Trusted Partner in Digital Printing Solutions</h1>
            <p>At Digital Media, we combine cutting-edge technology with creative expertise to deliver premium printing services that help businesses stand out.</p>
            <a href="products.html" class="cta-button">Explore Our Products</a>
        </section>
        
        <!-- Our Story Section -->
        <section class="section">
            <h2 class="section-title">Our Story</h2>
            <p>Founded in 2015, Digital Media began as a small printing studio with a passion for quality and innovation. Today, we've grown into a leading provider of digital printing services, serving clients across India and internationally.</p>
            
            <div class="story-timeline">
                <div class="timeline-item">
                    <div class="timeline-year">2015</div>
                    <h3>Humble Beginnings</h3>
                    <p>Started as a small printing shop in Mumbai with just 3 employees and one printing machine.</p>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2017</div>
                    <h3>First Major Client</h3>
                    <p>Secured our first corporate client, leading to expansion of our service offerings.</p>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2019</div>
                    <h3>Technology Upgrade</h3>
                    <p>Invested in state-of-the-art printing equipment, enabling us to offer higher quality products.</p>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2021</div>
                    <h3>National Recognition</h3>
                    <p>Awarded "Best Digital Printing Service" by the Indian Printing Association.</p>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2023</div>
                    <h3>Current Operations</h3>
                    <p>Now serving over 5,000 satisfied customers with a team of 25 professionals.</p>
                </div>
            </div>
        </section>
        
        <!-- Our Team Section -->
        <section class="section">
            <h2 class="section-title">Meet Our Team</h2>
            <p>Our success is driven by a team of passionate professionals who are experts in printing technology, design, and customer service.</p>
            
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-image" style="background-image: url('./assets/images/team/team1.jpg');"></div>
                    <div class="team-info">
                        <div class="team-name">Rajesh Patel</div>
                        <div class="team-position">Founder & CEO</div>
                        <p>With over 15 years in the printing industry, Rajesh leads our vision for innovation and quality.</p>
                    </div>
                </div>
                
                <div class="team-card">
                    <div class="team-image" style="background-image: url('./assets/images/team/team2.jpg');"></div>
                    <div class="team-info">
                        <div class="team-name">Priya Sharma</div>
                        <div class="team-position">Creative Director</div>
                        <p>Priya ensures every design meets our high standards for creativity and impact.</p>
                    </div>
                </div>
                
                <div class="team-card">
                    <div class="team-image" style="background-image: url('./assets/images/team/team3.jpg');"></div>
                    <div class="team-info">
                        <div class="team-name">Amit Kumar</div>
                        <div class="team-position">Production Manager</div>
                        <p>Amit oversees our printing operations to guarantee perfect results every time.</p>
                    </div>
                </div>
                
                <div class="team-card">
                    <div class="team-image" style="background-image: url('./assets/images/team/team4.jpg');"></div>
                    <div class="team-info">
                        <div class="team-name">Neha Gupta</div>
                        <div class="team-position">Customer Success</div>
                        <p>Neha and her team ensure every client receives exceptional service.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Stats Section -->
        <section class="section">
            <h2 class="section-title">By The Numbers</h2>
            <p>Our commitment to excellence has led to impressive growth and satisfied customers.</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">5,000+</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">50,000+</div>
                    <div class="stat-label">Products Delivered</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">25</div>
                    <div class="stat-label">Team Members</div>
                </div>
            </div>
        </section>
        
        <!-- Our Values Section -->
        <section class="section">
            <h2 class="section-title">Our Core Values</h2>
            <p>These principles guide everything we do at Digital Media.</p>
            
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <ion-icon name="diamond-outline"></ion-icon>
                    </div>
                    <h3 class="value-title">Quality First</h3>
                    <p>We never compromise on quality. Every product that leaves our facility meets our rigorous standards.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <ion-icon name="bulb-outline"></ion-icon>
                    </div>
                    <h3 class="value-title">Innovation</h3>
                    <p>We continuously invest in new technologies and techniques to deliver cutting-edge solutions.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <ion-icon name="people-outline"></ion-icon>
                    </div>
                    <h3 class="value-title">Customer Focus</h3>
                    <p>Your satisfaction is our top priority. We listen carefully and respond quickly to your needs.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <ion-icon name="leaf-outline"></ion-icon>
                    </div>
                    <h3 class="value-title">Sustainability</h3>
                    <p>We're committed to eco-friendly practices, using sustainable materials whenever possible.</p>
                </div>
            </div>
        </section>
        
        <!-- CTA Section -->
        <section class="cta-section">
            <h2 class="cta-title">Ready to Bring Your Ideas to Life?</h2>
            <p>Whether you need business cards, marketing materials, or custom prints, we've got you covered with premium quality and exceptional service.</p>
            <a href="https://wa.me/919934940864?text=Hi%20Digital%20Media,%20I%27m%20interested%20in%20your%20printing%20services." target="_blank" rel="noopener noreferrer" class="cta-button">Get in Touch</a>
        </section>
    </div>

    <!-- IONICONS -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php require_once 'footer.php'; ?>
</body>
</html>