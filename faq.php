<?php require_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions - Digital Media</title>
    <style>
        .faq-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .faq-item {
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
        }
        .faq-question {
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 0.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .faq-answer {
            color: #666;
            line-height: 1.6;
            padding: 0.5rem 0;
        }
    </style>
</head>
<body>
    <div class="faq-container">
        <h1>Frequently Asked Questions</h1>
        
        <div class="faq-item">
            <div class="faq-question">What payment methods do you accept?<ion-icon name="chevron-down-outline"></ion-icon></div>
            <div class="faq-answer">
                We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">How long does production take?<ion-icon name="chevron-down-outline"></ion-icon></div>
            <div class="faq-answer">
                Standard production time is 3-5 business days after we receive your design files and approval.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">What file formats do you accept for designs?<ion-icon name="chevron-down-outline"></ion-icon></div>
            <div class="faq-answer">
                We accept JPG, PNG, PDF, PSD, and AI files. For best results, please provide high-resolution files (300 DPI or higher).
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">Can I get a proof before production?<ion-icon name="chevron-down-outline"></ion-icon></div>
            <div class="faq-answer">
                Yes, we provide digital proofs for approval before production begins. Additional charges may apply for multiple revisions.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">How can I track my order?<ion-icon name="chevron-down-outline"></ion-icon></div>
            <div class="faq-answer">
                Once your order ships, you'll receive a tracking number via email. You can track your package using our website or the courier's tracking system.
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const icon = question.querySelector('ion-icon');
                
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                    icon.setAttribute('name', 'chevron-down-outline');
                } else {
                    answer.style.display = 'block';
                    icon.setAttribute('name', 'chevron-up-outline');
                }
            });
        });
    </script>
    <?php require_once 'footer.php'; ?>
</body>
</html>