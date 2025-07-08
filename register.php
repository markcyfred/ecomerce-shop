<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!empty($_SESSION['auth'])) {
    $_SESSION['message']     = "You are already logged in";
    $_SESSION['messageType'] = "error";
    header('Location: index.php');
    exit;
}

include 'includes/header.php';
include 'admin/config/dbcon.php';

function generateCustomerCode($conn) {
    do {
        $code   = 'CUST' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $result = $conn->query("SELECT id FROM users WHERE customer_code = '$code'");
    } while ($result && $result->num_rows > 0);
    return $code;
}

// Display error/success messages
if (isset($_SESSION['message'])) {
    $messageType = isset($_SESSION['messageType']) ? $_SESSION['messageType'] : 'info';
    echo "<div class='alert alert-{$messageType} alert-dismissible fade show' role='alert'>
            {$_SESSION['message']}
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          </div>";
    unset($_SESSION['message'], $_SESSION['messageType']);
}
?>

<section id="register-page">
  <!-- Progress Indicator -->
  <div class="rp-progress-container">
    <div class="rp-progress-bar">
      <div class="rp-progress-fill" id="progressFill"></div>
    </div>
    <div class="rp-progress-text" id="progressText">Step 1 of 4</div>
  </div>


  <div class="rp-register">
    <div class="rp-image">
      <div class="rp-image-content">
        <h2>Join Our Community</h2>
        <p>Create your account and start exploring our amazing products with exclusive benefits.</p>
        <div class="rp-benefits">
          <div class="rp-benefit">
            <i class="fas fa-shipping-fast"></i>
            <span>Free shipping on orders over $50</span>
          </div>
          <div class="rp-benefit">
            <i class="fas fa-shield-alt"></i>
            <span>Secure payment processing</span>
          </div>
          <div class="rp-benefit">
            <i class="fas fa-headset"></i>
            <span>24/7 customer support</span>
          </div>
          <div class="rp-benefit">
            <i class="fas fa-gift"></i>
            <span>Exclusive member discounts</span>
          </div>
        </div>
        <div class="rp-stats">
          <div class="rp-stat">
            <span class="rp-stat-number">10K+</span>
            <span class="rp-stat-label">Happy Customers</span>
          </div>
          <div class="rp-stat">
            <span class="rp-stat-number">500+</span>
            <span class="rp-stat-label">Products</span>
          </div>
        </div>
      </div>
    </div>

    <form
      class="rp-form"
      method="post"
      enctype="multipart/form-data"
      action="functions/authcode.php"
      autocomplete="off"
      aria-labelledby="rp-heading"
      id="registrationForm"
      novalidate
    >
      <input type="hidden" name="register" value="1">
      <h1 id="rp-heading">Create Your Account</h1>
      <p>Sign up to start shopping and managing your orders.</p>

      <!-- Step Indicators -->
      <div class="rp-steps">
        <div class="rp-step active" data-step="1">
          <div class="rp-step-number">1</div>
          <span>Personal Info</span>
        </div>
        <div class="rp-step" data-step="2">
          <div class="rp-step-number">2</div>
          <span>Contact Details</span>
        </div>
        <div class="rp-step" data-step="3">
          <div class="rp-step-number">3</div>
          <span>Security</span>
        </div>
        <div class="rp-step" data-step="4">
          <div class="rp-step-number">4</div>
          <span>Complete</span>
        </div>
      </div>

      <div class="rp-social">
        <a href="oauth/google-login.php" class="rp-social-btn google-btn" aria-label="Sign up with Google">
          <i class="fab fa-google"></i>
          <span>Continue with Google</span>
        </a>
       
      </div>

      <div class="rp-divider">
        <span>or register with email</span>
      </div>

      <!-- Step 1: Personal Information -->
      <div class="rp-step-content active" data-step="1">
       
        <h3>Personal Information</h3>
        <div class="rp-grid">
          <div class="rp-group">
            <label for="first_name">First Name *</label>
            <input type="text" name="first_name" id="first_name" required minlength="2" maxlength="50">
            <div class="rp-error" id="first_name_error"></div>
          </div>
          <div class="rp-group">
            <label for="last_name">Last Name *</label>
            <input type="text" name="last_name" id="last_name" required minlength="2" maxlength="50">
            <div class="rp-error" id="last_name_error"></div>
          </div>
          <div class="rp-group rp-full-width">
            <label for="profile_picture">Profile Picture</label>
            <div class="rp-file-upload">
              <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
              <div class="rp-file-preview" id="filePreview">
                <i class="fas fa-user-circle"></i>
                <span>Click to upload or drag and drop</span>
              </div>
            </div>
            <div class="rp-error" id="profile_picture_error"></div>
          </div>
        </div>
        <div class="rp-step-actions">
          <button type="button" class="rp-next-btn" onclick="nextStep(1)">Next Step</button>
        </div>
      </div>

      <!-- Step 2: Contact Details -->
      <div class="rp-step-content" data-step="2">
        <h3>Contact Details</h3>
        <div class="rp-grid">
          <div class="rp-group rp-full-width">
            <label for="email">Email Address *</label>
            <input type="email" name="email" id="email" required>
            <div class="rp-error" id="email_error"></div>
            <div class="rp-email-check" id="email_check">
              <i class="fas fa-spinner fa-spin" id="email_spinner" style="display: none;"></i>
              <span id="email_status"></span>
            </div>
          </div>
          <div class="rp-group rp-full-width">
            <label for="phone">Phone Number *</label>
            <input type="tel" name="phone" id="phone" required pattern="[0-9+\-\s\(\)]{10,15}">
            <div class="rp-error" id="phone_error"></div>
          </div>
          <div class="rp-group rp-full-width">
            <label for="street_address">Street Address *</label>
            <input type="text" name="street_address" id="street_address" required>
            <div class="rp-error" id="street_address_error"></div>
          </div>
          <div class="rp-group">
            <label for="city">City *</label>
            <input type="text" name="city" id="city" required>
            <div class="rp-error" id="city_error"></div>
          </div>
          <div class="rp-group">
            <label for="postal_code">Postal Code *</label>
            <input type="text" name="postal_code" id="postal_code" required>
            <div class="rp-error" id="postal_code_error"></div>
          </div>
          <div class="rp-group rp-full-width">
            <label for="additional_info">Additional Information</label>
            <textarea name="additional_info" id="additional_info" rows="3" placeholder="Any additional delivery instructions or notes..."></textarea>
          </div>
        </div>
        <div class="rp-step-actions">
          <button type="button" class="rp-prev-btn" onclick="prevStep(2)">Previous</button>
          <button type="button" class="rp-next-btn" onclick="nextStep(2)">Next Step</button>
        </div>
      </div>

      <!-- Step 3: Security -->
      <div class="rp-step-content" data-step="3">
        <h3>Security Setup</h3>
        <div class="rp-grid">
          <div class="rp-group">
            <label for="password">Password *</label>
            <div class="rp-password-input">
              <input type="password" name="password" id="password" required minlength="8">
              <button type="button" class="rp-password-toggle" id="passwordToggle">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div class="rp-password-strength" id="passwordStrength">
              <div class="rp-strength-bar">
                <div class="rp-strength-fill" id="strengthFill"></div>
              </div>
              <span class="rp-strength-text" id="strengthText">Password strength</span>
            </div>
            <div class="rp-password-requirements">
              <div class="rp-requirement" id="req-length"><i class="fas fa-circle"></i> At least 8 characters</div>
              <div class="rp-requirement" id="req-lowercase"><i class="fas fa-circle"></i> One lowercase letter</div>
              <div class="rp-requirement" id="req-uppercase"><i class="fas fa-circle"></i> One uppercase letter</div>
              <div class="rp-requirement" id="req-number"><i class="fas fa-circle"></i> One number</div>
              <div class="rp-requirement" id="req-special"><i class="fas fa-circle"></i> One special character</div>
            </div>
            <div class="rp-error" id="password_error"></div>
          </div>
          <div class="rp-group">
            <label for="confirm_password">Confirm Password *</label>
            <div class="rp-password-input">
              <input type="password" name="confirm_password" id="confirm_password" required>
              <button type="button" class="rp-password-toggle" id="confirmPasswordToggle">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div class="rp-error" id="confirm_password_error"></div>
          </div>
        </div>
        <div class="rp-step-actions">
          <button type="button" class="rp-prev-btn" onclick="prevStep(3)">Previous</button>
          <button type="button" class="rp-next-btn" onclick="nextStep(3)">Next Step</button>
        </div>
      </div>

      <!-- Step 4: Final -->
      <div class="rp-step-content" data-step="4">
        <h3>Complete Registration</h3>
        <div class="rp-summary">
          <div class="rp-summary-item">
            <span class="rp-summary-label">Name:</span>
            <span class="rp-summary-value" id="summary-name"></span>
          </div>
          <div class="rp-summary-item">
            <span class="rp-summary-label">Email:</span>
            <span class="rp-summary-value" id="summary-email"></span>
          </div>
          <div class="rp-summary-item">
            <span class="rp-summary-label">Phone:</span>
            <span class="rp-summary-value" id="summary-phone"></span>
          </div>
          <div class="rp-summary-item">
            <span class="rp-summary-label">Address:</span>
            <span class="rp-summary-value" id="summary-address"></span>
          </div>
        </div>

        <div class="rp-check">
          <input type="checkbox" name="agreed_to_terms" id="termsCheckbox" required>
          <label for="termsCheckbox">
            I agree to the <a href="terms.php" target="_blank">Terms & Conditions</a> and <a href="privacy.php" target="_blank">Privacy Policy</a> *
          </label>
          <div class="rp-error" id="terms_error"></div>
        </div>

        <div class="rp-check">
          <input type="checkbox" name="newsletter" id="newsletterCheckbox">
          <label for="newsletterCheckbox">
            Subscribe to our newsletter for exclusive offers and updates
          </label>
        </div>

        <div class="rp-check">
          <input type="checkbox" name="email_verification" id="emailVerificationCheckbox" checked>
          <label for="emailVerificationCheckbox">
            Send me a verification email to confirm my account
          </label>
        </div>

        <div class="rp-step-actions">
          <button type="button" class="rp-prev-btn" onclick="prevStep(4)">Previous</button>
          <button type="submit" class="rp-submit" id="submitBtn">
            <span class="rp-submit-text">Create Account</span>
            <div class="rp-spinner" id="submitSpinner">
              <i class="fas fa-spinner fa-spin"></i>
            </div>
          </button>
        </div>
      </div>

      <p class="rp-signin">
        Already have an account? <a href="login.php">Sign in now</a>
      </p>
    </form>
  </div>
