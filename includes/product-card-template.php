<?php
// inside the products‐render loop, before the <article> tag
$pid = (int)$product['id'];

// Fetch primary image
$imgQ1 = mysqli_query(
     $conn,
     "SELECT image_path 
FROM product_images 
WHERE product_id = {$pid} 
  AND is_primary = 1 
LIMIT 1"
);
$primaryImg = ($imgR1 = mysqli_fetch_assoc($imgQ1)) ? $imgR1['image_path'] : 'uploads/shop/default.png';

// Fetch secondary image
$imgQ2 = mysqli_query(
     $conn,
     "SELECT image_path 
FROM product_images 
WHERE product_id = {$pid} 
  AND is_primary = 0 
ORDER BY id ASC 
LIMIT 1"
);
$secondaryImg = ($imgR2 = mysqli_fetch_assoc($imgQ2)) ? $imgR2['image_path'] : $primaryImg;

// Fetch actual cart quantity
$session_id = session_id();
$user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : 0;
$cartQ = mysqli_query(
     $conn,
     "SELECT quantity 
FROM cart 
WHERE product_id = {$pid} 
  AND (session_id = '{$session_id}' OR user_id = {$user_id})
  AND (cart_status IS NULL OR cart_status != 'processed')
LIMIT 1"
);
$product['in_cart'] = ($cartR = mysqli_fetch_assoc($cartQ)) ? $cartR['quantity'] : 0;

