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

// Validate token
$token = isset($_GET['token']) ? $_GET['token'] : '';
$valid_token = false;
$token_error = '';

if (!empty($token)) {
    $token = mysqli_real_escape_string($conn, $token);
    $check_token_query = "SELECT * FROM password_resets WHERE token = '$token' AND used = 0 AND expires_at > NOW()";
    $check_token_result = mysqli_query($conn, $check_token_query);
    
    if (mysqli_num_rows($check_token_result) > 0) {
        $valid_token = true;
    } else {
        $token_error = "Invalid or expired reset link. Please request a new one.";
    }
} else {
    $token_error = "No reset token provided.";
}
?>

<section id="reset-password-page">
  <div class="reset-password-container">
    <?php if ($valid_token): ?>
    <div class="reset-password-form">
      <h1>Set New Password</h1>
      <p>Enter your new password below</p>

      <form method="post" action="functions/reset_password.php" id="resetPasswordForm">
        <input type="hidden" name="reset_password" value="1">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        
        <div class="form-group">
          <label for="password">New Password</label>
          <div class="password-input">
            <input type="password" name="password" id="password" required>
            <button type="button" class="password-toggle" id="passwordToggle">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="form-group">
          <label for="confirm_password">Confirm New Password</label>
          <div class="password-input">
            <input type="password" name="confirm_password" id="confirm_password" required>
            <button type="button" class="password-toggle" id="confirmPasswordToggle">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="password-requirements">
          <h4>Password Requirements:</h4>
          <ul>
            <li id="length-check">At least 6 characters long</li>
            <li id="match-check">Passwords match</li>
          </ul>
        </div>

        <div class="form-actions">
          <button type="submit" class="reset-password-btn">
            <span class="btn-text">Reset Password</span>
            <div class="spinner" id="resetPasswordSpinner">
              <i class="fas fa-spinner fa-spin"></i>
            </div>
          </button>
        </div>

        <div class="form-links">
          <a href="login.php">Back to Login</a>
          <a href="reset.php">Request New Reset Link</a>
        </div>
      </form>
    </div>

    <div class="reset-password-image">
      <div class="image-content">
        <h2>Create New Password</h2>
        <p>Choose a strong password to keep your account secure.</p>
        <div class="benefits">
          <div class="benefit">
            <i class="fas fa-lock"></i>
            <span>Secure password</span>
          </div>
          <div class="benefit">
            <i class="fas fa-shield-alt"></i>
            <span>Account protection</span>
          </div>
          <div class="benefit">
            <i class="fas fa-check-circle"></i>
            <span>Quick setup</span>
          </div>
        </div>
      </div>
    </div>

    <?php else: ?>
    <div class="error-container">
      <div class="error-content">
        <i class="fas fa-exclamation-triangle"></i>
        <h1>Invalid Reset Link</h1>
        <p><?php echo htmlspecialchars($token_error); ?></p>
        <div class="error-actions">
          <a href="reset.php" class="btn-primary">Request New Reset Link</a>
          <a href="login.php" class="btn-secondary">Back to Login</a>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<style>
#reset-password-page {
  font-family: "Segoe UI", sans-serif;
  color: #333;
  padding: 2rem 0;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.reset-password-container {
  display: flex;
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
  max-width: 1000px;
  margin: 0 auto;
  min-height: 500px;
}

