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

                            <!-- Search Form -->
                            <form id="ajax-search-form">
                                <select class="select-active" name="category">
                                    <option value="">All Categories</option>
                                    <?php
                                    $category_query = "SELECT * FROM categories WHERE status = 1";
                                    $category_result = mysqli_query($conn, $category_query);
                                    while ($category = mysqli_fetch_assoc($category_result)): ?>
                                        <option value="<?php echo htmlspecialchars($category['name']); ?>">
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <input type="text" name="search" placeholder="Search for items…">
                                <button type="submit"><i class="fi-rs-search"></i></button>
                            </form>

                            <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="searchModalLabel">Search Results</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Loading container -->
                                            <div id="loading" style="display: none; position: relative; height: 300px;">
                                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
                                                    <dotlottie-player
                                                        src="https://lottie.host/c11637a5-4006-467c-8c9f-de0eda7d70e4/jf7UbkGrkG.lottie"
                                                        background="transparent"
                                                        speed="1"
                                                        style="width: 300px; height: 300px;"
                                                        loop
                                                        autoplay>
                                                    </dotlottie-player>
                                                </div>
                                            </div>
                                            <!-- Search results container -->
                                            <div id="search-results">
                                                <!-- Search results will be injected here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        // Determine session and user ID
                        $session_id = session_id();
                        $user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

                        // Fetch cart items
                        $cart_query = "SELECT * FROM cart WHERE session_id = '$session_id'" . ($user_id ? " OR user_id = '$user_id'" : "");
                        $cart_result = mysqli_query($conn, $cart_query);

                        $total_items = 0;
                        $total_price = 0;
                        $cart_items = [];

                        if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                            while ($row = mysqli_fetch_assoc($cart_result)) {
                                $cart_items[] = $row;
                                $total_items += $row['quantity'];
                                $total_price += ($row['selling_price'] * $row['quantity']);
                            }
                        }

                        // Fetch favorites count
                        $fav_query = "SELECT COUNT(*) AS total_favorites FROM favorite WHERE session_id = '$session_id'" . ($user_id ? " OR user_id = '$user_id'" : "");
                        $fav_result = mysqli_query($conn, $fav_query);
                        $fav_count = 0;
                        if ($fav_result) {
                            $fav_row = mysqli_fetch_assoc($fav_result);
                            $fav_count = $fav_row['total_favorites'];
                        }
                        ?>

                        <div class="header-action-right">
                            <div class="header-action-2">
                                <!-- Wishlist Icon -->
                                <div class="header-action-icon-2">
                                    <a href="shop-wishlist.php">
                                        <img class="svgInject" alt="Evara" src="assets/images/icon-heart.svg">
                                        <span class="pro-count blue"><?php echo $fav_count; ?></span>
                                    </a>
                                </div>

                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="shop-cart.php">
                                        <img alt="Evara" src="assets/images/icon-cart.svg">
                                        <span class="pro-count blue"><?php echo $total_items; ?></span>
                                    </a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                        <ul>
                                            <?php if (!empty($cart_items)): ?>
                                                <?php if (!empty($cart_items)): ?>
                                                    <?php foreach (array_slice($cart_items, 0, 3) as $item): ?>
                                                        <li>
                                                            <div class="shopping-cart-img">
                                                                <a href="shop-product.php?id=<?php echo $item['product_id']; ?>">
                                                                    <img alt="Evara" src="uploads/shop/<?php echo $item['image']; ?>">
                                                                </a>
                                                            </div>
                                                            <div class="shopping-cart-title">
                                                                <a href="shop-product.php?id=<?php echo $item['product_id']; ?>">
                                                                    <?php
                                                                    $name = $item['product_name'];
                                                                    $short_name = mb_substr($name, 0, 10);
                                                                    echo htmlspecialchars($short_name) . (mb_strlen($name) > 10 ? '...' : '');
                                                                    ?>
                                                                </a>
                                                                <h4>
                                                                    <span><?php echo $item['quantity']; ?> ×</span>
                                                                    kes<?php echo number_format($item['selling_price'], 2); ?>
                                                                </h4>
                                                            </div>
                                                            <div class="shopping-cart-delete">
                                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <li>
                                                        <div class="shopping-cart-title">
                                                            <h4>No items in cart</h4>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>

                                            <?php else: ?>
                                                <li>
                                                    <div class="shopping-cart-title">
                                                        <h4>No items in cart</h4>
                                                    </div>
                                                </li>
                                            <?php endif; ?>


                                        </ul>
                                        <div class="shopping-cart-footer">
                                            <div class="shopping-cart-total">
                                                <h4>Total <span>Kes<?php echo number_format($total_price, 2); ?></span></h4>
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

                <!-- Container for Mobile Search Results -->
                <div id="mobile-search-results"></div>

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




    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>



    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle the search form submission
            $("#ajax-search-form").on("submit", function(e) {
                e.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize();
                $("#search-results").empty();
                $("#loading").show();
                $("#searchModal").modal("show");

                $.ajax({
                    url: 'search_products.php',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        setTimeout(function() {
                            $("#loading").hide();
                            $("#search-results").html(response);
                        }, 4000);
                    },
                    error: function() {
                        setTimeout(function() {
                            $("#loading").hide();
                            alert("There was an error processing your search.");
                        }, 4000);
                    }
                });
            });

            // Handle pagination link clicks
            $(document).on("click", ".pagination-link", function(e) {
                e.preventDefault();
                var page = $(this).data("page");
                var formData = $("#ajax-search-form").serialize() + "&page=" + page;

                $("#search-results").empty();
                $("#loading").show();

                $.ajax({
                    url: 'search_products.php',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        setTimeout(function() {
                            $("#loading").hide();
                            $("#search-results").html(response);
                        }, 1000);
                    },
                    error: function() {
                        setTimeout(function() {
                            $("#loading").hide();
                            alert("There was an error processing your request.");
                        }, 1000);
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('#ajax-search-form input[name="search"]');
            const searchForm = document.getElementById('ajax-search-form');
            let timeout;

            // Detect user typing
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    // Clear input and optionally reset form
                    searchInput.value = '';
                    // Optional: clear other filters
                    // searchForm.reset();
                    console.log('Search cleared due to inactivity');
                }, 5000); // 5000ms = 5 seconds
            });

            // Optional: Clear when user clicks outside the form
            document.addEventListener('click', function(e) {
                if (!searchForm.contains(e.target)) {
                    clearTimeout(timeout);
                    searchInput.value = '';
                    // searchForm.reset(); // optional
                }
            });
        });
    </script>

    <style>
        /* Container for all the products */
        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px auto;
            max-width: 1200px;
        }

        /* Individual product styling */
        .product {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: box-shadow 0.3s ease;
            width: 280px;
            /* Fixed width for consistent appearance */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Hover effect to indicate clickable area */
        .product:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        /* Styling for the product title */
        .product h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #333;
        }

        /* Styling for the product description and prices */
        .product p {
            margin: 5px 0;
            font-size: 1em;
            color: #444;
        }

        /* Override default styling for product link to blend in with card */
        .product a {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        /* Ensure product images fit nicely in the card */
        .product img {
            margin-top: 10px;
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }

        /* Pagination styling */
        .pagination {
            margin-top: 30px;
        }

        .pagination li {
            list-style: none;
            display: inline-block;
        }

        .pagination li a,
        .pagination li span {
            padding: 8px 16px;
            margin: 0 4px;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #333;
            text-decoration: none;
        }

        /* Hover effect for pagination links */
        .pagination li a:hover {
            background-color: #ddd;
        }

        /* Active page highlight */
        .pagination li.active span {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        /* Disabled styling for unavailable pagination controls */
        .pagination li.disabled span {
            color: #aaa;
            background-color: #f1f1f1;
            border-color: #ccc;
        }
    </style>