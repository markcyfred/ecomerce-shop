<?php
include 'init.php';

if (session_status() == PHP_SESSION_NONE) {
     session_start();
}

include 'functions/userfunctions.php';
?>
<!doctype html>
<html lang="en-US">

<head>

     <meta charset="utf-8">

     <meta http-equiv="x-ua-compatible" content="ie=edge">

     <title>Market place</title>


     <meta name="viewport" content="width=device-width, initial-scale=1">



     <link rel="icon" type="image/vnd.microsoft.icon" href="assets/imgs/logo/logo.png" />
     <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/logo/logo.png" />
     <link rel="apple-touch-icon" href="assets/imgs/logo/logo.png" />



     <!-- Codezeel added -->
     <link href="//fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

     <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOFQNHSoRxMt0aBcB/+Yw5yYtN0bBI7f0Q5V0hMdIP+"
          crossorigin="anonymous">
     <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
          integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm"
          crossorigin="anonymous">
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.10-0/css/ionicons.min.css">
     <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/themify-icons@0.1.2/css/themify-icons.css">
     <link rel="stylesheet"
          href="{$shop_url}/modules/ps_fontawesome/views/dist/css/all.css">

     <link rel="stylesheet" href="assets/css/main.css" type="text/css" media="all">



     <link href="//fonts.googleapis.com/css?family=Lexend:300,400,500,600,700,800,900&display=swap" rel="stylesheet" id="body_font">

     <link href="//fonts.googleapis.com/css?family=Lexend:300,400,500,600,700,800,900&display=swap" rel="stylesheet" id="title_font">

     <link href="//fonts.googleapis.com/css?family=Lexend:300,400,500,600,700,800,900&display=swap" rel="stylesheet" id="banner_font">




     <script type="text/javascript">
          var CZBORDER_RADIUS = "1";
          var CZBOX_LAYOUT = "0";
          var CZSTICKY_HEADER = "1";

          var prestashop = {

          };
     </script>



     <!-- module psproductcountdown start -->
     <script type="text/javascript">
          var pspc_labels = ['days', 'hours', 'minutes', 'seconds'];
          var pspc_labels_lang = {
               'days': 'days',
               'hours': 'hrs',
               'minutes': 'min',
               'seconds': 'sec'
          };
          var pspc_show_weeks = 0;
          var pspc_psv = 8.2;
     </script>
     <!-- module psproductcountdown end -->

</head>

