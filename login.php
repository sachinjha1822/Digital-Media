<?php 
$pageTitle = "Login - Digital Media";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/style-prefix.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <!-- Favicon -->
    <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">
  <style>
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 15px;
    }

    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px 25px;
      border-radius: 5px;
      color: white;
      font-weight: 500;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      z-index: 1000;
      animation: slideIn 0.3s, fadeOut 0.5s 2.5s forwards;
      background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    }

    .notification.success {
      background: linear-gradient(135deg, #4CAF50, #66BB6A);
    }
    
    .notification.error {
      background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    }
    
    .notification.warning {
      background: linear-gradient(135deg, #FFA000, #FFB74D);
    }
    
    @keyframes slideIn {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes fadeOut {
      from { opacity: 1; }
      to { opacity: 0; }
    }
    
    .auth-container {
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .auth-logo {
      width: 80px;
      height: auto;
      display: block;
      margin: 0 auto 10px;
    }

    .auth-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 30px;
      text-align: center;
      color: var(--eerie-black);
    }

    .auth-subtitle {
      font-size: 18px;
      font-weight: 500;
      margin-bottom: 30px;
      text-align: center;
      color: var(--eerie-black);
    }

    .auth-form .form-group {
      margin-bottom: 20px;
    }

    .auth-form label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--sonic-silver);
    }

    .auth-form input {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid var(--cultured);
      border-radius: 5px;
      font-size: 14px;
      transition: var(--transition-timing);
    }

    .auth-form input.error {
      border-color: #ff6b6b;
    }

    .auth-form input:focus {
      border-color: var(--salmon-pink);
      outline: none;
    }

    .error-message {
      color: #ff6b6b;
      font-size: 13px;
      margin-top: 5px;
      display: none;
    }

    .auth-form .forgot-password {
      display: block;
      text-align: right;
      margin-top: 5px;
      font-size: 13px;
      color: var(--salmon-pink);
      text-decoration: none;
    }

    .auth-form .forgot-password:hover {
      text-decoration: underline;
    }

    .auth-form .submit-btn {
      width: 100%;
      padding: 12px;
      background-color: var(--salmon-pink);
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 20px;
      transition: var(--transition-timing);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .auth-form .submit-btn:hover {
      background-color: var(--eerie-black);
    }

    .auth-switch {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
    }

    .auth-switch a {
      color: var(--salmon-pink);
      font-weight: 500;
    }

    .social-login {
      margin-top: 30px;
      text-align: center;
    }

    .social-login p {
      position: relative;
      margin-bottom: 20px;
      color: var(--sonic-silver);
    }

    .social-login p::before,
    .social-login p::after {
      content: "";
      position: absolute;
      top: 50%;
      width: 30%;
      height: 1px;
      background-color: var(--cultured);
    }

    .social-login p::before {
      left: 0;
    }

    .social-login p::after {
      right: 0;
    }

    .google-login-btn {
      display: inline-flex;
      align-items: center;
      padding: 10px 20px;
      border: 1px solid #dadce0;
      border-radius: 4px;
      font-family: 'Roboto', sans-serif;
      font-weight: 500;
      font-size: 16px;
      color: #3c4043;
      background: white;
      text-decoration: none;
      cursor: pointer;
      transition: background-color 0.3s, box-shadow 0.3s;
      user-select: none;
    }

    .google-login-btn:hover {
      background-color: #f7f8f8;
      box-shadow: 0 1px 2px rgba(60, 64, 67, 0.3);
    }

    .google-login-btn svg {
      flex-shrink: 0;
    }

    .spinner-border {
      vertical-align: middle;
      margin-left: 8px;
    }

    /* Password toggle styles */
    .password-wrapper {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--sonic-silver);
      background: none;
      border: none;
      padding: 5px;
    }

    .password-toggle:hover {
      color: var(--eerie-black);
    }

    .password-toggle i {
      font-size: 18px;
    }
  </style>
</head>
<body>
  <!-- LOGIN FORM -->
  <div class="container">
    <div id="notification" class="notification" style="display: none;"></div>
    <div class="auth-container">
      <img src="./assets/images/logo/favicon.ico" alt="Digital Media" class="auth-logo">
      <h1 class="auth-title">Welcome Back</h1>
      <p class="auth-subtitle">Login to access your account</p>
    
      <form class="auth-form" id="loginForm">
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="Enter your email">
          <div class="error-message" id="emailError"></div>
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Enter your password">
            <button type="button" class="password-toggle" id="togglePassword">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div class="error-message" id="passwordError"></div>
          <a href="forgot-password.php" class="forgot-password">Forgot Password?</a>
        </div>
        
        <button type="submit" class="submit-btn">
          <span id="loginText">Login</span>
          <span id="loginSpinner" class="spinner-border spinner-border-sm" role="status" style="display: none;">
            <span class="visually-hidden">Loading...</span>
          </span>
        </button>
      </form>
      
      <div class="auth-switch">
        Don't have an account? <a href="signup.php">Sign up here</a>
      </div>
      
      <div class="social-login">
        <p>Or login with</p>
        <!-- Google Sign-In button styled -->
        <a href="https://accounts.google.com/o/oauth2/v2/auth?client_id=1070538201136-1spl35re93j2hfiikk35eitba2gtafjd.apps.googleusercontent.com&redirect_uri=https://digitalmedia.free.nf/api/auth/google-callback.php&response_type=code&scope=email%20profile&access_type=online" class="google-login-btn">
          <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" style="margin-right: 10px;">
            <path fill="#4285F4" d="M17.64 9.2045c0-.638-.0575-1.25-.163-1.837H9v3.481h4.844c-.208 1.124-.843 2.08-1.8 2.72v2.25h2.908c1.703-1.567 2.69-3.872 2.69-6.614z"/>
            <path fill="#34A853" d="M9 18c2.43 0 4.476-.805 5.968-2.18l-2.908-2.25c-.807.54-1.84.86-3.06.86-2.352 0-4.345-1.59-5.06-3.724H1.974v2.34C3.453 15.933 6.042 18 9 18z"/>
            <path fill="#FBBC05" d="M3.94 10.706a5.44 5.44 0 010-3.41V5.955H1.974a8.98 8.98 0 000 6.09l1.967-1.34z"/>
            <path fill="#EA4335" d="M9 3.576c1.323 0 2.51.456 3.444 1.35l2.582-2.58C13.473 1.01 11.424 0 9 0 6.042 0 3.453 2.07 1.974 5.954l1.966 1.34c.58-2.13 2.7-3.718 5.06-3.718z"/>
          </svg>
          Login with Google
        </a>
      </div>
    </div>
  </div>

  <script>
    // Function to show notification
    function showNotification(message, type = 'error') {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.className = 'notification ' + type;
      notification.style.display = 'block';
      
      // Hide after 3 seconds
      setTimeout(() => {
        notification.style.display = 'none';
      }, 3000);
    }

    // Password visibility toggle
    function setupPasswordToggle() {
      const togglePassword = document.getElementById('togglePassword');
      const password = document.getElementById('password');
      
      if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
          const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
          password.setAttribute('type', type);
          this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
      }
    }

    // Helper function to show errors
    function showError(fieldId, message) {
      const field = document.getElementById(fieldId);
      const errorElement = document.getElementById(`${fieldId}Error`);
      
      if (field) field.classList.add('error');
      if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
      }
    }

    // Helper function to clear errors
    function clearError(fieldId) {
      const field = document.getElementById(fieldId);
      const errorElement = document.getElementById(`${fieldId}Error`);
      
      if (field) field.classList.remove('error');
      if (errorElement) {
        errorElement.textContent = '';
        errorElement.style.display = 'none';
      }
    }

    // Form validation
    function validateForm(email, password) {
      let isValid = true;
      
      // Email validation
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!email) {
        showError('email', 'Email is required');
        isValid = false;
      } else if (!emailRegex.test(email)) {
        showError('email', 'Please enter a valid email address');
        isValid = false;
      } else {
        clearError('email');
      }
      
      // Password validation
      if (!password) {
        showError('password', 'Password is required');
        isValid = false;
      } else if (password.length < 6) {
        showError('password', 'Password must be at least 6 characters');
        isValid = false;
      } else {
        clearError('password');
      }
      
      return isValid;
    }

    // Form submission handler
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      const email = emailInput.value.trim();
      const password = passwordInput.value;
      
      // Validate form
      if (!validateForm(email, password)) {
        return;
      }
      
      // Show loading spinner
      const submitBtn = document.querySelector('.submit-btn');
      submitBtn.disabled = true;
      document.getElementById('loginText').style.display = 'none';
      document.getElementById('loginSpinner').style.display = 'inline-block';

      try {
        const response = await fetch('https://digitalmedia.free.nf/api/auth/login.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          credentials: 'include',
          body: JSON.stringify({ email, password })
        });

        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
          throw new Error('Invalid server response. Please try again.');
        }

        const data = await response.json();

        if (data.status === 'success') {
          // Login success
          showNotification('Login successful! Redirecting...', 'success');
          setTimeout(() => {
            window.location.href = data.redirect || 'index.php';
          }, 1000);
        } else {
          // Handle different error cases
          let errorMessage = data.message || 'Login failed';
          
          if (data.error === 'invalid_credentials') {
            errorMessage = 'Invalid email or password';
          } else if (data.error === 'account_locked') {
            errorMessage = 'Account locked. Please try again later or reset your password.';
          } else if (data.error === 'email_not_verified') {
            errorMessage = 'Email not verified. Please check your inbox.';
          }
          
          showNotification(errorMessage, 'error');
        }

      } catch (error) {
        console.error('Login error:', error);
        showNotification(error.message || 'Network error. Please try again.', 'error');
      } finally {
        submitBtn.disabled = false;
        document.getElementById('loginText').style.display = 'inline';
        document.getElementById('loginSpinner').style.display = 'none';
      }
    });

    // Initialize password toggle on page load
    document.addEventListener('DOMContentLoaded', function() {
      setupPasswordToggle();
    });
  </script>
</body>
</html>