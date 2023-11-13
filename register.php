<?php
include 'header.php';
include 'admin/config/dbcon.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Shop sell- Register</title>

    <!-- Favicon -->
    <link href="assets/img/logo.png" rel="icon">


    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/register.css">

</head>

<body>

    <!-- Main Wrapper -->
    <div style="margin-top: 50px;" class="page-wrappers login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">

                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Register</h1>
                            <p class="account-subtitle">Access to our dashboard</p>
                            <p style="color:red;"></p>
                            <p style="color:green;"></p>
                            <!-- Shop Registration Form -->
                            <form method="post">
                                <!-- Personal Information Section -->
                                <!-- Personal Information Section -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="First Name" name="first_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Last Name" name="last_name">
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information Section -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="email" placeholder="Email" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Phone" name="phone" maxlength="10">
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Section -->
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Street Address --eg--90100----" name="street_address">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="City" name="city">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Postal Code" name="postal_code">
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information Section -->
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Additional Information" name="additional_info" rows="3"></textarea>
                                </div>

                                <!-- Login Information Section -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="password" placeholder="Password" name="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" type="password" placeholder="Confirm Password" name="confirm_password">
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group mb-0">
                                    <input class="btn btn-primary btn-block" type="submit" name="register" value="Register Shop">
                                </div>
                            </form>


                            <div class="text-center dont-have">Already have an account? <a href="login.php">Login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->

</body>

</html>
<?php
include 'includes/footer.php';
?>