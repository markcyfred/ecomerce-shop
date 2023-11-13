<?php
include 'header.php';
include 'admin/config/dbcon.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Register</title>

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
                        <h1>Login</h1>
                        <p class="account-subtitle">Access your account</p>
                        <p style="color:red;"></p>
                        <p style="color:green;"></p>
                        <!-- Login Form -->
                        <form method="post">
                            <!-- Email Section -->
                            <div class="form-group">
                                <input class="form-control" type="email" placeholder="Email" name="email">
                            </div>

                            <!-- Password Section -->
                            <div class="form-group">
                                <input class="form-control" type="password" placeholder="Password" name="password">
                            </div>

                            <!-- Remember Me Checkbox (optional) -->
                            <div class="form-group">
                                <input type="checkbox" id="rememberMe">
                                <label for="rememberMe">Remember me</label>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group mb-0">
                                <input class="btn btn-primary btn-block" type="submit" name="login" value="Login">
                            </div>
                        </form>

                        <div class="text-center dont-have">Don't have an account? <a href="register.php">Register</a></div>
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