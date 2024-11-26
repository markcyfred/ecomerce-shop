<?php
session_start();
if (isset($_SESSION['auth'])) {
     $_SESSION['message'] = "You are already logged in";
     $_SESSION['messageType'] = "error";
     header('location: index.php');
     exit();
}

include 'includes/header.php';
include 'admin/config/dbcon.php';
?>
<main class="main">
     <div class="page-header breadcrumb-wrap">
          <div class="container">
               <div class="breadcrumb">
                    <a href="index.php" rel="nofollow">Home</a>
                    <span></span> Pages
                    <span></span> Register
               </div>
          </div>
     </div>
     <section class="pt-150 pb-150">
          <div class="container">
               <div class="row align-items-center">
                    <!-- Image Section -->
                    <div class="col-lg-6">
                         <div class="image-wrap">
                              <img src="assets/images/menu-banner-4.jpg" alt="Register Image" class="img-fluid border-radius-10">
                         </div>
                    </div>
                    <!-- Registration Form Section -->
                    <div class="col-lg-6">
                         <div class="login_wrap widget-taber-content p-30 background-white border-radius-5">
                              <div class="padding_eight_all bg-white">
                                   <?php
                                   if (isset($_SESSION['message'])) {
                                   ?>

                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                             <strong>Holy!</strong> <?php echo $_SESSION['message']; ?>
                                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                   <?php
                                        
                                   }
                                   ?>
                                   <div class="heading_s1">
                                        <h3 class="mb-30">Create an Account</h3>
                                   </div>
                                   <p class="mb-50 font-sm">
                                   </p>
                                   <form method="post" enctype="multipart/form-data" action="functions/authcode.php">
                                        <div class="row">
                                             <div class="col-md-6 form-group">
                                                  <input type="text" name="first_name" placeholder="First Name">
                                             </div>
                                             <div class="col-md-6 form-group">
                                                  <input type="text" name="last_name" placeholder="Last Name">
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-6 form-group">
                                                  <input type="email" name="email" placeholder="Email">
                                             </div>
                                             <div class="col-md-6 form-group">
                                                  <input type="text" name="phone" placeholder="Phone Number">
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-6 form-group">
                                                  <input type="text" name="street_address" placeholder="Street Address">
                                             </div>
                                             <div class="col-md-6 form-group">
                                                  <input type="text" name="city" placeholder="City">
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-6 form-group">
                                                  <input type="text" name="postal_code" placeholder="Postal Code">
                                             </div>
                                             <div class="col-md-6 form-group">
                                                  <input type="test" name="additional_info" placeholder="Additional Information">
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-12 form-group">
                                                  <input type="file" name="profile_picture">
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-6 form-group">
                                                  <input type="password" name="password" placeholder="Password">
                                             </div>
                                             <div class="col-md-6 form-group">
                                                  <input type="password" name="confirm_password" placeholder="Confirm Password">
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <div class="chek-form">
                                                  <div class="custome-checkbox">
                                                       <input class="form-check-input" type="checkbox" name="agreed_to_terms" id="termsCheckbox">
                                                       <label class="form-check-label" for="termsCheckbox">
                                                            <span>I agree to the <a href="terms.php" target="_blank">Terms and Conditions</a>.</span>
                                                       </label>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="form-group">
                                             <button type="submit" class="btn btn-fill-out btn-block hover-up" name="register">Submit &amp; Register</button>
                                        </div>
                                   </form>
                                   <div class="text-muted text-center">Already have an account? <a href="login.php">Sign in now</a></div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>
</main>
<?php include 'includes/footer.php'; ?>