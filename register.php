<?php
session_start();

if (isset($_SESSION['auth'])) {
    $_SESSION['message'] = "You are already logged in";
    header('location: index.php');
    exit();
}

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
                                <!-- Add a dropdown for user type -->
                                <div class="form-group">
                                    <select class="form-select"  aria-label="Default select example" name="role_as" >
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

                                <!-- Additional Information Section -->
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

                                <!-- Submit Button -->
                                <div class="form-group mb-0">
                                    <input class="btn btn-primary btn-block" type="submit" name="register" value="Register now" required>
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