<body id="index" class="lang-en country-us currency-usd layout-full-width page-index tax-display-disabled">



     <main id="page">

          <header id="header">
               <!--top most header-->
               <nav class="header-nav">
                    <div class="container">
                         <div class="left-nav">
                              <div id="cznavcmsblock" class="nav-cms-block">
                                   <p><span class="offer-text">Tell a friends about Market place &amp; get 30% off.</span></p>
                              </div>

                         </div>

                         <div class="right-nav">
                              <div id="_desktop_contact_link">
                                   <div id="contact-link">

                                        <div class="email">
                                             <i class="fa fa-envelope-o"></i>
                                             <a href="mailto:buy@marketplace@com">buy@marketplace.com </a>
                                        </div>

                                        <div class="contact_number">
                                             <i class="fa fa-whatsapp"></i>
                                             <a href="https://wa.me/254111893789" target="_blank">Agree via WhatsApp</a><br>
                                             <i class="fa fa-phone"></i>
                                             <a href="tel:+254111893789">Call: +254 111 893 789</a>
                                        </div>

                                   </div>
                              </div>


                              <div class="language-selector dropdown js-dropdown" id="_desktop_language_selector">
                                   <span class="hidden-lg-up language">Language:</span>
                                   <span class="expand-more" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="language-dropdown">
                                        <span><img class="lang-flag lazyload" data-src="assets/img/eng.jpg"></span>
                                        <span class="hidden-md-down">English </span>
                                        <span class="hidden-lg-up language-iso_code text-uppercase">en</span>
                                   </span>

                              </div>

                              <div class="currency-selector dropdown js-dropdown" id="_desktop_currency_selector">
                                   <span class="currency hidden-lg-up">Currency : </span>
                                   <span class="expand-more _gray-darker" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="currency-dropdown">
                                        KES
                                   </span>

                              </div>
                         </div>

                    </div>
               </nav>
               <!--top most header end-->



               <div class="header-top">
                    <div class="container">

                         <div class="js-top-menu mobile" id="_mobile_base_menu"></div>

                         <div class="header_logo">
                              <h1>
                                   <a href="index.php" title="Market place" class="logo">
                                        <img
                                             src="assets/imgs/logo/logo.png"
                                             alt="Market place"
                                             class="logo img-responsive"
                                             style="width:50px; height:auto;"
                                             loading="lazy">
                                   </a>
                              </h1>
                         </div>


                         <!-- Block search module TOP -->
                         <!-- Block search module TOP (consolidated into one) -->
                         <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                         <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                         <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>


                         <div id="search_block_top" class="search-widget">
                              <span class="search_button" data-target="#search-toggle" data-toggle="collapse" aria-expanded="false"></span>
                              <div id="search-toggle" class="search_toggle collapse">
                                   <form id="ajax-search-form-2" method="get" action="javascript:;">
                                        <div class="czsearch-main">
                                             <input type="hidden" name="controller" value="search">
                                             <input type="hidden" name="orderby" value="position" />
                                             <input type="hidden" name="orderway" value="desc" />

                                             <input class="search_query form-control" type="text" id="search_query_top" name="search" placeholder="Search Product Here..." value="" />
                                        </div>
                                        <button type="submit" class="btn search-icon-btn">
                                             <div class="submit-text">Search</div>
                                        </button>
                                   </form>
                              </div>
                         </div>

                         <!-- Modal for results -->
                         <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                   <div class="modal-content">
                                        <span class="search-exit" aria-label="Exit">&times;</span>

                                        <div class="modal-header">
                                             <h5 class="modal-title" id="searchModalLabel">Search Results</h5>
                                        </div>
                                        <div class="modal-body">
                                             <div id="loading" style="display:none; position:relative; height:300px;">
                                                  <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">
                                                       <dotlottie-player src="https://lottie.host/c11637a5-4006-467c-8c9f-de0eda7d70e4/jf7UbkGrkG.lottie" background="transparent" speed="1" style="width:300px; height:300px;" loop autoplay></dotlottie-player>
                                                  </div>
                                             </div>
                                             <div id="search-results"><!-- AJAX results injected here --></div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <script>
                              $(function() {
                                   var inactivityTime = function() {
                                        let timeout;

                                        function resetTimer() {
                                             clearTimeout(timeout);
                                             timeout = setTimeout(() => {
                                                  // Clear the search input
                                                  $('#search_query_top').val('');

                                                  // Clear the results
                                                  $('#search-results').empty();

                                                  // Hide the modal
                                                  $('#searchModal').removeClass('show').attr('aria-hidden', 'true').css('display', 'none');
                                                  $('body').removeClass('modal-open');
                                                  $('.modal-backdrop').remove();
                                             }, 10000); // 30 seconds
                                        }

                                        // Reset timer on any of these user actions
                                        ['mousemove', 'keypress', 'click', 'scroll'].forEach(evt => {
                                             document.addEventListener(evt, resetTimer, false);
                                        });

                                        resetTimer(); // Initialize
                                   };

                                   inactivityTime();
                              });

                              $(function() {
                                   var $form = $("#ajax-search-form-2"),
                                        $input = $("#search_query_top"),
                                        $results = $("#search-results"),
                                        $loading = $("#loading");

                                   // Core AJAX search + modal
                                   $form.on("submit", function(e) {
                                        e.preventDefault();
                                        var data = $form.serialize();
                                        $results.empty();
                                        $loading.show();
                                        $("#searchModal").modal("show");

                                        $.ajax({
                                             url: 'search_products.php',
                                             type: 'GET',
                                             data: data,
                                             success: function(resp) {
                                                  setTimeout(function() {
                                                       $loading.hide();
                                                       $results.html(resp);
                                                  }, 400);
                                             },
                                             error: function() {
                                                  setTimeout(function() {
                                                       $loading.hide();
                                                       alert("There was an error processing your search.");
                                                  }, 400);
                                             }
                                        });
                                   });

                                   // Pagination links inside results
                                   $(document).on("click", ".pagination-link", function(e) {
                                        e.preventDefault();
                                        var page = $(this).data("page"),
                                             data = $form.serialize() + "&page=" + page;
                                        $results.empty();
                                        $loading.show();
                                        $.ajax({
                                             url: 'search_products.php',
                                             type: 'GET',
                                             data: data,
                                             success: function(resp) {
                                                  setTimeout(function() {
                                                       $loading.hide();
                                                       $results.html(resp);
                                                  }, 400);
                                             },
                                             error: function() {
                                                  setTimeout(function() {
                                                       $loading.hide();
                                                       alert("There was an error processing your request.");
                                                  }, 400);
                                             }
                                        });
                                   });
                              });
                              $(document).on('click', '.search-exit', function() {
                                   $('#searchModal').removeClass('show').attr('aria-hidden', 'true').css('display', 'none');
                                   $('body').removeClass('modal-open');
                                   $('.modal-backdrop').remove(); // If you added a backdrop manually or via JS
                              });
                         </script>
                         <!-- /Block search module TOP -->


                         <div class="header-top-right">

                              <div class="user-info js-dropdown">
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

                                        <a class="user-icon" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             <img style="width: 50px;border: radious 50px;" src="uploads/profile/<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-pic">
                                             <span style="color: white;"><?= htmlspecialchars($full_name) ?></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">
                                             <a class="dropdown-item" href="profile.php">My Profile</a>
                                             <a class="dropdown-item" href="orders.php">My Orders</a>
                                             <a class="dropdown-item" href="functions/logout.php">Logout</a>
                                        </div>
                                   <?php else: ?>
                                        <a class="user-icon" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             <i class="fas fa-user-circle" style="font-size: 20px; color: #fff;"></i>
                                             <span style="color: white;" class="user-name">Login/Register</span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">
                                             <a class="dropdown-item" href="login.php">Login</a>
                                             <a class="dropdown-item" href="register.php">Register</a>
                                        </div>
                                   <?php endif; ?>
                              </div>


                              <div class="head-wishlist">
                                   <?php
                                   // Determine session and user ID
                                   $session_id = session_id();
                                   $user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

                                   // Fetch cart items
                                   $cart_query = "SELECT * FROM cart WHERE  cart_status = 'unprocessed' AND (session_id = '$session_id'" . ($user_id ? " OR user_id = '$user_id'" : "") . ")";


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
                                   <div class="head-wishlist"></div>
                                   <a class="ap-btn-wishlist" href="wishlist" title="Wishlist" rel="nofollow">
                                        <i class="material-icons">&#xE87C;</i>
                                        <span class="icon">Wishlist</span>
                                        <span class="ap-total-wishlist"><?php echo $fav_count; ?></span>
                                   </a>
                              </div>
                              <div id="desktop_cart">
                                   <div class="blockcart" id="blockcart_top_menu">
                                        <div class="header blockcart-header">
                                             <?php if (!empty($cart_items)): ?>
                                                  <div class="shopping-cart" rel="nofollow">
                                                       <span class="icon"> </span>
                                                       <span class="mobile_count"><?php echo $total_items; ?></span>
                                                       <span class="cart-products-count hidden-sm-down">
                                                            My Cart
                                                            <span class="value"> Kes <?php echo number_format($total_price, 2); ?></span>
                                                       </span>
                                                  </div>

                                                  <div class="cart_block block exclusive">
                                                       <div class="top-block-cart">
                                                            <div class="toggle-title">
                                                                 Shopping Cart
                                                                 <span class="cart-products-count hidden-sm-down">
                                                                      My Cart
                                                                      <span class="value"> Kes <?php echo number_format($total_price, 2); ?></span>
                                                                 </span>
                                                            </div>
                                                            <span aria-hidden="true" class="close-icon">
                                                                 <i class="material-icons">close</i>
                                                            </span>
                                                       </div>

                                                       <div class="cart-items-scrollable">
                                                            <?php foreach (array_slice($cart_items, 0, 10) as $item): ?>
                                                                 <div class="cart-item">
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
                                                                 </div>
                                                            <?php endforeach; ?>
                                                       </div>
                                                       <style>
                                                            .cart-items-scrollable {
                                                                 max-height: 600px;
                                                                 /* Adjust based on your layout */
                                                                 overflow-y: auto;
                                                                 padding-right: 5px;
                                                                 /* To prevent content being hidden under scrollbar */
                                                            }



                                                            /* Optional: Smooth scrollbar styling (for modern browsers) */
                                                            .cart-items-scrollable::-webkit-scrollbar {
                                                                 width: 6px;
                                                            }

                                                            .cart-items-scrollable::-webkit-scrollbar-thumb {
                                                                 background-color: #ccc;
                                                                 border-radius: 4px;
                                                            }

                                                            .cart-item {
                                                                 display: flex;
                                                                 align-items: center;
                                                                 justify-content: space-between;
                                                                 padding: 10px 0;
                                                                 border-bottom: 1px solid #e0e0e0;
                                                                 font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                                            }

                                                            .shopping-cart-img img {
                                                                 width: 70px;
                                                                 height: auto;
                                                                 object-fit: contain;
                                                                 border-radius: 6px;
                                                            }

                                                            .shopping-cart-title {
                                                                 flex: 1;
                                                                 margin: 0 15px;
                                                            }

                                                            .shopping-cart-title a {
                                                                 font-size: 14px;
                                                                 font-weight: 500;
                                                                 color: #333;
                                                                 text-decoration: none;
                                                                 display: block;
                                                                 margin-bottom: 4px;
                                                            }

                                                            .shopping-cart-title a:hover {
                                                                 color: #d10000;
                                                            }

                                                            .shopping-cart-title h4 {
                                                                 font-size: 13px;
                                                                 font-weight: 400;
                                                                 color: #666;
                                                                 margin: 0;
                                                            }

                                                            .shopping-cart-delete a {
                                                                 color: #999;
                                                                 font-size: 16px;
                                                                 text-decoration: none;
                                                                 transition: color 0.2s;
                                                            }

                                                            .shopping-cart-delete a:hover {
                                                                 color: #ff0000;
                                                            }
                                                       </style>
                                                  </div>
                                             <?php else: ?>
                                                  <div id="desktop_cart" class="shopping-cart" rel="nofollow">
                                                       <span class="icon"></span>
                                                       <span class="mobile_count">
                                                            <?php echo isset($total_items) && $total_items > 0 ? $total_items : '0'; ?>
                                                       </span>
                                                       <span class="cart-products-count hidden-sm-down">
                                                            My Cart
                                                            <span class="value">
                                                                 Kes <?php echo number_format(isset($total_price) ? $total_price : 0, 2); ?>
                                                            </span>
                                                       </span>
                                                  </div>
                                             <?php endif; ?>


                                        </div>
                                   </div>
                              </div>


                         </div>
                    </div>
                    <div class="overlay"></div>

                    <span id="moremenu_text" style="display:none;">More</span>
                    <span id="morecategory_text" style="display:none;">More Categories</span>
                    <span id="lesscategory_text" style="display:none;">Less Categories</span>

               </div>


               <div class="header-top-inner">
                    <div class="container">


                         <div class="vertical-menu menu js-top-menu position-static hidden-md-down">
                              <div id="czverticalmenublock" class="block verticalmenu-block">
                                   <h4 class="expand-more title h3 block_title" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="verticalmenu-dropdown">
                                        Browse All Category
                                        <span class="dropdown-arrow"></span>
                                   </h4>
                                   <div class="block_content verticalmenu_block dropdown-menu" aria-labelledby="verticalmenu-dropdown" id="_desktop_vertical_menu">
                                        <div class="title_main_menu hidden-lg-up">
                                             <div class="title_menu">Browse All Category</div>
                                        </div>

                                        <?php
                                        $category_query = "SELECT * FROM categories WHERE status = 1";
                                        $category_result = mysqli_query($conn, $category_query);
                                        ?>
                                        <ul class="verticalmenu-content">
                                             <?php while ($category = mysqli_fetch_assoc($category_result)): ?>
                                                  <li class="level-1 parent">
                                                       <a href="category.php?id=<?php echo $category['id']; ?>" class="baseinnermenu">
                                                            <span class="material-icons base-left-arrow">arrow_forward</span>
                                                            <span class="catagory"><?php echo htmlspecialchars($category['name']); ?></span>
                                                       </a>
                                                  </li>
                                             <?php endwhile; ?>
                                        </ul>

                                   </div>
                              </div>
                         </div>
                         <!-- Module Horizontalmenu-->
                         <div id="_desktop_base_menu">
                              <div class="container_base_horizontalmenu col-sm-12">
                                   <div id="base-menu-horizontal" class="base-menu-horizontal clearfix">
                                        <div class="title-horizontalmenu-mobile default-open" title="Shop Categories">
                                             <div class="menu-title">Menu</div>
                                        </div>

                                        <div class="horizontalmain-menu">
                                             <div class="title_main_menu">
                                                  <div class="title_menu">Menu</div>
                                                  <i class="material-icons menu-close">&#xE5CD;</i>
                                             </div>

                                             <ul class="horizontalmenu-content">

                                                  <li class="level-1 label-danger parent">
                                                       <a href="#" class="baseinnermenu">
                                                            <span class="material-icons base-left-arrow">arrow_forward</span>
                                                            <span class="catagory">Shoes</span> <i class="material-icons expand-more">&#xe313;</i>
                                                            <div class="menu-subtitle">Sale</div>
                                                       </a>

                                                       <span data-target="#top_sub_menu_65453" data-toggle="collapse" class="navbar-toggler collapse-icons">
                                                            <i class="material-icons add">&#xe145;</i>
                                                            <i class="material-icons remove">&#xE15B;</i>
                                                       </span>

                                                       <div class="base-sub-menu menu-dropdown col-xs-12 col-sm-12 base-sub-left" id="top_sub_menu_65453">

                                                            <div class="base-menu-row five-column">

                                                                 <div class="base-menu-col col-xs-12 col-sm-2 ">


                                                                      <ul class="ul-column ">
                                                                           <?php //display men shoes 
                                                                           $men_shoes_query = "SELECT * FROM categories WHERE status = 1 AND name LIKE '%Shoes%'";
                                                                           $men_shoes_result = mysqli_query($conn, $men_shoes_query);
                                                                           ?>

                                                                           <?php while ($men_shoes = mysqli_fetch_assoc($men_shoes_result)): ?>
                                                                                <li class="menu-item item-line ">
                                                                                     <a href="category.php?id=<?php echo $men_shoes['id']; ?>" class="submenu-title"><?php echo htmlspecialchars($men_shoes['name']); ?></a>
                                                                                </li>
                                                                           <?php endwhile; ?>
                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-2 ">

                                                                      <ul class="ul-column ">

                                                                           <?php //show 3 items under categories in table products under the above category having shoes 

                                                                           $men_shoes_query = "SELECT * FROM products WHERE status = 1 AND category_name LIKE '%Shoes%' LIMIT 10";
                                                                           $men_shoes_result = mysqli_query($conn, $men_shoes_query);

                                                                           ?>
                                                                           <?php while ($men_shoes = mysqli_fetch_assoc($men_shoes_result)): ?>
                                                                                <li class="menu-item item-line ">
                                                                                     <a href="shop-product.php?id=<?php echo $men_shoes['id']; ?>" class="submenu-title"><?php echo htmlspecialchars($men_shoes['product_name']); ?></a>
                                                                                </li>
                                                                           <?php endwhile; ?>

                                                                      </ul>
                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-4 product-listview product-slider background-gray">



                                                                      <ul class="ul-column menu-product-carousel_1 owl-carousel">
                                                                           <li class="menu-item item-header">
                                                                                <a href="#" class="submenu-title">Featured Products</a>
                                                                           </li>
                                                                           <?php //select from producta status is 1 and featured = featured
                                                                           $featured_query = "SELECT * FROM products WHERE status = 1 AND featured = 'featured' LIMIT 4";
                                                                           $featured_result = mysqli_query($conn, $featured_query);
                                                                           ?>
                                                                           <?php while ($featured = mysqli_fetch_assoc($featured_result)): ?>
                                                                                <li class="menu-item item-line product-block owl-item">
                                                                                     <article class="product_item product-miniature js-product-miniature">
                                                                                          <div class="products">
                                                                                               <div class="thumbnail-container clearfix">
                                                                                                    <div class="baseproduct-image">
                                                                                                         <a class="product_img_link product-thumbnail" href="shop-product.php?id=<?php echo $featured['id']; ?>" title="<?php echo htmlspecialchars($featured['product_name']); ?>">
                                                                                                              <img class="replace-2x img-responsive" src="uploads/shop/<?php echo $featured['image']; ?>" alt="<?php echo htmlspecialchars($featured['product_name']); ?>" title="<?php echo htmlspecialchars($featured['product_name']); ?>" height="236" width="307" />

                                                                                                         </a>

                                                                                                         <p class="discount-percentage product-flags discount-product">
                                                                                                              <span class="product-flag flash-sale discount">
                                                                                                                   <i class="material-icons left">&#xe3e7;</i>
                                                                                                                   -10%
                                                                                                              </span>
                                                                                                         </p>
                                                                                                    </div>
                                                                                                    <div class="baseproduct-desc">
                                                                                                         <div class="product-description">
                                                                                                              <h3 class="product-title">
                                                                                                                   <a class="product-name" href="shop-product.php?id=<?php echo $featured['id']; ?>" title="<?php echo htmlspecialchars($featured['product_name']); ?>">
                                                                                                                        <?php echo htmlspecialchars($featured['product_name']); ?>
                                                                                                                   </a>
                                                                                                              </h3>
                                                                                                              <div class="content_price product-price-and-shipping">
                                                                                                                   <span class="price  special-price">
                                                                                                                        kes<?php echo number_format($featured['selling_price'], 2); ?>
                                                                                                                   </span>
                                                                                                                   <span class="old-price regular-price">
                                                                                                                        kes<?php echo number_format($featured['original_price'], 2); ?>
                                                                                                                   </span>
                                                                                                              </div>
                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </article>
                                                                                </li>
                                                                           <?php endwhile; ?>


                                                                      </ul>
                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-4 customhtml">



                                                                      <ul class="ul-column ">
                                                                           <?php
                                                                           // Select the product deal that is active, not expired, and ending soonest
                                                                           $deal_query = "SELECT * FROM products WHERE deal_of_day_status = 'open' AND status = 1 AND deal_end > NOW() ORDER BY deal_end ASC LIMIT 1";
                                                                           $deal_result = mysqli_query($conn, $deal_query);
                                                                           $deal = mysqli_fetch_assoc($deal_result);
                                                                           ?>

                                                                           <?php if ($deal): ?>
                                                                                <li class="menu-item item-header">
                                                                                     <a href="#" class="submenu-title">Deal of the Day</a>
                                                                                </li>
                                                                                <li class="menu-item item-line">
                                                                                     <div class="html-block">
                                                                                          <div class="deal-of-day">
                                                                                               <div class="deal-image">
                                                                                                    <a href="shop-product.php?id=<?php echo $deal['id']; ?>">
                                                                                                         <img src="uploads/shop/<?php echo $deal['image']; ?>" />
                                                                                                    </a>
                                                                                               </div>
                                                                                               <div class="deal-title">
                                                                                                    <a href="shop-product.php?id=<?php echo $deal['id']; ?>">
                                                                                                         <?php echo htmlspecialchars($deal['product_name']); ?>
                                                                                                    </a>
                                                                                               </div>
                                                                                               <div class="deal-price">
                                                                                                    <span class="price">kes<?php echo number_format($deal['selling_price'], 2); ?></span>
                                                                                               </div>
                                                                                               <div class="deal-countdown">
                                                                                                    <div class="deal-countdown-timer">
                                                                                                         <div class="deal-countdown-title">Hurry Up!</div>
                                                                                                         <div class="deal-countdown-time" data-deal-end="<?php echo $deal['deal_end']; ?>">
                                                                                                              <div class="deal-countdown-item">
                                                                                                                   <span class="deal-countdown-number" id="hours">00</span>
                                                                                                                   <span class="deal-countdown-label">Hrs</span>
                                                                                                              </div>
                                                                                                              <div class="deal-countdown-item">
                                                                                                                   <span class="deal-countdown-number" id="minutes">00</span>
                                                                                                                   <span class="deal-countdown-label">Mins</span>
                                                                                                              </div>
                                                                                                              <div class="deal-countdown-item">
                                                                                                                   <span class="deal-countdown-number" id="seconds">00</span>
                                                                                                                   <span class="deal-countdown-label">Secs</span>
                                                                                                              </div>
                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                               <div class="deal-button">
                                                                                                    <a class="btn shopnow-link" href="shop-product.php?id=<?php echo $deal['id']; ?>">Shop Now</a>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </li>

                                                                                <script>
                                                                                     document.addEventListener('DOMContentLoaded', function() {
                                                                                          const countdown = document.querySelector('.deal-countdown-time');
                                                                                          if (!countdown) return;

                                                                                          const endTime = new Date(countdown.getAttribute('data-deal-end')).getTime();

                                                                                          function updateCountdown() {
                                                                                               const now = new Date().getTime();
                                                                                               const distance = endTime - now;

                                                                                               if (distance < 0) {
                                                                                                    countdown.innerHTML = "<strong>Deal Expired</strong>";
                                                                                                    return;
                                                                                               }

                                                                                               const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                                               const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                                                               const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                                                               document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                                                                                               document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                                                                                               document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
                                                                                          }

                                                                                          updateCountdown();
                                                                                          setInterval(updateCountdown, 1000);
                                                                                     });
                                                                                </script>

                                                                                <style>
                                                                                     .deal-of-day {
                                                                                          text-align: center;
                                                                                          padding: 15px;
                                                                                     }

                                                                                     .deal-image img {
                                                                                          width: 100%;
                                                                                          max-height: 180px;
                                                                                          object-fit: cover;
                                                                                          border-radius: 5px;
                                                                                     }

                                                                                     .deal-title {
                                                                                          font-weight: bold;
                                                                                          font-size: 1.1em;
                                                                                          margin: 10px 0;
                                                                                     }

                                                                                     .deal-price .price {
                                                                                          color: #dc3545;
                                                                                          font-size: 1.2em;
                                                                                          font-weight: bold;
                                                                                     }

                                                                                     .deal-countdown {
                                                                                          margin-top: 10px;
                                                                                     }

                                                                                     .deal-countdown-timer {
                                                                                          background: #343a40;
                                                                                          color: #fff;
                                                                                          padding: 10px;
                                                                                          border-radius: 5px;
                                                                                     }

                                                                                     .deal-countdown-title {
                                                                                          font-weight: bold;
                                                                                          margin-bottom: 8px;
                                                                                     }

                                                                                     .deal-countdown-time {
                                                                                          display: flex;
                                                                                          justify-content: center;
                                                                                          gap: 10px;
                                                                                     }

                                                                                     .deal-countdown-item {
                                                                                          text-align: center;
                                                                                     }

                                                                                     .deal-countdown-number {
                                                                                          font-size: 1.5em;
                                                                                          font-weight: bold;
                                                                                     }

                                                                                     .deal-button .btn {
                                                                                          background-color: #28a745;
                                                                                          color: white;
                                                                                          padding: 8px 16px;
                                                                                          border-radius: 4px;
                                                                                          display: inline-block;
                                                                                          margin-top: 10px;
                                                                                          text-decoration: none;
                                                                                     }

                                                                                     .deal-button .btn:hover {
                                                                                          background-color: #218838;
                                                                                     }
                                                                                </style>
                                                                           <?php else: ?>
                                                                                <li class="menu-item item-header">
                                                                                     <a href="#" class="submenu-title">Deal of the Day</a>
                                                                                </li>
                                                                                <li class="menu-item item-line">
                                                                                     <div class="html-block">
                                                                                          <div class="deal-of-day" style="text-align: center;">
                                                                                               <img src="admin/assets/img/nothing.png" alt="No Deal Available" style="max-width: 100%; height: auto; border-radius: 5px;" />
                                                                                               <div style="margin-top: 10px; font-weight: bold; color: #888;">No deal available right now</div>
                                                                                          </div>
                                                                                     </div>
                                                                                </li>
                                                                           <?php endif; ?>
                                                                      </ul>

                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </li>

                                                  <li class="level-1 label-info parent">
                                                       <a href="#" class="baseinnermenu">
                                                            <span class="material-icons base-left-arrow">arrow_forward</span>
                                                            <span class="catagory">Categories</span> <i class="material-icons expand-more">&#xe313;</i>
                                                            <div class="menu-subtitle">Hot</div>
                                                       </a>

                                                       <span data-target="#top_sub_menu_34368" data-toggle="collapse" class="navbar-toggler collapse-icons">
                                                            <i class="material-icons add">&#xe145;</i>
                                                            <i class="material-icons remove">&#xE15B;</i>
                                                       </span>

                                                       <div class="base-sub-menu menu-dropdown col-xs-12 col-sm-12 base-sub-left" id="top_sub_menu_34368">

                                                            <div class="base-menu-row ">

                                                                 <div class="base-menu-col col-xs-12 col-sm-2 ">
                                                                      <?php //select categories from categories table where status = 1 and name is Accessories
                                                                      $accessories_query = "SELECT * FROM categories WHERE status = 1 AND name LIKE '%Accessories%'";
                                                                      $accessories_result = mysqli_query($conn, $accessories_query);
                                                                      ?>
                                                                      <ul class="ul-column ">
                                                                           <?php while ($accessories = mysqli_fetch_assoc($accessories_result)): ?>
                                                                                <li class="menu-item item-header">
                                                                                     <a href="category.php?id=<?php echo $accessories['id']; ?>" class="submenu-title"><?php echo htmlspecialchars($accessories['name']); ?></a>
                                                                                </li>
                                                                           <?php endwhile; ?>
                                                                           <?php //show 3 items under categories in table products under the above category having accessories
                                                                           $accessories_query = "SELECT * FROM products WHERE status = 1 AND category_name LIKE '%Accessories%' LIMIT 4";
                                                                           $accessories_result = mysqli_query($conn, $accessories_query);
                                                                           ?>
                                                                           <?php while ($accessories = mysqli_fetch_assoc($accessories_result)): ?>
                                                                                <li class="menu-item item-line ">
                                                                                     <a href="shop-product.php?id=<?php echo $accessories['id']; ?>" class="submenu-title"><?php echo htmlspecialchars($accessories['product_name']); ?></a>
                                                                                </li>
                                                                           <?php endwhile; ?>


                                                                      </ul>

                                                                      <?php //select categories from categories table where status = 1 and name is Accessories
                                                                      $women_query = "SELECT * FROM categories WHERE status = 1 AND name LIKE '%Women Clothing%'";
                                                                      $women_result = mysqli_query($conn, $women_query);
                                                                      ?>
                                                                      <ul class="ul-column ">
                                                                           <?php while ($women = mysqli_fetch_assoc($women_result)): ?>
                                                                                <li class="menu-item item-header">
                                                                                     <a href="category.php?id=<?php echo $women['id']; ?>" class="submenu-title"><?php echo htmlspecialchars($women['name']); ?></a>
                                                                                </li>
                                                                           <?php endwhile; ?>
                                                                           <?php //show 3 items under categories in table products under the above category having accessories
                                                                           $women_query = "SELECT * FROM products WHERE status = 1 AND category_name LIKE '%Women Clothing%' LIMIT 4";
                                                                           $women_result = mysqli_query($conn, $women_query);
                                                                           ?>
                                                                           <?php while ($women = mysqli_fetch_assoc($women_result)): ?>
                                                                                <li class="menu-item item-line ">
                                                                                     <a href="shop-product.php?id=<?php echo $women['id']; ?>" class="submenu-title"><?php echo htmlspecialchars($women['product_name']); ?></a>
                                                                                </li>
                                                                           <?php endwhile; ?>



                                                                      </ul>

                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-2 ">

                                                                      <?php //select categories from categories table where status = 1 and name is Accessories
                                                                      $men_query = "SELECT * FROM categories WHERE status = 1 AND name LIKE '%Men Clothing%'";
                                                                      $men_result = mysqli_query($conn, $men_query);
                                                                      ?>
                                                                      <ul class="ul-column ">
                                                                           <?php while ($men = mysqli_fetch_assoc($men_result)): ?>
                                                                                <li class="menu-item item-header">
                                                                                     <a href="category.php?id=<?php echo $men['id']; ?>" class="submenu-title"><?php echo htmlspecialchars($men['name']); ?></a>
                                                                                </li>
                                                                           <?php endwhile; ?>
                                                                           <?php //show 3 items under categories in table products under the above category having accessories
                                                                           $men_query = "SELECT * FROM products WHERE status = 1 AND category_name LIKE '%Men Clothing%' LIMIT 4";
                                                                           $men_result = mysqli_query($conn, $men_query);
                                                                           ?>
                                                                           <?php while ($men = mysqli_fetch_assoc($men_result)): ?>
                                                                                <li class="menu-item item-line ">
                                                                                     <a href="shop-product.php?id=<?php echo $men['id']; ?>" class="submenu-title"><?php echo htmlspecialchars($men['product_name']); ?></a>
                                                                                </li>
                                                                           <?php endwhile; ?>


                                                                      </ul>

                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-4 menu-category">
                                                                      <?php
                                                                      // Get categories with active status
                                                                      $categories_query = "SELECT * FROM categories WHERE status = 1  ORDER BY RAND() LIMIT 8";
                                                                      $categories_result = mysqli_query($conn, $categories_query);
                                                                      ?>
                                                                      <ul class="ul-column">
                                                                           <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                                                                                <li class="menu-item item-line">
                                                                                     <div class="html-block">
                                                                                          <div class="categorylist">
                                                                                               <div class="cate-image">
                                                                                                    <a href="category.php?id=<?php echo $category['id']; ?>">
                                                                                                         <img src="uploads/categories/<?php echo htmlspecialchars($category['image']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" />
                                                                                                    </a>
                                                                                                    <div class="cate-heading">
                                                                                                         <a href="category.php?id=<?php echo $category['id']; ?>">
                                                                                                              <?php echo htmlspecialchars($category['name']); ?>
                                                                                                         </a>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </li>
                                                                           <?php endwhile; ?>
                                                                      </ul>
                                                                 </div>

                                                                 <div class="base-menu-col col-xs-12 col-sm-4 product-listview product-slider background-gray">
                                                                      <?php
                                                                      // Get 6 active products
                                                                      $products_query = "SELECT * FROM products WHERE status = 1 ORDER BY RAND() DESC LIMIT 4";
                                                                      $products_result = mysqli_query($conn, $products_query);
                                                                      ?>

                                                                      <ul class="ul-column menu-product-carousel_2 owl-carousel">
                                                                           <?php while ($product = mysqli_fetch_assoc($products_result)): ?>
                                                                                <li class="menu-item item-line product-block owl-item">
                                                                                     <article class="product_item product-miniature js-product-miniature">
                                                                                          <div class="products">
                                                                                               <div class="thumbnail-container clearfix">
                                                                                                    <div class="baseproduct-image">
                                                                                                         <a class="product_img_link product-thumbnail" href="shop-product.php?id=<?php echo $product['id']; ?>" title="<?php echo htmlspecialchars($product['product_name']); ?>">
                                                                                                              <img class="replace-2x img-responsive"
                                                                                                                   src="uploads/shop/<?php echo $product['image']; ?>"
                                                                                                                   alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                                                                                                   title="<?php echo htmlspecialchars($product['product_name']); ?>"
                                                                                                                   height="236" width="307" />
                                                                                                         </a>

                                                                                                         <?php if ($product['discount'] > 0): ?>
                                                                                                              <p class="discount-percentage product-flags discount-product">
                                                                                                                   <span class="product-flag flash-sale discount">
                                                                                                                        <i class="material-icons left">&#xe3e7;</i>
                                                                                                                        -<?php echo (int)$product['discount']; ?>%
                                                                                                                   </span>
                                                                                                              </p>
                                                                                                         <?php endif; ?>
                                                                                                    </div>

                                                                                                    <div class="baseproduct-desc">
                                                                                                         <div class="product-description">
                                                                                                              <h3 class="product-title">
                                                                                                                   <a class="product-name" href="shop-product.php?id=<?php echo $product['id']; ?>" title="<?php echo htmlspecialchars($product['product_name']); ?>">
                                                                                                                        <?php echo htmlspecialchars($product['product_name']); ?>
                                                                                                                   </a>
                                                                                                              </h3>

                                                                                                              <div class="content_price product-price-and-shipping">
                                                                                                                   <span class="price special-price">
                                                                                                                        KES <?php echo number_format($product['selling_price'], 2); ?>
                                                                                                                   </span>

                                                                                                                   <?php if ($product['original_price'] > $product['selling_price']): ?>
                                                                                                                        <span class="old-price regular-price">
                                                                                                                             KES <?php echo number_format($product['original_price'], 2); ?>
                                                                                                                        </span>
                                                                                                                   <?php endif; ?>
                                                                                                              </div>
                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </article>
                                                                                </li>
                                                                           <?php endwhile; ?>
                                                                      </ul>

                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </li>


                                                  <li class="level-1 label-success parent">
                                                       <a href="#" class="baseinnermenu">
                                                            <span class="material-icons base-left-arrow">arrow_forward</span>
                                                            <span class="catagory">Products</span> <i class="material-icons expand-more">&#xe313;</i>
                                                            <div class="menu-subtitle">New</div>
                                                       </a>

                                                       <span data-target="#top_sub_menu_47333" data-toggle="collapse" class="navbar-toggler collapse-icons">
                                                            <i class="material-icons add">&#xe145;</i>
                                                            <i class="material-icons remove">&#xE15B;</i>
                                                       </span>

                                                       <div class="base-sub-menu menu-dropdown col-xs-12 col-sm-12 base-sub-auto" id="top_sub_menu_47333">

                                                            <div class="base-menu-row product-main-slider">

                                                                 <div class="base-menu-col col-xs-12 col-sm-2 htmlblock-background">




                                                                      <ul class="ul-column">
                                                                           <li class="menu-item item-line">
                                                                                <div class="html-block">
                                                                                     <div class="custom-text-html">
                                                                                          <div class="main-title">Latest Arrivals <?= date('Y') ?></div>
                                                                                          <div class="detail">
                                                                                               Explore our newest collection of products for <?= date('Y') ?>. Enjoy a seamless shopping experience with fully customizable and modern designs.
                                                                                          </div>
                                                                                          <a class="btn shopnow-link" href="#">Browse Now</a>
                                                                                     </div>
                                                                                </div>
                                                                           </li>
                                                                      </ul>

                                                                 </div>
                                                                 <div class="base-menu-col col-xs-12 col-sm-10 ">

                                                                      <ul class="ul-column menu-product-carousel_3 owl-carousel">
                                                                           <?php
                                                                           // Get 4 random active products
                                                                           $products_query = "SELECT * FROM products WHERE status = 1 ORDER BY RAND() DESC LIMIT 5";
                                                                           $products_result = mysqli_query($conn, $products_query);

                                                                           if (mysqli_num_rows($products_result) > 0) {
                                                                                while ($product = mysqli_fetch_assoc($products_result)) {
                                                                           ?>
                                                                                     <li class="menu-item item-line product-block owl-item">
                                                                                          <article class="product_item product-miniature js-product-miniature">
                                                                                               <div class="products">
                                                                                                    <div class="thumbnail-container clearfix">
                                                                                                         <div class="baseproduct-image">
                                                                                                              <a class="product_img_link product-thumbnail" href="shop-product.php?id=<?= $product['id'] ?>"
                                                                                                                   title="<?= htmlspecialchars($product['product_name']) ?>">
                                                                                                                   <img class="replace-2x img-responsive"
                                                                                                                        src="uploads/shop/<?= htmlspecialchars($product['image']) ?>"
                                                                                                                        alt="<?= htmlspecialchars($product['product_name']) ?>"
                                                                                                                        title="<?= htmlspecialchars($product['product_name']) ?>"
                                                                                                                        height="236" width="307" />
                                                                                                              </a>

                                                                                                              <?php if ($product['discount'] > 0): ?>
                                                                                                                   <p class="discount-percentage product-flags discount-product">
                                                                                                                        <span class="product-flag flash-sale discount">
                                                                                                                             <i class="material-icons left">&#xe3e7;</i>
                                                                                                                             -<?= round($product['discount']) ?>%
                                                                                                                        </span>
                                                                                                                   </p>
                                                                                                              <?php endif; ?>
                                                                                                         </div>
                                                                                                         <div class="baseproduct-desc">
                                                                                                              <div class="product-description">
                                                                                                                   <h3 class="product-title">
                                                                                                                        <a class="product-name" href="shop-product.php?id=<?= $product['id'] ?>"
                                                                                                                             title="<?= htmlspecialchars($product['product_name']) ?>">
                                                                                                                             <?= htmlspecialchars($product['product_name']) ?>
                                                                                                                        </a>
                                                                                                                   </h3>
                                                                                                                   <div class="content_price product-price-and-shipping">
                                                                                                                        <span class="price special-price">
                                                                                                                             Ksh <?= number_format($product['selling_price'], 2) ?>
                                                                                                                        </span>
                                                                                                                        <?php if ($product['original_price'] > $product['selling_price']): ?>
                                                                                                                             <span class="old-price regular-price">
                                                                                                                                  Ksh <?= number_format($product['original_price'], 2) ?>
                                                                                                                             </span>
                                                                                                                        <?php endif; ?>
                                                                                                                   </div>
                                                                                                              </div>
                                                                                                         </div>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </article>
                                                                                     </li>
                                                                           <?php
                                                                                }
                                                                           } else {
                                                                                echo "<li>No products found.</li>";
                                                                           }
                                                                           ?>
                                                                      </ul>

                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </li>

                                           

                                                  <li class="level-1 ">
                                                       
                                                  <a href="shop.php" class="baseinnermenu">
                                                       <span class="catagory">Shop</span></i>
                                                  </a>
                                                  </li>


                                                  <li class="level-1 ">
                                                    
                                                  <a href="about.php" class="baseinnermenu">
                                                       <span class="catagory">About Us</span></i>
                                                  </li>

                                             </ul>

                                             <div class="js-top-menu mobile" id="_mobile_vertical_menu"></div>

                                             <div class="js-top-menu-bottom">
                                                  <div id="_mobile_currency_selector"></div>
                                                  <div id="_mobile_language_selector"></div>
                                                  <div id="_mobile_contact_link"></div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <!-- /Module Horizontalmenu -->

                    </div>
               </div>

          </header>