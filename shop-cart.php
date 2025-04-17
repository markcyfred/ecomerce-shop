<?php include 'includes/header.php'; ?>
<main class="main">
     <div class="page-header breadcrumb-wrap">
          <div class="container">
               <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> Your Cart
               </div>
          </div>
     </div>
     <section class="mt-50 mb-50">
          <div class="container">
               <div class="row">
                    <div class="col-12">
                         <!-- Cart Items Table -->
                         <div class="table-responsive">
                              <table class="table shopping-summery text-center clean">
                                   <thead>
                                        <tr class="main-heading">
                                             <th scope="col">Image</th>
                                             <th scope="col">Name</th>
                                             <th scope="col">Price</th>
                                             <th scope="col">Quantity</th>
                                             <th scope="col">Subtotal</th>
                                             <th scope="col">Remove</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                        $session_id = session_id();
                                        $user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;
                                        // Fetch cart items using session or user id if logged in, only unprocessed items.
                                        $cart_query = "SELECT * FROM cart WHERE cart_status = 'unprocessed' AND (session_id = '$session_id'" . ($user_id ? " OR user_id = '$user_id'" : "") . ")";
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
                                        if (!empty($cart_items)) :
                                             foreach ($cart_items as $item) :
                                        ?>
                                                  <tr data-id="<?php echo $item['id']; ?>">
                                                       <td class="image product-thumbnail">
                                                            <a href="shop-product.php?id=<?php echo $item['product_id']; ?>">
                                                                 <img src="uploads/shop/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                                                            </a>
                                                       </td>
                                                       <td class="product-des product-name">
                                                            <h5 class="product-name">
                                                                 <a href="shop-product.php?id=<?php echo $item['product_id']; ?>">
                                                                      <?php echo htmlspecialchars($item['product_name']); ?>
                                                                 </a>
                                                            </h5>
                                                            <?php if (!empty($item['description'])): ?>
                                                                 <p class="font-xs">
                                                                      <?php echo htmlspecialchars($item['description']); ?>
                                                                 </p>
                                                            <?php endif; ?>
                                                       </td>
                                                       <td class="price" data-title="Price">
                                                            <span>Kes <?php echo number_format($item['selling_price'], 2); ?></span>
                                                       </td>
                                                       <td class="text-center" data-title="Quantity">
                                                            <div class="detail-qty border radius m-auto">
                                                                 <!-- Decrease quantity -->
                                                                 <a href="update_cart.php?action=decrease&id=<?php echo $item['id']; ?>" class="qty-down">
                                                                      <i class="fi-rs-angle-small-down"></i>
                                                                 </a>
                                                                 <span class="qty-val"><?php echo htmlspecialchars($item['quantity']); ?></span>
                                                                 <!-- Increase quantity -->
                                                                 <a href="update_cart.php?action=increase&id=<?php echo $item['id']; ?>" class="qty-up">
                                                                      <i class="fi-rs-angle-small-up"></i>
                                                                 </a>
                                                            </div>
                                                       </td>
                                                       <td class="text-right" data-title="Subtotal">
                                                            <span>Kes <?php echo number_format($item['selling_price'] * $item['quantity'], 2); ?></span>
                                                       </td>
                                                       <td class="action" data-title="Remove">
                                                            <a href="#" class="text-muted delete-cart" data-id="<?php echo $item['id']; ?>">
                                                                 <i class="fi-rs-trash"></i>
                                                            </a>
                                                       </td>
                                                  </tr>
                                             <?php
                                             endforeach;
                                        else:
                                             ?>
                                             <tr>
                                                  <td colspan="6" class="text-center">Your cart is empty.</td>
                                             </tr>
                                        <?php endif; ?>
                                        <tr>
                                             <td colspan="6" class="text-end">
                                                  <a href="#" class="text-muted clear-cart">
                                                       <i class="fi-rs-cross-small"></i> Clear Cart
                                                  </a>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>
                         </div>

                         <div class="cart-action text-end">
                              <a class="btn mr-10 mb-sm-15"><i class="fi-rs-shuffle mr-10"></i>Update Cart</a>
                              <a class="btn"><i class="fi-rs-shopping-bag mr-10"></i>Continue Shopping</a>
                         </div>

                         <?php
                         // Only display Shipping Calculator, Coupon, and Cart Totals if the cart is not empty.
                         if (!empty($cart_items)) :
                         ?>
                              <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>

                              <div class="row mb-50">
                                   <div class="col-lg-6 col-md-12">
                                        <div class="heading_s1 mb-3">
                                             <h4>Calculate Shipping</h4>
                                        </div>
                                        <p class="mt-15 mb-30">
                                             Flat rate: <span class="font-xl text-brand fw-900">5%</span> (base product cost)
                                        </p>
                                        <!-- Shipping Calculator Form -->
                                        <form class="field_form shipping_calculator">
                                             <!-- Destination selection -->
                                             <div class="form-row">
                                                  <div class="form-group col-lg-12">
                                                       <label>Select Destination Place</label>
                                                       <div class="custom_select">
                                                            <select id="destination" class="form-control select-active">
                                                                 <option value="">-- Select Destination --</option>
                                                                 <option value="Nairobi" data-lat="-1.286389" data-lng="36.817223">Nairobi</option>
                                                                 <option value="Mombasa" data-lat="-4.043477" data-lng="39.668206">Mombasa</option>
                                                                 <option value="Kisumu" data-lat="-0.091702" data-lng="34.7680">Kisumu</option>
                                                                 <option value="Nakuru" data-lat="-0.303099" data-lng="36.0662">Nakuru</option>
                                                                 <option value="Eldoret" data-lat="0.5128" data-lng="35.2694">Eldoret</option>
                                                                 <option value="Nyeri" data-lat="-0.4194" data-lng="36.9532">Nyeri</option>
                                                                 <option value="Meru" data-lat="-0.0474" data-lng="37.6462">Meru</option>
                                                                 <option value="Machakos" data-lat="-1.5167" data-lng="37.2542">Machakos</option>
                                                                 <option value="Embu" data-lat="-0.4167" data-lng="37.45">Embu</option>
                                                                 <option value="Kitui" data-lat="-1.3667" data-lng="38.0833">Kitui</option>
                                                                 <option value="Garissa" data-lat="-1.4531" data-lng="39.6594">Garissa</option>
                                                                 <option value="Lamu" data-lat="-2.2700" data-lng="40.9000">Lamu</option>
                                                                 <option value="Kajiado" data-lat="-1.8833" data-lng="36.7833">Kajiado</option>

                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <!-- Manual delivery location inputs -->
                                             <div class="form-row row">
                                                  <div class="form-group col-lg-6">
                                                       <input id="state" required="required" placeholder="State / Country" name="state" type="text">
                                                  </div>
                                                  <div class="form-group col-lg-6">
                                                       <input id="postcode" required="required" placeholder="PostCode / ZIP" name="postcode" type="text">
                                                  </div>
                                             </div>
                                             <!-- Button to use current location -->
                                             <div class="form-row">
                                                  <div class="form-group col-lg-12">
                                                       <button type="button" id="use_location" class="btn btn-info btn-sm">
                                                            Use My Current Location
                                                       </button>
                                                  </div>
                                             </div>
                                             <div class="form-row">
                                                  <div class="form-group col-lg-12">
                                                       <button id="calc_shipping" class="btn btn-sm">
                                                            <i class="fi-rs-shuffle mr-10"></i>Calculate Shipping
                                                       </button>
                                                  </div>
                                             </div>
                                        </form>

                                        <div class="mb-30 mt-50">
                                             <div class="heading_s1 mb-3">
                                                  <h4>Apply Coupon</h4>
                                             </div>
                                             <div class="total-amount">
                                                  <div class="left">
                                                       <div class="coupon">
                                                            <form action="#" target="_blank">
                                                                 <div class="form-row row justify-content-center">
                                                                      <div class="form-group col-lg-6">
                                                                           <input class="font-medium" name="Coupon" placeholder="Enter Your Coupon">
                                                                      </div>
                                                                      <div class="form-group col-lg-6">
                                                                           <button class="btn btn-sm">
                                                                                <i class="fi-rs-label mr-10"></i>Apply
                                                                           </button>
                                                                      </div>
                                                                 </div>
                                                            </form>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   <!-- Cart Totals Section -->
                                   <div class="col-lg-6 col-md-12">
                                        <div class="border p-md-4 p-30 border-radius cart-totals">
                                             <div class="heading_s1 mb-3">
                                                  <h4>Cart Totals</h4>
                                             </div>
                                             <div class="table-responsive">
                                                  <table class="table">
                                                       <tbody>
                                                            <tr>
                                                                 <td class="cart_total_label">Cart Subtotal</td>
                                                                 <td class="cart_total_amount">
                                                                      <span id="cart_total" class="font-lg fw-900 text-brand">
                                                                           Kes <?php echo number_format($total_price, 2); ?>
                                                                      </span>
                                                                 </td>
                                                            </tr>
                                                            <tr>
                                                                 <td class="cart_total_label">Shipping</td>
                                                                 <td class="cart_total_amount">
                                                                      <span id="shipping_cost">
                                                                           <i class="ti-gift mr-5"></i> Free Shipping
                                                                      </span>
                                                                 </td>
                                                            </tr>
                                                            <tr>
                                                                 <td class="cart_total_label">Total</td>
                                                                 <td class="cart_total_amount">
                                                                      <strong>
                                                                           <span id="cart_total_total" class="font-xl fw-900 text-brand">
                                                                                Kes <?php echo number_format($total_price, 2); ?>
                                                                           </span>
                                                                      </strong>
                                                                 </td>
                                                            </tr>
                                                       </tbody>
                                                  </table>
                                             </div>
                                             <!-- Hidden checkout form -->
                                             <form id="checkout_form" action="checkout.php" method="post">
                                                  <input type="hidden" name="destination" id="checkout_destination" value="">
                                                  <input type="hidden" name="state" id="checkout_state" value="">
                                                  <input type="hidden" name="postcode" id="checkout_postcode" value="">
                                                  <input type="hidden" name="shipping_cost" id="checkout_shipping_cost" value="">
                                                  <input type="hidden" name="cart_subtotal" id="checkout_cart_subtotal" value="<?php echo $total_price; ?>">
                                                  <input type="hidden" name="total_amount" id="checkout_total_amount" value="">
                                                  <input type="hidden" name="user_lat" id="checkout_user_lat" value="">
                                                  <input type="hidden" name="user_lng" id="checkout_user_lng" value="">
                                                  <input type="hidden" name="destination_lat" id="checkout_destination_lat" value="">
                                                  <input type="hidden" name="destination_lng" id="checkout_destination_lng" value="">
                                                  <a href="#" id="proceed_checkout" class="btn">
                                                       <i class="fi-rs-box-alt mr-10"></i> Proceed To CheckOut
                                                  </a>
                                             </form>
                                        </div>
                                   </div>
                              </div>
                         <?php endif; // End check for empty cart 
                         ?>
                    </div>
               </div>
          </div>
     </section>
