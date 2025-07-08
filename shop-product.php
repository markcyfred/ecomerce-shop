<?php
session_start();
include 'includes/header.php';
include 'admin/config/dbcon.php'; // defines $conn

// === 1) Fetch and validate product ID ===
if (!isset($_GET['id'])) {
     echo "<p>Invalid product</p>";
     exit;
}
$product_id = intval($_GET['id']);

// === 2) Query product row ===
$sql = "SELECT * FROM products WHERE id = $product_id AND status = 1";
$res = mysqli_query($conn, $sql);
if (!$res || mysqli_num_rows($res) === 0) {
     echo "<p>Product not found</p>";
     exit;
}
$product = mysqli_fetch_assoc($res);

// === 3) Fetch all gallery images (primary first) ===
$img_sql = "SELECT image_path, is_primary FROM product_images WHERE product_id = $product_id ORDER BY is_primary DESC, id ASC";
$img_res = mysqli_query($conn, $img_sql);
$gallery_images = [];
if ($img_res && mysqli_num_rows($img_res) > 0) {
     while ($row = mysqli_fetch_assoc($img_res)) {
          $gallery_images[] = $row['image_path'];
     }
} else {
     // fallback to single product image
     $gallery_images[] = 'uploads/shop/' . htmlspecialchars($product['image']);
}
// Define $primaryImg for use in wishlist and cart
$primaryImg = !empty($gallery_images[0]) ? $gallery_images[0] : 'uploads/shop/' . htmlspecialchars($product['image']);

// === 4) Category breadcrumb resolution ===
if (empty($product['category_id']) || empty($product['category_name'])) {
     $cat_name = mysqli_real_escape_string($conn, $product['category_name'] ?? '');
     $cat_q = mysqli_query($conn, "SELECT id, name FROM categories WHERE name = '$cat_name' LIMIT 1");
     if ($cat_q && mysqli_num_rows($cat_q)) {
          $cat_row = mysqli_fetch_assoc($cat_q);
          $product['category_id'] = $cat_row['id'];
          $product['category_name'] = $cat_row['name'];
     }
}

// === 5) Pricing and stock calculations ===
// Directly use original_price and selling_price from DB
$original_price = floatval($product['original_price']);
$selling_price  = floatval($product['selling_price']);

$stock_qty = intval($product['quantity']);
$max_stock = 500;
$stock_pct = min(100, max(0, ($stock_qty / $max_stock) * 100));

// Countdown timestamp in ms
$deal_end_ts = isset($product['deal_end']) ? strtotime($product['deal_end']) * 1000 : 0;
?>

<aside id="notifications">
     <div class="container">


     </div>
</aside>



<nav data-depth="3" class="breadcrumb">
     <div class="container">
          <ol>


               <li>
                    <a href="index.php"><span>Home</span></a>
               </li>

               <?php
               // Try to fetch category info if missing
               if (empty($product['category_id']) || empty($product['category_name'])) {
                    $cat_name = mysqli_real_escape_string($conn, $product['category_name'] ?? '');
                    $cat_id_result = mysqli_query($conn, "SELECT id, name FROM categories WHERE name = '$cat_name' LIMIT 1");
                    $cat_id_row = mysqli_fetch_assoc($cat_id_result);
                    if ($cat_id_row) {
                         $product['category_id'] = $cat_id_row['id'];
                         $product['category_name'] = $cat_id_row['name'];
                    }
               }
               ?>

               <?php if (!empty($product['category_id']) && !empty($product['category_name'])): ?>
                    <li>
                         <a href="category.php?id=<?= intval($product['category_id']) ?>">
                              <span><?= htmlspecialchars($product['category_name']) ?></span>
                         </a>
                    </li>
               <?php endif; ?>


               <li>
                    <span><?= htmlspecialchars($product['product_name']) ?></span>
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
</style>