?>
<article class="product_item slider_item">
     <div class="product-miniature js-product-miniature"
          data-id-product="<?= $product['id']; ?>">

          <div class="thumbnail-container">
               <a href="shop-product.php?id=<?= $product['id']; ?>" class="thumbnail product-thumbnail">
                    <img
                         class="lazyload primary-img"
                         src="themes/Electech/assets/img/codezeel/lazy-loader.svg"
                         data-src="<?= htmlspecialchars($primaryImg); ?>"
                         alt="<?= htmlspecialchars($product['product_name']); ?>"
                         width="250"
                         height="250">
                    <img
                         class="lazyload secondary-img fliper_image img-responsive"
                         src="themes/Electech/assets/img/codezeel/lazy-loader.svg"
                         data-src="<?= htmlspecialchars($secondaryImg); ?>"
                         alt="Flip image of <?= htmlspecialchars($product['product_name']); ?>"
                         width="250"
                         height="250">
               </a>
               <style>
                    .product-thumbnail img {
                         max-width: 250px;
                         max-height: 250px;
                         width: auto;
                         height: auto;
                         display: block;
                    }
               </style>


               <ul class="product-flags js-product-flags">
                    <li class="product-flag on-sale">On sale!</li>
                    <li><i class="material-icons left">&#xe3e7;</i><?= $product['discount'] ?? ''; ?></li>
                    <li class="product-flag new"><?= $product['featured']; ?></li>
               </ul>

               <div class="outer-functional">
                    <div class="functional-buttons">
                         <div class="wishlist">
                              <a class="st-wishlist-button btn-product btn"
                                   href="javascript:void(0);"
                                   data-product-id="<?= $product['id']; ?>"
                                   data-product-name="<?= $product['product_name']; ?>"
                                   data-selling-price="<?= $product['selling_price']; ?>"
                                   data-image="<?= $product['image']; ?>">
                                   <span class="st-wishlist-bt-content">
                                        <?php if ($product['in_favorite'] > 0): ?>
                                             <i class="fa fa-heart" aria-hidden="true"></i>
                                        <?php else: ?>
                                             <i class="fi-rs-heart"></i>
                                        <?php endif; ?>
                                   </span>
                              </a>
                         </div>

                         <div class="quickview">
                              <a href="#" class="quick-view-btn text-blue-600 hover:underline"
                                   data-product-id="<?= $product['id']; ?>">Quick View</a>
                         </div>
                    </div>
               </div>
          </div>

          <div class="product-description">
               <div class="brand-title" itemprop="name">
                    <a href="?id=<?= $category_id; ?>&brand=<?= urlencode($product['brand_name']); ?>">
                         <?= htmlspecialchars($product['brand_name']); ?>
                    </a>
               </div>

               <h3 class="h3 product-title">
                    <a href="shop-product.php?id=<?= $product['id']; ?>">
                         <?= htmlspecialchars($product['product_name']); ?>
                    </a>
               </h3>

               <div class="comments_note">
                    <div class="star_content clearfix">
                         <?php
                         $rating = $product['rating'] ?? 0;
                         for ($i = 0; $i < 5; $i++) {
                              echo '<div class="star' . ($i < $rating ? ' star_on' : '') . '"></div>';
                         }
                         ?>
                    </div>
               </div>

               <div class="product-price-and-shipping">
                    <span class="regular-price">Kes <?= $product['original_price']; ?></span>
                    <span class="price">Kes <?= $product['selling_price']; ?></span>
               </div>

               <div class="proaction-button">
                    <form id="cartForm_<?= $product['id']; ?>" method="POST" action="">
                         <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                         <input type="hidden" name="add_to_cart_btn" value="true">
                         <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['product_name']); ?>">
                         <input type="hidden" name="selling_price" value="<?= $product['selling_price']; ?>">
                         <input type="hidden" name="image" value="<?= $product['image']; ?>">
                         <input type="hidden" name="quantity" value="1">

                         <?php if (!isset($product['in_cart']) || $product['in_cart'] == 0): ?>
                              <button class="btn btn-primary add-to-cart" type="button" onclick="addToCart('cartForm_<?= $product['id']; ?>');">
                                   Add to cart
                              </button>
                         <?php elseif ($product['in_cart'] > 0): ?>
                              <button class="btn btn-success add-to-cart" type="button" disabled>
                                   In Cart (<?= $product['in_cart']; ?>)
                              </button>
                         <?php elseif ($product['in_cart'] === 'out_of_stock'): ?>
                              <span class="action-btn hover-up btn-primary add-to-cart">Out of Stock</span>
                         <?php elseif ($product['in_cart'] === 'not_available'): ?>
                              <span class="action-btn hover-up btn-primary add-to-cart">Not Available</span>
                         <?php elseif ($product['in_cart'] === 'not_allowed'): ?>
                         <?php else: ?>
                              <button class="btn btn-success add-to-cart" type="button" disabled>
                                   In Cart
                              </button>
                         <?php endif; ?>

                         <style>
                              .btn-primary.add-to-cart {
                                   transition: all 0.3s ease;
                              }

                              .btn-primary.add-to-cart.added,
                              .btn-success.add-to-cart {
                                   background-color: #28a745;
                                   border-color: #28a745;
                                   cursor: not-allowed;
                                   opacity: 0.8;
                              }

                              .btn-success.add-to-cart:disabled {
                                   cursor: not-allowed;
                                   opacity: 0.8;
                              }
                         </style>
                    </form>
               </div>
          </div>
     </div>
</article>

