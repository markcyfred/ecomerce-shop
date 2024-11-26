<?php
if (isset($_SESSION['auth'])) {
     $_SESSION['message'] = "You are already logged in";
     $_SESSION['messageType'] = "error";
     header('location: index.php');
     exit();
}

include 'includes/header.php';


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
                                        <h3 class="mb-30">Login</h3>
                                   </div>
                                   <p class="mb-50 font-sm">
                                   </p>
                                   <form method="post" enctype="multipart/form-data" action="functions/authcode.php">
                                        <!-- Email Address -->
                                        <div class="form-group mb-20">
                                             <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                                        </div>
                                        <!-- Password -->
                                        <div class="form-group mb-20">
                                             <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                        <!-- Remember Me -->
                                        <div class="form-group mb-20">
                                             <div class="custom-control custom-checkbox">
                                                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                  <label class="custom-control-label" for="customCheck1">Remember me</label>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <button type="submit" class="btn btn-fill-out btn-block hover-up" name="login">Submit &amp; Login</button>
                                        </div>
                                   </form>
                                   <div class="text-muted text-center">Create an account? <a href="register.php">register now</a></div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>
</main>
<?php include 'includes/footer.php'; ?>