<section style="margin-top: 20px;" id="wrapper">


     <div class="container">
          <div id="columns_inner">




               <div id="content-wrapper" class="js-content-wrapper">


                    <section id="main">
                         <!-- Dynamic Open Graph meta tag for product URL -->
                         <meta property="og:url" content="<?= htmlspecialchars('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>">
                         <div class="product-container js-product-container row">
                              <div class="pp-left-column col-xs-12 col-sm-6 col-md-6">

                                   <section class="page-content" id="content">
                                        <div class="product-leftside">



                                             <div class="images-container js-images-container">
                                                  <div class="images-container-slider">

                                                       <?php if (!empty($gallery_images)): ?>
                                                            <!-- Main product cover: use the first image in the array -->
                                                            <div class="product-cover">
                                                                 <img
                                                                      class="js-qv-product-cover img-fluid zoom-product lazyload"
                                                                      data-zoom-image="<?= htmlspecialchars($gallery_images[0]) ?>"
                                                                      data-src="<?= htmlspecialchars($gallery_images[0]) ?>"
                                                                      src="uploads/placeholder/lazy-loader.svg"
                                                                      height="370"
                                                                      width="370"
                                                                      alt="<?= htmlspecialchars($product['product_name']) ?>"
                                                                      title="<?= htmlspecialchars($product['product_name']) ?>"
                                                                      loading="lazy" />
                                                                 <div class="layer" data-toggle="modal" data-target="#product-modal">
                                                                      <i class="fa fa-arrows-alt zoom-in"></i>
                                                                 </div>
                                                            </div>

                                                            <!-- Thumbnails slider -->
                                                            <div class="js-qv-mask mask additional_slider">
                                                                 <ul id="thumb-gallery1" class="cz-carousel product_list additional-carousel additional-image-slider">
                                                                      <?php foreach ($gallery_images as $index => $path): ?>
                                                                           <li class="thumb-container item">
                                                                                <a href="javascript:void(0)" class="elevatezoom-gallery"
                                                                                     data-image="<?= htmlspecialchars($path) ?>"
                                                                                     data-zoom-image="<?= htmlspecialchars($path) ?>">
                                                                                     <img
                                                                                          class="thumb js-thumb lazyload <?= $index === 0 ? 'selected js-thumb-selected' : '' ?>"
                                                                                          data-image-medium-src="<?= htmlspecialchars($path) ?>"
                                                                                          data-image-large-src="<?= htmlspecialchars($path) ?>"
                                                                                          data-src="<?= htmlspecialchars($path) ?>"
                                                                                          src="uploads/placeholder/lazy-loader.svg"
                                                                                          width="250"
                                                                                          height="250"
                                                                                          alt="<?= htmlspecialchars($product['product_name']) ?>"
                                                                                          title="<?= htmlspecialchars($product['product_name']) ?>"
                                                                                          loading="lazy">
                                                                                </a>
                                                                           </li>
                                                                      <?php endforeach; ?>
                                                                 </ul>

                                                                 <div class="customNavigation">
                                                                      <a class="btn prev additional_prev">&nbsp;</a>
                                                                      <a class="btn next additional_next">&nbsp;</a>
                                                                 </div>
                                                            </div>

                                                            <!-- Modal thumbnails (if needed) -->
                                                            <div class="image-block_slider">
                                                                 <aside id="thumbnails" class="thumbnails js-thumbnails text-xs-center">
                                                                      <div class="js-modal-mask mask nomargin">
                                                                           <ul id="thumb-gallery" class="product-images js-modal-product-images additional-image-slider">
                                                                                <?php foreach ($gallery_images as $index => $path): ?>
                                                                                     <li class="thumb-container">
                                                                                          <a href="javascript:void(0)" class="elevatezoom-gallery"
                                                                                               data-image="<?= htmlspecialchars($path) ?>"
                                                                                               data-zoom-image="<?= htmlspecialchars($path) ?>">
                                                                                               <img
                                                                                                    class="thumb js-thumb lazyload <?= $index === 0 ? 'selected' : '' ?>"
                                                                                                    data-image-medium-src="<?= htmlspecialchars($path) ?>"
                                                                                                    data-image-large-src="<?= htmlspecialchars($path) ?>"
                                                                                                    data-src="<?= htmlspecialchars($path) ?>"
                                                                                                    src="uploads/placeholder/lazy-loader.svg"
                                                                                                    width="250"
                                                                                                    height="250"
                                                                                                    alt="<?= htmlspecialchars($product['product_name']) ?>"
                                                                                                    title="<?= htmlspecialchars($product['product_name']) ?>"
                                                                                                    loading="lazy">
                                                                                          </a>
                                                                                     </li>
                                                                                <?php endforeach; ?>
                                                                           </ul>
                                                                      </div>
                                                                 </aside>
                                                            </div>
                                                            <!-- … your existing "View larger images" button/modal trigger … -->

                                                            <!-- Leave a Review button -->
                                                            <div class="mt-4">
                                                                 <button
                                                                      type="button"
                                                                      class="btn btn-secondary"
                                                                      data-toggle="modal"
                                                                      data-target="#feedback-modal">
                                                                      <i class="fa fa-comment"></i> Leave a Review
                                                                 </button>
                                                            </div>


                                                       <?php else: ?>
                                                            <!-- Fallback: no images in product_images, use the single products.image -->
                                                            <div class="product-cover">
                                                                 <img
                                                                      class="js-qv-product-cover img-fluid zoom-product lazyload"
                                                                      data-zoom-image="uploads/shop/<?= htmlspecialchars($product['image']) ?>"
                                                                      data-src="uploads/shop/<?= htmlspecialchars($product['image']) ?>"
                                                                      src="uploads/placeholder/lazy-loader.svg"
                                                                      height="1000"
                                                                      width="1000"
                                                                      alt="<?= htmlspecialchars($product['product_name']) ?>"
                                                                      title="<?= htmlspecialchars($product['product_name']) ?>"
                                                                      loading="lazy" />
                                                                 <div class="layer" data-toggle="modal" data-target="#product-modal">
                                                                      <i class="fa fa-arrows-alt zoom-in"></i>
                                                                 </div>
                                                            </div>

                                                            <!-- No additional thumbnails to show in fallback -->
                                                       <?php endif; ?>

                                                  </div>
                                             </div>



                                        </div>
                                   </section>

                              </div>

                              <div class="pp-right-column col-xs-12  col-sm-6 col-md-6">

                                   <h2 class="h1 productpage_title">
                                        <?= htmlspecialchars($product['product_name']) ?>
                                   </h2>

                                   <div class="product-information">

                                        <div id="product-description-short-1" itemprop="description" class="description-short">
                                             <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                                        </div>

                                        <div class="product-actions js-product-actions">

                                             <div class="product-variants js-product-variants">
                                                  <div class="product-attributes js-product-attributes">
                                                       <?php if (!empty($product['brand'])): ?>
                                                            <div class="product-manufacturer">
                                                                 <label class="label">Brand: </label>
                                                                 <span><?= htmlspecialchars($product['brand']) ?></span>
                                                            </div>
                                                       <?php endif; ?>

                                                       <?php if (!empty($product['condition'])): ?>
                                                            <div class="product-condition">
                                                                 <label class="label">Condition: </label>
                                                                 <span><?= htmlspecialchars($product['condition']) ?></span>
                                                            </div>
                                                       <?php endif; ?>

                                                       <?php if (!empty($product['reference'])): ?>
                                                            <div class="product-reference">
                                                                 <label class="label">Reference: </label>
                                                                 <span><?= htmlspecialchars($product['reference']) ?></span>
                                                            </div>
                                                       <?php endif; ?>

                                                       <div class="product-quantities">
                                                            <label class="label">Available In Stock: </label>
                                                            <span data-stock="<?= $stock_qty ?>" data-allow-oosp="0"><?= $stock_qty ?> Items</span>
                                                       </div>

                                                       <div class="qtyprogress">
                                                            <span class="text">
                                                                 Hurry up! only <strong class="quantity"><?= $stock_qty ?></strong> items left in stock!
                                                            </span>
                                                            <div class="progress" style="background-color: #eee; height: 10px; border-radius: 4px;">
                                                                 <div
                                                                      class="progress-bar"
                                                                      role="progressbar"
                                                                      style="width: <?= $stock_percentage ?>%; background-color: #28a745; height: 10px; border-radius: 4px;"></div>
                                                            </div>
                                                       </div>

                                                       <?php if ($deal_end_ts > 0): ?>
                                                            <div class="product-counter" style="margin-top: -10px 0 ; font-family: sans-serif;">
                                                                 <span class="end-deal" style="font-weight: bold; color: #d9534f; display: block; margin-bottom: 8px;">
                                                                      Hurry up! Sale ends in:
                                                                 </span>
                                                                 <div
                                                                      class="psproductcountdown"
                                                                      data-to="<?= $deal_end_ts ?>"
                                                                      style="font-size: 1rem; color: #333;">
                                                                      <span id="deal-countdown">
                                                                           <!-- JS will populate "00d 00h 00m 00s" here -->
                                                                      </span>
                                                                 </div>
                                                            </div>

                                                            <script>
                                                                 (function() {
                                                                      function pad(n) {
                                                                           return n < 10 ? '0' + n : n;
                                                                      }

                                                                      function updateCountdown() {
                                                                           var container = document.querySelector('.psproductcountdown');
                                                                           var el = document.getElementById('deal-countdown');
                                                                           if (!container || !el) return;

                                                                           var end = parseInt(container.getAttribute('data-to'), 10);
                                                                           var now = new Date().getTime();
                                                                           var diff = end - now;

                                                                           if (diff <= 0) {
                                                                                el.textContent = 'Deal ended';
                                                                                return;
                                                                           }

                                                                           var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                                                                           var hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                                                                           var minutes = Math.floor((diff / (1000 * 60)) % 60);
                                                                           var seconds = Math.floor((diff / 1000) % 60);

                                                                           el.textContent =
                                                                                pad(days) + 'd ' +
                                                                                pad(hours) + 'h ' +
                                                                                pad(minutes) + 'm ' +
                                                                                pad(seconds) + 's';
                                                                      }

                                                                      updateCountdown();
                                                                      var interval = setInterval(function() {
                                                                           updateCountdown();
                                                                           var el = document.getElementById('deal-countdown');
                                                                           if (el && el.textContent === 'Deal ended') {
                                                                                clearInterval(interval);
                                                                           }
                                                                      }, 1000);
                                                                 })();
                                                            </script>
                                                       <?php endif; ?>

                                                  </div>


                                             </div>



                                             <div class="product-prices js-product-prices">
                                                  <p>Price:
                                                       <?php if ($original_price > $selling_price): ?>
                                                            <span class="text-muted" style="text-decoration: line-through;">KES <?= number_format($original_price, 2) ?></span>
                                                            <span class="fw-bold ms-2">KES <?= number_format($selling_price, 2) ?></span>
                                                       <?php else: ?>
                                                            <span class="fw-bold">KES <?= number_format($selling_price, 2) ?></span>
                                                       <?php endif; ?>
                                                  </p>

                                                  <div class="tax-shipping-delivery-label">
                                                       <span class="delivery-information">Est. Delivery Time 2–3 Days</span>
                                                  </div>
                                             </div>
                                             <?php
                                             // === Start of Cart Status Logic ===
                                             $in_cart = 0;
                                             $cart_quantity = 1;

                                             if (isset($product['in_cart'])) {
                                                  $in_cart = intval($product['in_cart']);
                                                  $cart_quantity = isset($product['cart_quantity']) ? intval($product['cart_quantity']) : 1;
                                             } else {
                                                  $session_id = session_id();
                                                  $user_id = !empty($_SESSION['auth_user']['id']) ? intval($_SESSION['auth_user']['id']) : 0;
                                                  $cart_sql = "SELECT quantity FROM cart WHERE product_id = $product_id AND ((session_id = '$session_id')";
                                                  if ($user_id) {
                                                       $cart_sql .= " OR user_id = $user_id";
                                                  }
                                                  $cart_sql .= ") AND (cart_status IS NULL OR cart_status != 'processed') LIMIT 1";

                                                  $cart_result = mysqli_query($conn, $cart_sql);
                                                  if ($cart_row = mysqli_fetch_assoc($cart_result)) {
                                                       $in_cart = 1;
                                                       $cart_quantity = intval($cart_row['quantity']);
                                                  }
                                             }
                                             ?>

                                             <style>
                                                  .qty-btn {
                                                       width: 32px;
                                                       height: 32px;
                                                       font-size: 18px;
                                                       border: 1px solid #ccc;
                                                       background-color: #f0f0f0;
                                                       border-radius: 4px;
                                                       cursor: pointer;
                                                       transition: background 0.2s;
                                                  }

                                                  .qty-btn:hover {
                                                       background-color: #e0e0e0;
                                                  }

                                                  .btn {
                                                       display: inline-flex;
                                                       align-items: center;
                                                       gap: 6px;
                                                       padding: 8px 12px;
                                                       font-size: 14px;
                                                       text-decoration: none;
                                                       border: none;
                                                       border-radius: 4px;
                                                       cursor: pointer;
                                                       transition: all 0.2s;
                                                  }

                                                  .btn-primary {
                                                       background-color: #007bff;
                                                       color: white;
                                                  }

                                                  .btn-warning {
                                                       background-color: #ffc107;
                                                       color: black;
                                                  }

                                                  .btn-outline-danger {
                                                       background-color: transparent;
                                                       border: 1px solid #dc3545;
                                                       color: #dc3545;
                                                  }
                                             </style>

                                             <script>
                                                  function changeQty(productId, delta) {
                                                       const visible = document.getElementById('quantity_wanted_' + productId);
                                                       const hidden = document.getElementById('quantity_field_' + productId);
                                                       if (!visible) return;

                                                       let value = parseInt(visible.value, 10) || 1;
                                                       const maxStock = parseInt(visible.getAttribute('data-max-stock'));
                                                       const maxLimit = visible.getAttribute('data-max-limit');
                                                       
                                                       // Calculate max allowed based on sale_out_limit
                                                       let maxAllowed;
                                                       if (maxLimit === 'no limit' || maxLimit === 'no_limit' || maxLimit === 'nolimit') {
                                                           maxAllowed = maxStock; // Only check against available stock
                                                       } else {
                                                           maxAllowed = Math.min(maxStock, parseInt(maxLimit)); // Check against both stock and admin-set limit
                                                       }
                                                       
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
                                                       visible.value = value;
                                                       if (hidden) hidden.value = value;
                                                  }


                                                  // 1) Delegate all clicks on .cart-btn
                                                  $(document).on('click', '.cart-btn', function(e) {
                                                       e.preventDefault();
                                                       const $btn = $(this);
                                                       const $form = $btn.closest('form');
                                                       const productId = $btn.data('product-id');
                                                       const quantity = $('#quantity_wanted_' + productId).val() || 1;

                                                       // Sync your hidden field
                                                       $form.find('#quantity_field_' + productId).val(quantity);

                                                       // Show loading state
                                                       $btn.prop('disabled', true);
                                                       $btn.html('<i class="bi bi-arrow-repeat"></i> Adding...');

                                                       // Serialize & POST
                                                       $.post('ajax/code.php', $form.serialize(), null, 'json')
                                                            .done(function(response) {
                                                                 const icon = response.status === 'success' ? 'success' : 'error';

                                                                 Swal.fire({
                                                                      position: 'top-end',
                                                                      icon,
                                                                      title: response.message,
                                                                      toast: true,
                                                                      showConfirmButton: false,
                                                                      timer: 2000,
                                                                      background: 'white',
                                                                      customClass: {
                                                                           popup: 'small-swal'
                                                                      }
                                                                 });

                                                                 if (response.status === 'success') {
                                                                      // Update button state
                                                                      if ($btn.hasClass('btn-primary')) {
                                                                           $btn
                                                                                .removeClass('btn-primary')
                                                                                .addClass('btn-warning')
                                                                                .html('<i class="bi bi-arrow-repeat"></i> Update Quantity');
                                                                      }
                                                                      
                                                                      // Trigger cart count update
                                                                      if (typeof updateCartCount === 'function') {
                                                                           updateCartCount();
                                                                      }
                                                                 }
                                                            })
                                                            .fail(function() {
                                                                 Swal.fire({
                                                                      position: 'top-end',
                                                                      icon: 'error',
                                                                      title: 'An error occurred.',
                                                                      toast: true,
                                                                      showConfirmButton: false,
                                                                      timer: 2000,
                                                                      background: 'white',
                                                                      customClass: {
                                                                           popup: 'small-swal'
                                                                      }
                                                                 });
                                                            })
                                                            .always(function() {
                                                                 // Reset button state
                                                                 $btn.prop('disabled', false);
                                                                 // Restore correct text/icon
                                                                 if ($btn.hasClass('btn-warning')) {
                                                                      $btn.html('<i class="bi bi-arrow-repeat"></i> Update Quantity');
                                                                 } else if ($btn.hasClass('btn-primary')) {
                                                                      $btn.html('<i class="bi bi-cart-plus"></i> Add to Cart');
                                                                 }
                                                            });
                                                  });
                                             </script>

                                             <div class="product-add-to-cart js-product-add-to-cart">
                                                  <div class="product-quantity-container" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; justify-content: space-between; padding: 1rem; border: 1px solid #eee; border-radius: 8px; background: #fafafa;">

                                                       <!-- Quantity Selector -->
                                                       <div class="qty-selector" style="display: flex; align-items: center; gap: 0.5rem;">
                                                            <button type="button" class="qty-btn" onclick="changeQty(<?php echo $product_id ?>, -1)">–</button>

                                                            <input type="number"
                                                                 id="quantity_wanted_<?php echo $product_id ?>"
                                                                 name="quantity_wanted"
                                                                 value="<?php echo $cart_quantity ?>"
                                                                 min="1"
                                                                 max="<?php echo $product['sale_out_limit'] === 'no limit' ? $stock_qty : min($stock_qty, $product['sale_out_limit']); ?>"
                                                                 data-max-stock="<?php echo $stock_qty ?>"
                                                                 data-max-limit="<?php echo $product['sale_out_limit'] ?>"
                                                                 class="qty-input"
                                                                 style="width: 60px; text-align: center; border: 1px solid #ccc; border-radius: 4px; padding: 4px;" />

                                                            <button type="button" class="qty-btn" onclick="changeQty(<?php echo $product_id ?>, +1)">+</button>
                                                       </div>

                                                       <!-- Cart Button -->
                                                       <div class="cart-action">
                                                            <form id="cartForm_<?php echo $product_id ?>" class="cart-form d-inline">
                                                                 <input type="hidden" name="add_to_cart_btn" value="true">
                                                                 <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                                                                 <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['product_name']) ?>">
                                                                 <input type="hidden" name="selling_price" value="<?php echo $product['selling_price'] ?>">
                                                                 <input type="hidden" name="image" value="<?php echo htmlspecialchars($primaryImg) ?>">
                                                                 <input type="hidden" name="quantity" id="quantity_field_<?php echo $product_id ?>" value="<?php echo $cart_quantity ?>">

                                                                 <?php if ($in_cart == 0): ?>
                                                                      <button type="button"
                                                                           class="btn btn-primary cart-btn"
                                                                           data-product-id="<?php echo $product_id ?>">
                                                                           <i class="bi bi-cart-plus"></i> Add to Cart
                                                                      </button>
                                                                 <?php else: ?>
                                                                      <button type="button"
                                                                           class="btn btn-warning cart-btn"
                                                                           data-product-id="<?php echo $product_id ?>">
                                                                           <i class="bi bi-arrow-repeat"></i> Update Quantity
                                                                      </button>
                                                                 <?php endif; ?>


                                                            </form>
                                                       </div>

                                                       <!-- Wishlist -->
                                                       <div class="wishlist-action">
                                                           
                                                            <a href="javascript:void(0)" class="btn btn-outline-danger st-wishlist-button btn-product btn"  title="Add to Wishlist" data-product-id="<?php echo $product_id ?>"
                                                                 data-product-name="<?php echo htmlspecialchars($product['product_name']) ?>"
                                                                 data-selling-price="<?php echo $product['selling_price'] ?>"
                                                                 data-image="<?php echo htmlspecialchars($primaryImg) ?>">
                                                                 <span class="st-wishlist-bt-content">
                                                                      <i class="fa fa-heart" aria-hidden="true"></i>
                                                                      <span class="ajax_wishlist_text">Add to Wishlist</span>
                                                                 </span>
                                                            </a>
                                                       </div>
                                                  </div>


                                                  <div class="clearfix"></div>

                                                  <span id="product-availability" class="js-product-availability">
                                                       <?php if ($stock_qty > 0): ?>
                                                            <span class="product-available"><i class="material-icons">&#xE5CA;</i> In Stock</span>
                                                       <?php else: ?>
                                                            <span class="product-unavailable"><i class="material-icons">&#xE5CA;</i> Out of Stock</span>
                                                       <?php endif; ?>
                                                  </span>
                                             </div>


                                             <div class="product-additional-info js-product-additional-info">


                                                  <div class="trust_badge_block">
                                                       <div class="trust_badge_image">
                                                            <h6><span>Guarantee Safe Checkout</span></h6>
                                                            <img
                                                                 class="lazyload"
                                                                 src="assets/img/payment-badge.png"
                                                                 alt="Guarantee Safe Checkout"
                                                                 width="501"
                                                                 height="35" />
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>


                              </div>
                         </div>

                         <section class="product-tabcontent">

                              <div class="tabs">
                                   <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                             <a
                                                  class="nav-link active js-product-nav-active"
                                                  data-toggle="tab"
                                                  href="#description"
                                                  role="tab"
                                                  aria-controls="description"
                                                  aria-selected="true">Description</a>
                                        </li>

                                        <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#custom_tab_1" role="tab">
                                                  Size Guide
                                             </a>
                                        </li>
                                        <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#custom_tab_2" role="tab">
                                                  Shipping &amp; Return
                                             </a>
                                        </li>


                                   </ul>

                                   <div class="tab-content" id="tab-content">
                                        <div class="tab-pane fade in active js-product-tab-active" id="description" role="tabpanel">

                                             <div class="product-description">
                                                  <h4>About this item</h4>
                                                  <p><?= $product['description']; ?></p>

                                             </div>

                                        </div>

                                        <div class="tab-pane fade in customtab" id="custom_tab_1" role="tabpanel">

                                             <p>Finding the perfect fit is essential for a comfortable and flattering wardrobe. To assist you in selecting the right size, we have compiled comprehensive size guides for both men's and women's clothing. Please refer to the following information to ensure a perfect fit every time</p>
                                             <div class="table-scroll">
                                                  <table class="table table-bordered">
                                                       <thead>
                                                            <tr>
                                                                 <th>Size</th>
                                                                 <th>Chest (inches)</th>
                                                                 <th>Waist (inches)</th>
                                                                 <th>Hips (inches)</th>
                                                                 <th>Neck (inches)</th>
                                                                 <th>Sleeve Length (inches)</th>
                                                                 <th>Inseam (inches)</th>
                                                            </tr>
                                                       </thead>
                                                       <tbody>
                                                            <tr>
                                                                 <td>XS</td>
                                                                 <td>34-36</td>
                                                                 <td>28-30</td>
                                                                 <td>34-36</td>
                                                                 <td>14.5-15</td>
                                                                 <td>32-33</td>
                                                                 <td>30-31</td>
                                                            </tr>
                                                            <tr>
                                                                 <td>S</td>
                                                                 <td>36-38</td>
                                                                 <td>30-32</td>
                                                                 <td>36-38</td>
                                                                 <td>15-15.5</td>
                                                                 <td>33-34</td>
                                                                 <td>31-32</td>
                                                            </tr>
                                                            <tr>
                                                                 <td>M</td>
                                                                 <td>38-40</td>
                                                                 <td>32-34</td>
                                                                 <td>38-40</td>
                                                                 <td>15.5-16</td>
                                                                 <td>34-35</td>
                                                                 <td>32-33</td>
                                                            </tr>
                                                            <tr>
                                                                 <td>L</td>
                                                                 <td>40-42</td>
                                                                 <td>34-36</td>
                                                                 <td>40-42</td>
                                                                 <td>16-16.5</td>
                                                                 <td>35-36</td>
                                                                 <td>33-34</td>
                                                            </tr>
                                                            <tr>
                                                                 <td>XL</td>
                                                                 <td>42-44</td>
                                                                 <td>36-38</td>
                                                                 <td>42-44</td>
                                                                 <td>16.5-17</td>
                                                                 <td>36-37</td>
                                                                 <td>34-35</td>
                                                            </tr>
                                                            <tr>
                                                                 <td>XXL</td>
                                                                 <td>44-46</td>
                                                                 <td>38-40</td>
                                                                 <td>44-46</td>
                                                                 <td>17-17.5</td>
                                                                 <td>37-38</td>
                                                                 <td>35-36</td>
                                                            </tr>
                                                            <tr>
                                                                 <td>XXXL</td>
                                                                 <td>46-48</td>
                                                                 <td>40-42</td>
                                                                 <td>46-48</td>
                                                                 <td>17.5-18</td>
                                                                 <td>38-39</td>
                                                                 <td>36-37</td>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             </div>
                                        </div>
                                        <div class="tab-pane fade in customtab" id="custom_tab_2" role="tabpanel">
                                             <h4>Shipping Policy</h4>
                                             <p>At our marketplace, we prioritize fast and reliable delivery for all our customers in Kenya. We offer several shipping options, including standard and express delivery, to suit your needs. Our team works to process and dispatch your orders quickly, aiming to deliver within the estimated timeframe.</p>
                                             <p>Key shipping details:</p>
                                             <ul>
                                                  <li>Dispatch: Within 24 hours after payment confirmation</li>
                                                  <li>Free shipping on all products for orders above KES 10,000</li>
                                                  <li>Delivery within Kenya: 2 to 4 business days</li>
                                                  <li>International delivery: 5 to 10 business days</li>
                                                  <li>Cash on delivery available for select locations</li>
                                                  <li>Easy 30-day returns and exchanges</li>
                                             </ul>
                                             <p>Note: Delivery times are estimates and may vary due to product availability, destination, or courier delays.</p>
                                             <h4>Returns Policy</h4>
                                             <p>Your satisfaction is our priority. If you are not happy with your order, you can return eligible items for a refund or exchange. Refunds are processed to your bank account or mobile money (e.g., M-Pesa) as per your preference. Please review our full return policy for details and exclusions.</p>
                                             <ol>
                                                  <li>Returned items must be unused, undamaged, and in original condition.</li>
                                                  <li>All original tags, labels, and packaging must be included.</li>
                                                  <li>Proof of purchase (order confirmation or receipt) is required for all returns.</li>
                                             </ol>
                                        </div>


                                   </div>
                              </div>

                         </section>


                         <section class="productscategory-products products-section clearfix">
                              <div class="container">
                                   <?php
                                   // Make sure $product refers to the current (opened) product:
                                   // (This $product array must already be fetched above via its ID.)
                                   $category_name = mysqli_real_escape_string($conn, $product['category_name'] ?? '');
                                   $current_id    = intval($product['id']);

                                   // Fetch up to 8 other products in the same category, excluding the current product
                                   $related_query = "
                                        SELECT p.*,
                                             c.id   AS category_id,
                                             c.name AS category_name,
                                             (
                                                  SELECT COUNT(*)
                                                  FROM cart
                                                  WHERE cart.product_id = p.id
                                                  AND (
                                                       cart.session_id = '" . session_id() . "'
                                                       OR cart.user_id   = '" . ($_SESSION['auth_user']['id'] ?? '0') . "'
                                                  )
                                                  AND (cart.cart_status IS NULL OR cart.cart_status != 'processed')
                                             ) AS in_cart,
                                             (
                                                  SELECT COUNT(*)
                                                  FROM favorite
                                                  WHERE favorite.product_id = p.id
                                                  AND (
                                                       favorite.session_id = '" . session_id() . "'
                                                       OR favorite.user_id  = '" . ($_SESSION['auth_user']['id'] ?? '0') . "'
                                                  )
                                             ) AS in_favorite
                                        FROM products AS p
                                        LEFT JOIN categories AS c ON p.category_name = c.name
                                        WHERE p.status = 1
                                        AND p.category_name = '$category_name'
                                        AND p.id != $current_id
                                        ORDER BY RAND()
                                        LIMIT 8
                                   ";
                                   $related_run   = mysqli_query($conn, $related_query);
                                   $related_count = mysqli_num_rows($related_run);
                                   ?>

                                   <h2 style="color: #333;" class="h1 products-section-title text-uppercase">
                                        <?= $related_count ?> other product<?= ($related_count == 1 ? '' : 's') ?> in the same category:
                                   </h2>

                                   <div class="products-wrapper">
                                        <div class="products">
                                             <div id="productscategory-carousel" class="cz-carousel product_list">
                                                  <?php
                                                  if ($related_count > 0) {
                                                       while ($related = mysqli_fetch_assoc($related_run)) {
                                                            // If your `includes/product-card-template.php` expects $product,
                                                            // temporarily assign $product = $related before including.
                                                            $product = $related;
                                                            include 'includes/product-card-template.php';
                                                       }
                                                  } else {
                                                       echo "<p>No other products in this category.</p>";
                                                  }
                                                  ?>
                                             </div>

                                             <div class="customNavigation">
                                                  <a class="btn prev productscategory_prev">Prev</a>
                                                  <a class="btn next productscategory_next">Next</a>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </section>
                         <!-- Define Number of product for SLIDER -->

                         <section style="margin-bottom: 100px;" class="product-accessories products-section clearfix">
                              <h2 style="color: #333;" class="h1 products-section-title text-uppercase">
                                   You might also like
                              </h2>

                              <div class="product-wrapper">
                                   <div class="products">
                                        <div id="accessories-carousel" class="cz-carousel product_list">
                                             <?php
                                             // Suggest 4 random products from different categories (not current), excluding current product
                                             $product_id = intval($product['id']);
                                             $category_name = mysqli_real_escape_string($conn, $product['category_name'] ?? '');

                                             $accessories_query = "
                                                  SELECT products.*, categories.name AS category_name
                                                  FROM products
                                                  LEFT JOIN categories ON products.category_name = categories.name
                                                  WHERE products.status = 1
                                                       AND products.id != $product_id
                                                       AND products.category_name != '$category_name'
                                                  ORDER BY RAND()
                                                  LIMIT 10
                                             ";
                                             $accessories_query_run = mysqli_query($conn, $accessories_query);

                                             if (mysqli_num_rows($accessories_query_run) > 0) {
                                                  while ($accessory = mysqli_fetch_assoc($accessories_query_run)) {
                                                       // Ensure category_id is set for the product card template
                                                       if (!isset($accessory['category_id'])) {
                                                            // Try to fetch category_id from categories table if missing
                                                            $cat_name = mysqli_real_escape_string($conn, $accessory['category_name'] ?? '');
                                                            $cat_id_result = mysqli_query($conn, "SELECT id FROM categories WHERE name = '$cat_name' LIMIT 1");
                                                            $cat_id_row = mysqli_fetch_assoc($cat_id_result);
                                                            $accessory['category_id'] = $cat_id_row['id'] ?? null;
                                                       }
                                                       $product = $accessory;
                                                       include 'includes/product-card-template.php';
                                                  }
                                             } else {
                                                  echo "<p>No suggestions available.</p>";
                                             }
                                             ?>
                                        </div>

                                        <div class="customNavigation">
                                             <a class="btn prev accessories_prev">&nbsp;</a>
                                             <a class="btn next accessories_next">&nbsp;</a>
                                        </div>

                                   </div>
                              </div>
                         </section>

                         <!-- Product FAQ Section -->
                         <section class="product-faq-section" style="margin: 40px 0; font-family: 'Segoe UI', sans-serif;">
                              <div class="container" style="max-width: 800px; margin: auto;">
                                   <h2 class="section-title" style="text-align: center; color: #222; font-size: 2em; margin-bottom: 30px;">
                                        FAQs About This Product
                                   </h2>

                                   <div class="faq-item">
                                        <input type="checkbox" id="faq1" class="faq-toggle">
                                        <label for="faq1" class="faq-question">
                                             <span><i class="fa fa-credit-card"></i> What payment methods do you accept?</span>
                                        </label>
                                        <div class="faq-answer">
                                             We accept M-Pesa, Paystack (card & mobile), credit/debit cards, and bank transfers. Cash on delivery is available for select regions.
                                        </div>
                                   </div>

                                   <div class="faq-item">
                                        <input type="checkbox" id="faq2" class="faq-toggle">
                                        <label for="faq2" class="faq-question">
                                             <span><i class="fa fa-truck"></i> How do I track my order?</span>
                                        </label>
                                        <div class="faq-answer">
                                             Once your order is shipped, you'll receive a tracking number via SMS or email to monitor progress on our site.
                                        </div>
                                   </div>

                                   <div class="faq-item">
                                        <input type="checkbox" id="faq3" class="faq-toggle">
                                        <label for="faq3" class="faq-question">
                                             <span><i class="fa fa-edit"></i> Can I change or cancel my order?</span>
                                        </label>
                                        <div class="faq-answer">
                                             You can modify or cancel your order before it's confirmed. For confirmed orders, contact our support team.
                                        </div>
                                   </div>

                                   <div class="faq-item">
                                        <input type="checkbox" id="faq4" class="faq-toggle">
                                        <label for="faq4" class="faq-question">
                                             <span><i class="fa fa-shield"></i> Is there a warranty on this product?</span>
                                        </label>
                                        <div class="faq-answer">
                                             Most products include a standard manufacturer warranty. Please see the product details or contact us for specifics.
                                        </div>
                                   </div>
                              </div>

                              <style>
                                   .faq-item {
                                        margin-bottom: 15px;
                                        border: 1px solid #ddd;
                                        border-radius: 8px;
                                        background-color: #fff;
                                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
                                   }

                                   .faq-question {
                                        display: block;
                                        padding: 15px 20px;
                                        cursor: pointer;
                                        font-weight: 600;
                                        font-size: 1rem;
                                        color: #333;
                                        transition: background 0.3s;
                                   }

                                   .faq-question:hover {
                                        background-color: #f7faff;
                                   }

                                   .faq-question i {
                                        color: #007bff;
                                        margin-right: 10px;
                                        font-size: 1.1em;
                                   }

                                   .faq-toggle {
                                        display: none;
                                   }

                                   .faq-answer {
                                        max-height: 0;
                                        overflow: hidden;
                                        transition: max-height 0.3s ease, padding 0.3s ease;
                                        padding: 0 20px;
                                        color: #444;
                                        background-color: #fafafa;
                                   }

                                   .faq-toggle:checked+.faq-question+.faq-answer {
                                        max-height: 300px;
                                        padding: 15px 20px 20px;
                                   }
                              </style>
                         </section>

                         <!-- Product Images Modal -->
                         <div class="modal fade js-product-images-modal" id="product-modal">
                              <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                        <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true"><i class="material-icons">close</i></span>
                                             </button>
                                        </div>
                                        <div class="modal-body">
                                             <figure>
                                                  <?php if (!empty($gallery_images)): ?>
                                                       <img
                                                            class="js-modal-product-cover product-cover-modal"
                                                            width="1000"
                                                            src="<?= htmlspecialchars($gallery_images[0]) ?>"
                                                            alt="<?= htmlspecialchars($product['product_name']) ?>"
                                                            title="<?= htmlspecialchars($product['product_name']) ?>"
                                                            height="1000">
                                                  <?php else: ?>
                                                       <img
                                                            class="js-modal-product-cover product-cover-modal"
                                                            width="1000"
                                                            src="uploads/shop/<?= htmlspecialchars($product['image']) ?>"
                                                            alt="<?= htmlspecialchars($product['product_name']) ?>"
                                                            title="<?= htmlspecialchars($product['product_name']) ?>"
                                                            height="1000">
                                                  <?php endif; ?>
                                                  <figcaption class="image-caption">
                                                       <div id="product-description-short">
                                                            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                                                       </div>
                                                  </figcaption>
                                             </figure>
                                             <aside id="thumbnails" class="thumbnails js-thumbnails text-xs-center">
                                                  <div class="js-modal-mask mask nomargin">
                                                       <ul class="product-images js-modal-product-images">
                                                            <?php if (!empty($gallery_images)): ?>
                                                                 <?php foreach ($gallery_images as $index => $path): ?>
                                                                      <li class="thumb-container js-thumb-container">
                                                                           <img
                                                                                data-image-large-src="<?= htmlspecialchars($path) ?>"
                                                                                class="thumb js-modal-thumb <?= $index === 0 ? 'selected' : '' ?>"
                                                                                src="<?= htmlspecialchars($path) ?>"
                                                                                alt="<?= htmlspecialchars($product['product_name']) ?>"
                                                                                title="<?= htmlspecialchars($product['product_name']) ?>"
                                                                                width="250">
                                                                      </li>
                                                                 <?php endforeach; ?>
                                                            <?php else: ?>
                                                                 <li class="thumb-container js-thumb-container">
                                                                      <img
                                                                           data-image-large-src="uploads/shop/<?= htmlspecialchars($product['image']) ?>"
                                                                           class="thumb js-modal-thumb selected"
                                                                           src="uploads/shop/<?= htmlspecialchars($product['image']) ?>"
                                                                           alt="<?= htmlspecialchars($product['product_name']) ?>"
                                                                           title="<?= htmlspecialchars($product['product_name']) ?>"
                                                                           width="250">
                                                                 </li>
                                                            <?php endif; ?>
                                                       </ul>
                                                  </div>
                                             </aside>
                                        </div>
                                   </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                         </div><!-- /.modal -->

                         <?php
                         // Make sure session is started so we can read $_SESSION['auth_user']
                         if (session_status() === PHP_SESSION_NONE) {
                              session_start();
                         }

                         // Pre-fill variables
                         $prefill_name  = '';
                         $prefill_email = '';

                         if (!empty($_SESSION['auth']) && $_SESSION['auth'] === true && !empty($_SESSION['auth_user'])) {
                              // You can choose to use 'display_name' or combine first+last name:
                              $prefill_name  = trim($_SESSION['auth_user']['display_name'] ??
                                   ($_SESSION['auth_user']['first_name'] . ' ' . $_SESSION['auth_user']['last_name']));
                              $prefill_email = $_SESSION['auth_user']['email'] ?? '';
                         }

                         // We still need $productId so the form knows which product to attach feedback to:
                         $productId = intval($product['id']);
                         ?>

                         <!-- Feedback Modal -->
                         <!-- Feedback Modal -->
                         <div
                              class="modal fade"
                              id="feedback-modal"
                              tabindex="-1"
                              role="dialog"
                              aria-labelledby="feedback-modal-label"
                              aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                   <div class="modal-content">
                                        <div class="modal-header">
                                             <h5 class="modal-title" id="feedback-modal-label">Leave Your Review</h5>
                                             <button
                                                  type="button"
                                                  class="close"
                                                  data-dismiss="modal"
                                                  aria-label="Close">
                                                  <span aria-hidden="true"><i class="material-icons">close</i></span>
                                             </button>
                                        </div>

                                        <div class="modal-body">
                                             <!-- 1) Container for server-returned messages -->
                                             <div id="feedback-alert"></div>

                                             <form
                                                  id="feedback-form"
                                                  action="submit_feedback.php"
                                                  method="post"
                                                  enctype="multipart/form-data"
                                                  class="needs-validation"
                                                  novalidate>
                                                  <!-- Hidden field for product_id -->
                                                  <input type="hidden" name="product_id" value="<?= $productId ?>">

                                                  <div class="form-row">
                                                       <!-- Name (readonly if logged in) -->
                                                       <div class="form-group col-md-6">
                                                            <label for="fb_name">Your Name <span class="text-danger">*</span></label>
                                                            <input
                                                                 type="text"
                                                                 class="form-control"
                                                                 id="fb_name"
                                                                 name="name"
                                                                 placeholder="John Doe"
                                                                 required
                                                                 maxlength="100"
                                                                 <?php if ($prefill_name !== ''): ?>
                                                                 value="<?= htmlspecialchars($prefill_name, ENT_QUOTES, 'UTF-8') ?>"
                                                                 readonly
                                                                 <?php endif; ?>>
                                                            <div class="invalid-feedback">Please enter your name.</div>
                                                       </div>

                                                       <!-- Email (readonly if logged in) -->
                                                       <div class="form-group col-md-6">
                                                            <label for="fb_email">Your Email <span class="text-danger">*</span></label>
                                                            <input
                                                                 type="email"
                                                                 class="form-control"
                                                                 id="fb_email"
                                                                 name="email"
                                                                 placeholder="you@example.com"
                                                                 required
                                                                 maxlength="150"
                                                                 <?php if ($prefill_email !== ''): ?>
                                                                 value="<?= htmlspecialchars($prefill_email, ENT_QUOTES, 'UTF-8') ?>"
                                                                 readonly
                                                                 <?php endif; ?>>
                                                            <div class="invalid-feedback">Please enter a valid email address.</div>
                                                       </div>
                                                  </div>

                                                  <!-- Title -->
                                                  <div class="form-group">
                                                       <label for="fb_title">Review Title <span class="text-danger">*</span></label>
                                                       <input
                                                            type="text"
                                                            class="form-control"
                                                            id="fb_title"
                                                            name="title"
                                                            placeholder="Great product!"
                                                            required
                                                            maxlength="150">
                                                       <div class="invalid-feedback">Please give your review a title.</div>
                                                  </div>

                                                  <!-- Feedback Text -->
                                                  <div class="form-group">
                                                       <label for="fb_feedback">Your Feedback <span class="text-danger">*</span></label>
                                                       <textarea
                                                            class="form-control"
                                                            id="fb_feedback"
                                                            name="feedback"
                                                            rows="5"
                                                            placeholder="Write what you think about this product…"
                                                            required
                                                            maxlength="2000"></textarea>
                                                       <div class="invalid-feedback">Please write your feedback.</div>
                                                  </div>

                                                  <!-- Optional Image Upload -->
                                                  <div class="form-group">
                                                       <label for="fb_image">Upload an Image (optional)</label>
                                                       <input
                                                            type="file"
                                                            class="form-control-file"
                                                            id="fb_image"
                                                            name="image"
                                                            accept="image/jpeg,image/png,image/gif">
                                                       <small class="form-text text-muted">JPEG, PNG or GIF; max size 2 MB.</small>
                                                  </div>

                                                  <div class="modal-footer">
                                                       <button
                                                            type="button"
                                                            class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                            Cancel
                                                       </button>
                                                       <button type="submit" class="btn btn-primary" id="feedback-submit-btn">
                                                            Submit Review
                                                       </button>
                                                  </div>
                                             </form>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <script>
                              document.addEventListener('DOMContentLoaded', function() {
                                   const feedbackForm = document.getElementById('feedback-form');
                                   const submitBtn = document.getElementById('feedback-submit-btn');

                                   feedbackForm.addEventListener('submit', function(event) {
                                        event.preventDefault(); // Prevent normal form submission

                                        // Disable the submit button to prevent double-click
                                        submitBtn.disabled = true;
                                        submitBtn.textContent = 'Submitting…';

                                        // Build a FormData object (will include file if provided)
                                        const formData = new FormData(feedbackForm);

                                        fetch(feedbackForm.action, {
                                                  method: 'POST',
                                                  headers: {
                                                       'X-Requested-With': 'XMLHttpRequest' // let PHP know it's AJAX
                                                  },
                                                  body: formData
                                             })
                                             .then(response => response.json())
                                             .then(data => {
                                                  // Re-enable button
                                                  submitBtn.disabled = false;
                                                  submitBtn.textContent = 'Submit Review';

                                                  // data = { success: true/false, message: "…" }
                                                  if (data.success) {
                                                       Swal.fire({
                                                            toast: true,
                                                            position: 'top-end',
                                                            icon: 'success',
                                                            title: data.message,
                                                            showConfirmButton: false,
                                                            timer: 2000,
                                                            background: 'white',
                                                            customClass: {
                                                                 container: 'my-swal-container'
                                                            }
                                                       });

                                                       // Optionally reset form (except read-only fields)
                                                       feedbackForm.reset();

                                                       // Close modal after 2 seconds
                                                       setTimeout(() => {
                                                            $('#feedback-modal').modal('hide'); // Bootstrap 4/5 example
                                                       }, 2000);

                                                  } else {
                                                       Swal.fire({
                                                            toast: true,
                                                            position: 'top-end',
                                                            icon: 'error',
                                                            title: data.message,
                                                            showConfirmButton: false,
                                                            timer: 2000,
                                                            background: 'white',
                                                            customClass: {
                                                                 container: 'my-swal-container'
                                                            }
                                                       });
                                                  }
                                             })
                                             .catch(err => {
                                                  submitBtn.disabled = false;
                                                  submitBtn.textContent = 'Submit Review';

                                                  Swal.fire({
                                                       toast: true,
                                                       position: 'top-end',
                                                       icon: 'error',
                                                       title: 'An unexpected error occurred. Please try again.',
                                                       showConfirmButton: false,
                                                       timer: 2000,
                                                       background: 'white',
                                                       customClass: {
                                                            container: 'my-swal-container'
                                                       }
                                                  });

                                                  console.error('Error submitting feedback:', err);
                                             });
                                   });
                              });
                         </script>



                         <!-- Optional: Client-side validation script (Bootstrap 4/5) -->
                         <script>
                              (function() {
                                   'use strict';
                                   window.addEventListener('load', function() {
                                        var forms = document.getElementsByClassName('needs-validation');
                                        Array.prototype.filter.call(forms, function(form) {
                                             form.addEventListener('submit', function(event) {
                                                  if (!form.checkValidity()) {
                                                       event.preventDefault();
                                                       event.stopPropagation();
                                                  }
                                                  form.classList.add('was-validated');
                                             }, false);
                                        });
                                   }, false);
                              })();
                         </script>



               </div>
</section>


<?php include 'includes/footer.php'; ?>