<script>
     // Only define these functions once
     if (typeof window.cartFunctionsInitialized === 'undefined') {
          window.cartFunctionsInitialized = true;

          function addToCart(formId) {
               var form = $('#' + formId);
               var button = form.find('.add-to-cart');
               var formData = form.serialize();
               var productId = form.find('input[name="product_id"]').val();

               // Disable button immediately to prevent double clicks
               button.prop('disabled', true);

               $.ajax({
                    url: 'ajax/code.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                         if (response.status === 'success') {
                              // Show success message
                              Swal.fire({
                                   position: 'top-end',
                                   icon: 'success',
                                   title: response.message,
                                   showConfirmButton: false,
                                   timer: 2000,
                                   toast: true
                              });

                              // Get the quantity from the response instead of form
                              var quantity = response.quantity || form.find('input[name="quantity"]').val();

                              // Update button state immediately
                              button.removeClass('btn-primary').addClass('btn-success');
                              button.text('In Cart (' + quantity + ')');
                              button.prop('disabled', true);

                              // Update Quick View button if modal is open
                              var quickViewBtn = $('#qc-submit-btn-' + productId);
                              if (quickViewBtn.length) {
                                   quickViewBtn.addClass('success').text('Update Cart');
                              }

                              // Update cart count and dropdown
                              updateCartCount();
                         } else {
                              // Re-enable button on error
                              button.prop('disabled', false);

                              // Show error message
                              Swal.fire({
                                   position: 'top-end',
                                   icon: 'error',
                                   title: response.message,
                                   showConfirmButton: false,
                                   timer: 2000,
                                   toast: true
                              });
                         }
                    },
                    error: function(xhr, status, error) {
                         // Re-enable button on error
                         button.prop('disabled', false);

                         console.error('AJAX Error:', error);
                         Swal.fire({
                              position: 'top-end',
                              icon: 'error',
                              title: 'An error occurred while adding the product to the cart.',
                              showConfirmButton: false,
                              timer: 2000,
                              toast: true
                         });
                    }
               });
          }

          // Function to update cart count and dropdown
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

                              // Update cart items list
                              $('#cart-items-list-mobile, .cart-items-list').html(response.cart_html);

                              // Update cart summary
                              $('#cart-subtotal-products-value').text('Kes ' + (response.total_price - response.shipping_cost).toFixed(2));
                              $('#cart-subtotal-shipping-value').text('Kes ' + response.shipping_cost.toFixed(2));

                              // Update cart button state
                              if (response.total_items > 0) {
                                   $('.shopping-cart').removeClass('empty');
                              } else {
                                   $('.shopping-cart').addClass('empty');
                              }

                              // Update all product card buttons based on cart items
                              $('.add-to-cart').each(function() {
                                   var button = $(this);
                                   var form = button.closest('form');
                                   var productId = form.find('input[name="product_id"]').val();
                                   
                                   // Check if this product is in the cart
                                   var inCart = false;
                                   var cartQuantity = 0;
                                   if (response.cart_items && response.cart_items.length > 0) {
                                        response.cart_items.forEach(function(item) {
                                             if (item.product_id == productId) {
                                                  inCart = true;
                                                  cartQuantity = item.quantity;
                                                  return false;
                                             }
                                        });
                                   }

                                   if (inCart) {
                                        button.removeClass('btn-primary').addClass('btn-success');
                                        button.text('In Cart (' + cartQuantity + ')');
                                        button.prop('disabled', true);
                                   } else {
                                        button.removeClass('btn-success').addClass('btn-primary');
                                        button.text('Add to cart');
                                        button.prop('disabled', false);
                                   }
                              });
                         }
                    },
                    error: function(xhr, status, error) {
                         console.error('Error updating cart:', error);
                    }
               });
          }

          // Listen for cart item removal
          $(document).on('click', '.remove-from-cart', function(e) {
               e.preventDefault();
               e.stopPropagation();
               
               var cartId = $(this).data('cart-id');
               var $itemRow = $(this).closest('.cart-item');
               var productId = $itemRow.find('a[href*="shop-product.php?id="]').attr('href').match(/id=(\d+)/)[1];

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

                                   // Immediately update the product card button
                                   var $cardBtn = $(`#cartForm_${productId} .add-to-cart`);
                                   if ($cardBtn.length) {
                                        $cardBtn.removeClass('btn-success').addClass('btn-primary');
                                        $cardBtn.text('Add to cart');
                                        $cardBtn.prop('disabled', false);
                                   }

                                   // Update cart counts and totals
                                   updateCartCount();

                                   // Show success message
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
                              });
                         } else {
                              // Show error message
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
                         // Show error message
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

          // Initialize all add to cart buttons when document is ready
          $(document).ready(function() {
               $(document).on('click', '.add-to-cart', function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    var formId = form.attr('id');
                    addToCart(formId);
               });

               // Initial cart state update
               updateCartCount();
          });
     }
</script>