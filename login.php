<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!empty($_SESSION['auth'])) {
    $_SESSION['message'] = "You are already logged in";
    $_SESSION['messageType'] = "error";
    header('Location: index.php');
    exit;
}

include 'includes/header.php';
include 'admin/config/dbcon.php';

// Debug: Check if session messages exist
if (isset($_SESSION['message'])) {
    echo "<!-- Debug: Session message exists: " . htmlspecialchars($_SESSION['message']) . " -->";
}

date_default_timezone_set('Africa/Nairobi');
?>

<section id="login-page">
  <div class="login-container">
    <div class="login-form">
      <h1>Welcome Back</h1>
      <p>Sign in to your account to continue shopping</p>

      <form method="post" action="functions/authcode.php" id="loginForm">
        <input type="hidden" name="login" value="1">
        
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="password-input">
            <input type="password" name="password" id="password" required>
            <button type="button" class="password-toggle" id="passwordToggle">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="login-btn">
            <span class="btn-text">Sign In</span>
            <div class="spinner" id="loginSpinner">
              <i class="fas fa-spinner fa-spin"></i>
            </div>
          </button>
        </div>

        <div class="social-login">
          <div class="divider">
            <span>or</span>
          </div>
          <div class="oauth-buttons">
            <a href="oauth/google-login.php" class="oauth-btn google-btn">
              <i class="fab fa-google"></i>
              <span>Continue with Google</span>
            </a>
           
          </div>
        </div>

        <div class="form-links">
          <a href="reset.php">Forgot your password?</a>
          <a href="register.php">Don't have an account? Sign up</a>
        </div>
      </form>
    </div>

    <div class="login-image">
      <div class="image-content">
        <h2>Welcome Back!</h2>
        <p>Sign in to access your account and continue shopping with us.</p>
        <div class="benefits">
          <div class="benefit">
            <i class="fas fa-shipping-fast"></i>
            <span>Track your orders</span>
          </div>
          <div class="benefit">
            <i class="fas fa-heart"></i>
            <span>Manage your favorites</span>
          </div>
          <div class="benefit">
            <i class="fas fa-user"></i>
            <span>Update your profile</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
#login-page {
  font-family: "Segoe UI", sans-serif;
  color: #333;
  padding: 2rem 0;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.login-container {
  display: flex;
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
  max-width: 1000px;
  margin: 0 auto;
  min-height: 500px;
}

.login-form {
  flex: 1;
  padding: 3rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.login-form h1 {
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
  color: #333;
  font-weight: 700;
}

.login-form p {
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

.password-input {
  position: relative;
}

.password-toggle {
  position: absolute;
  right: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  color: #666;
  padding: 0.25rem;
}

.password-toggle:hover {
  color: #d32f2f;
}

.password-input input {
  padding-right: 2.5rem;
}

.login-btn {
  width: 100%;
  padding: 1rem;
  background: linear-gradient(135deg, #d32f2f 0%, #a32020 100%);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.login-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(211, 47, 47, 0.3);
}

.login-btn:disabled {
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

.login-btn.loading .btn-text {
  opacity: 0;
}

.login-btn.loading .spinner {
  display: block;
}

.form-actions {
  margin-bottom: 1.5rem;
}

.social-login {
  margin-bottom: 1.5rem;
}

.divider {
  text-align: center;
  position: relative;
  margin: 1rem 0;
}

.divider::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 1px;
  background: #e0e0e0;
}

.divider span {
  background: #fff;
  padding: 0 1rem;
  color: #666;
  font-size: 0.9rem;
}

.oauth-buttons {
  display: flex;
  justify-content: center;
  gap: 0.75rem;
}

.oauth-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e0e0e0;
  background: #fff;
  border-radius: 8px;
  text-decoration: none;
  color: #333;
  font-weight: 500;
  transition: all 0.3s ease;
}

.oauth-btn:hover {
  border-color: #d32f2f;
  background: #fff5f5;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(211, 47, 47, 0.15);
}

/* Specific OAuth button styles */
.google-btn {
  border-color: #4285F4;
  color: #4285F4;
}

.google-btn:hover {
  background: #4285F4;
  color: white;
  border-color: #4285F4;
}

.github-btn {
  border-color: #24292e;
  color: #24292e;
}

.github-btn:hover {
  background: #24292e;
  color: white;
  border-color: #24292e;
}

/* Responsive OAuth buttons */
@media (max-width: 768px) {
  .oauth-buttons {
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .oauth-btn {
    padding: 0.6rem;
    font-size: 0.9rem;
  }
}

.form-links {
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-links a {
  color: #d32f2f;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s;
}

.form-links a:hover {
  color: #a32020;
  text-decoration: underline;
}

.login-image {
  flex: 1;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  padding: 3rem;
}

.image-content {
  text-align: center;
  max-width: 400px;
}

.image-content h2 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  font-weight: 700;
}

.image-content p {
  font-size: 1.1rem;
  margin-bottom: 2rem;
  opacity: 0.9;
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
  font-size: 0.95rem;
}

.benefit i {
  font-size: 1.2rem;
  color: #ffd700;
}

/* Alert styles */
.alert {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 1000;
  max-width: 400px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Responsive */
@media (max-width: 768px) {
  .login-container {
    flex-direction: column;
    margin: 0 1rem;
  }
  
  .login-image {
    height: 200px;
    padding: 1.5rem;
  }
  
  .login-image h2 {
    font-size: 1.8rem;
  }
  
  .login-form {
    padding: 2rem;
  }
}

@media (max-width: 480px) {
  .login-form {
    padding: 1.5rem;
  }
  
  .login-form h1 {
    font-size: 2rem;
  }
  
  .login-image h2 {
    font-size: 1.5rem;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordInput = document.getElementById('password');
    
    // Password toggle functionality
    if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener('click', function() {
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fas fa-eye-slash';
                this.setAttribute('aria-label', 'Hide password');
            } else {
                passwordInput.type = 'password';
                icon.className = 'fas fa-eye';
                this.setAttribute('aria-label', 'Show password');
            }
        });
    }
    
    // Simple form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            
            // Basic validation
            if (!email || !password) {
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>
