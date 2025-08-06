<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonials - Digital Media</title>
    <style>
        .dm-testimonials-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .dm-testimonials-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .dm-testimonials-header h1 {
            font-size: 2.5rem;
            color: #4f46e5;
            margin-bottom: 1rem;
        }
        
        .dm-testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .dm-testimonial-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            position: relative;
        }
        
        .dm-testimonial-card:before {
            content: '"';
            position: absolute;
            top: 1rem;
            left: 1.5rem;
            font-size: 4rem;
            color: #e0e7ff;
            font-family: serif;
            line-height: 1;
            z-index: 0;
        }
        
        .dm-testimonial-content {
            position: relative;
            z-index: 1;
            margin-bottom: 1.5rem;
            font-style: italic;
            color: #555;
            line-height: 1.6;
        }
        
        .dm-testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .dm-author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin-right: 1rem;
        }
        
        .dm-author-info h4 {
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .dm-author-info p {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .dm-rating {
            color: #fbbf24;
            margin-bottom: 0.5rem;
            display: flex;          /* Force horizontal layout */
            gap: 0.25rem;           /* Optional: spacing between stars */
            align-items: center;
        }

        
        .dm-video-testimonials {
            margin: 4rem 0;
        }
        
        .dm-video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .dm-video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 0.5rem;
        }
        
        .dm-video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        @media (max-width: 768px) {
            .dm-testimonials-grid {
                grid-template-columns: 1fr;
            }
            
            .dm-video-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dm-testimonials-container">
        <div class="dm-testimonials-header">
            <h1>What Our Clients Say</h1>
            <p>Hear from businesses and individuals who have used our services</p>
        </div>
        
        <div class="dm-testimonials-grid">
            <div class="dm-testimonial-card">
                <div class="dm-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                </div>
                <p class="dm-testimonial-content">Digital Media transformed our company's branding materials. The quality of their printing is exceptional, and their design team understood our vision perfectly.</p>
                <div class="dm-testimonial-author">
                    <div class="dm-author-avatar" style="background-image: url('./assets/images/testimonials/client1.jpg');"></div>
                    <div class="dm-author-info">
                        <h4>Rahul Mehta</h4>
                        <p>CEO, TechSolutions</p>
                    </div>
                </div>
            </div>
            
            <div class="dm-testimonial-card">
                <div class="dm-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                </div>
                <p class="dm-testimonial-content">We've been using Digital Media for all our printing needs for 3 years now. Their attention to detail and customer service is unmatched in the industry.</p>
                <div class="dm-testimonial-author">
                    <div class="dm-author-avatar" style="background-image: url('./assets/images/testimonials/client2.jpg');"></div>
                    <div class="dm-author-info">
                        <h4>Priya Nair</h4>
                        <p>Marketing Director, GreenLife</p>
                    </div>
                </div>
            </div>
            
            <div class="dm-testimonial-card">
                <div class="dm-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                </div>
                <p class="dm-testimonial-content">The PVC cards we ordered exceeded our expectations. They were delivered ahead of schedule and the quality was perfect. Will definitely use them again!</p>
                <div class="dm-testimonial-author">
                    <div class="dm-author-avatar" style="background-image: url('./assets/images/testimonials/client3.jpg');"></div>
                    <div class="dm-author-info">
                        <h4>Arjun Kapoor</h4>
                        <p>HR Manager, EduCare</p>
                    </div>
                </div>
            </div>
            
            <div class="dm-testimonial-card">
                <div class="dm-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                </div>
                <p class="dm-testimonial-content">As a small business owner, I appreciate their affordable prices without compromising on quality. Their team helped me create professional materials on a budget.</p>
                <div class="dm-testimonial-author">
                    <div class="dm-author-avatar" style="background-image: url('./assets/images/testimonials/client4.jpg');"></div>
                    <div class="dm-author-info">
                        <h4>Neha Sharma</h4>
                        <p>Owner, Cafe Aroma</p>
                    </div>
                </div>
            </div>
            
            <div class="dm-testimonial-card">
                <div class="dm-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star-half-outline"></ion-icon>
                </div>
                <p class="dm-testimonial-content">We ordered 500 wedding invitations and they were absolutely stunning. The paper quality and printing were perfect, and our guests couldn't stop complimenting them.</p>
                <div class="dm-testimonial-author">
                    <div class="dm-author-avatar" style="background-image: url('./assets/images/testimonials/client5.jpg');"></div>
                    <div class="dm-author-info">
                        <h4>Ananya & Rohan</h4>
                        <p>Wedding Clients</p>
                    </div>
                </div>
            </div>
            
            <div class="dm-testimonial-card">
                <div class="dm-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                </div>
                <p class="dm-testimonial-content">Their quick turnaround saved us when we needed last-minute presentation materials for an important investor meeting. The quality was excellent despite the tight deadline.</p>
                <div class="dm-testimonial-author">
                    <div class="dm-author-avatar" style="background-image: url('./assets/images/testimonials/client6.jpg');"></div>
                    <div class="dm-author-info">
                        <h4>Vikram Joshi</h4>
                        <p>Startup Founder</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="dm-video-testimonials">
            <h2 style="text-align: center; margin-bottom: 2rem;">Video Testimonials</h2>
            <div class="dm-video-grid">
                <div class="dm-video-container">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="dm-video-container">
                    <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 3rem;">
            <h3>Ready to experience our quality service?</h3>
            <a href="contact.html" class="dm-cta-button" style="display: inline-block; margin-top: 1rem;">Get a Free Quote</a>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php require_once 'footer.php'; ?>
</body>
</html>