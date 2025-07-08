<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle cart clearing BEFORE any output
include_once 'admin/config/dbcon.php';
include_once 'init.php';
$session_id = session_id();
$user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

// Check for user's previous location if logged in
$previous_location = null;
if ($user_id) {
    $location_query = "SELECT precise_location_name, user_lat, user_lng, destination, state, postcode, location_method 
                       FROM checkout 
                       WHERE user_id = ? AND precise_location_name IS NOT NULL AND precise_location_name != '' 
                       ORDER BY created_at DESC 
                       LIMIT 1";
    
    $stmt = mysqli_prepare($conn, $location_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $previous_location = mysqli_fetch_assoc($result);
        }
    }
}

if (isset($_POST['clear_cart']) && $_POST['clear_cart'] === 'clear_cart') {
     // Clear the cart
     $clear_query = "DELETE FROM cart WHERE cart_status = 'unprocessed' AND (session_id = '$session_id'" . ($user_id ? " OR user_id = '$user_id'" : "") . ")";
     mysqli_query($conn, $clear_query);

     // Clear all session variables
     unset($_SESSION['promo_code']);
     unset($_SESSION['discount_amount']);
     unset($_SESSION['discount_code']);
     unset($_SESSION['cart_total']);
     unset($_SESSION['cart_items']);

     // Reset session variables
     $_SESSION['cart_total'] = 0;
     $_SESSION['cart_items'] = 0;
     $_SESSION['discount_amount'] = 0;

     // Redirect to refresh the page
     header('Location: ' . $_SERVER['PHP_SELF']);
     exit;
}

include 'includes/header.php';
?>

<aside id="notifications">
     <div class="container">
          <?php
          if (isset($_SESSION['message'])) {
               echo '<div class="alert alert-' . $_SESSION['message_type'] . ' alert-dismissible fade show" role="alert">
                    ' . $_SESSION['message'] . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
               </div>';
               unset($_SESSION['message']);
               unset($_SESSION['message_type']);
          }
          ?>
     </div>
</aside>



<nav style="margin-bottom: 20px;" data-depth="3" class="breadcrumb">
     <div class="container">
          <ol>


               <li>
                    <a href="index.php"><span>Home</span></a>
               </li>



          </ol>
     </div>
</nav>
<style>
     .breadcrumb {
          text-align: left;
     }

     .breadcrumb .container {
          display: flex;
          justify-content: flex-start;
     }

     .breadcrumb ol {
          display: flex;
          gap: 5px;
          padding: 0;
          margin: 0;
          list-style: none;
     }

     .breadcrumb ol {
          justify-content: flex-end;
          width: 80%;
     }

     .shipping-options {
          margin-top: 15px;
          padding: 15px;
          border: 1px solid #ddd;
          border-radius: 4px;
     }

     .shipping-option {
          margin-bottom: 10px;
          padding: 10px;
          border: 1px solid #eee;
          border-radius: 4px;
          cursor: pointer;
     }

     .shipping-option:hover {
          background-color: #f8f9fa;
     }

     .shipping-option.selected {
          background-color: #e9ecef;
          border-color: #0d6efd;
     }

     .shipping-option input[type="radio"] {
          margin-right: 10px;
     }

     .qty-btn {
          width: 32px;
          height: 32px;
          font-size: 18px;
          border: 1px solid #ccc;
          background-color: #f0f0f0;
          border-radius: 4px;
          cursor: pointer;
          transition: background 0.2s;
          display: flex;
          align-items: center;
          justify-content: center;
     }

     .qty-btn:hover {
          background-color: #e0e0e0;
     }

     .qty-selector {
          display: flex;
          align-items: center;
          gap: 0.5rem;
     }

     .js-cart-line-product-quantity {
          width: 60px;
          text-align: center;
          border: 1px solid #ccc;
          border-radius: 4px;
          padding: 4px;
     }

     /* Shipping Calculator Styles */
     .shipping_calculator {
          background: #f8f9fa;
          padding: 20px;
          border-radius: 8px;
          margin-top: 20px;
     }

     .shipping_calculator .form-group {
          margin-bottom: 15px;
     }

     .shipping_calculator label {
          font-weight: 600;
          color: #333;
          margin-bottom: 5px;
     }

     .shipping_calculator .form-control {
          border: 1px solid #ddd;
          border-radius: 4px;
          padding: 8px 12px;
     }

     .shipping_calculator .btn {
          margin-right: 10px;
          margin-bottom: 10px;
     }

     .shipping_calculator .btn-info {
          background-color: #17a2b8;
          border-color: #17a2b8;
     }

     .shipping_calculator .btn-primary {
          background-color: #007bff;
          border-color: #007bff;
     }

     .shipping_calculator .btn:disabled {
          opacity: 0.6;
          cursor: not-allowed;
     }

     #shipping-status {
          color: #6c757d;
          font-style: italic;
     }

     #proceedToCheckout:disabled {
          opacity: 0.6;
          cursor: not-allowed;
     }

     /* Manual coordinates input styling */
     .form-text {
          font-size: 0.875rem;
          color: #6c757d;
          margin-top: 0.25rem;
     }

     #manual_lat, #manual_lng {
          font-family: 'Courier New', monospace;
          font-size: 0.9rem;
     }

     .btn-sm {
          padding: 0.25rem 0.5rem;
          font-size: 0.875rem;
          border-radius: 0.2rem;
     }

     .ml-2 {
          margin-left: 0.5rem;
     }

     /* Shipping calculator improvements */
     .shipping_calculator .form-row {
          margin-bottom: 1rem;
     }

     .shipping_calculator .form-group {
          margin-bottom: 1rem;
     }

     .shipping_calculator .btn {
          margin-bottom: 0.5rem;
     }

     /* Location search styling */
     .search-result-item {
          transition: all 0.2s ease;
     }

     .search-result-item:hover {
          background-color: #e9ecef !important;
          transform: translateX(2px);
     }

     .search-result-item:last-child {
          border-bottom: none !important;
     }

     .cursor-pointer {
          cursor: pointer;
     }

     #search_results {
          border: 1px solid #dee2e6;
          border-radius: 0.375rem;
          background-color: #fff;
     }

     #results_list {
          background-color: #f8f9fa;
          border: none !important;
     }

     .input-group-append .btn {
          border-left: 0;
     }

     /* Alert styling improvements */
     .alert-info {
          background-color: #d1ecf1;
          border-color: #bee5eb;
          color: #0c5460;
     }

     .alert-heading {
          color: #0c5460;
          font-weight: 600;
     }
</style>

