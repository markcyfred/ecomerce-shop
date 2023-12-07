<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Shop Sell</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">



    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">



    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="index.php"><span>Shop</span>Sell</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="index.php" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <!-- Update navigation links -->
                    <!--categories.php-->
                    <!--cart.php-->
                    <!--checkout.php-->
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="#products.php">Products</a></li>
                    <li><a href="#categories.php">Categories</a></li>
                    <li><a href="#cart.php">Cart</a></li>
                    <a href="https://www.google.com" target="blank">Go to Google</a>                    <?php
                    if (isset($_SESSION['auth'])) {
                    ?>

                        <li class="dropdown"><a href="#"><span>

                                    <?= $_SESSION['auth_user']['email']; ?>

                                </span> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <a href="profile.php">
                                    <i class="bi bi-box-arrow-in-right"></i> Profile
                                </a>
                                <a href="functions/logout.php">
                                    <i class="bi bi-box-arrow-in-right"></i> <span style="margin-left: 20px;margin-right:-10px">Logout</span>
                                </a>
                            </ul>

                        <?php

                    } else {
                        ?>
                        <li class="dropdown"><a href="#"><span>Login/Signup</span> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <a href="login.php">
                                    <i class="bi bi-box-arrow-in-right"></i> login
                                </a>
                                <a href="register.php">
                                    <i class="bi bi-box-arrow-in-right"></i> <span style="margin-left: 20px;margin-right:-10px">register</span>
                                </a>
                            </ul>
                        </li>

                    <?php
                    }

                    ?>

                </ul>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

            <div class="header-social-links d-flex">
                <a href="#" class="twitter"><i class="bu bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bu bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bu bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bu bi-linkedin"></i></i></a>
            </div>

        </div>
    </header><!-- End Header -->