.reset-password-form {
  flex: 1;
  padding: 3rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.reset-password-form h1 {
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
  color: #333;
  font-weight: 700;
}

.reset-password-form p {
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

.password-input {
  position: relative;
}

.password-input input {
  width: 100%;
  padding: 0.75rem;
  padding-right: 3rem;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.password-input input:focus {
  border-color: #d32f2f;
  outline: none;
  box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
}

.password-toggle {
  position: absolute;
  right: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: #666;
  cursor: pointer;
  padding: 0.25rem;
  transition: color 0.3s ease;
}

.password-toggle:hover {
  color: #d32f2f;
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

.password-requirements {
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  padding: 1rem;
  margin-bottom: 1.5rem;
}

.password-requirements h4 {
  margin: 0 0 0.5rem 0;
  color: #333;
  font-size: 0.9rem;
}

.password-requirements ul {
  margin: 0;
  padding-left: 1.2rem;
  list-style: none;
}

.password-requirements li {
  font-size: 0.85rem;
  color: #666;
  margin-bottom: 0.25rem;
  position: relative;
}

.password-requirements li::before {
  content: "✗";
  color: #dc3545;
  font-weight: bold;
  position: absolute;
  left: -1.2rem;
}

.password-requirements li.valid::before {
  content: "✓";
  color: #28a745;
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

.reset-password-btn {
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

.reset-password-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(211, 47, 47, 0.3);
}

.reset-password-btn:active {
  transform: translateY(0);
}

.reset-password-btn:disabled {
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

.reset-password-image {
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

/* Error Container */
.error-container {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3rem;
}

.error-content {
  text-align: center;
  max-width: 500px;
}

.error-content i {
  font-size: 4rem;
  color: #dc3545;
  margin-bottom: 1rem;
}

.error-content h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
  color: #333;
}

.error-content p {
  color: #666;
  margin-bottom: 2rem;
  font-size: 1.1rem;
  line-height: 1.6;
}

.error-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.btn-primary, .btn-secondary {
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-primary {
  background: #d32f2f;
  color: white;
}

.btn-primary:hover {
  background: #b71c1c;
  transform: translateY(-2px);
}

.btn-secondary {
  background: #6c757d;
  color: white;
}

.btn-secondary:hover {
  background: #545b62;
  transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
  .reset-password-container {
    flex-direction: column;
    margin: 1rem;
    min-height: auto;
  }
  
  .reset-password-form {
    padding: 2rem;
  }
  
  .reset-password-image {
    padding: 2rem;
  }
  
  .reset-password-form h1 {
    font-size: 2rem;
  }
  
  .image-content h2 {
    font-size: 1.5rem;
  }
  
  .error-actions {
    flex-direction: column;
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
    const resetPasswordForm = document.getElementById('resetPasswordForm');
    const resetPasswordBtn = document.querySelector('.reset-password-btn');
    const btnText = document.querySelector('.btn-text');
    const spinner = document.getElementById('resetPasswordSpinner');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const passwordToggle = document.getElementById('passwordToggle');
    const confirmPasswordToggle = document.getElementById('confirmPasswordToggle');
    
    // Password visibility toggles
    passwordToggle.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
    
    confirmPasswordToggle.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
    
    // Password validation
    function validatePassword(password) {
        return password.length >= 6;
    }
    
    function validatePasswordMatch(password, confirmPassword) {
        return password === confirmPassword && password !== '';
    }
    
    function updatePasswordRequirements() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        const lengthCheck = document.getElementById('length-check');
        const matchCheck = document.getElementById('match-check');
        
        // Length check
        if (validatePassword(password)) {
            lengthCheck.classList.add('valid');
        } else {
            lengthCheck.classList.remove('valid');
        }
        
        // Match check
        if (validatePasswordMatch(password, confirmPassword)) {
            matchCheck.classList.add('valid');
        } else {
            matchCheck.classList.remove('valid');
        }
    }
    
    passwordInput.addEventListener('input', updatePasswordRequirements);
    confirmPasswordInput.addEventListener('input', updatePasswordRequirements);
    
    // Form validation
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
    
    // Form submission
    resetPasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        let isValid = true;
        
        // Validate password
        if (!validatePassword(password)) {
            showFieldError(passwordInput, 'Password must be at least 6 characters long');
            isValid = false;
        } else {
            clearFieldError(passwordInput);
        }
        
        // Validate password match
        if (!validatePasswordMatch(password, confirmPassword)) {
            showFieldError(confirmPasswordInput, 'Passwords do not match');
            isValid = false;
        } else {
            clearFieldError(confirmPasswordInput);
        }
        
        if (!isValid) {
            return;
        }
        
        // Show loading state
        resetPasswordBtn.disabled = true;
        btnText.classList.add('hide');
        spinner.classList.add('show');
        
        // Submit form
        this.submit();
    });
});
</script>

<?php include 'includes/footer.php'; ?>        