<section id="wrapper">


     <div class="container">
          <div id="columns_inner">




               <div id="content-wrapper" class="js-content-wrapper">



                    <section id="main">
                         <div class="cart-grid row">

                              <!-- Left Block: cart product informations & shpping -->
                              <div class="cart-grid-body col-lg-8">

                                   <!-- cart products detailed -->
                                   <div class="card cart-container">
                                        <div class="card-block">
                                             <h1 class="h1">Shopping Cart</h1>
                                        </div>
                                        <hr class="separator">
                                        <?php
                                        $session_id = session_id();
                                        $user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

                                        // Handle cart clearing
                                        if (isset($_POST['clear_cart']) && $_POST['clear_cart'] === 'clear_cart') {
                                             // Clear the cart
                                             $clear_query = "DELETE FROM cart WHERE cart_status = 'unprocessed' AND (session_id = '$session_id'" . ($user_id ? " OR user_id = '$user_id'" : "") . ")";
                                             mysqli_query($conn, $clear_query);

                                             // Clear all session variables
                                             unset($_SESSION['promo_code']);
                                             unset($_SESSION['discount_amount']);
                                             unset($_SESSION['discount_code']);
                                             unset($_SESSION['cart_total']);
                                             unset($_SESSION['cart_items']);

                                             // Reset session variables
                                             $_SESSION['cart_total'] = 0;
                                             $_SESSION['cart_items'] = 0;
                                             $_SESSION['discount_amount'] = 0;

                                             // Redirect to refresh the page
                                             header('Location: ' . $_SERVER['PHP_SELF']);
                                             exit;
                                        }

                                        // Initialize totals
                                        $total_items = 0;
                                        $total_price = 0;
                                        $cart_items = [];

                                        // Fetch cart items
                                        $cart_query = "SELECT c.*, p.product_name, p.description, p.original_price,
                                                     COALESCE(pi.image_path, CONCAT('uploads/shop/', p.image)) as image_path,
                                                     p.selling_price, p.quantity as available_stock, 
                                                     CASE 
                                                         WHEN LOWER(p.sale_out_limit) = 'no limit' THEN 'no limit'
                                                         WHEN LOWER(p.sale_out_limit) = 'no_limit' THEN 'no limit'
                                                         WHEN LOWER(p.sale_out_limit) = 'nolimit' THEN 'no limit'
                                                         WHEN p.sale_out_limit IS NULL THEN 'no limit'
                                                         WHEN p.sale_out_limit = '' THEN 'no limit'
                                                         ELSE p.sale_out_limit 
                                                     END as sale_out_limit 
                                                     FROM cart c 
                                                     JOIN products p ON c.product_id = p.id 
                                                     LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                                                     WHERE c.cart_status = 'unprocessed' 
                                                     AND (c.session_id = '$session_id'" . ($user_id ? " OR c.user_id = '$user_id'" : "") . ")";

                                        $cart_result = mysqli_query($conn, $cart_query);

                                        if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                                             while ($row = mysqli_fetch_assoc($cart_result)) {
                                                  $cart_items[] = $row;
                                                  $total_items += $row['quantity'];
                                                  $total_price += ($row['selling_price'] * $row['quantity']);
                                             }
                                        }

                                        // Clear promo code if cart is empty
                                        if (empty($cart_items)) {
                                             unset($_SESSION['promo_code']);
                                        }

                                        // Calculate final total with discount if applicable
                                        $discount_amount = isset($_SESSION['promo_code']['discount_amount']) ? $_SESSION['promo_code']['discount_amount'] : 0;
                                        $final_total = $total_price - $discount_amount;

                                        if (!empty($cart_items)) :
                                        ?>

                                             <div class="cart-overview js-cart">
                                                  <?php if (!empty($cart_items)): ?>
                                                       <button type="button" class="btn btn-danger clear-cart" id="clear-cart-btn">
                                                            <i class="material-icons">delete_sweep</i> Remove All Items
                                                       </button>
                                                  <?php endif; ?>
                                                  <ul class="cart-items">
                                                       <?php foreach ($cart_items as $item): ?>
                                                            <li class="cart-item" data-unit-price="<?php echo $item['selling_price']; ?>">

                                                                 <div class="product-line-grid">
                                                                      <!--  product line left content: image-->
                                                                      <div class="product-line-grid-left col-md-3 col-xs-4">
                                                                           <span class="product-image media-middle">
                                                                                <?php
                                                                                // Build the image path
                                                                                $imagePath = $item['image_path'];

                                                                                // Generate accessible alt text for the product image
                                                                                $altText = $item['product_name'];
                                                                                if (!empty($item['description'])) {
                                                                                     // Optionally add more detail if available
                                                                                     $altText .= ' - ' . strip_tags($item['description']);
                                                                                }
                                                                                ?>
                                                                                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($altText); ?>" loading="lazy">
                                                                           </span>
                                                                      </div>

                                                                      <!--  product line body: label, discounts, price, attributes, customizations -->
                                                                      <div class="product-line-grid-body col-md-4 col-xs-8">
                                                                           <div class="product-line-info">
                                                                                <a class="label" href="shop-product.php?id=<?php echo $item['product_id']; ?>"><?php echo htmlspecialchars($item['product_name']); ?></a>
                                                                           </div>

                                                                           <div class="product-line-info product-price h5 ">
                                                                                <div class="current-price">
                                                                                     <?php if ($item['original_price'] > $item['selling_price']): ?>
                                                                                          <span class="regular-price text-muted text-decoration-line-through">Kes <?php echo number_format($item['original_price'], 2); ?></span>
                                                                                     <?php endif; ?>
                                                                                     <span class="price">Kes <?php echo number_format($item['selling_price'], 2); ?></span>
                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <!--  product line right content: actions (quantity, delete), price -->
                                                                      <div class="product-line-grid-right product-line-actions col-md-5 col-xs-12">
                                                                           <div class="row">
                                                                                <div class="col-xs-4 hidden-md-up"></div>
                                                                                <div class="col-md-10 col-xs-6">
                                                                                     <div class="row">
                                                                                          <div class="col-md-6 col-xs-6 qty">
                                                                                               <div class="qty-selector" style="display: flex; align-items: center; gap: 0.5rem;">
                                                                                                    <button type="button" class="qty-btn" onclick="changeQty(<?php echo $item['product_id']; ?>, -1)">–</button>
                                                                                                    <input
                                                                                                         class="js-cart-line-product-quantity"
                                                                                                         type="number"
                                                                                                         value="<?php echo $item['quantity']; ?>"
                                                                                                         min="1"
                                                                                                         max="<?php echo $item['sale_out_limit'] === 'no_limit' ? $item['available_stock'] : min($item['available_stock'], $item['sale_out_limit']); ?>"
                                                                                                         data-product-id="<?php echo $item['product_id']; ?>"
                                                                                                         data-unit-price="<?php echo $item['selling_price']; ?>"
                                                                                                         data-max-stock="<?php echo $item['available_stock']; ?>"
                                                                                                         data-max-limit="<?php echo $item['sale_out_limit']; ?>" />
                                                                                                    <button type="button"
                                                                                                         class="qty-btn increase-btn"
                                                                                                         onclick="changeQty(<?php echo $item['product_id']; ?>, +1)"
                                                                                                         data-product-id="<?php echo $item['product_id']; ?>"
                                                                                                         title="Increase quantity">+</button>
                                                                                               </div>
                                                                                          </div>
                                                                                          <div class="col-md-6 col-xs-2 price">
                                                                                               <span class="product-price">
                                                                                                    <strong>
                                                                                                         Kes <?php echo number_format($item['selling_price'] * $item['quantity'], 2); ?>
                                                                                                    </strong>
                                                                                               </span>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                                <div class="col-md-2 col-xs-2 text-xs-right">
                                                                                     <div class="cart-line-product-actions">
                                                                                          <a
                                                                                               class="remove-from-cart"
                                                                                               rel="nofollow"
                                                                                               href="#"
                                                                                               data-cart-id="<?php echo $item['id']; ?>"
                                                                                               title="Remove from cart">
                                                                                               <i class="material-icons float-xs-left">delete</i>
                                                                                          </a>
                                                                                     </div>
                                                                                </div>
                                                                           </div>
                                                                      </div>

                                                                      <div class="clearfix"></div>
                                                                 </div>

                                                            </li>
                                                       <?php endforeach; ?>
                                                  </ul>
                                             </div>
                                        <?php else: ?>
                                             <div class="alert alert-info">
                                                  Your cart is empty. <a href="shop.php">Continue shopping</a>
                                             </div>
                                        <?php endif; ?>


                                   </div>


                                   <a class="label" href="shop.php" title="Continue shopping">
                                        <i class="material-icons">chevron_left</i>Continue shopping
                                   </a>

                                   <!-- Shipping Calculator Section -->
                                   <?php if (!empty($cart_items)): ?>
                                   <div class="card mt-4">
                                        <div class="card-block">
                                             <h4 class="h4">Calculate Shipping</h4>
                                             <p class="mt-2 mb-3">
                                                  Flat rate: <span class="font-xl text-brand fw-900">5%</span> (base product cost)
                                             </p>
                                             
                                             <?php if ($previous_location): ?>
                                             <div class="alert alert-success mb-3" id="previous_location_alert">
                                                  <h6 class="alert-heading">✅ Previous Location Auto-Loaded!</h6>
                                                  <p class="mb-2">We've automatically loaded your previous delivery location: <strong><?php echo htmlspecialchars($previous_location['precise_location_name']); ?></strong></p>
                                                  <button type="button" id="remove_previous_location" class="btn btn-outline-danger btn-sm">
                                                       <i class="material-icons">clear</i> Use Different Location
                                                  </button>
                                             </div>
                                             <?php endif; ?>
                                             
                                             <!-- Shipping Calculator Form -->
                                             <form class="field_form shipping_calculator" id="shipping-form">
                                                  <!-- Simple location search for non-technical users -->
                                                  <div class="form-row">
                                                       <div class="form-group col-lg-12">
                                                            <label>🔍 Find your location:</label>
                                                            <div class="input-group">
                                                                 <input id="location_search" type="text" class="form-control" placeholder="Type your area name (e.g., Konza, Wote, Nairobi, Mombasa...)" autocomplete="off">
                                                                 <div class="input-group-append">
                                                                      <button type="button" id="search_location" class="btn btn-primary" title="Search for location" style="font-size: 1.3em; padding: 0.4em 0.8em;">
                                                                           <i class="material-icons" style="vertical-align: middle;">search</i>
                                                                      </button>
                                                                 </div>
                                                            </div>
                                                            <div id="search_results" class="mt-2" style="display: none;">
                                                                 <small class="text-muted">Click on your location:</small>
                                                                 <div id="results_list" class="border rounded p-2 bg-light" style="max-height: 150px; overflow-y: auto;"></div>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  
                                                  <!-- Manual delivery location inputs -->
                                                  <div class="form-row row">
                                                       <div class="form-group col-lg-6">
                                                            <input id="state" required="required" placeholder="State / County" name="state" type="text">
                                                       </div>
                                                       <div class="form-group col-lg-6">
                                                            <input id="postcode" required="required" placeholder="PostCode / ZIP" name="postcode" type="text">
                                                       </div>
                                                  </div>
                                                  
                                                  <!-- Manual coordinates input for precise location -->
                                                  <div class="form-row row">
                                                       <div class="form-group col-lg-6">
                                                            <input id="manual_lat" placeholder="Latitude (e.g., -1.7883)" name="manual_lat" type="number" step="0.0001" min="-5" max="5">
                                                            <small class="form-text text-muted">Optional: Enter exact latitude for precise shipping</small>
                                                       </div>
                                                       <div class="form-group col-lg-6">
                                                            <input id="manual_lng" placeholder="Longitude (e.g., 37.1759)" name="manual_lng" type="number" step="0.0001" min="33" max="42">
                                                            <small class="form-text text-muted">Optional: Enter exact longitude for precise shipping</small>
                                                       </div>
                                                  </div>
                                                  
                                                  <!-- Location buttons -->
                                                  <div class="form-row">
                                                       <div class="form-group col-lg-12">
                                                            <button type="button" id="use_location" class="btn btn-info btn-sm">
                                                                 📱 Use My Current Location
                                                            </button>
                                                       </div>
                                                  </div>
                                                  
                                                  <div class="form-row">
                                                       <div class="form-group col-lg-12">
                                                            <button type="button" id="calc_shipping" class="btn btn-primary btn-sm">
                                                                 <i class="material-icons">calculate</i> Calculate Shipping
                                                            </button>
                                                       </div>
                                                  </div>
                                             </form>
                                        </div>
                                   </div>
                                   <?php endif; ?>

                              </div>

                              <!-- Right Block: cart subtotal & cart total -->
                              <div class="cart-grid-right col-lg-4">


                                   <div class="card cart-summary">


                                        <div class="cart-detailed-totals js-cart-detailed-totals">

                                             <div class="card-block cart-detailed-subtotals js-cart-detailed-subtotals">
                                                  <div class="cart-summary-line" id="cart-subtotal-products">
                                                       <span class="label js-subtotal" id="sidebar-item-count">
                                                            <?php echo $total_items; ?> item<?php echo $total_items !== 1 ? 's' : ''; ?>
                                                       </span>
                                                       <span class="value" id="cart-total-price-mobile">Kes <?php echo number_format($total_price, 2); ?></span>

                                                  </div>
                                                  <div class="cart-summary-line" id="cart-subtotal-shipping">
                                                       <span class="label">
                                                            Shipping
                                                       </span>
                                                       <span class="value" id="shipping_cost">
                                                            <span id="shipping-status">Not calculated</span>
                                                            <button type="button" id="remove-shipping" class="btn btn-sm btn-outline-danger ml-2" title="Remove shipping" style="display: none;">
                                                                 <i class="material-icons">delete</i>
                                                            </button>
                                                       </span>
                                                  </div>
                                                  <?php if ($discount_amount > 0): ?>
                                                  <div class="cart-summary-line" id="cart-subtotal-discount" style="background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; padding: 8px; margin: 5px 0;">
                                                       <span class="label" style="color: #155724; font-weight: bold;">
                                                            🎉 Promo Code Applied (<?php echo htmlspecialchars($_SESSION['promo_code']['code']); ?>)
                                                       </span>
                                                       <span class="value" id="discount-amount" style="color: #155724; font-weight: bold;">
                                                            -Kes <?php echo number_format($discount_amount, 2); ?>
                                                       </span>
                                                  </div>
                                                  
                                                  <!-- Savings Summary -->
                                                  <div class="cart-summary-line" style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 4px; padding: 8px; margin: 5px 0;">
                                                       <span class="label" style="color: #856404; font-weight: bold;">
                                                            💰 Total Savings
                                                       </span>
                                                       <span class="value" style="color: #856404; font-weight: bold;">
                                                            Kes <?php echo number_format($discount_amount, 2); ?>
                                                       </span>
                                                  </div>
                                                  <?php endif; ?>
                                             </div>


                                             <div class="card-block cart-summary-totals js-cart-summary-totals">


                                                  <div class="cart-summary-line cart-total">
                                                       <span class="label">Total</span>
                                                       <span class="value" id="cart-total-price">Kes <?php echo number_format($final_total, 2); ?></span>

                                                  </div>


                                             </div>




                                             <div class="block-promo">
                                                  <div class="cart-voucher js-cart-voucher">
                                                       <?php if (isset($_SESSION['promo_code'])): ?>
                                                            <ul class="promo-name card-block">
                                                                 <li class="cart-summary-line">
                                                                      <span class="label">Promo Code: <?php echo htmlspecialchars($_SESSION['promo_code']['code']); ?></span>
                                                                      <div class="float-xs-right">
                                                                           <span>-Kes <?php echo number_format($_SESSION['promo_code']['discount_amount'], 2); ?></span>
                                                                           <a href="#" class="remove-promo" data-link-action="remove-voucher"><i class="material-icons">&#xE872;</i></a>
                                                                      </div>
                                                                 </li>
                                                            </ul>
                                                       <?php endif; ?>

                                                       <p class="promo-code-button display-promo">
                                                            <a class="collapse-button" href="#promo-code">
                                                                 Have a promo code?
                                                            </a>
                                                       </p>

                                                       <div id="promo-code" class="collapse">
                                                            <div class="promo-code">
                                                                 <form id="promo-form" action="ajax/apply_promo.php" method="post">
                                                                      <input type="hidden" name="cart_total" value="<?php echo $total_price; ?>">
                                                                      <input class="promo-input" type="text" name="promo_code" placeholder="Enter promo code">
                                                                      <button type="submit" class="btn btn-primary"><span>Apply</span></button>
                                                                 </form>

                                                                 <div class="alert alert-danger js-error" role="alert" style="display: none;">
                                                                      <i class="material-icons">&#xE001;</i><span class="ml-1 js-error-text"></span>
                                                                 </div>

                                                                 <a class="collapse-button promo-code-button cancel-promo" role="button" data-toggle="collapse" data-target="#promo-code" aria-expanded="true" aria-controls="promo-code">
                                                                      Close
                                                                 </a>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>


                                        </div>





                                        <div class="checkout cart-detailed-actions js-cart-detailed-actions card-block">
                                             <div class="text-sm-center">
                                                  <button type="button" class="btn btn-primary w-100" id="proceedToCheckout" disabled>
                                                       <span id="checkout-text">Calculate Shipping First</span>
                                                  </button>
                                             </div>
                                        </div>



                                   </div>


                                   <div>
                                        <img src="assets/img/payment-badge.png" alt="Secure Payment" class="img-fluid">

                                        <div>
                                             <div class="blockreassurance_product">
                                                  <!--secure payment badge-->
                                                  <div>

                                                       <span class="block-title" style="color:#000000;">Security policy</span>
                                                       <p style="color:#000000;">Your payment information is processed securely.</p>
                                                  </div>
                                                  <div>

                                                       <span class="block-title" style="color:#000000;">Delivery policy</span>
                                                       <p style="color:#000000;">Fast and reliable delivery to your doorstep.</p>
                                                  </div>
                                                  <div>

                                                       <span class="block-title" style="color:#000000;">Return policy</span>
                                                       <p style="color:#000000;">Easy returns within 14 days.</p>
                                                  </div>
                                                  <div class="clearfix"></div>
                                             </div>



                                        </div>

                                   </div>


                    </section>


               </div>




          </div>
     </div>

