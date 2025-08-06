<?php 
$pageTitle = "Sign Up - Digital Media";
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

    .name-fields {
      display: flex;
      gap: 15px;
    }

    .name-fields .form-group {
      flex: 1;
    }

    .terms {
      font-size: 13px;
      color: var(--sonic-silver);
      margin-top: 15px;
      text-align: center;
    }

    .terms a {
      color: var(--salmon-pink);
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
<!-- SIGNUP FORM -->
<div class="container">
  <div id="notification" class="notification" style="display: none;"></div>
  <div class="auth-container">
    <img src="./assets/images/logo/favicon.ico" alt="Digital Media" class="auth-logo">
    <h1 class="auth-title">Create Your Account</h1>
    
    <form class="auth-form" id="signupForm">
      <div class="name-fields">
        <div class="form-group">
          <label for="first-name">First Name</label>
          <input type="text" id="first-name" name="first-name" placeholder="Enter your first name">
          <div class="error-message" id="first-name-error"></div>
        </div>
        
        <div class="form-group">
          <label for="last-name">Last Name</label>
          <input type="text" id="last-name" name="last-name" placeholder="Enter your last name">
          <div class="error-message" id="last-name-error"></div>
        </div>
      </div>
      
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email">
        <div class="error-message" id="email-error"></div>
      </div>
      
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
        <div class="error-message" id="phone-error"></div>
      </div>
      
      <div class="form-group">
        <label for="password">Password</label>
        <div class="password-wrapper">
          <input type="password" id="password" name="password" placeholder="Create a password">
          <button type="button" class="password-toggle" id="togglePassword">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <div class="error-message" id="password-error"></div>
      </div>
      
      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <div class="password-wrapper">
          <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password">
          <button type="button" class="password-toggle" id="toggleConfirmPassword">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        <div class="error-message" id="confirm-password-error"></div>
      </div>
      
      <button type="submit" class="submit-btn">
        <span id="signupText">Create Account</span>
        <span id="signupSpinner" class="spinner-border spinner-border-sm" role="status" style="display: none;">
          <span class="visually-hidden">Loading...</span>
        </span>
      </button>
      
      <p class="terms">
        By creating an account, you agree to our <a href="terms.php">Terms of Service</a> and <a href="privacy-policy.php">Privacy Policy</a>
      </p>
    </form>
    
    <div class="auth-switch">
      Already have an account? <a href="login.php">Login here</a>
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

// Helper function to show errors
function showError(fieldId, message) {
  const field = document.getElementById(fieldId);
  const errorElement = document.getElementById(`${fieldId}-error`);
  
  if (field) field.classList.add('error');
  if (errorElement) {
    errorElement.textContent = message;
    errorElement.style.display = 'block';
  }
}

// Helper function to clear errors
function clearError(fieldId) {
  const field = document.getElementById(fieldId);
  const errorElement = document.getElementById(`${fieldId}-error`);
  
  if (field) field.classList.remove('error');
  if (errorElement) {
    errorElement.textContent = '';
    errorElement.style.display = 'none';
  }
}

// Password visibility toggle
function setupPasswordToggle() {
  const togglePassword = document.getElementById('togglePassword');
  const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
  const password = document.getElementById('password');
  const confirmPassword = document.getElementById('confirm-password');
  
  if (togglePassword && password) {
    togglePassword.addEventListener('click', function() {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
  }
  
  if (toggleConfirmPassword && confirmPassword) {
    toggleConfirmPassword.addEventListener('click', function() {
      const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmPassword.setAttribute('type', type);
      this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
  }
}

// Client-side validation
function validateForm(formData) {
  let isValid = true;
  
  // Validate first name
  if (!formData.firstName) {
    showError('first-name', 'First name cannot be blank');
    isValid = false;
  } else if (formData.firstName.length < 2) {
    showError('first-name', 'First name must be at least 2 characters');
    isValid = false;
  } else {
    clearError('first-name');
  }
  
  // Validate last name
  if (!formData.lastName) {
    showError('last-name', 'Last name cannot be blank');
    isValid = false;
  } else if (formData.lastName.length < 2) {
    showError('last-name', 'Last name must be at least 2 characters');
    isValid = false;
  } else {
    clearError('last-name');
  }
  
  // Validate email
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!formData.email) {
    showError('email', 'Email cannot be blank');
    isValid = false;
  } else if (!emailRegex.test(formData.email)) {
    showError('email', 'Please enter a valid email address');
    isValid = false;
  } else {
    clearError('email');
  }
  
  // Validate phone (optional)
  if (formData.phone) {
    const phoneRegex = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
    if (!phoneRegex.test(formData.phone)) {
      showError('phone', 'Please enter a valid phone number');
      isValid = false;
    } else {
      clearError('phone');
    }
  }
  
  // Validate password
  if (!formData.password) {
    showError('password', 'Password cannot be blank');
    isValid = false;
  } else if (formData.password.length < 8) {
    showError('password', 'Password must be at least 8 characters');
    isValid = false;
  } else {
    clearError('password');
  }
  
  // Validate confirm password
  if (!formData.confirmPassword) {
    showError('confirm-password', 'Please confirm your password');
    isValid = false;
  } else if (formData.password !== formData.confirmPassword) {
    showError('confirm-password', 'Passwords do not match');
    isValid = false;
  } else {
    clearError('confirm-password');
  }
  
  return isValid;
}

// Form submission
document.getElementById('signupForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const formData = {
    firstName: document.getElementById('first-name').value.trim(),
    lastName: document.getElementById('last-name').value.trim(),
    email: document.getElementById('email').value.trim(),
    phone: document.getElementById('phone').value.trim(),
    password: document.getElementById('password').value,
    confirmPassword: document.getElementById('confirm-password').value
  };

  // Clear all errors before validation
  ['first-name', 'last-name', 'email', 'phone', 'password', 'confirm-password'].forEach(field => {
    clearError(field);
  });

  // Validate form
  if (!validateForm(formData)) {
    return;
  }

  // Show loading spinner
  const submitBtn = document.querySelector('.submit-btn');
  submitBtn.disabled = true;
  document.getElementById('signupText').style.display = 'none';
  document.getElementById('signupSpinner').style.display = 'inline-block';

  try {
    const response = await fetch('https://digitalmedia.free.nf/api/auth/signup.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(formData)
    });

    const contentType = response.headers.get('content-type');
    if (!contentType || !contentType.includes('application/json')) {
      throw new Error('Invalid server response');
    }

    const data = await response.json();

    if (data.status === 'success') {
      // Show success message
      showNotification(data.message || 'Registration successful!', 'success');
      // Redirect to login page
      setTimeout(() => {
        window.location.href = data.redirect || 'login.php';
      }, 1000);
    } else {
      // Handle specific errors from server
      if (data.field) {
        showError(data.field, data.message);
      } else {
        showNotification(data.message || 'Registration failed. Please try again.');
      }
    }
  } catch (error) {
    console.error('Signup error:', error);
    showNotification(error.message || 'An error occurred. Please try again.');
  } finally {
    submitBtn.disabled = false;
    document.getElementById('signupText').style.display = 'inline';
    document.getElementById('signupSpinner').style.display = 'none';
  }
});

// Real-time validation for better UX
document.getElementById('signupForm').addEventListener('input', function(e) {
  const target = e.target;
  const fieldId = target.id;
  const value = target.value.trim();
  
  // Clear error when user starts typing
  if (value) {
    clearError(fieldId);
  }
  
  // Validate password match in real-time
  if (fieldId === 'password' || fieldId === 'confirm-password') {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    
    if (password && confirmPassword && password !== confirmPassword) {
      showError('confirm-password', 'Passwords do not match');
    } else if (confirmPassword) {
      clearError('confirm-password');
    }
  }
});

// Initialize password toggle on page load
document.addEventListener('DOMContentLoaded', function() {
  setupPasswordToggle();
});
</script>
</body>
</html>