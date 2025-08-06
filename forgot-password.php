<?php 
$pageTitle = "Forgot Password - Digital Media";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="./assets/css/style-prefix.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <style>
    .notification {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 5px;
      display: none;
    }
    .notification.error {
      background-color: #ffebee;
      color: #c62828;
      border: 1px solid #ef9a9a;
    }
    .notification.success {
      background-color: #e8f5e9;
      color: #2e7d32;
      border: 1px solid #a5d6a7;
    }
  </style>
</head>
<body>
  <div class="container">
    <div id="notification" class="notification" style="display: none;"></div>
    <div class="auth-container">
      <img src="./assets/images/logo/favicon.ico" alt="Digital Media" class="auth-logo">
      <h1 class="auth-title">Reset Your Password</h1>
      <p class="auth-subtitle">Enter your email to receive a reset link</p>
      
      <form class="auth-form" id="forgotPasswordForm">
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Enter your registered email" required>
          <div class="error-message" id="emailError"></div>
        </div>
        
        <button type="submit" class="submit-btn">
          <span id="submitText">Send Reset Link</span>
          <span id="submitSpinner" class="spinner-border spinner-border-sm" role="status" style="display: none;"></span>
        </button>
      </form>
      
      <div class="auth-switch">
        Remember your password? <a href="login.php">Login here</a>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('forgotPasswordForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value.trim();
    const submitBtn = document.querySelector('.submit-btn');
    
    // Validate email
    if (!email) {
        showNotification('Email is required', 'error');
        return;
    }

    // Show loading
    submitBtn.disabled = true;
    document.getElementById('submitText').style.display = 'none';
    document.getElementById('submitSpinner').style.display = 'inline-block';

    try {
        const response = await fetch('api/auth/forgot-password.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email })
        });

        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Invalid server response');
        }

        const data = await response.json();

        if (data.status === 'success') {
            showNotification(data.message, 'success');
        } else {
            // Show detailed error if available
            const errorMsg = data.debug ? `${data.message} (${data.debug})` : data.message;
            showNotification(errorMsg, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Network error. Please try again.', 'error');
    } finally {
        submitBtn.disabled = false;
        document.getElementById('submitText').style.display = 'inline';
        document.getElementById('submitSpinner').style.display = 'none';
    }
});
  </script>
</body>
</html>