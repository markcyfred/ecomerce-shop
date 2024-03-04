<?php

if (isset($_SESSION['auth'])) {
    $_SESSION['message'] = "You are already logged in";
    header('location: index.php');
    exit();
}

include 'header.php';
include 'admin/config/dbcon.php';

?>
<!--End header-->
<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href='index.html' rel='nofollow'><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Pages <span></span> My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-50 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 col-lg-10 col-md-12 m-auto">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 ">
                            <!-- Left Column -->
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h1 style="font-size: 20px;" class="mb-5">Create an Account</h1>
                                        <p class="mb-30">Already have an account? <a href='login.php'>Login</a></p>
                                    </div>
                                    <?php
                                    if (isset($_SESSION['message'])) {
                                    ?>

                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Holy!</strong> <?php echo $_SESSION['message']; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php
                                        unset($_SESSION['message']);
                                    }
                                    ?>
                                    <h1>Register</h1>
                                    <p class="account-subtitle">Access to our dashboard</p>
                                    <p style="color:red;"></p>
                                    <p style="color:green;"></p>
                                    <!-- Shop Registration Form -->
                                    <form action="functions/authcode.php" method="post">
                                        <!-- Personal Information Section -->
                                        <!-- Personal Information Section -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="First Name" name="first_name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Last Name" name="last_name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <style>
                                            select.form-select:focus {
                                                color: #495057;
                                                background-color: #fff;
                                                border-color: #cfe2ff;
                                                outline: 0;
                                                box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0);
                                            }

                                            .form-control:focus {
                                                border-color: #cfe2ff !important;
                                            }
                                        </style>
                                        <div class="form-group">
                                            <select class="form-select" aria-label="Default select example" name="role_as">
                                                <option selected>Select User Type</option>
                                                <option value="0">Customer</option>
                                                <option value="2">Supplier</option>
                                            </select>
                                        </div>

                                        <!-- Contact Information Section -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="email" placeholder="Email" name="email" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" placeholder="Phone" name="phone" maxlength="10" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Address Section -->
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Street Address --eg--90100----" name="street_address" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="City" name="city" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Postal Code" name="postal_code" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="Additional Information" name="additional_info" rows="3"></textarea>
                                        </div>

                                        <!-- Login Information Section -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="password" placeholder="Password" name="password" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="password" placeholder="Confirm Password" name="confirm_password">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="register" value="Register now" required> Register</button>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 pr-30 d-none d-lg-block">
                            <div class="card-login mt-115">
                                <div class="card-body">
                                    <img src="assets/imgs/logo.png" alt="Logo" class="img-fluid">
                                    <h2 style="font-size: 20px;" class="mt-3">Welcome to our store</h2>
                                    <p class="mb-4">Create an account to get started today.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 style="font-size: 14px;" class="card-title   text-center">Customer</h5>
                                                    <p class="card-text text-center">Create an account as a customer to get started today.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 style="font-size: 14px;" class="card-title  text-center">Supplier</h5>
                                                    <p class="card-text text-center">Create an account as a supplier to get started today.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-top: 20px;" class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 style="font-size: 14px;" class="card-title  text-center">Already have an account?</h5>
                                                    <p class="card-text text-center"> <a href="login.php">
                                                            <button type="submit" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="register" value="Register now" required> Login</button></a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<?php include 'includes/footer.php'; ?>
</body>

</html>