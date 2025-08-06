<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team - Digital Media</title>
    <style>
        .team-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .page-header h1 {
            font-size: 2.5rem;
            color: #4f46e5;
            margin-bottom: 1rem;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }
        
        .team-member {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .team-member:hover {
            transform: translateY(-5px);
        }
        
        .member-image {
            height: 300px;
            background-size: cover;
            background-position: center;
        }
        
        .member-info {
            padding: 1.5rem;
        }
        
        .member-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .member-position {
            color: #4f46e5;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .member-bio {
            color: #666;
            margin-bottom: 1.5rem;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-links a {
            color: #6b7280;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }
        
        .social-links a:hover {
            color: #4f46e5;
        }
        
        .department-section {
            margin-bottom: 4rem;
        }
        
        .department-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e0e7ff;
        }
        
        @media (max-width: 768px) {
            .team-grid {
                grid-template-columns: 1fr;
            }
            
            .member-image {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="team-container">
        <div class="page-header">
            <h1>Meet Our Team</h1>
            <p>The talented individuals behind Digital Media's success</p>
        </div>
        
        <div class="department-section">
            <h2 class="department-title">Leadership Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-image" style="background-image: url('./assets/images/team/ceo.jpg');"></div>
                    <div class="member-info">
                        <h3 class="member-name">Rajesh Patel</h3>
                        <p class="member-position">CEO & Founder</p>
                        <p class="member-bio">With 15+ years in the printing industry, Rajesh founded Digital Media with a vision for quality and innovation.</p>
                        <div class="social-links">
                            <a href="#"><ion-icon name="logo-linkedin"></ion-icon></a>
                            <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                        </div>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-image" style="background-image: url('./assets/images/team/operations.jpg');"></div>
                    <div class="member-info">
                        <h3 class="member-name">Priya Sharma</h3>
                        <p class="member-position">Operations Director</p>
                        <p class="member-bio">Priya ensures our production processes run smoothly while maintaining our high quality standards.</p>
                        <div class="social-links">
                            <a href="#"><ion-icon name="logo-linkedin"></ion-icon></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="department-section">
            <h2 class="department-title">Creative Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-image" style="background-image: url('./assets/images/team/design1.jpg');"></div>
                    <div class="member-info">
                        <h3 class="member-name">Amit Kumar</h3>
                        <p class="member-position">Creative Director</p>
                        <p class="member-bio">Amit leads our design team with an eye for detail and passion for visual storytelling.</p>
                        <div class="social-links">
                            <a href="#"><ion-icon name="logo-behance"></ion-icon></a>
                            <a href="#"><ion-icon name="logo-dribbble"></ion-icon></a>
                        </div>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-image" style="background-image: url('./assets/images/team/design2.jpg');"></div>
                    <div class="member-info">
                        <h3 class="member-name">Neha Gupta</h3>
                        <p class="member-position">Senior Designer</p>
                        <p class="member-bio">Neha specializes in typography and layout design for print materials.</p>
                        <div class="social-links">
                            <a href="#"><ion-icon name="logo-behance"></ion-icon></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="department-section">
            <h2 class="department-title">Production Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-image" style="background-image: url('./assets/images/team/production1.jpg');"></div>
                    <div class="member-info">
                        <h3 class="member-name">Vikram Singh</h3>
                        <p class="member-position">Production Manager</p>
                        <p class="member-bio">Vikram oversees our printing operations with 10+ years of technical expertise.</p>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-image" style="background-image: url('./assets/images/team/production2.jpg');"></div>
                    <div class="member-info">
                        <h3 class="member-name">Anjali Mehta</h3>
                        <p class="member-position">Quality Control</p>
                        <p class="member-bio">Anjali ensures every product meets our rigorous quality standards before shipping.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php require_once 'footer.php'; ?>
</body>
</html>