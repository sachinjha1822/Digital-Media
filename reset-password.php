<?php
require_once 'includes/db.php';
$pageTitle = "Reset Password - Digital Media";

// Check if token is valid
$token = $_GET['token'] ?? '';
$isValidToken = false;
$userId = null;

if ($token) {
    try {
        $stmt = $pdo->prepare("SELECT user_id FROM password_resets WHERE token = ? AND expires_at > NOW() AND used = 0");
        $stmt->execute([$token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            $isValidToken = true;
            $userId = $result['user_id'];
        }
    } catch (PDOException $e) {
        error_log("Token validation error: " . $e->getMessage());
    }
}
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
    .error-message {
      color: #ff6b6b;
      font-size: 13px;
      margin-top: 5px;
      display: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div id="notification" class="notification" style="display: none;"></div>
    <div class="auth-container">
      <img src="./assets/images/logo/favicon.ico" alt="Digital Media" class="auth-logo">
      
      <?php if ($isValidToken): ?>
        <h1 class="auth-title">Reset Your Password</h1>
        <form class="auth-form" id="resetPasswordForm">
          <input type="hidden" id="token" value="<?php echo htmlspecialchars($token); ?>">
          
          <div class="form-group">
            <label for="newPassword">New Password</label>
            <input type="password" id="newPassword" name="newPassword" placeholder="Enter new password" required minlength="6">
            <div class="error-message" id="newPasswordError"></div>
          </div>
          
          <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" required minlength="6">
            <div class="error-message" id="confirmPasswordError"></div>
          </div>
          
          <button type="submit" class="submit-btn">
            <span id="submitText">Reset Password</span>
            <span id="submitSpinner" class="spinner-border spinner-border-sm" role="status" style="display: none;"></span>
          </button>
        </form>
      <?php else: ?>
        <h1 class="auth-title">Invalid Token</h1>
        <p class="auth-subtitle">The password reset link is invalid or has expired.</p>
        <div class="auth-switch">
          <a href="forgot-password.php">Request a new reset link</a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script>
    document.getElementById('resetPasswordForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const token = document.getElementById('token').value;
      const newPassword = document.getElementById('newPassword').value;
      const confirmPassword = document.getElementById('confirmPassword').value;
      
      // Reset errors
      document.getElementById('newPasswordError').style.display = 'none';
      document.getElementById('confirmPasswordError').style.display = 'none';
      
      // Validate passwords
      if (newPassword.length < 6) {
        document.getElementById('newPasswordError').textContent = 'Password must be at least 6 characters';
        document.getElementById('newPasswordError').style.display = 'block';
        return;
      }
      
      if (newPassword !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
        document.getElementById('confirmPasswordError').style.display = 'block';
        return;
      }
      
      // Show loading spinner
      const submitBtn = document.querySelector('.submit-btn');
      submitBtn.disabled = true;
      document.getElementById('submitText').style.display = 'none';
      document.getElementById('submitSpinner').style.display = 'inline-block';

      try {
        const response = await fetch('api/auth/reset-password.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ token, newPassword })
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
          showNotification('Password reset successfully! Redirecting to login...', 'success');
          setTimeout(() => {
            window.location.href = 'login.php';
          }, 2000);
        } else {
          showNotification(data.message || 'Error resetting password', 'error');
        }
      } catch (error) {
        showNotification('Network error. Please try again.', 'error');
        console.error('Error:', error);
      } finally {
        submitBtn.disabled = false;
        document.getElementById('submitText').style.display = 'inline';
        document.getElementById('submitSpinner').style.display = 'none';
      }
    });
    
    function showNotification(message, type = 'error') {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.className = 'notification ' + type;
      notification.style.display = 'block';
      
      setTimeout(() => {
        notification.style.display = 'none';
      }, 5000);
    }
  </script>
</body>
</html>