</section>

<script>
     // Global variables for shipping calculation
     var userLat = null;
     var userLng = null;
     var destinationLat = null;
     var destinationLng = null;
     var shippingCalculated = false;
     
     // Previous location data from PHP
     var previousLocation = <?php echo $previous_location ? json_encode($previous_location) : 'null'; ?>;

     // Use My Current Location handler
     document.getElementById('use_location').addEventListener('click', function() {
          if (navigator.geolocation) {
               navigator.geolocation.getCurrentPosition(function(position) {
                    // Update global user location variables
                    userLat = position.coords.latitude;
                    userLng = position.coords.longitude;

                    // Reverse geocoding to get address details
                    const geocodeURL = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLat}&lon=${userLng}&addressdetails=1&zoom=12`;

                    fetch(geocodeURL)
                         .then(response => response.json())
                         .then(data => {
                              if (data && data.address) {
                                   const address = data.address;
                                   console.log('Geocoding result:', data);
                                   
                                   // Prefer state if available; otherwise use county
                                   const stateVal = address.state || address.county || '';
                                   const countryVal = address.country || '';
                                   // Use town, village, city, or suburb if available
                                   const townVal = address.town || address.village || address.city || address.suburb || '';
                                   const districtVal = address.district || '';
                                   const countyVal = address.county || '';

                                   // Update postcode if available
                                   document.getElementById('postcode').value = address.postcode || '';

                                   // Helper function to normalize text (removing " county" for better matching)
                                   const normalize = str => str ? str.trim().toLowerCase().replace(' county', '').replace(' district', '') : '';

                                   const normalizedTown = normalize(townVal);
                                   const normalizedState = normalize(stateVal);
                                   const normalizedCountry = normalize(countryVal);
                                   const normalizedDistrict = normalize(districtVal);
                                   const normalizedCounty = normalize(countyVal);

                                   let destinationFound = false;

                                   // Set destination coordinates to user location for shipping calculation
                                   destinationLat = userLat;
                                   destinationLng = userLng;
                                   destinationFound = true;

                                   // Store the precise location name for shipping calculation
                                   window.selectedPreciseLocation = data.display_name || '';
                                   console.log('Selected precise location:', window.selectedPreciseLocation);
                                   console.log('Result object:', data);
                                   console.log('Display name:', data.display_name);
                                   console.log('Name:', data.name);

                                   // Fill in state/county if available
                                   if (address.state || address.county) {
                                        document.getElementById('state').value = address.state || address.county || '';
                                   }
                                   
                                   // Fill in postcode if available
                                   if (address.postcode) {
                                        document.getElementById('postcode').value = address.postcode;
                                   }

                                   console.log('Location detected:', {
                                        town: townVal,
                                        state: stateVal,
                                        county: countyVal,
                                        coordinates: `${userLat}, ${userLng}`,
                                        precise_location: data.display_name
                                   });

                                   window.selectedLocationMethod = 'current_location';
                              }
                         });

                    Swal.fire({
                         position: 'top-end',
                         toast: true,
                         showConfirmButton: false,
                         timer: 2000,
                         icon: 'success',
                         title: 'Location captured and address fields updated!'
                    });
               }, showError);
          } else {
               Swal.fire('Error', "Geolocation is not supported by your browser.", 'error');
          }
     });

     // Calculate Shipping handler
     document.getElementById('calc_shipping').addEventListener('click', function(e) {
          e.preventDefault();

          const manualLat = document.getElementById('manual_lat').value;
          const manualLng = document.getElementById('manual_lng').value;
          
          // Check if manual coordinates are provided
          if (manualLat && manualLng) {
               destinationLat = parseFloat(manualLat);
               destinationLng = parseFloat(manualLng);
               console.log('Using manual coordinates:', destinationLat, destinationLng);
               if (!window.selectedLocationMethod) {
                    window.selectedLocationMethod = 'manual_coordinates';
               }
          } else if (!(destinationLat && destinationLng)) {
               Swal.fire('Error', "Please search for your location or enter manual coordinates first.", 'error');
               return;
          }

          if (userLat === null || userLng === null) {
               Swal.fire({
                    title: 'Warning',
                    text: "Current location not captured. Use 'Use My Current Location' option or search for your location.",
                    icon: 'warning'
               });
               return;
          }

          // Hide previous location alert when calculating shipping
          const previousLocationAlert = document.getElementById('previous_location_alert');
          if (previousLocationAlert) {
               previousLocationAlert.style.display = 'none';
          }

          // Show loading state
          const calcBtn = this;
          const originalBtnText = calcBtn.innerHTML;
          calcBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...';
          calcBtn.disabled = true;

          // Make AJAX request to calculate shipping
          const requestData = {
               destination: document.getElementById('state').value || 'Unknown Location',
               state: document.getElementById('state').value,
               postcode: document.getElementById('postcode').value,
               lat: destinationLat,
               lng: destinationLng,
               user_lat: userLat,
               user_lng: userLng,
               precise_location_name: window.selectedPreciseLocation || '',
               search_term: document.getElementById('location_search').value,
               location_method: window.selectedLocationMethod || ''
          };
          
          console.log('Shipping calculation request data:', requestData);
          console.log('Selected precise location from window:', window.selectedPreciseLocation);
          console.log('Precise location name being sent:', requestData.precise_location_name);
          
          fetch('ajax/calculate_cart_shipping.php', {
               method: 'POST',
               headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
               },
               body: new URLSearchParams(requestData)
          })
          .then(response => {
               console.log('Response status:', response.status);
               console.log('Response headers:', response.headers);
               return response.text().then(text => {
                    console.log('Raw response:', text);
                    try {
                         return JSON.parse(text);
                    } catch (e) {
                         console.error('JSON parse error:', e);
                         console.error('Response text:', text);
                         throw new Error('Invalid JSON response: ' + text.substring(0, 200));
                    }
               });
          })
          .then(data => {
               console.log('Parsed data:', data);
               
               if (data.status === 'success') {
                    // Ensure shipping_cost is a number
                    const shippingCost = typeof data.shipping_cost === 'number' ? 
                         data.shipping_cost : parseFloat(data.shipping_cost || 0);
                    
                    // Update shipping cost display
                    document.getElementById('shipping-status').innerHTML = `Kes ${shippingCost.toFixed(2)}`;
                    
                    // Show the remove shipping button
                    const removeShippingBtn = document.getElementById('remove-shipping');
                    if (removeShippingBtn) {
                         removeShippingBtn.style.display = 'inline-block';
                    }
                    
                    // Update total amount
                    const totalElement = document.getElementById('cart-total-price');
                    const subtotalText = document.getElementById('cart-total-price-mobile').textContent;
                    const subtotal = parseFloat(subtotalText.replace(/[^\d.]/g, ''));
                    
                    let discountAmount = 0;
                    const discountElement = document.getElementById('discount-amount');
                    if (discountElement) {
                        const discountText = discountElement.textContent;
                        discountAmount = parseFloat(discountText.replace(/[^\d.-]/g, ''));
                    }

                    const finalTotal = subtotal + shippingCost + discountAmount; // discountAmount is negative

                    if (totalElement) {
                         totalElement.textContent = `Kes ${finalTotal.toFixed(2)}`;
                    }

                    // Enable checkout button
                    const checkoutBtn = document.getElementById('proceedToCheckout');
                    const checkoutText = document.getElementById('checkout-text');
                    checkoutBtn.disabled = false;
                    checkoutText.textContent = 'Proceed to Checkout';
                    shippingCalculated = true;

                    Swal.fire({
                         position: 'top-end',
                         toast: true,
                         showConfirmButton: false,
                         timer: 2000,
                         icon: 'success',
                         title: `Shipping calculated. Distance: ${data.distance} km`
                    });
               } else {
                    Swal.fire({
                         icon: 'error',
                         title: 'Error!',
                         text: data.message || 'Failed to calculate shipping cost'
                    });
               }
          })
          .catch(error => {
               console.error('Error:', error);
               Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while calculating shipping cost: ' + error.message
               });
          })
          .finally(() => {
               // Reset button state
               calcBtn.innerHTML = originalBtnText;
               calcBtn.disabled = false;
          });
     });

     function calculateDistance(lat1, lon1, lat2, lon2) {
          var R = 6371;
          var dLat = deg2rad(lat2 - lat1);
          var dLon = deg2rad(lon2 - lon1);
          var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
               Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
               Math.sin(dLon / 2) * Math.sin(dLon / 2);
          var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
          return R * c;
     }

     function deg2rad(deg) {
          return deg * (Math.PI / 180);
     }

     function showError(error) {
          var errMsg = '';
          switch (error.code) {
               case error.PERMISSION_DENIED:
                    errMsg = "User denied the request for Geolocation.";
                    break;
               case error.POSITION_UNAVAILABLE:
                    errMsg = "Location information is unavailable.";
                    break;
               case error.TIMEOUT:
                    errMsg = "The request to get user location timed out.";
                    break;
               case error.UNKNOWN_ERROR:
                    errMsg = "An unknown error occurred.";
                    break;
          }
          Swal.fire({
               title: 'Error',
               text: errMsg,
               icon: 'error'
          });
     }

     document.getElementById('clear-cart-btn').addEventListener('click', function(e) {
          e.preventDefault();

          Swal.fire({
               title: 'Clear Cart',
               text: 'Are you sure you want to remove all items from your cart?',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#d33',
               cancelButtonColor: '#3085d6',
               confirmButtonText: 'Yes, clear cart',
               cancelButtonText: 'Cancel'
          }).then((result) => {
               if (result.isConfirmed) {
                    Swal.fire({
                         title: 'Clearing Cart...',
                         text: 'Please wait while we clear your cart',
                         allowOutsideClick: false,
                         didOpen: () => {
                              Swal.showLoading();
                         }
                    });

                    fetch('ajax/clear_cart.php', {
                              method: 'POST',
                              headers: {
                                   'X-Requested-With': 'XMLHttpRequest',
                                   'Content-Type': 'application/json'
                              }
                         })
                         .then(response => {
                              if (!response.ok) {
                                   throw new Error('Network response was not ok');
                              }
                              return response.json();
                         })
                         .then(data => {
                              if (data.success) {
                                   // Remove all cart items from the DOM
                                   document.querySelector('.cart-items').innerHTML = '';
                                   // Hide the Remove All Items button
                                   document.getElementById('clear-cart-btn').style.display = 'none';
                                   // Update left-side totals
                                   document.getElementById('sidebar-item-count').textContent = '0 items';
                                   document.getElementById('cart-total-price-mobile').textContent = 'Kes 0.00';
                                   document.getElementById('cart-total-value').textContent = 'Kes 0.00';
                                   // Remove any previous empty cart message
                                   let cartContainer = document.querySelector('.cart-container');
                                   let oldAlert = cartContainer.querySelector('.alert.alert-info');
                                   if (oldAlert) oldAlert.remove();
                                   // Show empty cart message
                                   cartContainer.innerHTML += '<div class="alert alert-info">Your cart is empty. <a href="shop.php">Continue shopping</a></div>';

                                   // --- UPDATE RIGHT SIDE SUMMARY ---
                                   // Items count
                                   let rightItemCount = document.querySelector('#cart-subtotal-products .label');
                                   if (rightItemCount) rightItemCount.textContent = '0 items';
                                   // Total price
                                   let rightTotal = document.querySelector('#cart-total-value');
                                   if (rightTotal) rightTotal.textContent = 'Kes 0.00';
                                   // Shipping
                                   let rightShipping = document.getElementById('shipping_cost');
                                   if (rightShipping) rightShipping.textContent = 'Kes 0.00';
                                   // Promo code area
                                   let promoBlock = document.querySelector('.block-promo');
                                   if (promoBlock) promoBlock.style.display = 'none';
                                   // Checkout button
                                   let checkoutBtn = document.querySelector('.cart-detailed-actions .btn-primary');
                                   if (checkoutBtn) checkoutBtn.style.display = 'none';

                                   Swal.fire({
                                        title: 'Cart Cleared!',
                                        text: 'All items have been removed from your cart.',
                                        icon: 'success',
                                        confirmButtonColor: '#3085d6'
                                   }).then(() => {
                                        location.reload();
                                   });
                              } else {
                                   Swal.fire({
                                        title: 'Error!',
                                        text: data.message || 'Failed to clear cart. Please try again.',
                                        icon: 'error',
                                        confirmButtonColor: '#3085d6'
                                   });
                              }
                         })
                         .catch(error => {
                              console.error('Error:', error);
                              Swal.fire({
                                   title: 'Error!',
                                   text: 'Unable to connect to the server. Please check your internet connection and try again.',
                                   icon: 'error',
                                   confirmButtonColor: '#3085d6'
                              });
                         });
               }
          });
     });

     function changeQty(productId, delta) {
          const input = document.querySelector(`.js-cart-line-product-quantity[data-product-id="${productId}"]`);
          if (!input) return;

          let value = parseInt(input.value, 10) || 1;
          const maxStock = parseInt(input.getAttribute('data-max-stock'));
          const maxLimit = input.getAttribute('data-max-limit');

          console.log('Debug - changeQty:', {
               productId,
               currentValue: value,
               maxStock,
               maxLimit,
               delta
          });

          // Calculate max allowed based on sale_out_limit
          let maxAllowed;
          if (maxLimit === 'no limit' || maxLimit === 'no_limit' || maxLimit === 'nolimit') {
               maxAllowed = maxStock; // Only check against available stock
          } else {
               maxAllowed = Math.min(maxStock, parseInt(maxLimit)); // Check against both stock and admin-set limit
          }

          console.log('Debug - maxAllowed:', maxAllowed);

          // If trying to increase beyond limit, show message
          if (delta > 0 && value >= maxAllowed) {
               const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
               });

               let message = '';
               if (maxLimit === 'no limit' || maxLimit === 'no_limit' || maxLimit === 'nolimit') {
                    message = `Only ${maxStock} items available in stock`;
               } else {
                    message = `Maximum order limit is ${maxLimit} items`;
               }

               Toast.fire({
                    icon: 'info',
                    title: message
               });
               return;
          }

          value = Math.max(1, Math.min(maxAllowed, value + delta));
          input.value = value;

          // Trigger the change event to update the cart
          const event = new Event('change', {
               bubbles: true
          });
          input.dispatchEvent(event);
     }

     function updateCartQuantity(productId, newQuantity) {
          return fetch('ajax/update_quantity.php', {
                    method: 'POST',
                    headers: {
                         'Content-Type': 'application/x-www-form-urlencoded',
                         'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `product_id=${productId}&quantity=${newQuantity}`
               })
               .then(response => {
                    if (!response.ok) {
                         throw new Error('Network response was not ok');
                    }
                    return response.json();
               });
     }

     // Add updateCartCount function
     function updateCartCount() {
          return fetch('ajax/cart_update.php', {
                    method: 'GET',
                    headers: {
                         'X-Requested-With': 'XMLHttpRequest'
                    }
               })
               .then(response => {
                    if (!response.ok) {
                         throw new Error('Network response was not ok');
                    }
                    return response.json();
               })
               .then(data => {
                    if (data.status === 'success') {
                         // Update all cart count elements
                         document.querySelectorAll('.mobile_count, #cart-item-count-mobile, #cart-item-count-mobile-title').forEach(el => {
                              el.textContent = data.total_items;
                         });

                         // Update cart total
                         document.querySelectorAll('.cart-products-count .value, #cart-total-price-mobile').forEach(el => {
                              el.textContent = 'Kes ' + data.total_price;
                         });

                         // Update cart items list
                         document.querySelectorAll('#cart-items-list-mobile, .cart-items-list').forEach(el => {
                              el.innerHTML = data.cart_html;
                         });

                         // Update cart summary
                         const subtotalEl = document.getElementById('cart-subtotal-products-value');
                         if (subtotalEl) subtotalEl.textContent = 'Kes ' + (data.total_price - (data.shipping_cost || 0)).toFixed(2);

                         const shippingEl = document.getElementById('cart-subtotal-shipping-value');
                         if (shippingEl) {
                              const shippingCost = typeof data.shipping_cost === 'number' ? data.shipping_cost : parseFloat(data.shipping_cost || 0);
                              shippingEl.textContent = 'Kes ' + shippingCost.toFixed(2);
                         }

                         // Update cart button state
                         const cartBtn = document.querySelector('.shopping-cart');
                         if (cartBtn) {
                              if (data.total_items > 0) {
                                   cartBtn.classList.remove('empty');
                              } else {
                                   cartBtn.classList.add('empty');
                              }
                         }
                    }
               });
     }

     // Update the cart items event listener
     document.querySelector('.cart-items').addEventListener('change', function(e) {
          if (e.target.classList.contains('js-cart-line-product-quantity')) {
               const input = e.target;
               const productId = input.getAttribute('data-product-id');
               const newQuantity = parseInt(input.value);
               const maxStock = parseInt(input.getAttribute('data-max-stock'));
               const maxLimit = input.getAttribute('data-max-limit');

               console.log('Debug - change event:', {
                    productId,
                    newQuantity,
                    maxStock,
                    maxLimit
               });

               // Calculate max allowed based on sale_out_limit
               let maxAllowed;
               if (maxLimit === 'no limit' || maxLimit === 'no_limit' || maxLimit === 'nolimit') {
                    maxAllowed = maxStock; // Only check against available stock
               } else {
                    maxAllowed = Math.min(maxStock, parseInt(maxLimit)); // Check against both stock and admin-set limit
               }

               console.log('Debug - maxAllowed:', maxAllowed);

               // Only validate minimum quantity
               if (newQuantity < 1 || isNaN(newQuantity)) {
                    console.log('Debug - Invalid quantity:', newQuantity);
                    Swal.fire({
                         icon: 'error',
                         title: 'Invalid Quantity',
                         text: 'Please enter a quantity of 1 or more',
                         confirmButtonColor: '#3085d6'
                    });
                    input.value = input.getAttribute('data-original-value') || 1;
                    return;
               }

               // Validate maximum quantity
               if (newQuantity > maxAllowed) {
                    let message = '';
                    if (maxLimit === 'no limit' || maxLimit === 'no_limit' || maxLimit === 'nolimit') {
                         message = `Only ${maxStock} items available in stock`;
                    } else {
                         message = `Maximum order limit is ${maxLimit} items`;
                    }

                    Swal.fire({
                         icon: 'info',
                         title: 'Quantity Limit',
                         text: message,
                         confirmButtonColor: '#3085d6'
                    });
                    input.value = maxAllowed;
                    return;
               }

               // Store original value before update
               const originalValue = input.value;
               input.setAttribute('data-original-value', originalValue);

               // Show loading
               Swal.fire({
                    title: 'Updating Cart...',
                    allowOutsideClick: false,
                    didOpen: () => {
                         Swal.showLoading();
                    }
               });

               updateCartQuantity(productId, newQuantity)
                    .then(data => {
                         // Close the loading dialog
                         Swal.close();

                         if (data.status === 'success') {
                              // Update the price display
                              const cartItem = input.closest('.cart-item');
                              const unitPrice = parseFloat(cartItem.getAttribute('data-unit-price'));
                              const totalPrice = unitPrice * newQuantity;

                              // Update the price display
                              const priceElement = cartItem.querySelector('.product-price strong');
                              if (priceElement) {
                                   priceElement.textContent = `Kes ${totalPrice.toFixed(2)}`;
                              }

                              // Update cart totals from server response
                              document.getElementById('sidebar-item-count').textContent = `${data.cart_items} item${data.cart_items !== 1 ? 's' : ''}`;
                              document.getElementById('cart-total-price-mobile').textContent = `Kes ${parseFloat(data.cart_total).toFixed(2)}`;
                              document.getElementById('cart-total-value').textContent = `Kes ${parseFloat(data.cart_total).toFixed(2)}`;

                              // Store the new value as original
                              input.setAttribute('data-original-value', newQuantity);

                              // Update cart dropdown and count
                              updateCartCount();

                              // Show success message without blocking focus
                              const Toast = Swal.mixin({
                                   toast: true,
                                   position: 'top-end',
                                   showConfirmButton: false,
                                   timer: 1000,
                                   timerProgressBar: true
                              });

                              Toast.fire({
                                   icon: 'success',
                                   title: 'Cart updated successfully'
                              });
                         } else {
                              // Handle error response
                              throw new Error(data.message || 'Failed to update cart');
                         }
                    })
                    .catch(error => {
                         console.error('Error:', error);
                         // Reset to previous value
                         input.value = input.getAttribute('data-original-value') || 1;

                         // Show error message without blocking focus
                         const Toast = Swal.mixin({
                              toast: true,
                              position: 'top-end',
                              showConfirmButton: false,
                              timer: 3000,
                              timerProgressBar: true
                         });

                         Toast.fire({
                              icon: 'error',
                              title: error.message || 'Unable to update cart. Please try again.'
                         });
                    });
          }
     });

     // Initialize input values on page load
     document.addEventListener('DOMContentLoaded', function() {
          document.querySelectorAll('.js-cart-line-product-quantity').forEach(input => {
               input.setAttribute('data-original-value', input.value);
          });
     });

     // Add promo code handling
     document.addEventListener('DOMContentLoaded', function() {
          const promoForm = document.getElementById('promo-form');
          if (promoForm) {
               promoForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const form = this;
                    const promoInput = form.querySelector('input[name="promo_code"]');
                    const errorDiv = form.closest('.promo-code').querySelector('.js-error');
                    const errorText = errorDiv ? errorDiv.querySelector('.js-error-text') : null;
                    const submitBtn = form.querySelector('button[type="submit"]');
                    
                    // Clear previous errors
                    if (errorDiv) {
                         errorDiv.style.display = 'none';
                    }
                    if (errorText) {
                         errorText.textContent = '';
                    }
                    
                    // Validate input
                    if (!promoInput.value.trim()) {
                         if (errorText) {
                              errorText.textContent = 'Please enter a promo code';
                         }
                         if (errorDiv) {
                              errorDiv.style.display = 'block';
                         }
                         return;
                    }
                    
                    // Show loading state
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Applying...';
                    submitBtn.disabled = true;
                    
                    // Create form data
                    const formData = new FormData(form);
                    
                    // Make the AJAX request
                    fetch('ajax/apply_promo.php', {
                         method: 'POST',
                         headers: {
                              'Content-Type': 'application/x-www-form-urlencoded',
                              'X-Requested-With': 'XMLHttpRequest'
                         },
                         body: new URLSearchParams(formData)
                    })
                    .then(response => {
                         if (!response.ok) {
                              throw new Error('Network response was not ok');
                         }
                         return response.text().then(text => {
                              try {
                                   return JSON.parse(text);
                              } catch (e) {
                                   console.error('Invalid JSON response:', text);
                                   throw new Error('Invalid server response');
                              }
                         });
                    })
                    .then(data => {
                         if (data.status === 'success') {
                              // Update all total displays
                              document.querySelectorAll('#cart-total-price-mobile, .cart-total .value').forEach(el => {
                                   el.textContent = 'Kes ' + parseFloat(data.final_total).toFixed(2);
                              });
                              
                              // Add or update discount line
                              let discountLine = document.getElementById('cart-subtotal-discount');
                              if (!discountLine) {
                                   discountLine = document.createElement('div');
                                   discountLine.id = 'cart-subtotal-discount';
                                   discountLine.className = 'cart-summary-line';
                                   document.querySelector('.cart-detailed-subtotals').appendChild(discountLine);
                              }
                              discountLine.innerHTML = `
                                   <span class="label">
                                        Promo Code (${data.promo_code})
                                   </span>
                                   <span class="value" id="discount-amount">
                                        -Kes ${parseFloat(data.discount_amount).toFixed(2)}
                                   </span>
                              `;
                              
                              // Show success message
                              Swal.fire({
                                   icon: 'success',
                                   title: 'Success!',
                                   text: data.message,
                                   timer: 2000,
                                   showConfirmButton: false
                              }).then(() => {
                                   // Reload the page to update all totals
                                   window.location.reload();
                              });
                         } else {
                              // Show error message
                              if (errorText) {
                                   errorText.textContent = data.message || 'Failed to apply promo code';
                              }
                              if (errorDiv) {
                                   errorDiv.style.display = 'block';
                              }
                              
                              // Show error in SweetAlert
                              Swal.fire({
                                   icon: 'error',
                                   title: 'Error!',
                                   text: data.message || 'Failed to apply promo code'
                              });
                         }
                    })
                    .catch(error => {
                         console.error('Error:', error);
                         
                         // Show error message
                         if (errorText) {
                              errorText.textContent = 'An error occurred. Please try again.';
                         }
                         if (errorDiv) {
                              errorDiv.style.display = 'block';
                         }
                         
                         // Show error in SweetAlert
                         Swal.fire({
                              icon: 'error',
                              title: 'Error!',
                              text: 'An error occurred while applying the promo code. Please try again.'
                         });
                    })
                    .finally(() => {
                         // Reset button state
                         submitBtn.innerHTML = originalBtnText;
                         submitBtn.disabled = false;
                    });
               });
          }

          // Handle promo code removal
          const removePromoBtn = document.querySelector('.remove-promo');
          if (removePromoBtn) {
               removePromoBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const removeBtn = this;
                    const originalBtnHtml = removeBtn.innerHTML;
                    
                    // Show loading state
                    removeBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                    removeBtn.disabled = true;
                    
                    fetch('ajax/remove_promo.php', {
                         method: 'POST',
                         headers: {
                              'Content-Type': 'application/x-www-form-urlencoded',
                              'X-Requested-With': 'XMLHttpRequest'
                         }
                    })
                    .then(response => {
                         if (!response.ok) {
                              throw new Error('Network response was not ok');
                         }
                         return response.text().then(text => {
                              try {
                                   return JSON.parse(text);
                              } catch (e) {
                                   console.error('Invalid JSON response:', text);
                                   throw new Error('Invalid server response');
                              }
                         });
                    })
                    .then(data => {
                         if (data.status === 'success') {
                              // Update cart totals
                              document.querySelectorAll('#cart-total-price-mobile, .cart-total .value').forEach(el => {
                                   el.textContent = 'Kes ' + parseFloat(data.final_total).toFixed(2);
                              });
                              
                              // Show success message
                              Swal.fire({
                                   icon: 'success',
                                   title: 'Success!',
                                   text: data.message,
                                   timer: 2000,
                                   showConfirmButton: false
                              }).then(() => {
                                   // Reload the page to update the promo code display
                                   window.location.reload();
                              });
                         } else {
                              throw new Error(data.message || 'Failed to remove promo code');
                         }
                    })
                    .catch(error => {
                         console.error('Error:', error);
                         
                         // Show error in SweetAlert
                         Swal.fire({
                              icon: 'error',
                              title: 'Error!',
                              text: error.message || 'An error occurred while removing the promo code. Please try again.'
                         });
                    })
                    .finally(() => {
                         // Reset button state
                         removeBtn.innerHTML = originalBtnHtml;
                         removeBtn.disabled = false;
                    });
               });
          }
     });

     // Extract coordinates from Google Maps URL
     // document.getElementById('extract_coordinates').addEventListener('click', function() { ... });
     // function extractCoordinatesFromGoogleMaps(url) { ... }

     document.addEventListener('DOMContentLoaded', function() {
          // Handle checkout process
          document.getElementById('proceedToCheckout').addEventListener('click', function() {
               // Check if shipping has been calculated
               if (!shippingCalculated) {
                    Swal.fire({
                         title: 'Shipping Required',
                         text: 'Please calculate shipping before proceeding to checkout',
                         icon: 'warning',
                         confirmButtonColor: '#3085d6'
                    });
                    return;
               }

               if (!<?php echo isset($_SESSION['auth_user']) ? 'true' : 'false'; ?>) {
                    Swal.fire({
                         title: 'Login Required',
                         text: 'Please login or register to proceed with checkout',
                         icon: 'info',
                         showCancelButton: true,
                         confirmButtonText: 'Login',
                         cancelButtonText: 'Register',
                         showDenyButton: true,
                         denyButtonText: 'Cancel'
                    }).then((result) => {
                         if (result.isConfirmed) {
                              window.location.href = 'login.php?redirect=shop-cart.php';
                         } else if (result.isDismissed) {
                              window.location.href = 'register.php?redirect=shop-cart.php';
                         }
                    });
                    return;
               }

               // Show loading state
               Swal.fire({
                    title: 'Processing Checkout',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                         Swal.showLoading();
                    }
               });

               // Process checkout
               fetch('process_checkout.php', {
                    method: 'POST',
                    headers: {
                         'Content-Type': 'application/json',
                         'Accept': 'application/json'
                    }
               })
               .then(response => {
                    console.log('Checkout response status:', response.status);
                    return response.text().then(text => {
                         console.log('Checkout raw response:', text);
                         try {
                              return JSON.parse(text);
                         } catch (e) {
                              console.error('Checkout JSON parse error:', e);
                              console.error('Checkout response text:', text);
                              throw new Error('Invalid JSON response from checkout: ' + text.substring(0, 200));
                         }
                    });
               })
               .then(data => {
                    console.log('Checkout response:', data);
                    if (data.status === 'success') {
                         Swal.fire({
                              title: 'Success!',
                              text: data.message,
                              icon: 'success'
                         }).then(() => {
                              if (data.data && data.data.redirect) {
                                   window.location.href = data.data.redirect;
                              }
                         });
                    } else {
                         Swal.fire({
                              title: 'Error',
                              text: data.message || 'Failed to process checkout',
                              icon: 'error'
                         });
                    }
               })
               .catch(error => {
                    console.error('Checkout Error:', error);
                    Swal.fire({
                         title: 'Error',
                         text: 'An error occurred while processing your checkout. Please try again.',
                         icon: 'error'
                    });
               });
          });
     });

     // Initialize shipping persistence and remove functionality
     document.addEventListener('DOMContentLoaded', function() {
          // Restore shipping information if exists
          <?php if (isset($_SESSION['shipping_info'])): ?>
          const shippingInfo = <?php echo json_encode($_SESSION['shipping_info']); ?>;
          if (shippingInfo) {
               // Update shipping display
               document.getElementById('shipping-status').innerHTML = `Kes ${parseFloat(shippingInfo.shipping_cost).toFixed(2)}`;
               
               // Show the remove shipping button
               const removeShippingBtn = document.getElementById('remove-shipping');
               if (removeShippingBtn) {
                    removeShippingBtn.style.display = 'inline-block';
               }
               
               // Update form fields
               if (shippingInfo.destination) {
                    // Set destination coordinates directly
                    destinationLat = parseFloat(shippingInfo.lat);
                    destinationLng = parseFloat(shippingInfo.lng);
               }
               
               if (shippingInfo.state) {
                    document.getElementById('state').value = shippingInfo.state;
               }
               
               if (shippingInfo.postcode) {
                    document.getElementById('postcode').value = shippingInfo.postcode;
               }
               
               // Set user location
               userLat = parseFloat(shippingInfo.lat);
               userLng = parseFloat(shippingInfo.lng);
               
               // Update total
               const subtotalText = document.getElementById('cart-total-price-mobile').textContent;
               const subtotal = parseFloat(subtotalText.replace(/[^\d.]/g, ''));
               const shippingCost = parseFloat(shippingInfo.shipping_cost);
               
               let discountAmount = 0;
               const discountElement = document.getElementById('discount-amount');
               if (discountElement) {
                    const discountText = discountElement.textContent;
                    discountAmount = parseFloat(discountText.replace(/[^\d.-]/g, ''));
               }
               
               const finalTotal = subtotal + shippingCost + discountAmount;
               document.getElementById('cart-total-price').textContent = `Kes ${finalTotal.toFixed(2)}`;
               
               // Enable checkout button
               const checkoutBtn = document.getElementById('proceedToCheckout');
               const checkoutText = document.getElementById('checkout-text');
               checkoutBtn.disabled = false;
               checkoutText.textContent = 'Proceed to Checkout';
               shippingCalculated = true;
          }
          <?php endif; ?>

          // Handle remove shipping button
          const removeShippingBtn = document.getElementById('remove-shipping');
          if (removeShippingBtn) {
               removeShippingBtn.addEventListener('click', function() {
                    Swal.fire({
                         title: 'Remove Shipping',
                         text: 'Are you sure you want to remove the shipping calculation?',
                         icon: 'warning',
                         showCancelButton: true,
                         confirmButtonColor: '#d33',
                         cancelButtonColor: '#3085d6',
                         confirmButtonText: 'Yes, remove it',
                         cancelButtonText: 'Cancel'
                    }).then((result) => {
                         if (result.isConfirmed) {
                              // Show loading
                              Swal.fire({
                                   title: 'Removing Shipping...',
                                   allowOutsideClick: false,
                                   didOpen: () => {
                                        Swal.showLoading();
                                   }
                               });

                              fetch('ajax/remove_shipping.php', {
                                   method: 'POST',
                                   headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                        'X-Requested-With': 'XMLHttpRequest'
                                   }
                              })
                              .then(response => response.json())
                              .then(data => {
                                   if (data.status === 'success') {
                                        // Reset shipping display
                                        document.getElementById('shipping-status').textContent = 'Not calculated';
                                        
                                        // Remove the delete button
                                        removeShippingBtn.remove();
                                        
                                        // Update total
                                        const subtotalText = document.getElementById('cart-total-price-mobile').textContent;
                                        const subtotal = parseFloat(subtotalText.replace(/[^\d.]/g, ''));
                                        
                                        let discountAmount = 0;
                                        const discountElement = document.getElementById('discount-amount');
                                        if (discountElement) {
                                             const discountText = discountElement.textContent;
                                             discountAmount = parseFloat(discountText.replace(/[^\d.-]/g, ''));
                                        }
                                        
                                        const finalTotal = subtotal + discountAmount;
                                        document.getElementById('cart-total-price').textContent = `Kes ${finalTotal.toFixed(2)}`;
                                        
                                        // Disable checkout button
                                        const checkoutBtn = document.getElementById('proceedToCheckout');
                                        const checkoutText = document.getElementById('checkout-text');
                                        checkoutBtn.disabled = true;
                                        checkoutText.textContent = 'Calculate Shipping First';
                                        shippingCalculated = false;
                                        
                                        // Reset form fields
                                        document.getElementById('state').value = '';
                                        document.getElementById('postcode').value = '';
                                        document.getElementById('manual_lat').value = '';
                                        document.getElementById('manual_lng').value = '';
                                        document.getElementById('location_search').value = '';
                                        
                                        Swal.fire({
                                             title: 'Shipping Removed!',
                                             text: 'Shipping calculation has been removed.',
                                             icon: 'success',
                                             timer: 2000,
                                             showConfirmButton: false
                                         });
                                   } else {
                                        throw new Error(data.message || 'Failed to remove shipping');
                                   }
                              })
                              .catch(error => {
                                   console.error('Error:', error);
                                   Swal.fire({
                                        title: 'Error!',
                                        text: error.message || 'An error occurred while removing shipping.',
                                        icon: 'error'
                                   });
                              });
                         }
                    });
               });
          }
     });

     // Location search functionality for non-technical users
     document.getElementById('search_location').addEventListener('click', function() {
          const searchTerm = document.getElementById('location_search').value.trim();
          if (!searchTerm) {
               Swal.fire('Error', 'Please enter a location name to search', 'error');
               return;
          }
          
          searchLocation(searchTerm);
     });

     // Also search when user presses Enter
     document.getElementById('location_search').addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
               const searchTerm = this.value.trim();
               if (searchTerm) {
                    searchLocation(searchTerm);
               }
          }
     });

     function searchLocation(searchTerm) {
          // Show loading
          const searchBtn = document.getElementById('search_location');
          const originalBtnHtml = searchBtn.innerHTML;
          searchBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
          searchBtn.disabled = true;

          // Search using OpenStreetMap Nominatim
          const searchURL = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchTerm + ', Kenya')}&limit=10&addressdetails=1`;
          
          fetch(searchURL)
               .then(response => response.json())
               .then(data => {
                    searchBtn.innerHTML = originalBtnHtml;
                    searchBtn.disabled = false;
                    
                    if (data && data.length > 0) {
                         displaySearchResults(data);
                    } else {
                         Swal.fire('No Results', 'No locations found for "' + searchTerm + '". Try a different search term.', 'info');
                    }
               })
               .catch(error => {
                    console.error('Search error:', error);
                    searchBtn.innerHTML = originalBtnHtml;
                    searchBtn.disabled = false;
                    Swal.fire('Error', 'Failed to search for location. Please try again.', 'error');
               });
     }

     function displaySearchResults(results) {
          const resultsContainer = document.getElementById('search_results');
          const resultsList = document.getElementById('results_list');
          
          resultsList.innerHTML = '';
          
          results.forEach((result, index) => {
               const resultDiv = document.createElement('div');
               resultDiv.className = 'search-result-item p-2 border-bottom cursor-pointer';
               resultDiv.style.cursor = 'pointer';
               resultDiv.style.transition = 'background-color 0.2s';
               
               // Create a readable display name
               let displayName = result.display_name;
               if (displayName.length > 80) {
                    displayName = displayName.substring(0, 80) + '...';
               }
               
               resultDiv.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                         <div>
                              <strong>${result.name || 'Unknown Location'}</strong><br>
                              <small class="text-muted">${displayName}</small>
                         </div>
                         <small class="text-info">${result.lat}, ${result.lon}</small>
                    </div>
               `;
               
               resultDiv.addEventListener('click', function() {
                    selectSearchResult(result);
               });
               
               resultDiv.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
               });
               
               resultDiv.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
               });
               
               resultsList.appendChild(resultDiv);
          });
          
          resultsContainer.style.display = 'block';
     }

     function selectSearchResult(result) {
          // Fill in the coordinates
          document.getElementById('manual_lat').value = parseFloat(result.lat).toFixed(4);
          document.getElementById('manual_lng').value = parseFloat(result.lon).toFixed(4);
          
          // Update user location for shipping calculation
          userLat = parseFloat(result.lat);
          userLng = parseFloat(result.lon);
          
          // Set destination coordinates for shipping calculation
          destinationLat = parseFloat(result.lat);
          destinationLng = parseFloat(result.lon);
          
          // Fill in state/county if available
          if (result.address) {
               const state = result.address.state || result.address.county || result.address.district || '';
               if (state) {
                    document.getElementById('state').value = state;
               }
          }
          
          // Store the precise location name for shipping calculation
          window.selectedPreciseLocation = result.display_name || result.name;
          console.log('Selected precise location:', window.selectedPreciseLocation);
          console.log('Result object:', result);
          console.log('Display name:', result.display_name);
          console.log('Name:', result.name);
          
          // Hide search results
          document.getElementById('search_results').style.display = 'none';
          document.getElementById('location_search').value = result.name;
          
          Swal.fire({
               position: 'top-end',
               toast: true,
               showConfirmButton: false,
               timer: 2000,
               icon: 'success',
               title: 'Location selected successfully!'
          });

          window.selectedLocationMethod = 'google_maps';
     }

     // Use Previous Location handler
     document.addEventListener('DOMContentLoaded', function() {
          // Auto-apply previous location if available
          if (previousLocation) {
               // Set coordinates
               userLat = parseFloat(previousLocation.user_lat);
               userLng = parseFloat(previousLocation.user_lng);
               destinationLat = parseFloat(previousLocation.user_lat);
               destinationLng = parseFloat(previousLocation.user_lng);
               
               // Fill form fields
               document.getElementById('state').value = previousLocation.state || '';
               document.getElementById('postcode').value = previousLocation.postcode || '';
               document.getElementById('manual_lat').value = previousLocation.user_lat;
               document.getElementById('manual_lng').value = previousLocation.user_lng;
               document.getElementById('location_search').value = previousLocation.destination || '';
               
               // Store precise location name
               window.selectedPreciseLocation = previousLocation.precise_location_name;
               window.selectedLocationMethod = previousLocation.location_method || 'previous_location';
               
               console.log('Previous location auto-loaded:', previousLocation.precise_location_name);
          }
          
          // Handle remove previous location button
          const removePreviousBtn = document.getElementById('remove_previous_location');
          if (removePreviousBtn) {
               removePreviousBtn.addEventListener('click', function() {
                    // Clear all form fields
                    document.getElementById('state').value = '';
                    document.getElementById('postcode').value = '';
                    document.getElementById('manual_lat').value = '';
                    document.getElementById('manual_lng').value = '';
                    document.getElementById('location_search').value = '';
                    
                    // Reset global variables
                    userLat = null;
                    userLng = null;
                    destinationLat = null;
                    destinationLng = null;
                    window.selectedPreciseLocation = '';
                    window.selectedLocationMethod = '';
                    
                    // Hide the previous location alert
                    const alertDiv = removePreviousBtn.closest('.alert');
                    if (alertDiv) {
                         alertDiv.style.display = 'none';
                    }
                    
                    Swal.fire({
                         position: 'top-end',
                         toast: true,
                         showConfirmButton: false,
                         timer: 2000,
                         icon: 'info',
                         title: 'Previous location cleared. Please enter a new location.'
                    });
               });
          }
     });
</script>

<?php include 'includes/footer.php'; ?>