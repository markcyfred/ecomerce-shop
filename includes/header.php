<?php
include __DIR__ . '/../init.php';

if (session_status() == PHP_SESSION_NONE) {
     session_start();
}

include __DIR__ . '/../functions/userfunctions.php';
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
     <link href="assets/fonts/lexend.css" rel="stylesheet">

     <link rel="stylesheet" href="assets/css/all.min.css" type="text/css" media="all">

     <link href="assets/fonts/family.css" rel="stylesheet">



     <link rel="stylesheet" href="assets/css/main.css" type="text/css" media="all">
     <script src="assets/js/jquery-3.6.0.min.js"></script>

     <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
     <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
   

     <script type="text/javascript">
          var CZBORDER_RADIUS = "1";
          var CZBOX_LAYOUT = "0";
          var CZSTICKY_HEADER = "1";

          var goprimehost = {

          };
     </script>

     <link rel="stylesheet" href="assets/css/style.css">
     <link rel="stylesheet" href="assets/css/order.css">

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


                         <!-- ================= ORIGINAL TOP HEADER ================= -->
                         <div class="mobile-only">
                              <div id="original-top-header" class="header-top-right">
                                   <!-- ─── USER INFO DROPDOWN ─── -->
                                   <div class="user-info js-dropdown">
                                        <?php if (isset($_SESSION['auth_user'])): ?>
                                             <?php
                                             // Get user details from the session
                                             $user_id = $_SESSION['auth_user']['id'];
                                             $query = "SELECT `first_name`,`last_name`,`profile_picture` , phone , street_address ,postal_code FROM `users` WHERE `id`='$user_id'";
                                             $result = mysqli_query($conn, $query);
                                             $user_data = mysqli_fetch_assoc($result);

                                             $profile_picture = $user_data['profile_picture'] ?? 'default.png';
                                             $full_name = $user_data['first_name'] . ' ' . $user_data['last_name'];
                                             ?>
                                             <a class="user-icon" href="javascript:void(0)"
                                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <img
                                                       style="width:50px; height:50px; border-radius:50%;"
                                                       src="uploads/profile/<?php echo $profile_picture; ?>"
                                                       alt="Profile Picture"
                                                       class="profile-pic">
                                                  <span style="color: white;"><?= htmlspecialchars($full_name) ?></span>
                                             </a>
                                             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">
                                                  <a class="dropdown-item" href="profile.php">My Profile</a>
                                                  <a class="dropdown-item" href="orders.php">My Orders</a>
                                                  <a class="dropdown-item" href="functions/logout.php">Logout</a>
                                             </div>
                                        <?php else: ?>
                                             <a class="user-icon" href="javascript:void(0)"
                                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <i class="fas fa-user-circle" style="font-size:20px; color:#fff;"></i>
                                                  <span style="color: white;" class="user-name">Login/Register</span>
                                             </a>
                                             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">
                                                  <a class="dropdown-item" href="login.php">Login</a>
                                                  <a class="dropdown-item" href="register.php">Register</a>
                                             </div>
                                        <?php endif; ?>
                                   </div>
                                   <!-- ─── WISHLIST COUNT ─── -->
                                   <div class="head-wishlist">
                                        <?php
                                        // Determine session and user ID
                                        $session_id = session_id();
                                        $user_id    = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

                                        // Fetch cart items
                                        $cart_query = "
                                        SELECT cart.*, product_images.image_path 
                                        FROM cart 
                                        LEFT JOIN product_images 
                                        ON product_images.product_id = cart.product_id 
                                        AND product_images.is_primary = 1 
                                        WHERE (cart.cart_status IS NULL OR cart.cart_status = 'unprocessed') 
                                        AND (
                                                  cart.session_id = '$session_id'
                                                  " . ($user_id ? " OR cart.user_id = '$user_id'" : "") . "
                                             )
                                        ";
                                        $cart_result = mysqli_query($conn, $cart_query);

                                        $total_items = 0;
                                        $total_price = 0;
                                        $cart_items  = [];
                                        $shipping_cost = 0; // Initialize shipping cost to avoid undefined variable error

                                        if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                                             while ($row = mysqli_fetch_assoc($cart_result)) {
                                                  $cart_items[] = $row;
                                                  $total_items += $row['quantity'];
                                                  $total_price += ($row['selling_price'] * $row['quantity']);
                                             }
                                        }

                                        // Fetch favorites count
                                        $fav_query  = "
                                        SELECT COUNT(*) AS total_favorites 
                                        FROM favorite 
                                        WHERE session_id = '$session_id'
                                        " . ($user_id ? " OR user_id = '$user_id'" : "") . "
                                        ";
                                        $fav_result = mysqli_query($conn, $fav_query);
                                        $fav_count  = 0;
                                        if ($fav_result) {
                                             $fav_row  = mysqli_fetch_assoc($fav_result);
                                             $fav_count = $fav_row['total_favorites'];
                                        }
                                        ?>
                                        <a class="ap-btn-wishlist" href="wishlist" title="Wishlist" rel="nofollow">
                                             <i class="material-icons">&#xE87C;</i>
                                             <span class="icon">Wishlist</span>
                                             <span class="ap-total-wishlist"><?php echo $fav_count; ?></span>
                                        </a>
                                   </div>

                                   <!-- ─── f DROPDOWN ─── -->
                                   <div id="desktop_cart">
                                        <div class="blockcart" data-refresh-url="ajax/cart_summary.php">
                                             <div class="header blockcart-header">

                                                  <div class="shopping-cart" rel="nofollow">
                                                       <span class="icon"></span>
                                                       <span class="mobile_count" id="cart-item-count-mobile"><?php echo $total_items; ?></span>
                                                       <span class="cart-products-count hidden-sm-down">
                                                            Items
                                                            <span class="value" id="cart-total-price-mobile">Kes <?php echo number_format($total_price, 2); ?></span>
                                                       </span>
                                                  </div>

                                                  <div class="cart_block block exclusive">
                                                       <div class="top-block-cart">
                                                            <div class="toggle-title">
                                                                 Shopping Cart (<span id="cart-item-count-mobile-title"><?php echo $total_items; ?></span>)
                                                            </div>
                                                            <span aria-hidden="true" class="close-icon">
                                                                 <i class="material-icons">close</i>
                                                            </span>
                                                       </div>

                                                       <div class="block_content">
                                                            <div class="cart_block_list" id="cart-items-list-mobile">
                                                                 <?php if (!empty($cart_items)): ?>
                                                                      <?php foreach ($cart_items as $item): ?>
                                                                           <div class="cart-item" data-cart-id="<?php echo $item['id']; ?>">
                                                                                <div class="cart-image">
                                                                                     <a href="shop-product.php?id=<?php echo $item['product_id']; ?>">
                                                                                          <img
                                                                                               src="<?php echo $item['image_path'] ?: 'uploads/shop/default.png'; ?>"
                                                                                               alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                                                                               width="90" height="90"
                                                                                               style="object-fit:contain;">
                                                                                     </a>
                                                                                </div>
                                                                                <div class="cart-info">
                                                                                     <span class="product-name">
                                                                                          <a href="shop-product.php?id=<?php echo $item['product_id']; ?>">
                                                                                               <?php
                                                                                               $name = $item['product_name'];
                                                                                               echo htmlspecialchars(
                                                                                                    mb_strlen($name) > 30
                                                                                                         ? mb_substr($name, 0, 30) . '…'
                                                                                                         : $name
                                                                                               );
                                                                                               ?>
                                                                                          </a>
                                                                                     </span>
                                                                                     <div>
                                                                                          <span class="product-quantity"><?php echo $item['quantity']; ?> x</span>
                                                                                          <span class="product-price">
                                                                                               Kes <?php echo number_format($item['selling_price'], 2); ?>
                                                                                          </span>
                                                                                     </div>
                                                                                     <a
                                                                                          class="remove-from-cart"
                                                                                          href="#"
                                                                                          data-cart-id="<?php echo $item['id']; ?>"
                                                                                          title="Remove from cart">
                                                                                          <i class="material-icons pull-xs-left">delete</i>
                                                                                     </a>
                                                                                </div>
                                                                           </div>
                                                                      <?php endforeach; ?>
                                                                 <?php else: ?>
                                                                      <div class="no-more-item">
                                                                           <div class="no-img"></div>
                                                                           <div class="empty-text">Your cart is empty.</div>
                                                                           <a rel="nofollow" href="shop.php" class="continue"><button type="button" class="btn btn-primary">Continue shopping</button></a>
                                                                      </div>
                                                                 <?php endif; ?>
                                                            </div>
                                                       </div>

                                                       <div class="card cart-summary">
                                                            <div class="card-block">
                                                                 <div class="cart-summary-line" id="cart-subtotal-products">
                                                                      <span class="label js-subtotal">
                                                                           <?php echo $total_items; ?> item<?php echo $total_items !== 1 ? 's' : ''; ?>
                                                                      </span>
                                                                      <span class="value" id="cart-subtotal-products-value">
                                                                           Kes <?php echo number_format($total_price - $shipping_cost, 2); ?>
                                                                      </span>
                                                                 </div>
                                                                 <div class="cart-summary-line" id="cart-subtotal-shipping">
                                                                      <span class="label">Shipping</span>
                                                                      <span class="value" id="cart-subtotal-shipping-value">Kes <?php echo number_format($shipping_cost, 2); ?></span>
                                                                 </div>
                                                            </div>
                                                            <div class="card-block">
                                                                 <div class="cart-summary-line cart-total">
                                                                      <span class="label">Total&nbsp;(tax incl.)</span>
                                                                      <span class="value" id="cart-total-value">Kes <?php echo number_format($total_price, 2); ?></span>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <div class="checkout card-block">
                                                            <a rel="nofollow" href="cart.php" class="viewcart">
                                                                 <button type="button" class="btn btn-primary">View Cart</button>
                                                            </a>
                                                            <a rel="nofollow" href="shop-cart.php" class="checkout">
                                                                 <button type="button" class="btn btn-primary checkout_button">CheckOut</button>
                                                            </a>
                                                       </div>

                                                  </div>
                                             </div>
                                        </div>
                                   </div>


                              </div>
                         </div>

                         <style>
                              /* Hide on desktop, show on mobile */
                              .mobile-only {
                                   display: block;
                              }

                              @media (min-width: 768px) {
                                   .mobile-only {
                                        display: none;
                                   }
                              }
                         </style>

                         <?php
                         $user_points = 0;
                         $next_reward = 100;

                         if (isset($_SESSION['auth_user'])) {
                              $user_id = $_SESSION['auth_user']['id'];

                              $points_query = "
                                   SELECT SUM(total_amount) AS total_spent
                                   FROM checkout
                                   WHERE user_id = '$user_id'
                              ";

                              $result = mysqli_query($conn, $points_query);
                              if ($result) {
                                   $row = mysqli_fetch_assoc($result);
                                   $total_spent = $row['total_spent'] ?? 0;
                                   $user_points = floor($total_spent / 200); // 1 point per KES 100
                              }
                         }

                         $percent = min(100, ($user_points / $next_reward) * 100);
                         $bar_color = $user_points >= $next_reward ? 'gold' : 'limegreen';
                         ?>
                         <div class="desktop-only" style="padding:10px; color:white;">
                              🎉 You have <?= $user_points ?> points.
                              Only <?= max(0, $next_reward - $user_points) ?> points to unlock your next gift!
                              <div style="width: 100%; background: #444; border-radius: 5px; margin-top: 5px;">
                                   <div style="width: <?= $percent ?>%; background: <?= $bar_color ?>; height: 10px; border-radius: 5px;"></div>
                              </div>
                         </div>
                         <?php if ($user_points >= $next_reward): ?>
                              <div style="margin-top:10px;">
                                   <a href="claim-reward.php" class="btn btn-success">🎁 Claim Your Reward</a>
                              </div>
                         <?php endif; ?>


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
                                                            <div class="base-menu-row">

                                                                 <!-- First column: Accessories and Women Clothing -->
                                                                 <div class="base-menu-col col-xs-12 col-sm-2">
                                                                      <?php
                                                                      // Fetch "Accessories" category name (for header) and its 4 products
                                                                      $accessories_cat_q = "
                                                                           SELECT id, name
                                                                           FROM categories
                                                                           WHERE status = 1
                                                                           AND name LIKE '%Accessories%'
                                                                           LIMIT 1
                                                                      ";
                                                                      $accessories_cat_r = mysqli_query($conn, $accessories_cat_q);
                                                                      if ($accessories_cat = mysqli_fetch_assoc($accessories_cat_r)):
                                                                      ?>
                                                                           <ul class="ul-column">
                                                                                <li class="menu-item item-header">
                                                                                     <a href="category.php?id=<?= $accessories_cat['id']; ?>" class="submenu-title">
                                                                                          <?= htmlspecialchars($accessories_cat['name']); ?>
                                                                                     </a>
                                                                                </li>
                                                                                <?php
                                                                                // Now grab up to 4 products whose category_name contains "Accessories"
                                                                                $accessories_prod_q = "
                                                                                     SELECT p.id, p.product_name, pi.image_path, pi.alt_text
                                                                                     FROM products p
                                                                                     LEFT JOIN product_images pi
                                                                                          ON pi.product_id = p.id
                                                                                     AND pi.is_primary = 1
                                                                                     WHERE p.status = 1
                                                                                          AND p.category_name LIKE '%Accessories%'
                                                                                     LIMIT 4
                                                                                ";
                                                                                $accessories_prod_r = mysqli_query($conn, $accessories_prod_q);
                                                                                while ($prod = mysqli_fetch_assoc($accessories_prod_r)):
                                                                                ?>
                                                                                     <li class="menu-item item-line">
                                                                                          <a href="shop-product.php?id=<?= $prod['id']; ?>" class="submenu-title">
                                                                                               <?= htmlspecialchars($prod['product_name']); ?>
                                                                                          </a>
                                                                                     </li>
                                                                                <?php endwhile; ?>
                                                                           </ul>
                                                                      <?php endif; ?>

                                                                      <?php
                                                                      // Fetch "Women Clothing" category name (for header) and its 4 products
                                                                      $women_cat_q = "
                                                                           SELECT id, name
                                                                           FROM categories
                                                                           WHERE status = 1
                                                                           AND name LIKE '%Women Clothing%'
                                                                           LIMIT 1
                                                                      ";
                                                                      $women_cat_r = mysqli_query($conn, $women_cat_q);
                                                                      if ($women_cat = mysqli_fetch_assoc($women_cat_r)):
                                                                      ?>
                                                                           <ul class="ul-column">
                                                                                <li class="menu-item item-header">
                                                                                     <a href="category.php?id=<?= $women_cat['id']; ?>" class="submenu-title">
                                                                                          <?= htmlspecialchars($women_cat['name']); ?>
                                                                                     </a>
                                                                                </li>
                                                                                <?php
                                                                                // Now grab up to 4 products whose category_name contains "Women Clothing"
                                                                                $women_prod_q = "
                                                                                     SELECT p.id, p.product_name, pi.image_path, pi.alt_text
                                                                                     FROM products p
                                                                                     LEFT JOIN product_images pi
                                                                                          ON pi.product_id = p.id
                                                                                     AND pi.is_primary = 1
                                                                                     WHERE p.status = 1
                                                                                          AND p.category_name LIKE '%Women Clothing%'
                                                                                     LIMIT 4
                                                                                ";
                                                                                $women_prod_r = mysqli_query($conn, $women_prod_q);
                                                                                while ($prod = mysqli_fetch_assoc($women_prod_r)):
                                                                                ?>
                                                                                     <li class="menu-item item-line">
                                                                                          <a href="shop-product.php?id=<?= $prod['id']; ?>" class="submenu-title">
                                                                                               <?= htmlspecialchars($prod['product_name']); ?>
                                                                                          </a>
                                                                                     </li>
                                                                                <?php endwhile; ?>
                                                                           </ul>
                                                                      <?php endif; ?>
                                                                 </div>

                                                                 <!-- Second column: Men Clothing -->
                                                                 <div class="base-menu-col col-xs-12 col-sm-2">
                                                                      <?php
                                                                      // Fetch "Men Clothing" category name (for header) and its 4 products
                                                                      $men_cat_q = "
                                                                           SELECT id, name
                                                                           FROM categories
                                                                           WHERE status = 1
                                                                           AND name LIKE '%Men Clothing%'
                                                                           LIMIT 1
                                                                      ";
                                                                      $men_cat_r = mysqli_query($conn, $men_cat_q);
                                                                      if ($men_cat = mysqli_fetch_assoc($men_cat_r)):
                                                                      ?>
                                                                           <ul class="ul-column">
                                                                                <li class="menu-item item-header">
                                                                                     <a href="category.php?id=<?= $men_cat['id']; ?>" class="submenu-title">
                                                                                          <?= htmlspecialchars($men_cat['name']); ?>
                                                                                     </a>
                                                                                </li>
                                                                                <?php
                                                                                // Now grab up to 4 products whose category_name contains "Men Clothing"
                                                                                $men_prod_q = "
                                                                                     SELECT p.id, p.product_name, pi.image_path, pi.alt_text
                                                                                     FROM products p
                                                                                     LEFT JOIN product_images pi
                                                                                          ON pi.product_id = p.id
                                                                                     AND pi.is_primary = 1
                                                                                     WHERE p.status = 1
                                                                                          AND p.category_name LIKE '%Men Clothing%'
                                                                                     LIMIT 4
                                                                                ";
                                                                                $men_prod_r = mysqli_query($conn, $men_prod_q);
                                                                                while ($prod = mysqli_fetch_assoc($men_prod_r)):
                                                                                ?>
                                                                                     <li class="menu-item item-line">
                                                                                          <a href="shop-product.php?id=<?= $prod['id']; ?>" class="submenu-title">
                                                                                               <?= htmlspecialchars($prod['product_name']); ?>
                                                                                          </a>
                                                                                     </li>
                                                                                <?php endwhile; ?>
                                                                           </ul>
                                                                      <?php endif; ?>
                                                                 </div>

                                                                 <!-- Third column: Random Categories with Images -->
                                                                 <div class="base-menu-col col-xs-12 col-sm-4 menu-category">
                                                                      <?php
                                                                      // Get 8 random active categories
                                                                      $rand_cat_q = "
                                                                      SELECT id, name, image
                                                                      FROM categories
                                                                      WHERE status = 1
                                                                      ORDER BY RAND()
                                                                      LIMIT 8
                                                                 ";
                                                                      $rand_cat_r = mysqli_query($conn, $rand_cat_q);
                                                                      ?>
                                                                      <ul class="ul-column">
                                                                           <?php while ($cat = mysqli_fetch_assoc($rand_cat_r)): ?>
                                                                                <li class="menu-item item-line">
                                                                                     <div class="html-block">
                                                                                          <div class="categorylist">
                                                                                               <div class="cate-image">
                                                                                                    <a href="category.php?id=<?= $cat['id']; ?>">
                                                                                                         <img
                                                                                                              src="uploads/categories/<?= htmlspecialchars($cat['image']); ?>"
                                                                                                              alt="<?= htmlspecialchars($cat['name']); ?>" />
                                                                                                    </a>
                                                                                                    <div class="cate-heading">
                                                                                                         <a href="category.php?id=<?= $cat['id']; ?>">
                                                                                                              <?= htmlspecialchars($cat['name']); ?>
                                                                                                         </a>
                                                                                                    </div>
                                                                                               </div>
                                                                                          </div>
                                                                                     </div>
                                                                                </li>
                                                                           <?php endwhile; ?>
                                                                      </ul>
                                                                 </div>

                                                                 <!-- Fourth column: Random Products Carousel -->
                                                                 <div class="base-menu-col col-xs-12 col-sm-4 product-listview product-slider background-gray">
                                                                      <?php
                                                                      // Get 4 random active products with their primary image
                                                                      $rand_prod_q = "
                                                                      SELECT p.id,
                                                                           p.product_name,
                                                                           p.selling_price,
                                                                           p.original_price,
                                                                           p.discount,
                                                                           pi.image_path,
                                                                           pi.alt_text
                                                                      FROM products p
                                                                      LEFT JOIN product_images pi
                                                                      ON pi.product_id = p.id
                                                                      AND pi.is_primary = 1
                                                                      WHERE p.status = 1
                                                                      ORDER BY RAND()
                                                                      LIMIT 4
                                                                 ";
                                                                      $rand_prod_r = mysqli_query($conn, $rand_prod_q);
                                                                      ?>
                                                                      <ul class="ul-column menu-product-carousel_2 owl-carousel">
                                                                           <?php while ($product = mysqli_fetch_assoc($rand_prod_r)): ?>
                                                                                <li class="menu-item item-line product-block owl-item">
                                                                                     <article class="product_item product-miniature js-product-miniature">
                                                                                          <div class="products">
                                                                                               <div class="thumbnail-container clearfix">
                                                                                                    <div class="baseproduct-image">
                                                                                                         <a
                                                                                                              class="product_img_link product-thumbnail"
                                                                                                              href="shop-product.php?id=<?= $product['id']; ?>"
                                                                                                              title="<?= htmlspecialchars($product['product_name']); ?>">
                                                                                                              <?php if (!empty($product['image_path'])): ?>
                                                                                                                   <img
                                                                                                                        class="replace-2x img-responsive"
                                                                                                                        src="<?= htmlspecialchars($product['image_path']); ?>"
                                                                                                                        alt="<?= htmlspecialchars($product['alt_text'] ?? $product['product_name']); ?>"
                                                                                                                        title="<?= htmlspecialchars($product['product_name']); ?>"
                                                                                                                        height="236"
                                                                                                                        width="307" />
                                                                                                              <?php else: ?>
                                                                                                                   <!-- Fallback if no primary image is found -->
                                                                                                                   <img
                                                                                                                        class="replace-2x img-responsive"
                                                                                                                        src="path/to/default-placeholder.png"
                                                                                                                        alt="No image available"
                                                                                                                        title="<?= htmlspecialchars($product['product_name']); ?>"
                                                                                                                        height="236"
                                                                                                                        width="307" />
                                                                                                              <?php endif; ?>

                                                                                                              <?php if ($product['discount'] > 0): ?>
                                                                                                                   <p class="discount-percentage product-flags discount-product">
                                                                                                                        <span class="product-flag flash-sale discount">
                                                                                                                             <i class="material-icons left">&#xe3e7;</i>
                                                                                                                             -<?= round($product['discount']); ?>%
                                                                                                                        </span>
                                                                                                                   </p>
                                                                                                              <?php endif; ?>
                                                                                                         </a>
                                                                                                    </div>
                                                                                                    <div class="baseproduct-desc">
                                                                                                         <div class="product-description">
                                                                                                              <h3 class="product-title">
                                                                                                                   <a
                                                                                                                        class="product-name"
                                                                                                                        href="shop-product.php?id=<?= $product['id']; ?>"
                                                                                                                        title="<?= htmlspecialchars($product['product_name']); ?>">
                                                                                                                        <?= htmlspecialchars($product['product_name']); ?>
                                                                                                                   </a>
                                                                                                              </h3>
                                                                                                              <div class="content_price product-price-and-shipping">
                                                                                                                   <span class="price special-price">
                                                                                                                        KES <?= number_format($product['selling_price'], 2); ?>
                                                                                                                   </span>
                                                                                                                   <?php if ($product['original_price'] > $product['selling_price']): ?>
                                                                                                                        <span class="old-price regular-price">
                                                                                                                             KES <?= number_format($product['original_price'], 2); ?>
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

                                                                 <div class="base-menu-col col-xs-12 col-sm-10">
                                                                      <ul class="ul-column menu-product-carousel_3 owl-carousel">
                                                                           <?php
                                                                           $products_query = "
                                                                           SELECT 
                                                                                p.id,
                                                                                p.product_name,
                                                                                p.selling_price,
                                                                                p.original_price,
                                                                                p.discount,
                                                                                pi.image_path,
                                                                                pi.alt_text
                                                                           FROM products p
                                                                           LEFT JOIN product_images pi
                                                                                ON pi.product_id = p.id
                                                                                AND pi.is_primary = 1
                                                                           WHERE p.status = 1
                                                                           ORDER BY RAND()
                                                                           LIMIT 15
                                                                           ";
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
                                                                                                                   <?php if (!empty($product['image_path'])): ?>
                                                                                                                        <img class="replace-2x img-responsive"
                                                                                                                             src="<?= htmlspecialchars($product['image_path']) ?>"
                                                                                                                             alt="<?= htmlspecialchars($product['alt_text'] ?? $product['product_name']) ?>"
                                                                                                                             title="<?= htmlspecialchars($product['product_name']) ?>"
                                                                                                                             height="236" width="307" />
                                                                                                                   <?php else: ?>
                                                                                                                        <!-- Fallback if no primary image is found -->
                                                                                                                        <img class="replace-2x img-responsive"
                                                                                                                             src="path/to/default-placeholder.png"
                                                                                                                             alt="No image available"
                                                                                                                             title="<?= htmlspecialchars($product['product_name']) ?>"
                                                                                                                             height="236" width="307" />
                                                                                                                   <?php endif; ?>

                                                                                                                   <?php if ($product['discount'] > 0): ?>
                                                                                                                        <p class="discount-percentage product-flags discount-product">
                                                                                                                             <span class="product-flag flash-sale discount">
                                                                                                                                  <i class="material-icons left">&#xe3e7;</i>
                                                                                                                                  -<?= round($product['discount']) ?>%
                                                                                                                             </span>
                                                                                                                        </p>
                                                                                                                   <?php endif; ?>
                                                                                                              </a>
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




                                                  <!-- ─── USER ACCOUNT (LOGIN / PROFILE) ─── -->
                                                  <li class="hide level-1" style="margin-left: 160px;" class="level-1 user-account">
                                                       <div class="user-info js-dropdown">
                                                            <?php if (isset($_SESSION['auth_user'])): ?>
                                                                 <?php
                                                                 // Get user details from the session
                                                                 $user_id = $_SESSION['auth_user']['id'];
                                                                 $query = "SELECT `first_name`,`last_name`,`profile_picture` FROM `users` WHERE `id`='$user_id'";
                                                                 $result = mysqli_query($conn, $query);
                                                                 $user_data = mysqli_fetch_assoc($result);

                                                                 $profile_picture = $user_data['profile_picture'] ?? 'default.png';
                                                                 $full_name = $user_data['first_name'] . ' ' . $user_data['last_name'];
                                                                 ?>
                                                                 <a class="user-icon" href="javascript:void(0)"
                                                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                      <img
                                                                           style="width:40px; height:40px; border-radius:50%; object-fit:cover;"
                                                                           src="uploads/profile/<?php echo htmlspecialchars($profile_picture); ?>"
                                                                           alt="Profile Picture"
                                                                           class="profile-pic">
                                                                      <span class="user-name" style="color: white;"><?php echo htmlspecialchars($full_name); ?></span>
                                                                 </a>
                                                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">
                                                                      <a class="dropdown-item" href="profile.php">My Profile</a>
                                                                      <a class="dropdown-item" href="orders.php">My Orders</a>
                                                                      <a class="dropdown-item" href="functions/logout.php">Logout</a>
                                                                 </div>
                                                            <?php else: ?>
                                                                 <a class="user-icon" href="javascript:void(0)"
                                                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                      <i class="fas fa-user-circle" style="font-size:20px; color:#fff;"></i>
                                                                      <span class="user-name" style="color: white;">Login/Register</span>
                                                                 </a>
                                                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">
                                                                      <a class="dropdown-item" href="login.php">Login</a>
                                                                      <a class="dropdown-item" href="register.php">Register</a>
                                                                 </div>
                                                            <?php endif; ?>
                                                       </div>
                                                  </li>

                                                  <!-- ─── WISHLIST ITEM ─── -->
                                                  <li class="hide level-1" class="level-1">
                                                       <a class="ap-btn-wishlist baseinnermenu" href="wishlist" title="Wishlist" rel="nofollow" style="position: relative; display: inline-block;">
                                                            <i class="material-icons">favorite_border</i>
                                                            <!-- Wishlist count badge -->
                                                            <span class="wishlist_count_bubble"><?php echo $fav_count; ?></span>
                                                            <span class="catagory">Wishlist</span>
                                                       </a>
                                                  </li>
                                                  <!-- ─── CART DROPDOWN ─── -->
                                                  <li class="hide level-1">
                                                       <div id="desktop_cart">
                                                            <div class="blockcart" data-refresh-url="ajax/cart_summary.php">
                                                                 <div class="header blockcart-header">
                                                                      <div class="shopping-cart" rel="nofollow" id="cart-dropdown-toggle" style="cursor:pointer;">
                                                                           <span class="icon"></span>
                                                                           <span class="mobile_count" id="cart-item-count-mobile"><?php echo $total_items; ?></span>
                                                                           <span class="cart-products-count hidden-sm-down">
                                                                                Items
                                                                                <span class="value" id="cart-total-price-mobile">Kes <?php echo number_format($total_price, 2); ?></span>
                                                                           </span>
                                                                      </div>

                                                                      <div class="cart_block block exclusive" id="cart-dropdown-content" style="display:none;">
                                                                           <div class="top-block-cart">
                                                                                <div class="toggle-title">
                                                                                     Shopping Cart (<span id="cart-item-count-mobile-title"><?php echo $total_items; ?></span>)
                                                                                </div>
                                                                                <span aria-hidden="true" class="close-icon" id="cart-dropdown-close">
                                                                                     <i class="material-icons">close</i>
                                                                                </span>
                                                                           </div>

                                                                           <div class="block_content">
                                                                                <div class="cart_block_list" id="cart-items-list-mobile">
                                                                                     <?php if (!empty($cart_items)): ?>
                                                                                          <?php foreach ($cart_items as $item): ?>
                                                                                               <div class="cart-item" data-cart-id="<?php echo $item['id']; ?>">
                                                                                                    <div class="cart-image">
                                                                                                         <a href="shop-product.php?id=<?php echo $item['product_id']; ?>">
                                                                                                              <img
                                                                                                                   src="<?php echo $item['image_path'] ?: 'uploads/shop/default.png'; ?>"
                                                                                                                   alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                                                                                                   width="90" height="90"
                                                                                                                   style="object-fit:contain;">
                                                                                                         </a>
                                                                                                    </div>
                                                                                                    <div class="cart-info">
                                                                                                         <span class="product-name">
                                                                                                              <a href="shop-product.php?id=<?php echo $item['product_id']; ?>">
                                                                                                                   <?php
                                                                                                                   $name = $item['product_name'];
                                                                                                                   echo htmlspecialchars(
                                                                                                                        mb_strlen($name) > 30
                                                                                                                             ? mb_substr($name, 0, 30) . '…'
                                                                                                                             : $name
                                                                                                                   );
                                                                                                                   ?>
                                                                                                              </a>
                                                                                                         </span>
                                                                                                         <div>
                                                                                                              <span class="product-quantity"><?php echo $item['quantity']; ?> x</span>
                                                                                                              <span class="product-price">
                                                                                                                   Kes <?php echo number_format($item['selling_price'], 2); ?>
                                                                                                              </span>
                                                                                                         </div>
                                                                                                         <a
                                                                                                              class="remove-from-cart"
                                                                                                              href="#"
                                                                                                              data-cart-id="<?php echo $item['id']; ?>"
                                                                                                              title="Remove from cart">
                                                                                                              <i class="material-icons pull-xs-left">delete</i>
                                                                                                         </a>
                                                                                                    </div>
                                                                                               </div>
                                                                                          <?php endforeach; ?>
                                                                                     <?php else: ?>
                                                                                          <div class="no-more-item">
                                                                                               <div class="no-img"></div>
                                                                                               <div class="empty-text">Your cart is empty.</div>
                                                                                               <a rel="nofollow" href="shop.php" class="continue"><button type="button" class="btn btn-primary">Continue shopping</button></a>
                                                                                          </div>
                                                                                     <?php endif; ?>
                                                                                </div>
                                                                           </div>

                                                                           <div class="card cart-summary">
                                                                                <div class="card-block">
                                                                                     <div class="cart-summary-line" id="cart-subtotal-products">

                                                                                          <span class="mobile_count" id="cart-item-count-mobile"><?php echo $total_items; ?></span>
                                                                                          <span class="cart-products-count hidden-sm-down">
                                                                                               Items
                                                                                               <span class="value" id="cart-total-price-mobile">Kes <?php echo number_format($total_price, 2); ?></span>
                                                                                          </span>
                                                                                     </div>
                                                                                     <div class="cart-summary-line" id="cart-subtotal-shipping">
                                                                                          <span class="label">Shipping</span>
                                                                                          <span class="value" id="cart-subtotal-shipping-value">
                                                                                               Kes <?php echo number_format($shipping_cost, 2); ?>
                                                                                          </span>
                                                                                     </div>
                                                                                </div>
                                                                                <div class="card-block">
                                                                                     <div class="cart-summary-line cart-total">
                                                                                          <span class="label">Total&nbsp;(tax incl.)</span>
                                                                                          <span class="value" id="cart-total-value">
                                                                                               Kes <?php echo number_format($total_price, 2); ?>
                                                                                          </span>
                                                                                     </div>
                                                                                </div>
                                                                           </div>

                                                                           <div class="checkout card-block">
                                                                                <a rel="nofollow" href="cart.php" class="viewcart">
                                                                                     <button type="button" class="btn btn-primary">View Cart</button>
                                                                                </a>
                                                                                <a rel="nofollow" href="shop-cart.php" class="checkout">
                                                                                     <button type="button" class="btn btn-primary checkout_button">CheckOut</button>
                                                                                </a>
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                       <script>
                                                            // Toggle cart dropdown
                                                            $(document).on('click', '#cart-dropdown-toggle', function(e) {
                                                                 e.stopPropagation();
                                                                 $('#cart-dropdown-content').toggle();
                                                            });

                                                            // Close dropdown
                                                            $(document).on('click', '#cart-dropdown-close', function() {
                                                                 $('#cart-dropdown-content').hide();
                                                            });

                                                            // Hide when clicking outside
                                                            $(document).on('click', function(e) {
                                                                 if (!$(e.target).closest('#desktop_cart').length) {
                                                                      $('#cart-dropdown-content').hide();
                                                                 }
                                                            });

                                                            // Function to recount visible cart items
                                                            function recountCartItems() {
                                                                 return $('.cart-item:visible').length;
                                                            }

                                                            // Function to update cart totals
                                                            function updateCartTotals(data) {
                                                                 // Ensure we're working with numbers
                                                                 var totalItems = parseInt(data.total_items) || 0;
                                                                 var totalPrice = parseFloat(data.total_price) || 0;
                                                                 var shippingCost = parseFloat(data.shipping_cost) || 0;

                                                                 // Double check the count against visible items
                                                                 var visibleItems = recountCartItems();
                                                                 if (visibleItems !== totalItems) {
                                                                      totalItems = visibleItems;
                                                                 }

                                                                 // Update all cart count elements
                                                                 $('.mobile_count, #cart-item-count-mobile, #cart-item-count-mobile-title').text(totalItems);

                                                                 // Update all price elements
                                                                 $('.cart-products-count .value, #cart-total-price-mobile, #cart-total-value').text('Kes ' + totalPrice.toFixed(2));

                                                                 // Update subtotal and shipping
                                                                 $('#cart-subtotal-products-value').text('Kes ' + (totalPrice - shippingCost).toFixed(2));
                                                                 $('#cart-subtotal-shipping-value').text('Kes ' + shippingCost.toFixed(2));

                                                                 // Update the subtotal items text with proper pluralization
                                                                 var itemText = totalItems + ' item' + (totalItems !== 1 ? 's' : '');
                                                                 $('#cart-subtotal-products .js-subtotal').text(itemText);

                                                                 // Update cart items list if empty
                                                                 if (totalItems === 0) {
                                                                      $('#cart-items-list-mobile').html('<div style="padding:20px; text-align:center; color:#888;">Your cart is empty.</div>');
                                                                 }
                                                            }

                                                            // Function to update cart count in real-time
                                                            function updateCartCount() {
                                                                 $.ajax({
                                                                      url: 'ajax/cart_update.php',
                                                                      method: 'GET',
                                                                      dataType: 'json',
                                                                      success: function(response) {
                                                                           if (response.status === 'success') {
                                                                                // Update all cart count elements
                                                                                $('.mobile_count, #cart-item-count-mobile, #cart-item-count-mobile-title').text(response.total_items);

                                                                                // Update cart total
                                                                                $('.cart-products-count .value, #cart-total-price-mobile').text('Kes ' + response.total_price);

                                                                                // Update cart items list in both mobile and desktop views
                                                                                $('#cart-items-list-mobile, .cart-items-list').html(response.cart_html);

                                                                                // Update cart summary
                                                                                $('#cart-subtotal-products-value').text('Kes ' + (response.total_price - response.shipping_cost).toFixed(2));
                                                                                $('#cart-subtotal-shipping-value').text('Kes ' + response.shipping_cost.toFixed(2));

                                                                                // Update cart button state and UI elements
                                                                                if (response.total_items > 0) {
                                                                                     $('.shopping-cart').removeClass('empty');
                                                                                     $('.cart-summary').show();
                                                                                     $('.checkout').show();
                                                                                } else {
                                                                                     $('.shopping-cart').addClass('empty');
                                                                                     $('.cart-summary').hide();
                                                                                     $('.checkout').hide();
                                                                                }

                                                                                // Trigger a custom event after cart update
                                                                                $(document).trigger('cartContentUpdated');
                                                                           }
                                                                      }
                                                                 });
                                                            }

                                                            // Use event delegation for remove from cart functionality
                                                            $(document).on('click', '.remove-from-cart', function(e) {
                                                                 e.preventDefault();
                                                                 e.stopPropagation();

                                                                 var cartId = $(this).data('cart-id');
                                                                 var $itemRow = $(this).closest('.cart-item');

                                                                 // Show loading state
                                                                 $itemRow.css('opacity', '0.5');

                                                                 $.ajax({
                                                                      url: 'ajax/remove_cart_item.php',
                                                                      type: 'POST',
                                                                      data: {
                                                                           cart_id: cartId
                                                                      },
                                                                      dataType: 'json',
                                                                      success: function(resp) {
                                                                           if (resp.success) {
                                                                                // Remove the item with animation
                                                                                $itemRow.fadeOut(300, function() {
                                                                                     $(this).remove();

                                                                                     // Update cart counts and totals
                                                                                     $('.mobile_count, #cart-item-count-mobile, #cart-item-count-mobile-title').text(resp.total_items);
                                                                                     $('.cart-products-count .value, #cart-total-price-mobile, #cart-total-value').text('Kes ' + resp.total_price);

                                                                                     // Update subtotal items text
                                                                                     var itemText = resp.total_items + ' item' + (resp.total_items !== 1 ? 's' : '');
                                                                                     $('#cart-subtotal-products .js-subtotal').text(itemText);

                                                                                     // If cart is empty, show empty message and update UI
                                                                                     if (resp.total_items === 0) {
                                                                                          // Clear the cart items list
                                                                                          $('#cart-items-list-mobile').html('<div style="padding:20px; text-align:center; color:#888;">Your cart is empty.</div>');

                                                                                          // Update cart summary
                                                                                          $('.cart-summary').hide();
                                                                                          $('.checkout').hide();

                                                                                          // Update cart button state
                                                                                          $('.shopping-cart').addClass('empty');

                                                                                          // Hide the cart dropdown after a short delay
                                                                                          setTimeout(function() {
                                                                                               $('#cart-dropdown-content').hide();
                                                                                          }, 1000);
                                                                                     }

                                                                                     // Show success message with SweetAlert2 toast
                                                                                     Swal.fire({
                                                                                          position: 'top-end',
                                                                                          icon: 'success',
                                                                                          title: 'Item removed from cart',
                                                                                          toast: true,
                                                                                          showConfirmButton: false,
                                                                                          timer: 2000,
                                                                                          width: 'auto',
                                                                                          padding: '0.1em',
                                                                                          background: 'white',
                                                                                          customClass: {
                                                                                               container: 'my-swal-container'
                                                                                          }
                                                                                     });

                                                                                     // Trigger cart update after removal
                                                                                     updateCartCount();
                                                                                });
                                                                           } else {
                                                                                // Show error message with SweetAlert2 toast
                                                                                Swal.fire({
                                                                                     position: 'top-end',
                                                                                     icon: 'error',
                                                                                     title: resp.message || 'Failed to remove item',
                                                                                     toast: true,
                                                                                     showConfirmButton: false,
                                                                                     timer: 2000,
                                                                                     width: 'auto',
                                                                                     padding: '0.1em',
                                                                                     background: 'white',
                                                                                     customClass: {
                                                                                          container: 'my-swal-container'
                                                                                     }
                                                                                });
                                                                                $itemRow.css('opacity', '1');
                                                                           }
                                                                      },
                                                                      error: function() {
                                                                           // Show error message with SweetAlert2 toast
                                                                           Swal.fire({
                                                                                position: 'top-end',
                                                                                icon: 'error',
                                                                                title: 'Error removing item',
                                                                                toast: true,
                                                                                showConfirmButton: false,
                                                                                timer: 2000,
                                                                                width: 'auto',
                                                                                padding: '0.1em',
                                                                                background: 'white',
                                                                                customClass: {
                                                                                     container: 'my-swal-container'
                                                                                }
                                                                           });
                                                                           $itemRow.css('opacity', '1');
                                                                      }
                                                                 });
                                                            });

                                                            // Handle cart button clicks
                                                            $(document).on('click', '.cart-btn', function() {
                                                                 setTimeout(function() {
                                                                      updateCartCount();
                                                                 }, 500);
                                                            });

                                                            // Handle cart content updates
                                                            $(document).on('cartContentUpdated', function() {
                                                                 // Any additional UI updates after cart content changes
                                                                 console.log('Cart content updated');
                                                            });

                                                            // Initialize cart on page load
                                                            $(document).ready(function() {
                                                                 updateCartCount();
                                                            });
                                                       </script>
                                                  </li>



                                                  <style>
                                                       @media (max-width: 768px) {
                                                            .hide {
                                                                 display: none !important;
                                                            }
                                                       }
                                                  </style>
                                                  <li class="level-1 ">

                                                       <a href="shop.php" class="baseinnermenu">
                                                            <span class="catagory">Shop</span></i>
                                                       </a>
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