</main>

<!-- jQuery and SweetAlert2 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
     // Global variables to store coordinates and totals
     var userLat = null,
          userLng = null,
          destinationLat = null,
          destinationLng = null,
          cartSubtotal = parseFloat($('#cart_total').text().replace("Kes", "").replace(/,/g, "").trim());

     // Use My Current Location handler
     $('#use_location').click(function() {
          if (navigator.geolocation) {
               navigator.geolocation.getCurrentPosition(function(position) {
                    // Update global user location variables
                    userLat = position.coords.latitude;
                    userLng = position.coords.longitude;

                    // Reverse geocoding to get address details
                    const geocodeURL = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLat}&lon=${userLng}&addressdetails=1`;

                    $.getJSON(geocodeURL, function(data) {
                         if (data && data.address) {
                              const address = data.address;
                              // Prefer state if available; otherwise use county
                              const stateVal = address.state || address.county || '';
                              const countryVal = address.country || '';
                              // Use town, village, or city if available
                              const townVal = address.town || address.village || address.city || '';

                              // Update postcode if available
                              $('#postcode').val(address.postcode || '');

                              // Helper function to normalize text (removing " county" for better matching)
                              const normalize = str => str ? str.trim().toLowerCase().replace(' county', '') : '';

                              const normalizedTown = normalize(townVal);
                              const normalizedState = normalize(stateVal);
                              const normalizedCountry = normalize(countryVal);

                              let destinationFound = false;

                              $('#destination option').each(function() {
                                   const optionText = normalize($(this).text());
                                   if (normalizedTown.includes(optionText) ||
                                        normalizedState.includes(optionText) ||
                                        normalizedCountry.includes(optionText)) {
                                        $(this).prop('selected', true);
                                        destinationLat = parseFloat($(this).data('lat'));
                                        destinationLng = parseFloat($(this).data('lng'));
                                        destinationFound = true;
                                        return false;
                                   }
                              });

                              if (!destinationFound) {
                                   $('#state').val(stateVal);
                                   const geocodeStateURL = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(stateVal)}`;
                                   $.getJSON(geocodeStateURL, function(result) {
                                        if (result && result.length > 0) {
                                             destinationLat = parseFloat(result[0].lat);
                                             destinationLng = parseFloat(result[0].lon);
                                        }
                                   });
                              } else {
                                   $('#state').val(stateVal);
                              }
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
     $('#calc_shipping').click(function(e) {
          e.preventDefault();

          var dest = $('#destination').find(':selected');
          if (dest.val() !== "") {
               destinationLat = parseFloat(dest.data('lat'));
               destinationLng = parseFloat(dest.data('lng'));
          } else if (!(destinationLat && destinationLng)) {
               Swal.fire('Error', "Please select a destination place.", 'error');
               return;
          }

          if (userLat === null || userLng === null) {
               Swal.fire({
                    title: 'Warning',
                    text: "Current location not captured. Use 'Use My Current Location' option.",
                    icon: 'warning'
               });
               return;
          }

          var distance = calculateDistance(userLat, userLng, destinationLat, destinationLng);
          var baseRate = 50;
          var shippingCost = baseRate + (distance * 0.5);
          shippingCost = parseFloat(shippingCost).toFixed(2);

          $('#shipping_cost').html('<i class="ti-gift mr-5"></i> Shipping: Kes ' + shippingCost);
          var newTotal = cartSubtotal + parseFloat(shippingCost);
          $('#cart_total_total').text('Kes ' + newTotal.toFixed(2));

          Swal.fire({
               position: 'top-end',
               toast: true,
               showConfirmButton: false,
               timer: 2000,
               icon: 'success',
               title: 'Shipping calculated. Distance: ' + distance.toFixed(2) + ' km'
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

   

     $('#proceed_checkout').click(function(e) {
          e.preventDefault();

          var destination = $('#destination').find(':selected').val();
          if (!destination) {
               destination = $('#state').val();
          }
          var state = $('#state').val();
          var postcode = $('#postcode').val();
          var shippingText = $('#shipping_cost').text();

          if (!state || !postcode || shippingText.indexOf("Kes") === -1) {
               Swal.fire('Error', "Please ensure location details are set and shipping has been calculated.", 'error');
               return;
          }

          var shippingCost = parseFloat(shippingText.replace(/[^0-9.]/g, ''));
          var totalAmount = cartSubtotal + shippingCost;

          $('#checkout_destination').val(destination);
          $('#checkout_state').val(state);
          $('#checkout_postcode').val(postcode);
          $('#checkout_shipping_cost').val(shippingCost);
          $('#checkout_total_amount').val(totalAmount);
          $('#checkout_user_lat').val(userLat);
          $('#checkout_user_lng').val(userLng);
          $('#checkout_destination_lat').val(destinationLat);
          $('#checkout_destination_lng').val(destinationLng);

          $('#checkout_form').submit();
     });


     //OTHER CODE 



     $(document).ready(function() {
          $('.qty-up, .qty-down').on('click', function(e) {
               e.preventDefault(); // Prevent default behavior

               // Determine whether to increase or decrease the quantity
               var $button = $(this);
               var action = $button.hasClass('qty-up') ? 'increase' : 'decrease';

               // Get the cart item ID from the closest table row’s data attribute
               var $row = $button.closest('tr');
               var cartItemId = $row.data('id');

               // Send the AJAX request to your common file with a new parameter "update"
               $.ajax({
                    url: 'ajax/code.php', // Common file for your AJAX actions
                    method: 'POST',
                    data: {
                         update: 'update_added_to_cart', // identifies this as a quantity update for cart items
                         action: action,
                         id: cartItemId // The cart item ID
                    },
                    dataType: 'json',
                    success: function(response) {
                         if (response.status === "success") {
                              // Update the DOM with the new values from response
                              $row.find('.qty-val').text(response.new_quantity);
                              $row.find('td[data-title="Subtotal"] span').text('Kes ' + response.new_subtotal);

                              // Optionally update a global cart total element, if present
                              if ($('#cart_total').length) {
                                   $('#cart_total').text('Kes ' + response.new_total);
                              }
                         } else {
                              // Show SweetAlert2 toast notification for errors
                              Swal.fire({
                                   position: 'top-end',
                                   toast: true,
                                   showConfirmButton: false,
                                   timer: 2000,
                                   icon: 'error',
                                   title: 'Error',
                                   text: response.message,
                              });
                         }
                    },
                    error: function(xhr, status, error) {
                         // Show SweetAlert2 toast notification for AJAX errors
                         Swal.fire({
                              position: 'top-end',
                              toast: true,
                              showConfirmButton: false,
                              timer: 2000,
                              icon: 'error',
                              title: 'Oops...',
                              text: "An error occurred while updating the cart.",
                         });
                    }
               });
          });
     });
     $(document).on('click', '.clear-cart', function(e) {
          e.preventDefault();

          // Check if there are any cart items
          if ($('tbody tr[data-id]').length === 0) {
               Swal.fire({
                    icon: 'info',
                    title: 'Nothing to clear',
                    text: 'Your cart is already empty.',
                    timer: 2000,
                    showConfirmButton: false
               });
               return;
          }

          // Confirm before clearing the cart
          Swal.fire({
               title: 'Are you sure?',
               text: "This will clear your entire cart.",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes, clear it!'
          }).then((result) => {
               if (result.isConfirmed) {
                    // Send AJAX request to clear the cart
                    $.ajax({
                         url: 'ajax/code.php',
                         type: 'POST',
                         data: {
                              clear_cart: 'clear_cart'
                         },
                         success: function(response) {
                              var res = JSON.parse(response);
                              if (res.status === "success") {
                                   Swal.fire({
                                        title: 'Cleared!',
                                        text: res.message,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                   }).then(() => {
                                        location.reload();
                                   });
                              } else {
                                   Swal.fire({
                                        title: 'Error!',
                                        text: res.message,
                                        icon: 'error',
                                        timer: 2000,
                                        showConfirmButton: false
                                   });
                              }
                         },
                         error: function() {
                              Swal.fire({
                                   title: 'Error!',
                                   text: 'There was an error processing your request.',
                                   icon: 'error',
                                   timer: 2000,
                                   showConfirmButton: false
                              });
                         }
                    });
               }
          });
     });

     $(document).on('click', '.delete-cart', function(e) {
          e.preventDefault(); // Prevent the default link action

          // Retrieve the cart item ID from the data attribute
          var cartItemId = $(this).data('id');

          // Display a SweetAlert2 confirmation dialog
          Swal.fire({
               title: 'Are you sure?',
               text: "This will remove the item from your cart.",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
               if (result.isConfirmed) {
                    // If the user confirms, send an AJAX request to delete the cart item
                    $.ajax({
                         url: 'ajax/code.php', // Update this to the correct URL if needed
                         type: 'POST',
                         data: {
                              delete: 'delete_added_to_cart',
                              id: cartItemId
                         },
                         success: function(response) {
                              var res = JSON.parse(response);
                              if (res.status === "success") {
                                   Swal.fire({
                                        title: 'Deleted!',
                                        text: res.message,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                   }).then(() => {
                                        // Optionally, reload the page or remove the deleted item from the DOM
                                        location.reload();
                                   });
                              } else {
                                   Swal.fire({
                                        title: 'Error!',
                                        text: res.message,
                                        icon: 'error',
                                        timer: 2000,
                                        showConfirmButton: false
                                   });
                              }
                         },
                         error: function() {
                              Swal.fire({
                                   title: 'Error!',
                                   text: 'There was an error processing your request.',
                                   icon: 'error',
                                   timer: 2000,
                                   showConfirmButton: false
                              });
                         }
                    });
               }
          });
     });
</script>
<?php include 'includes/footer.php'; ?>