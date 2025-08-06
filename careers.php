<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers - Digital Media</title>
    <style>
        .careers-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .careers-hero {
            background: linear-gradient(135deg, #4f46e5, #8b5cf6);
            color: white;
            padding: 4rem 2rem;
            border-radius: 1rem;
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .careers-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .careers-hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }
        
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }
        
        .benefit-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .benefit-icon {
            font-size: 2.5rem;
            color: #4f46e5;
            margin-bottom: 1rem;
        }
        
        .job-listings {
            margin: 4rem 0;
        }
        
        .job-card {
            background: white;
            border-radius: 0.5rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-left: 4px solid #4f46e5;
        }
        
        .job-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .job-meta {
            display: flex;
            gap: 2rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }
        
        .job-description {
            margin-bottom: 1.5rem;
            color: #555;
        }
        
        .apply-btn {
            display: inline-block;
            background: #4f46e5;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        
        .apply-btn:hover {
            background: #4338ca;
        }
        
        @media (max-width: 768px) {
            .careers-hero {
                padding: 3rem 1rem;
            }
            
            .job-meta {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="careers-container">
        <div class="careers-hero">
            <h1>Build Your Career With Us</h1>
            <p>Join our team of passionate professionals and help shape the future of digital printing solutions.</p>
            <a href="#openings" class="apply-btn">View Open Positions</a>
        </div>
        
        <h2>Why Work at Digital Media?</h2>
        <p>We're committed to creating an environment where talented individuals can thrive and grow their careers.</p>
        
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">
                    <ion-icon name="rocket-outline"></ion-icon>
                </div>
                <h3>Growth Opportunities</h3>
                <p>We invest in our employees' development through training programs and career advancement paths.</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
                <h3>Collaborative Culture</h3>
                <p>Work with a team that values creativity, innovation, and mutual support.</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">
                    <ion-icon name="heart-outline"></ion-icon>
                </div>
                <h3>Work-Life Balance</h3>
                <p>Flexible schedules and generous leave policies to support your wellbeing.</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">
                    <ion-icon name="trophy-outline"></ion-icon>
                </div>
                <h3>Competitive Benefits</h3>
                <p>Comprehensive health insurance, retirement plans, and performance bonuses.</p>
            </div>
        </div>
        
        <div class="job-listings" id="openings">
            <h2>Current Openings</h2>
            
            <div class="job-card">
                <h3 class="job-title">Graphic Designer</h3>
                <div class="job-meta">
                    <span><ion-icon name="location-outline"></ion-icon> Mumbai</span>
                    <span><ion-icon name="briefcase-outline"></ion-icon> Full-time</span>
                    <span><ion-icon name="calendar-outline"></ion-icon> Posted 2 weeks ago</span>
                </div>
                <p class="job-description">We're looking for a creative graphic designer with 3+ years experience in print design to join our team. You'll work on diverse projects from business cards to large format prints.</p>
                <a href="apply.php?position=graphic-designer" class="apply-btn">Apply Now</a>
            </div>
            
            <div class="job-card">
                <h3 class="job-title">Production Assistant</h3>
                <div class="job-meta">
                    <span><ion-icon name="location-outline"></ion-icon> Mumbai</span>
                    <span><ion-icon name="briefcase-outline"></ion-icon> Full-time</span>
                    <span><ion-icon name="calendar-outline"></ion-icon> Posted 1 week ago</span>
                </div>
                <p class="job-description">Entry-level position in our production department. No experience required - we provide training. Great opportunity to learn about digital printing processes.</p>
                <a href="apply.php?position=production-assistant" class="apply-btn">Apply Now</a>
            </div>
            
            <div class="job-card">
                <h3 class="job-title">Sales Representative</h3>
                <div class="job-meta">
                    <span><ion-icon name="location-outline"></ion-icon> Remote</span>
                    <span><ion-icon name="briefcase-outline"></ion-icon> Full-time</span>
                    <span><ion-icon name="calendar-outline"></ion-icon> Posted 3 days ago</span>
                </div>
                <p class="job-description">Seeking an experienced sales professional to help grow our corporate client base. 2+ years in B2B sales preferred. Uncapped commission structure.</p>
                <a href="apply.php?position=sales-representative" class="apply-btn">Apply Now</a>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 3rem;">
            <p>Don't see your ideal position? We're always interested in meeting talented people.</p>
            <a href="contact.html" class="apply-btn">Send Us Your Resume</a>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php require_once 'footer.php'; ?>
</body>
</html>