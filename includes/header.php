<?php
include 'init.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'functions/userfunctions.php';
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>GoprimeBuy</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.svg">
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/main.css">

</head>

<body>
    <!-- <div class="modal fade custom-modal" id="onloadModal" tabindex="-1" aria-labelledby="onloadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="deal" style="background-image: url('assets/images/menu-banner-7.png')">
                        <div class="deal-top">
                            <h2 class="text-brand">Deal of the Day</h2>
                            <h5>Limited quantities.</h5>
                        </div>
                        <div class="deal-content">
                            <h6 class="product-title"><a href="shop-product-right.html">Summer Collection New Morden Design</a></h6>
                            <div class="product-price"><span class="new-price">$139.00</span><span class="old-price">$160.99</span></div>
                        </div>
                        <div class="deal-bottom">
                            <p>Hurry Up! Offer End In:</p>
                            <div class="deals-countdown" data-countdown="2025/03/25 00:00:00"><span class="countdown-section"><span class="countdown-amount hover-up">03</span><span class="countdown-period"> days </span></span><span class="countdown-section"><span class="countdown-amount hover-up">02</span><span class="countdown-period"> hours </span></span><span class="countdown-section"><span class="countdown-amount hover-up">43</span><span class="countdown-period"> mins </span></span><span class="countdown-section"><span class="countdown-amount hover-up">29</span><span class="countdown-period"> sec </span></span></div>
                            <a href="shop.php" class="btn hover-up">Shop Now <i class="fi-rs-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </div> -->
    <header class="header-area header-style-1 header-height-2">
        <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info">
                            <ul>
                                <li><i class="fi-rs-smartphone"></i> <a href="#">+254 111 893 789</a></li>
                                <li><i class="fi-rs-marker"></i><a href="page-contact.html">Our location</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <div class="text-center">
                            <div id="news-flash" class="d-inline-block">
                                <ul>
                                    <li>Get great devices up to 50% off <a href="shop.php">View details</a></li>
                                    <li>Supper Value Deals - Save more with coupons</li>
                                    <li>Trendy 25silver jewelry, save up 35% off today <a href="shop.php">Shop now</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info header-info-right">
                            <ul>
                                <?php if (isset($_SESSION['auth_user'])): ?>
                                    <?php
                                    // Get user details from the session
                                    $user_id = $_SESSION['auth_user']['id'];
                                    $user_email = $_SESSION['auth_user']['email'];

                                    // Fetch the profile picture and name from the database
                                    $query = "SELECT `first_name`, `last_name`, `profile_picture` FROM `users` WHERE `id`='$user_id'";
                                    $result = mysqli_query($conn, $query);
                                    $user_data = mysqli_fetch_assoc($result);

                                    $profile_picture = $user_data['profile_picture'] ?? 'default.png'; // Default picture if not set
                                    $full_name = $user_data['first_name'] . ' ' . $user_data['last_name'];
                                    ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img style="width: 30px;border: radious 50px;" src="uploads/profile/<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-pic">
                                            <?php echo htmlspecialchars($full_name); ?>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="profile.php"><i class="fi-rs-user"></i> My Profile</a></li>
                                            <li><a class="dropdown-item" href="orders.php"><i class="fi-rs-shopping-cart"></i> My Orders</a></li>
                                            <li><a class="dropdown-item" href="settings.php"><i class="fi-rs-settings"></i> Account Settings</a></li>
                                            <li><a class="dropdown-item" href="functions/logout.php"><i class="fi-rs-sign-out"></i> Logout</a></li>
                                        </ul>
                                    </li>
                                <?php else: ?>
                                    <li><a href="register.php"><i class="fi-rs-user"></i> Sign Up</a></li>
                                    <li><a href="login.php"><i class="fi-rs-user"></i> Login</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="index.php"><img src="assets/images/logo.svg" alt="logo"></a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="#">
                                <select class="select-active">
                                    <option>All Categories</option>
                                    <option>Women's</option>

                                </select>
                                <input type="text" placeholder="Search for items...">
                            </form>
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                <div class="header-action-icon-2">
                                    <a href="shop-wishlist.html">
                                        <img class="svgInject" alt="Evara" src="assets/images/icon-heart.svg">
                                        <span class="pro-count blue">4</span>
                                    </a>
                                </div>
                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="shop-cart.html">
                                        <img alt="Evara" src="assets/images/icon-cart.svg">
                                        <span class="pro-count blue">2</span>
                                    </a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                        <ul>
                                            <li>
                                                <div class="shopping-cart-img">
                                                    <a href="shop-product-right.html"><img alt="Evara" src="assets/images/thumbnail-3.jpg"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="shop-product-right.html">Daisy Casual Bag</a></h4>
                                                    <h4><span>1 × </span>$800.00</h4>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="#"><i class="fi-rs-cross-small"></i></a>
                                                </div>
                                            </li>

                                        </ul>
                                        <div class="shopping-cart-footer">
                                            <div class="shopping-cart-total">
                                                <h4>Total <span>$4000.00</span></h4>
                                            </div>
                                            <div class="shopping-cart-button">
                                                <a href="shop-cart.html" class="outline">View cart</a>
                                                <a href="shop-checkout.html">Checkout</a>
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
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="index.php"><img src="assets/images/logo.svg" alt="logo"></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categori-button-active" href="#">
                                <span class="fi-rs-apps"></span> Browse Categories
                            </a>
                            <div class="categori-dropdown-wrap categori-dropdown-active-large">
                                <ul>
                                    <li class="has-children">
                                        <?php
                                        $category_query = "SELECT * FROM categories WHERE status = 1";
                                        $category_result = mysqli_query($conn, $category_query);
                                        ?>
                                        <ul class="categori-dropdown">
                                            <?php while ($category = mysqli_fetch_assoc($category_result)): ?>
                                                <!--pull category image from database-->
                                                <li>
                                                    <a href="category.php?id=<?= $category['id']; ?>"> <img class="evara-font-dress" src="uploads/categories/<?php echo $category['image']; ?>" alt="category image" style="width: 20px; height: 20px;border-radius:50px;">
                                                        <?php echo $category['name']; ?></a>
                                                </li>
                                            <?php endwhile; ?>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                            <nav>
                                <ul>
                                    <li><a class="active" href="index.php">Home</a>
                                    </li>
                                    <li>
                                        <a href="about-us.php">About Us</a>
                                    </li>
                                    <li><a href="shop.php">Shop </i></a>

                                    </li>

                                    </li>

                                    </li>
                                    <li>
                                        <a href="page-contact.html">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-block">
                        <p><i class="fi-rs-headset"></i><span>Hotline</span>1189 3789</p>
                    </div>
                    <p class="mobile-promotion">Happy <span class="text-brand">Mother's Day</span>. Big Sale Up to 40%</p>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="shop-wishlist.html">
                                    <img alt="Evara" src="assets/images/icon-heart.svg">
                                    <span class="pro-count white">4</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="shop-cart.html">
                                    <img alt="Evara" src="assets/images/icon-cart.svg">
                                    <span class="pro-count white">2</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html"><img alt="Evara" src="assets/images/thumbnail-3.jpg"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="shop-product-right.html">Plain Striola Shirts</a></h4>
                                                <h3><span>1 × </span>$800.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html"><img alt="Evara" src="assets/images/thumbnail-4.jpg"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="shop-product-right.html">Macbook Pro 2022</a></h4>
                                                <h3><span>1 × </span>$3500.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>$383.00</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="shop-cart.html">View cart</a>
                                            <a href="shop-checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="header-action-icon-2 d-block d-lg-none">
                                <div class="burger-icon burger-icon-white">
                                    <span class="burger-icon-top"></span>
                                    <span class="burger-icon-mid"></span>
                                    <span class="burger-icon-bottom"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--mobile menu start-->
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="index.php"><img src="assets/images/logo.svg" alt="logo"></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="#">
                        <input type="text" placeholder="Search for items…">
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <div class="main-categori-wrap mobile-header-border">
                        <a class="categori-button-active-2" href="#">
                            <span class="fi-rs-apps"></span> Browse Categories
                        </a>
                        <div class="categori-dropdown-wrap categori-dropdown-active-small">
                            <ul>
                                <li class="has-children">
                                    <?php
                                    $category_query = "SELECT * FROM categories WHERE status = 1";
                                    $category_result = mysqli_query($conn, $category_query);
                                    ?>
                                    <ul class="categori-dropdown">
                                        <?php while ($category = mysqli_fetch_assoc($category_result)): ?>
                                            <!--pull category image from database-->
                                            <li>
                                                <a href="shop.php"> <img class="evara-font-dress" src="uploads/categories/<?php echo $category['image']; ?>" alt="category image" style="width: 20px; height: 20px;border-radius:50px;">
                                                    <?php echo $category['name']; ?></a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu">
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a href="index.php">Home</a>

                            </li>

                            <li><a href="about-us.php">About Us</a></li>
                            <li><a href="shop.php">Shop</a></li>
                            <li><a href="shop.php">Contact</a></li>

                        </ul>
                        <ul>
                            <?php if (isset($_SESSION['auth_user'])): ?>
                                <?php
                                // Get user details from the session
                                $user_id = $_SESSION['auth_user']['id'];
                                $user_email = $_SESSION['auth_user']['email'];

                                // Fetch the profile picture and name from the database
                                $query = "SELECT `first_name`, `last_name`, `profile_picture` FROM `users` WHERE `id`='$user_id'";
                                $result = mysqli_query($conn, $query);
                                $user_data = mysqli_fetch_assoc($result);

                                $profile_picture = $user_data['profile_picture'] ?? 'default.png'; // Default picture if not set
                                $full_name = $user_data['first_name'] . ' ' . $user_data['last_name'];
                                ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img style="width: 30px;border: radious 50px;" src="uploads/profile/<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-pic">
                                        <?php echo htmlspecialchars($full_name); ?>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="profile.php"><i class="fi-rs-user"></i> My Profile</a></li>
                                        <li><a class="dropdown-item" href="orders.php"><i class="fi-rs-shopping-cart"></i> My Orders</a></li>
                                        <li><a class="dropdown-item" href="settings.php"><i class="fi-rs-settings"></i> Account Settings</a></li>
                                        <li><a class="dropdown-item" href="functions/logout.php"><i class="fi-rs-sign-out"></i> Logout</a></li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li><a href="register.php"><i class="fi-rs-user"></i> Sign Up</a></li>
                                <li><a href="login.php"><i class="fi-rs-user"></i> Login</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-social-icon">
                    <h5 class="mb-15 text-grey-4">Follow Us</h5>
                    <a href="#"><img src="assets/images/icon-facebook.svg" alt=""></a>
                    <a href="#"><img src="assets/images/icon-twitter.svg" alt=""></a>
                    <a href="#"><img src="assets/images/icon-instagram.svg" alt=""></a>
                    <a href="#"><img src="assets/images/icon-pinterest.svg" alt=""></a>
                    <a href="#"><img src="assets/images/icon-youtube.svg" alt=""></a>
                </div>
            </div>
        </div>
    </div>