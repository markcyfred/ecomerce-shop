//cart
  function addToCart(formId) {
          var formData = $('#' + formId).serialize();
          $.ajax({
               url: 'ajax/code.php',
               type: 'POST',
               data: formData,
               dataType: 'json',
               success: function(response) {
                    if (response.status === 'success') {
                         // Show success message with SweetAlert2
                         Swal.fire({
                              position: 'top-end',
                              icon: 'success',
                              title: response.message,
                              showConfirmButton: false,
                              timer: 2000,
                              toast: true,
                              width: 'auto',
                              padding: '0.1em',
                              background: 'white',
                              customClass: {
                                   popup: 'small-swal'
                              }
                         });
                         
                         // Update UI: Replace the "Add To Cart" button with "Already in Cart" message
                         $('#' + formId + ' .action-btn').replaceWith('<span class="in-cart-message">Already in Cart</span>');

                         // Update cart display
                         updateCartDropdown();
                    } else {
                         // Show error message with SweetAlert2
                         Swal.fire({
                              position: 'top-end',
                              icon: 'error',
                              title: response.message,
                              showConfirmButton: false,
                              timer: 2000,
                              toast: true,
                              width: 'auto',
                              padding: '0.1em',
                              background: 'white',
                              customClass: {
                                   popup: 'small-swal'
                              }
                         });
                    }
               },
               error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    // Show generic error message with SweetAlert2
                    Swal.fire({
                         position: 'top-end',
                         icon: 'error',
                         title: 'An error occurred while adding the product to the cart.',
                         showConfirmButton: false,
                         timer: 2000,
                         toast: true,
                         width: 'auto',
                         padding: '0.1em',
                         background: 'white',
                         customClass: {
                              popup: 'small-swal'
                         }
                    });
               }
          });
     }

       // Wait until DOM is loaded
     document.addEventListener('DOMContentLoaded', function() {
          var cart = document.getElementById('desktop_cart');
          if (!cart) return; // safety check

          cart.addEventListener('click', function(e) {
               // Find the element with class 'mobile_count' inside the cart
               var countEl = cart.querySelector('.mobile_count');
               var count = 0;
               if (countEl) {
                    // parseInt will ignore non-numeric chars and return NaN if none; fallback to 0
                    count = parseInt(countEl.textContent, 10) || 0;
               }

               if (count === 0) {
                    // Stop any default action (like link navigation)
                    e.preventDefault();
                    Swal.fire({
                         icon: 'info',
                         title: 'Your cart is empty',
                         toast: true,
                         position: 'top-end',
                         showConfirmButton: false,
                         timer: 2000,
                         background: 'white',
                         customClass: {
                              popup: 'small-swal'
                         }
                    });
               }
               // If count > 0, click proceeds normally
          });
     });

     //wishlist
     $(function() {
          // Delegate click so it works for dynamically loaded items
          $(document).on('click', '.st-wishlist-button', function(e) {
               e.preventDefault();
               var $btn = $(this);
               var productId = $btn.data('product-id');
               var productName = $btn.data('product-name');
               var sellingPrice = $btn.data('selling-price');
               var image = $btn.data('image');
               
               // Check if already in favorites
               var isInFavorites = $btn.find('i').hasClass('fa-heart');
               
               var sessionData = {
                    add_to_favorite_btn: !isInFavorites,
                    remove_favorite: isInFavorites,
                    product_id: productId,
                    product_name: productName,
                    selling_price: sellingPrice,
                    image: image,
                    quantity: 1
               };

               $.ajax({
                         url: 'ajax/code.php',
                         method: 'POST',
                         dataType: 'json',
                         data: sessionData,
                    })
                    .done(function(response) {
                         if (response.status === 'success') {
                              Swal.fire({
                                   position: 'top-end',
                                   icon: 'success',
                                   title: response.message,
                                   showConfirmButton: false,
                                   timer: 2000,
                                   toast: true,
                                   background: 'white',
                                   customClass: {
                                        popup: 'small-swal'
                                   }
                              });
                              // Toggle heart icon
                              if (isInFavorites) {
                                   $btn.find('i')
                                        .removeClass('fa fa-heart')
                                        .addClass('fi-rs-heart');
                              } else {
                                   $btn.find('i')
                                        .removeClass('fi-rs-heart')
                                        .addClass('fa fa-heart');
                              }
                              // Update favorites display
                              updateFavoritesDisplay();
                         } else {
                              Swal.fire({
                                   position: 'top-end',
                                   icon: 'error',
                                   title: response.message,
                                   showConfirmButton: false,
                                   timer: 2000,
                                   toast: true,
                                   background: 'white',
                                   customClass: {
                                        popup: 'small-swal'
                                   }
                              });
                         }
                    })
                    .fail(function(xhr, status, error) {
                         console.error('Favorite AJAX Error:', error);
                         Swal.fire({
                              position: 'top-end',
                              icon: 'error',
                              title: 'Could not update favorites. Try again.',
                              showConfirmButton: false,
                              timer: 2000,
                              toast: true,
                              background: 'white',
                              customClass: {
                                   popup: 'small-swal'
                              }
                         });
                    });
          });
     });