</section>

<style>
  /* All styles scoped under #register-page */
  #register-page {
    font-family: "Segoe UI", sans-serif;
    color: #333;
    padding: 2rem 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
  }

  /* Progress Indicator */
  .rp-progress-container {
    max-width: 1200px;
    margin: 0 auto 2rem;
    padding: 0 1rem;
  }

  .rp-progress-bar {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
  }

  .rp-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #d32f2f, #ff6b6b);
    border-radius: 4px;
    transition: width 0.5s ease;
    width: 25%;
  }

  .rp-progress-text {
    text-align: center;
    font-size: 0.9rem;
    color: #666;
    font-weight: 500;
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

  /* Breadcrumb */
  .rp-breadcrumb__list {
    display: flex;
    list-style: none;
    gap: 0.5rem;
    padding: 0;
    margin: 0 0 2rem;
    font-size: 0.9rem;
  }
  .rp-breadcrumb__list li + li::before {
    content: "›";
    margin: 0 0.5rem;
    color: #666;
  }
  .rp-breadcrumb__list a {
    color: #d32f2f;
    text-decoration: none;
    transition: color 0.2s;
  }
  .rp-breadcrumb__list a:hover {
    color: #a32020;
  }

  /* Layout */
  .rp-register {
    display: flex;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    max-width: 1200px;
    margin: 0 auto;
    min-height: 600px;
  }
  
  .rp-image {
    flex: 1 1 45%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    padding: 3rem;
  }
  
  .rp-image-content {
    text-align: center;
    max-width: 400px;
  }
  
  .rp-image-content h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 700;
  }
  
  .rp-image-content p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
  }
  
  .rp-benefits {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
  }
  
  .rp-benefit {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.95rem;
  }
  
  .rp-benefit i {
    font-size: 1.2rem;
    color: #ffd700;
  }

  .rp-stats {
    display: flex;
    justify-content: space-around;
    gap: 2rem;
    margin-top: 2rem;
  }

  .rp-stat {
    text-align: center;
  }

  .rp-stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: #ffd700;
  }

  .rp-stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
  }
  
  .rp-form {
    flex: 1 1 55%;
    padding: 3rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    overflow-y: auto;
    max-height: 80vh;
  }

  /* Step Indicators */
  .rp-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 2rem;
    position: relative;
  }

  .rp-steps::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 0;
    right: 0;
    height: 2px;
    background: #e0e0e0;
    z-index: 1;
  }

  .rp-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .rp-step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e0e0e0;
    color: #666;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
  }

  .rp-step.active .rp-step-number {
    background: #d32f2f;
    color: white;
    transform: scale(1.1);
  }

  .rp-step.completed .rp-step-number {
    background: #4caf50;
    color: white;
  }

  .rp-step span {
    font-size: 0.8rem;
    color: #666;
    text-align: center;
    font-weight: 500;
  }

  .rp-step.active span {
    color: #d32f2f;
    font-weight: 600;
  }

  .rp-step.completed span {
    color: #4caf50;
  }

  /* Step Content */
  .rp-step-content {
    display: none;
    animation: fadeIn 0.5s ease;
  }

  .rp-step-content.active {
    display: block;
  }

  .rp-step-content h3 {
    margin-bottom: 1.5rem;
    color: #333;
    font-size: 1.3rem;
    font-weight: 600;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Step Actions */
  .rp-step-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
    gap: 1rem;
  }

  .rp-prev-btn,
  .rp-next-btn {
    padding: 0.75rem 1.5rem;
    border: 2px solid #e0e0e0;
    background: #fff;
    color: #666;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .rp-prev-btn:hover {
    border-color: #ccc;
    background: #f5f5f5;
  }

  .rp-next-btn {
    background: #d32f2f;
    color: white;
    border-color: #d32f2f;
  }

  .rp-next-btn:hover {
    background: #a32020;
    border-color: #a32020;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
  }

  .rp-next-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
  }

  /* Summary */
  .rp-summary {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .rp-summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e0e0e0;
  }

  .rp-summary-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
  }

  .rp-summary-label {
    font-weight: 600;
    color: #666;
  }

  .rp-summary-value {
    color: #333;
    font-weight: 500;
  }

  /* Social buttons */
  .rp-social {
    display: flex;
    gap: 0.75rem;
  }
  .rp-social-btn {
    flex: 1;
    padding: 0.75rem;
    border: 2px solid #e0e0e0;
    background: #fff;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-weight: 500;
  }
  .rp-social-btn:hover {
    border-color: #d32f2f;
    background: #fff5f5;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(211, 47, 47, 0.15);
  }
  .rp-social-btn img { 
    width: 20px; 
    height: 20px;
  }

  /* Specific OAuth button styles */
  .rp-social-btn.google-btn {
    border-color: #4285F4;
    color: #4285F4;
  }

  .rp-social-btn.google-btn:hover {
    background: #4285F4;
    color: white;
    border-color: #4285F4;
  }

  .rp-social-btn.github-btn {
    border-color: #24292e;
    color: #24292e;
  }

  .rp-social-btn.github-btn:hover {
    background: #24292e;
    color: white;
    border-color: #24292e;
  }

  /* Divider */
  .rp-divider {
    text-align: center;
    position: relative;
    margin: 1rem 0;
  }
  
  .rp-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e0e0e0;
  }
  
  .rp-divider span {
    background: #fff;
    padding: 0 1rem;
    color: #666;
    font-size: 0.9rem;
  }

  /* Form grid */
  .rp-grid {
    display: grid;
    gap: 1.5rem;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  }
  
  .rp-full-width {
    grid-column: 1 / -1;
  }
  
  .rp-group {
    display: flex;
    flex-direction: column;
    position: relative;
  }
  
  .rp-group label {
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
    font-size: 0.95rem;
  }
  
  .rp-group input,
  .rp-group textarea {
    padding: 0.75rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 1rem;
  }
  
  .rp-group input:focus,
  .rp-group textarea:focus {
    border-color: #d32f2f;
    outline: none;
    box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
  }
  
  .rp-group input:invalid:not(:placeholder-shown),
  .rp-group textarea:invalid:not(:placeholder-shown) {
    border-color: #f44336;
  }
  
  .rp-group input:valid:not(:placeholder-shown),
  .rp-group textarea:valid:not(:placeholder-shown) {
    border-color: #4caf50;
  }

  /* Error messages */
  .rp-error {
    color: #f44336;
    font-size: 0.85rem;
    margin-top: 0.25rem;
    min-height: 1.2rem;
    display: none;
  }
  
  .rp-error.show {
    display: block;
  }

  /* Email check indicator */
  .rp-email-check {
    margin-top: 0.25rem;
    font-size: 0.85rem;
    min-height: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .rp-email-check.checking {
    color: #ff9800;
  }

  .rp-email-check.available {
    color: #4caf50;
  }

  .rp-email-check.taken {
    color: #f44336;
  }

  .rp-email-check i {
    font-size: 0.8rem;
  }

  /* File upload */
  .rp-file-upload {
    position: relative;
  }
  
  .rp-file-upload input[type="file"] {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
  }
  
  .rp-file-preview {
    border: 2px dashed #e0e0e0;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  
  .rp-file-preview:hover {
    border-color: #d32f2f;
    background: #fff5f5;
  }
  
  .rp-file-preview i {
    font-size: 3rem;
    color: #ccc;
    margin-bottom: 1rem;
    display: block;
  }
  
  .rp-file-preview span {
    color: #666;
    font-size: 0.9rem;
  }
  
  .rp-file-preview.has-image {
    border-style: solid;
    padding: 1rem;
  }
  
  .rp-file-preview.has-image img {
    max-width: 100%;
    max-height: 150px;
    border-radius: 8px;
  }

  /* Password input */
  .rp-password-input {
    position: relative;
  }
  
  .rp-password-toggle {
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
  
  .rp-password-toggle:hover {
    color: #d32f2f;
  }
  
  .rp-password-input input {
    padding-right: 2.5rem;
  }

  /* Password strength */
  .rp-password-strength {
    margin-top: 0.5rem;
  }
  
  .rp-strength-bar {
    height: 4px;
    background: #e0e0e0;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 0.25rem;
  }
  
  .rp-strength-fill {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 2px;
  }
  
  .rp-strength-fill.weak { width: 25%; background: #f44336; }
  .rp-strength-fill.fair { width: 50%; background: #ff9800; }
  .rp-strength-fill.good { width: 75%; background: #ffc107; }
  .rp-strength-fill.strong { width: 100%; background: #4caf50; }
  
  .rp-strength-text {
    font-size: 0.8rem;
    color: #666;
  }

  /* Password requirements */
  .rp-password-requirements {
    margin-top: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #e0e0e0;
  }

  .rp-requirement {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
    color: #666;
  }

  .rp-requirement:last-child {
    margin-bottom: 0;
  }

  .rp-requirement i {
    font-size: 0.7rem;
    color: #ccc;
    transition: color 0.3s ease;
  }

  .rp-requirement.valid i {
    color: #4caf50;
  }

  .rp-requirement.valid {
    color: #4caf50;
  }

  /* Checkbox */
  .rp-check {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-top: 1rem;
  }
  
  .rp-check input[type="checkbox"] {
    margin-top: 0.25rem;
    width: 18px;
    height: 18px;
    accent-color: #d32f2f;
  }
  
  .rp-check label {
    font-size: 0.9rem;
    line-height: 1.4;
    cursor: pointer;
  }
  
  .rp-check a {
    color: #d32f2f;
    text-decoration: none;
    font-weight: 500;
  }
  
  .rp-check a:hover {
    text-decoration: underline;
  }

  /* Submit button */
  .rp-submit {
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #d32f2f 0%, #a32020 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .rp-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(211, 47, 47, 0.3);
  }
  
  .rp-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
  }
  
  .rp-spinner {
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  
  .rp-submit.loading .rp-submit-text {
    opacity: 0;
  }
  
  .rp-submit.loading .rp-spinner {
    display: block;
  }

  /* Sign‑in link */
  .rp-signin {
    font-size: 0.95rem;
    margin-top: 1rem;
    text-align: center;
  }
  .rp-signin a {
    color: #d32f2f;
    text-decoration: none;
    font-weight: 500;
  }
  .rp-signin a:hover {
    text-decoration: underline;
  }

  /* Responsive */
  @media (max-width: 1024px) {
    .rp-register {
      margin: 0 1rem;
    }
    
    .rp-form {
      padding: 2rem;
    }
  }

  @media (max-width: 768px) {
    .rp-register { 
      flex-direction: column; 
      margin: 0 1rem;
    }
    
    .rp-image { 
      height: 200px; 
      padding: 1.5rem;
    }
    
    .rp-image-content h2 {
      font-size: 1.8rem;
    }
    
    .rp-form {
      padding: 1.5rem;
    }
    
    .rp-social {
      flex-direction: column;
      gap: 0.5rem;
    }
    
    .rp-social-btn {
      padding: 0.6rem;
      font-size: 0.9rem;
    }
    
    .rp-grid {
      grid-template-columns: 1fr;
    }

    .rp-steps {
      flex-wrap: wrap;
      gap: 1rem;
    }

    .rp-steps::before {
      display: none;
    }

    .rp-step {
      flex: 1;
      min-width: 80px;
    }
  }

  @media (max-width: 480px) {
    #register-page {
      padding: 1rem 0;
    }
    
    .rp-form {
      padding: 1rem;
    }
    
    .rp-image-content h2 {
      font-size: 1.5rem;
    }

    .rp-step-actions {
      flex-direction: column;
    }

    .rp-prev-btn,
    .rp-next-btn {
      width: 100%;
    }
  }

  /* Additional enhancements */
  .rp-group input:focus,
  .rp-group textarea:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(211, 47, 47, 0.15);
  }

  .rp-group.error input,
  .rp-group.error textarea {
    border-color: #f44336;
    animation: shake 0.5s ease-in-out;
  }

  @keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
  }

  .rp-group.success input,
  .rp-group.success textarea {
    border-color: #4caf50;
  }

  .rp-error.show {
    animation: slideDown 0.3s ease-out;
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

  .rp-submit:active {
    transform: translateY(0);
  }

  .rp-submit.loading {
    pointer-events: none;
  }

  .rp-spinner i {
    color: #fff;
    font-size: 1.2rem;
  }

  /* Focus indicators for accessibility */
  .rp-social-btn:focus,
  .rp-password-toggle:focus,
  .rp-submit:focus,
  .rp-prev-btn:focus,
  .rp-next-btn:focus {
    outline: 2px solid #d32f2f;
    outline-offset: 2px;
  }

  /* Print styles */
  @media print {
    .rp-social,
    .rp-submit,
    .rp-breadcrumb,
    .rp-progress-container {
      display: none;
    }
    
    .rp-register {
      box-shadow: none;
      border: 1px solid #ccc;
    }
  }

  /* High contrast mode support */
  @media (prefers-contrast: high) {
    .rp-group input,
    .rp-group textarea {
      border-width: 3px;
    }
    
    .rp-submit {
      border: 3px solid #fff;
    }
  }

  /* Reduced motion support */
  @media (prefers-reduced-motion: reduce) {
    .rp-group input,
    .rp-group textarea,
    .rp-submit,
    .rp-social-btn,
    .rp-prev-btn,
    .rp-next-btn {
      transition: none;
    }
    
    .rp-error.show {
      animation: none;
    }

    .rp-progress-fill {
      transition: none;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.querySelector('.rp-submit-text');
    const submitSpinner = document.getElementById('submitSpinner');
    
    // Multi-step form management
    let currentStep = 1;
    const totalSteps = 4;
    let isSubmitting = false;
    let emailAvailable = false; // Track email availability globally
    
    // Initialize form
    initializeForm();
    
    function initializeForm() {
        updateProgress();
        updateStepIndicators();
        setupStepNavigation();
    }
    
    function updateProgress() {
        const progressFill = document.getElementById('progressFill');
        const progressText = document.getElementById('progressText');
        const progress = (currentStep / totalSteps) * 100;
        
        progressFill.style.width = progress + '%';
        progressText.textContent = `Step ${currentStep} of ${totalSteps}`;
    }
    
    function updateStepIndicators() {
        const steps = document.querySelectorAll('.rp-step');
        steps.forEach((step, index) => {
            const stepNumber = index + 1;
            step.classList.remove('active', 'completed');
            
            if (stepNumber === currentStep) {
                step.classList.add('active');
            } else if (stepNumber < currentStep) {
                step.classList.add('completed');
            }
        });
    }
    
    function setupStepNavigation() {
        const steps = document.querySelectorAll('.rp-step');
        steps.forEach((step, index) => {
            step.addEventListener('click', () => {
                const stepNumber = index + 1;
                if (stepNumber <= currentStep) {
                    goToStep(stepNumber);
                }
            });
        });
    }
    
    function goToStep(stepNumber) {
        console.log('[DEBUG] Switching to step:', stepNumber);
        if (stepNumber < 1 || stepNumber > totalSteps) return;
        // Hide all step content
        document.querySelectorAll('.rp-step-content').forEach((content, idx) => {
            if (content.classList.contains('active')) {
                console.log(`[DEBUG] Removing active from step ${idx+1}`);
            }
            content.classList.remove('active');
        });
        // Show current step content
        const currentStepContent = document.querySelector(`.rp-step-content[data-step="${stepNumber}"]`);
        if (currentStepContent) {
            currentStepContent.classList.add('active');
            console.log(`[DEBUG] Added active to .rp-step-content[data-step="${stepNumber}"]`);
        } else {
            console.error(`[DEBUG] Could not find .rp-step-content[data-step="${stepNumber}"]`);
        }
        currentStep = stepNumber;
        updateProgress();
        updateStepIndicators();
    }
    
    // Global step navigation functions
    window.nextStep = function(currentStepNumber) {
        console.log('[DEBUG] nextStep called from step', currentStepNumber);
        if (validateCurrentStep(currentStepNumber)) {
            goToStep(currentStepNumber + 1);
            updateSummary();
        } else {
            console.log('[DEBUG] Validation failed for step', currentStepNumber);
        }
    };
    
    window.prevStep = function(currentStepNumber) {
        console.log('[DEBUG] prevStep called from step', currentStepNumber);
        goToStep(currentStepNumber - 1);
    };
    
    function validateCurrentStep(stepNumber) {
        let isValid = true;
        const currentStepContent = document.querySelector(`[data-step="${stepNumber}"]`);
        const requiredFields = currentStepContent.querySelectorAll('input[required], textarea[required]');
        
        requiredFields.forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            // Scroll to first error
            const firstError = currentStepContent.querySelector('.rp-error.show');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        return isValid;
    }
    
    function updateSummary() {
        const firstName = document.getElementById('first_name').value;
        const lastName = document.getElementById('last_name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const streetAddress = document.getElementById('street_address').value;
        const city = document.getElementById('city').value;
        const postalCode = document.getElementById('postal_code').value;
        
        document.getElementById('summary-name').textContent = `${firstName} ${lastName}`;
        document.getElementById('summary-email').textContent = email;
        document.getElementById('summary-phone').textContent = phone;
        document.getElementById('summary-address').textContent = `${streetAddress}, ${city} ${postalCode}`;
    }
    
    // Password toggle functionality
    const passwordToggles = document.querySelectorAll('.rp-password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
                this.setAttribute('aria-label', 'Hide password');
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
                this.setAttribute('aria-label', 'Show password');
            }
        });
    });
    
    // File upload preview with drag and drop
    const fileInput = document.getElementById('profile_picture');
    const filePreview = document.getElementById('filePreview');
    
    // Drag and drop functionality
    filePreview.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#d32f2f';
        this.style.background = '#fff5f5';
    });
    
    filePreview.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = '#e0e0e0';
        this.style.background = '#fff';
    });
    
    filePreview.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '#e0e0e0';
        this.style.background = '#fff';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(files[0]);
        }
    });
    
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            handleFileSelect(file);
        } else {
            resetFilePreview();
        }
    });
    
    function handleFileSelect(file) {
        if (file.type.startsWith('image/')) {
            if (file.size > 5 * 1024 * 1024) { // 5MB limit
                showError('profile_picture', 'File size must be less than 5MB.');
                resetFilePreview();
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                filePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                filePreview.classList.add('has-image');
                hideError('profile_picture');
            };
            reader.readAsDataURL(file);
        } else {
            showError('profile_picture', 'Please select a valid image file (JPG, PNG, GIF).');
            resetFilePreview();
        }
    }
    
    function resetFilePreview() {
        filePreview.innerHTML = '<i class="fas fa-user-circle"></i><span>Click to upload or drag and drop</span>';
        filePreview.classList.remove('has-image');
    }
    
    // Enhanced password strength checker with requirements
    const passwordInput = document.getElementById('password');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = checkPasswordStrength(password);
        updatePasswordRequirements(password);
        
        strengthFill.className = 'rp-strength-fill ' + strength.level;
        strengthText.textContent = strength.text;
        
        // Update confirm password validation in real-time
        const confirmPassword = document.getElementById('confirm_password');
        if (confirmPassword.value) {
            validateField(confirmPassword);
        }
    });
    
    function updatePasswordRequirements(password) {
        const requirements = {
            length: password.length >= 8,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[^A-Za-z0-9]/.test(password)
        };
        
        Object.keys(requirements).forEach(req => {
            const element = document.getElementById(`req-${req}`);
            if (element) {
                if (requirements[req]) {
                    element.classList.add('valid');
                } else {
                    element.classList.remove('valid');
                }
            }
        });
    }
    
    function checkPasswordStrength(password) {
        let score = 0;
        
        if (password.length >= 8) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        
        if (score < 2) return { level: 'weak', text: 'Weak password' };
        if (score < 3) return { level: 'fair', text: 'Fair password' };
        if (score < 4) return { level: 'good', text: 'Good password' };
        return { level: 'strong', text: 'Strong password' };
    }
    
    // Enhanced real-time validation with debouncing
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let validationTimeout;
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearTimeout(validationTimeout);
            validationTimeout = setTimeout(() => {
                if (this.classList.contains('error') || this.value.trim()) {
                    validateField(this);
                }
            }, 300);
        });
    });

    // Real-time email validation
    const emailInput = document.getElementById('email');
    const emailCheck = document.getElementById('email_check');
    const emailSpinner = document.getElementById('email_spinner');
    const emailStatus = document.getElementById('email_status');
    let emailCheckTimeout;

    emailInput.addEventListener('input', function() {
        const email = this.value.trim();
        
        // Clear previous status
        emailCheck.className = 'rp-email-check';
        emailStatus.textContent = '';
        emailSpinner.style.display = 'none';
        
        // Clear timeout if user is still typing
        clearTimeout(emailCheckTimeout);
        
        // Only check if email is valid format and not empty
        if (email && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            // Show checking state
            emailCheck.classList.add('checking');
            emailSpinner.style.display = 'inline-block';
            emailStatus.textContent = 'Checking availability...';
            
            // Debounce the check
            emailCheckTimeout = setTimeout(() => {
                checkEmailAvailability(email);
            }, 500);
        }
    });

    function checkEmailAvailability(email) {
        fetch('ajax/check_email.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'email=' + encodeURIComponent(email)
        })
        .then(response => response.json())
        .then(data => {
            emailSpinner.style.display = 'none';
            
            if (data.available) {
                emailCheck.className = 'rp-email-check available';
                emailStatus.innerHTML = '<i class="fas fa-check-circle"></i> Email is available';
                emailInput.classList.remove('error');
                hideError('email');
                emailAvailable = true;
            } else {
                emailCheck.className = 'rp-email-check taken';
                emailStatus.innerHTML = '<i class="fas fa-times-circle"></i> Email is already registered';
                emailInput.classList.add('error');
                showError('email', 'This email is already registered. Please use a different email or try logging in.');
                emailAvailable = false;
            }
        })
        .catch(error => {
            console.error('Error checking email:', error);
            emailSpinner.style.display = 'none';
            emailCheck.className = 'rp-email-check';
            emailStatus.textContent = '';
        });
    }
    
    function validateField(field) {
        const fieldName = field.name;
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';
        
        // Remove existing error
        hideError(fieldName);
        
        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        }
        
        // Specific field validations
        if (isValid && value) {
            switch (fieldName) {
                case 'first_name':
                case 'last_name':
                    if (value.length < 2) {
                        isValid = false;
                        errorMessage = 'Name must be at least 2 characters long.';
                    } else if (!/^[a-zA-Z\s]+$/.test(value)) {
                        isValid = false;
                        errorMessage = 'Name can only contain letters and spaces.';
                    }
                    break;
                    
                case 'email':
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                        isValid = false;
                        errorMessage = 'Please enter a valid email address.';
                    } else if (!emailAvailable && value.trim()) {
                        isValid = false;
                        errorMessage = 'This email is already registered. Please use a different email or try logging in.';
                    }
                    break;
                    
                case 'phone':
                    if (!/^[\+]?[0-9\s\-\(\)]{10,15}$/.test(value)) {
                        isValid = false;
                        errorMessage = 'Please enter a valid phone number.';
                    }
                    break;
                    
                case 'password':
                    if (value.length < 8) {
                        isValid = false;
                        errorMessage = 'Password must be at least 8 characters long.';
                    }
                    break;
                    
                case 'confirm_password':
                    const password = document.getElementById('password').value;
                    if (value !== password) {
                        isValid = false;
                        errorMessage = 'Passwords do not match.';
                    }
                    break;
            }
        }
        
        if (!isValid) {
            showError(fieldName, errorMessage);
            field.classList.add('error');
        } else {
            field.classList.remove('error');
        }
        
        return isValid;
    }
    
    function showError(fieldName, message) {
        const errorElement = document.getElementById(fieldName + '_error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.add('show');
        }
    }
    
    function hideError(fieldName) {
        const errorElement = document.getElementById(fieldName + '_error');
        if (errorElement) {
            errorElement.classList.remove('show');
        }
    }
    
    // Enhanced form submission with better error handling
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (isSubmitting) {
            return; // Prevent double submission
        }
        
        // Validate all fields
        let isValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        // Check terms checkbox
        const termsCheckbox = document.getElementById('termsCheckbox');
        if (!termsCheckbox.checked) {
            showError('terms', 'You must agree to the terms and conditions.');
            isValid = false;
        } else {
            hideError('terms');
        }
        
        if (isValid && emailAvailable) {
            // Show loading state
            isSubmitting = true;
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.setAttribute('aria-label', 'Creating account...');
            
            // Add a small delay to show the loading state
            setTimeout(() => {
                form.submit();
            }, 500);
        } else {
            // Scroll to first error
            const firstError = form.querySelector('.rp-error.show');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
    
    // Add keyboard navigation support
    form.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.type !== 'textarea') {
            e.preventDefault();
            const nextInput = e.target.parentElement.nextElementSibling?.querySelector('input, textarea');
            if (nextInput) {
                nextInput.focus();
            }
        }
    });
    
    // Add form progress indicator
    function updateFormProgress() {
        const requiredFields = form.querySelectorAll('input[required], textarea[required]');
        const filledFields = Array.from(requiredFields).filter(field => field.value.trim() !== '');
        const progress = (filledFields.length / requiredFields.length) * 100;
        
        // Update progress bar
        const progressFill = document.getElementById('progressFill');
        if (progressFill) {
            progressFill.style.width = progress + '%';
        }
    }
    
    // Update progress on input
    inputs.forEach(input => {
        input.addEventListener('input', updateFormProgress);
    });
    
    // Add social login functionality
    const socialButtons = document.querySelectorAll('.rp-social-btn');
    socialButtons.forEach(button => {
        button.addEventListener('click', function() {
            const provider = this.textContent.trim();
            // Here you would integrate with actual social login providers
            console.log(`Social login with ${provider} would be implemented here`);
            
            // Show a temporary message
            showTemporaryMessage(`Social login with ${provider} is coming soon!`, 'info');
        });
    });
    
    function showTemporaryMessage(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
    
    // Add smooth scrolling for better UX
    function smoothScrollTo(element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
    
    // Add form auto-save functionality (localStorage)
    function autoSaveForm() {
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            if (value) {
                data[key] = value;
            }
        }
        
        localStorage.setItem('registrationFormData', JSON.stringify(data));
    }
    
    function loadSavedForm() {
        const savedData = localStorage.getItem('registrationFormData');
        if (savedData) {
            const data = JSON.parse(savedData);
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field && field.type !== 'file') {
                    field.value = data[key];
                }
            });
        }
    }
    
    // Auto-save on input
    inputs.forEach(input => {
        input.addEventListener('input', autoSaveForm);
    });
    
    // Load saved data on page load
    loadSavedForm();
    
    // Clear saved data on successful submission
    form.addEventListener('submit', function() {
        localStorage.removeItem('registrationFormData');
    });
});
</script>

<?php include 'includes/footer.php'; ?>
