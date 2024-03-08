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
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="row">
                        <div class="col-lg-6 pr-30 d-none d-lg-block">
                            <img class="border-radius-15" src="assets/imgs/page/login-1.png" alt="" />
                        </div>
                        <div class="col-lg-6 col-md-8">
                            <div class="login_wrap widget-taber-content background-white">
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
                                    <h1>Login</h1>
                                    <p class="mb-30">Don't have an account? <a href='register.php'>Create here</a></p>

                                    <p style="color:red;"></p>
                                    <p style="color:green;"></p>
                                    <!-- Login Form -->
                                    <form action="functions/authcode.php" method="post">
                                        <!-- Email Section -->
                                        <div class="form-group">
                                            <input class="form-control" type="email" placeholder="Email" name="email">
                                        </div>

                                        <!-- Password Section -->
                                        <div class="form-group">
                                            <input class="form-control" type="password" placeholder="Password" name="password">
                                        </div>

                                        <div class="login_footer form-group mb-50">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="" />
                                                        <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                                    </div>
                                                </div>
                                                <a class="text-muted" href="reset.php">Forgot password?</a>
                                            </div>
                                        <button type="submit" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="login" value="login" required> Login</button>
                                    </form>
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