// ─── AJAX CART & WISHLIST REFRESH ───
function updateCartWishlist() {
    $.ajax({
        url: 'ajax/cart_wishlist.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Update wishlist count
            $('.ap-total-wishlist').text(data.fav_count);

            // Update cart count and price
            $('.mobile_count').text(data.total_items);
            $('.cart-products-count .value').text('Kes ' + Number(data.total_price).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2}));

            // Update cart dropdown items
            var cartHtml = '';
            if (data.cart_items.length > 0) {
                data.cart_items.forEach(function(item) {
                    cartHtml += '<div class="cart-item">' +
                        '<div class="shopping-cart-img">' +
                        '<a href="shop-product.php?id=' + item.product_id + '">' +
                        '<img alt="Evara" src="' + (item.image_path ? item.image_path : 'uploads/shop/default.png') + '" style="width:70px; object-fit:contain; border-radius:6px;">' +
                        '</a></div>' +
                        '<div class="shopping-cart-title">' +
                        '<a href="shop-product.php?id=' + item.product_id + '">' + item.short_name + '</a>' +
                        '<h4><span>' + item.quantity + ' ×</span> kes' + Number(item.selling_price).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2}) + '</h4>' +
                        '</div>' +
                        '<div class="shopping-cart-delete"><a href="#"><i class="fi-rs-cross-small"></i></a></div>' +
                        '</div>';
                });
                $('.cart-items-scrollable').html(cartHtml);
            } else {
                $('.cart-items-scrollable').html('');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching cart/wishlist:', error);
        }
    });
}

// Initial load
$(document).ready(function() {
    updateCartWishlist();
});

// Optionally, call updateCartWishlist() after cart actions as well.

// Function to update cart display
function updateCartDisplay() {
    $.ajax({
        url: 'ajax/cart_update.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Update cart count
                $('.mobile_count').text(response.total_items);
                
                // Update cart total
                $('.cart-products-count .value').text('Kes ' + response.total_price);
                
                // Update cart items
                $('.cart-items-scrollable').html(response.cart_html);
                
                // Update cart button state
                if (response.total_items > 0) {
                    $('.shopping-cart').removeClass('empty');
                } else {
                    $('.shopping-cart').addClass('empty');
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating cart:', error);
        }
    });
}

// Handle remove item from cart
$(document).on('click', '.remove-cart-item', function(e) {
    e.preventDefault();
    const itemId = $(this).data('id');
    
    Swal.fire({
        title: 'Remove Item',
        text: 'Are you sure you want to remove this item from your cart?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'ajax/code.php',
                method: 'POST',
                data: {
                    delete: 'delete_added_to_cart',
                    id: itemId
                },
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
                        
                        // Update cart display
                        updateCartDisplay();
                    } else {
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
                    console.error('Error removing item:', error);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'An error occurred while removing the item',
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true
                    });
                }
            });
        }
    });
});

// Update cart display when page loads
$(document).ready(function() {
    updateCartDisplay();
});

// Function to update favorites display
function updateFavoritesDisplay() {
    $.ajax({
        url: 'ajax/favorites_update.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Update wishlist count in all locations
                $('.ap-total-wishlist').text(response.fav_count);
                $('.wishlist_count_bubble').text(response.fav_count);
                
                // Update wishlist items if container exists
                if ($('.wishlist-items-container').length) {
                    $('.wishlist-items-container').html(response.fav_html);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Favorites Update Error:', error);
        }
    });
}

// Handle remove from favorites
$(document).on('click', '.remove-favorite', function(e) {
    e.preventDefault();
    var favoriteId = $(this).data('id');
    var $item = $(this).closest('.wishlist-item');
    
    Swal.fire({
        title: 'Remove from Wishlist?',
        text: "Are you sure you want to remove this item from your wishlist?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'ajax/code.php',
                method: 'POST',
                data: {
                    remove_favorite: true,
                    favorite_id: favoriteId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            background: 'white',
                            customClass: {
                                popup: 'small-swal'
                            }
                        });
                        
                        // Remove item from DOM
                        $item.fadeOut(300, function() {
                            $(this).remove();
                            // If no items left, show empty message
                            if ($('.wishlist-item').length === 0) {
                                $('.wishlist-items-container').html('<div class="empty-wishlist-message">Your wishlist is empty</div>');
                            }
                        });
                        
                        // Update favorites count
                        updateFavoritesDisplay();
                        
                        // Update heart icon in product listing
                        $('.st-wishlist-button[data-product-id="' + response.product_id + '"] i')
                            .removeClass('fa fa-heart')
                            .addClass('fi-rs-heart');
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            background: 'white',
                            customClass: {
                                popup: 'small-swal'
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Remove Favorite Error:', error);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'An error occurred while removing the item.',
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true,
                        background: 'white',
                        customClass: {
                            popup: 'small-swal'
                        }
                    });
                }
            });
        }
    });
});

// Call updateFavoritesDisplay when page loads
$(document).ready(function() {
    updateFavoritesDisplay();
});

function updateCartDropdown() {
    $.ajax({
        url: 'ajax/cart_update.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Update cart count in all locations
                $('.cart-count, #cart-item-count-mobile, #cart-item-count-mobile-title').text(response.total_items);
                
                // Update cart total price in all locations
                $('.cart-total-price, #cart-total-price-mobile, #cart-total-value').text('Kes ' + response.total_price);
                
                // Update cart items list in both mobile and desktop views
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
                
                // Reinitialize remove from cart functionality
                initializeRemoveFromCart();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating cart:', error);
        }
    });
}

// Function to initialize remove from cart functionality
function initializeRemoveFromCart() {
    $('.remove-from-cart').off('click').on('click', function(e) {
        e.preventDefault();
        var cartId = $(this).data('cart-id');
        var $itemRow = $(this).closest('.cart-item');
        
        $.ajax({
            url: 'ajax/remove_cart_item.php',
            type: 'POST',
            data: {
                cart_id: cartId
            },
            dataType: 'json',
            success: function(resp) {
                if (resp.success) {
                    $itemRow.remove();
                    updateCartDropdown(); // Refresh the entire cart after removal
                }
            }
        });
    });
}

     
     