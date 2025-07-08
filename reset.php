<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Redirect if already logged in
if (!empty($_SESSION['auth'])) {
    $_SESSION['message'] = "You are already logged in";
    $_SESSION['messageType'] = "error";
    header('Location: index.php');
    exit;
}

include 'includes/header.php';
include 'admin/config/dbcon.php';
?>

<section id="reset-page">
  <div class="reset-container">
    <div class="reset-form">
      <h1>Reset Password</h1>
      <p>Enter your email address and we'll send you a link to reset your password</p>

      <form method="post" action="functions/reset_password.php" id="resetForm">
        <input type="hidden" name="reset_request" value="1">
        <input type="hidden" name="timezone" id="timezone" value="">
        
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" name="email" id="email" required>
        </div>

        <div class="form-actions">
          <button type="submit" class="reset-btn">
            <span class="btn-text">Send Reset Link</span>
            <div class="spinner" id="resetSpinner">
              <i class="fas fa-spinner fa-spin"></i>
            </div>
          </button>
        </div>

        <div class="form-links">
          <a href="login.php">Back to Login</a>
          <a href="register.php">Don't have an account? Sign up</a>
        </div>
      </form>
    </div>

    <div class="reset-image">
      <div class="image-content">
        <h2>Forgot Your Password?</h2>
        <p>No worries! We'll help you get back into your account quickly and securely.</p>
        <div class="benefits">
          <div class="benefit">
            <i class="fas fa-envelope"></i>
            <span>Email verification</span>
          </div>
          <div class="benefit">
            <i class="fas fa-shield-alt"></i>
            <span>Secure process</span>
          </div>
          <div class="benefit">
            <i class="fas fa-clock"></i>
            <span>Quick recovery</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
#reset-page {
  font-family: "Segoe UI", sans-serif;
  color: #333;
  padding: 2rem 0;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.reset-container {
  display: flex;
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
  max-width: 1000px;
  margin: 0 auto;
  min-height: 500px;
}

.reset-form {
  flex: 1;
  padding: 3rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.reset-form h1 {
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
  color: #333;
  font-weight: 700;
}

.reset-form p {
  color: #666;
  margin-bottom: 2rem;
  font-size: 1.1rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #333;
}

.form-group input {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.form-group input:focus {
  border-color: #d32f2f;
  outline: none;
  box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
}

.form-group input.error {
  border-color: #f44336;
  animation: shake 0.5s ease-in-out;
}

.form-group input.success {
  border-color: #4caf50;
}

.field-error {
  color: #f44336;
  font-size: 0.85rem;
  margin-top: 0.25rem;
  min-height: 1.2rem;
  display: none;
}

.field-error.show {
  display: block;
  animation: slideDown 0.3s ease-out;
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  75% { transform: translateX(5px); }
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.form-actions {
  margin-bottom: 1.5rem;
}

.reset-btn {
  width: 100%;
  padding: 0.75rem;
  background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.reset-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(211, 47, 47, 0.3);
}

.reset-btn:active {
  transform: translateY(0);
}

.reset-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
  transform: none;
}

.spinner {
  display: none;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.spinner.show {
  display: block;
}

.btn-text {
  transition: opacity 0.3s ease;
}

.btn-text.hide {
  opacity: 0;
}

.form-links {
  text-align: center;
  margin-top: 1.5rem;
}

.form-links a {
  display: block;
  color: #d32f2f;
  text-decoration: none;
  margin-bottom: 0.5rem;
  font-weight: 500;
  transition: color 0.3s ease;
}

.form-links a:hover {
  color: #b71c1c;
  text-decoration: underline;
}

.reset-image {
  flex: 1;
  background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3rem;
  color: white;
}

.image-content {
  text-align: center;
  max-width: 400px;
}

.image-content h2 {
  font-size: 2rem;
  margin-bottom: 1rem;
  font-weight: 700;
}

.image-content p {
  font-size: 1.1rem;
  margin-bottom: 2rem;
  opacity: 0.9;
  line-height: 1.6;
}

.benefits {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.benefit {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 1rem;
}

.benefit i {
  font-size: 1.2rem;
  width: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
  .reset-container {
    flex-direction: column;
    margin: 1rem;
    min-height: auto;
  }
  
  .reset-form {
    padding: 2rem;
  }
  
  .reset-image {
    padding: 2rem;
  }
  
  .reset-form h1 {
    font-size: 2rem;
  }
  
  .image-content h2 {
    font-size: 1.5rem;
  }
}

/* Message Styles */
.message {
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 1.5rem;
  font-weight: 500;
}

.message.success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.message.error {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.message.info {
  background-color: #d1ecf1;
  color: #0c5460;
  border: 1px solid #bee5eb;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const resetForm = document.getElementById('resetForm');
    const resetBtn = document.querySelector('.reset-btn');
    const btnText = document.querySelector('.btn-text');
    const spinner = document.getElementById('resetSpinner');
    const emailInput = document.getElementById('email');

    // Form validation
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function showFieldError(field, message) {
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (!errorDiv) {
            const newErrorDiv = document.createElement('div');
            newErrorDiv.className = 'field-error';
            newErrorDiv.textContent = message;
            field.parentNode.appendChild(newErrorDiv);
        } else {
            errorDiv.textContent = message;
        }
        errorDiv.classList.add('show');
        field.classList.add('error');
        field.classList.remove('success');
    }

    function clearFieldError(field) {
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.classList.remove('show');
        }
        field.classList.remove('error');
        field.classList.add('success');
    }

    // Email validation
    emailInput.addEventListener('blur', function() {
        const email = this.value.trim();
        if (email === '') {
            showFieldError(this, 'Email is required');
        } else if (!validateEmail(email)) {
            showFieldError(this, 'Please enter a valid email address');
        } else {
            clearFieldError(this);
        }
    });

    emailInput.addEventListener('input', function() {
        if (this.classList.contains('error')) {
            const email = this.value.trim();
            if (email !== '' && validateEmail(email)) {
                clearFieldError(this);
            }
        }
    });

    // Form submission
    resetForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = emailInput.value.trim();
        
        // Validate email
        if (email === '') {
            showFieldError(emailInput, 'Email is required');
            return;
        }
        
        if (!validateEmail(email)) {
            showFieldError(emailInput, 'Please enter a valid email address');
            return;
        }

        // Show loading state
        resetBtn.disabled = true;
        btnText.classList.add('hide');
        spinner.classList.add('show');

        // Submit form
        this.submit();
    });

    var tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    document.getElementById('timezone').value = tz;
});
</script>

<?php include 'includes/footer.php'; ?>
