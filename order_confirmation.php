<?php 
// order_confirmation.php

include 'admin/config/dbcon.php';  // Database connection
include 'includes/header.php';

// Start session if not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Retrieve and validate the order id from the URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if ($order_id <= 0) {
    echo "Invalid Order ID.";
    exit;
}

// Get the current order details from the checkout table.
$stmt = $conn->prepare("SELECT * FROM checkout WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    echo "Order not found.";
    exit;
}

$order = $result->fetch_assoc();
$stmt->close();

// Using the session_id from the checkout order, retrieve associated cart items
$session_id = $order['session_id'];
$stmt_cart = $conn->prepare("SELECT * FROM cart WHERE session_id = ? AND cart_status = 'processed'");
if (!$stmt_cart) {
    die("Prepare failed (cart): " . $conn->error);
}
$stmt_cart->bind_param("s", $session_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();
?>

<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow">Home</a>
                <span></span> Shop
                <span></span> Checkout
            </div>
        </div>
    </div>
    
    <!-- Order Confirmation Section -->
    <section class="mt-50 mb-50">
        <div class="container">
            <!-- Divider -->
            <div class="row">
                <div class="col-12">
                    <div class="divider mt-50 mb-50"></div>
                </div>
            </div>
            
            <!-- Main Content: Billing / Shipping and Order Review -->
            <div class="row">
                <!-- Billing Details Section -->
                <div class="col-md-6">
                    <div class="mb-25">
                        <h4>Billing Details</h4>
                    </div>
                    <form method="post">
                        <div class="form-group">
                            <input type="text" required name="fname" placeholder="First name *">
                        </div>
                        <div class="form-group">
                            <input type="text" required name="lname" placeholder="Last name *">
                        </div>
                        <div class="form-group">
                            <input type="text" required name="cname" placeholder="Company Name">
                        </div>
                        <div class="form-group">
                            <div class="custom_select">
                                <select class="form-control select-active">
                                    <!-- Options Here -->
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="billing_address" required placeholder="Address *">
                        </div>
                        <div class="form-group">
                            <input type="text" name="billing_address2" required placeholder="Address line2">
                        </div>
                        <div class="form-group">
                            <input type="text" required name="city" placeholder="City / Town *">
                        </div>
                        <div class="form-group">
                            <input type="text" required name="state" placeholder="State / County *">
                        </div>
                        <div class="form-group">
                            <input type="text" required name="zipcode" placeholder="Postcode / ZIP *">
                        </div>
                        <div class="form-group">
                            <input type="text" required name="phone" placeholder="Phone *">
                        </div>
                        <div class="form-group">
                            <input type="text" required name="email" placeholder="Email address *">
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="createaccount">
                                    <label class="form-check-label label_info" data-bs-toggle="collapse" data-target="#collapsePassword" aria-controls="collapsePassword" for="createaccount">
                                        <span>Create an account?</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="collapsePassword" class="form-group create-account collapse in">
                            <input type="password" required placeholder="Password" name="password">
                        </div>
                        <div class="ship_detail">
                            <div class="form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="differentaddress">
                                        <label class="form-check-label label_info" data-bs-toggle="collapse" data-target="#collapseAddress" aria-controls="collapseAddress" for="differentaddress">
                                            <span>Ship to a different address?</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseAddress" class="different_address collapse in">
                                <div class="form-group">
                                    <input type="text" required name="fname" placeholder="First name *">
                                </div>
                                <div class="form-group">
                                    <input type="text" required name="lname" placeholder="Last name *">
                                </div>
                                <div class="form-group">
                                    <input type="text" required name="cname" placeholder="Company Name">
                                </div>
                                <div class="form-group">
                                    <div class="custom_select">
                                        <select class="form-control select-active">
                                            <!-- Options Here -->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="billing_address" required placeholder="Address *">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="billing_address2" required placeholder="Address line2">
                                </div>
                                <div class="form-group">
                                    <input type="text" required name="city" placeholder="City / Town *">
                                </div>
                                <div class="form-group">
                                    <input type="text" required name="state" placeholder="State / County *">
                                </div>
                                <div class="form-group">
                                    <input type="text" required name="zipcode" placeholder="Postcode / ZIP *">
                                </div>
                            </div>
                        </div>
                        <div class="mb-20">
                            <h5>Additional information</h5>
                        </div>
                        <div class="form-group mb-30">
                            <textarea rows="5" placeholder="Order notes"></textarea>
                        </div>
                    </form>
                </div>
                
                <!-- Order Review Section -->
                <div class="col-md-6">
                    <div class="order_review">
                        <div class="mb-20">
                            <h4>Your Orders</h4>
                        </div>
                        <!-- Dynamic Order Confirmation Message -->
                        <div class="alert alert-success">
                            <h5 class="mb-0">Thank you for your order!</h5>
                            <p>Your Order ID is <strong>#<?php echo htmlspecialchars($order_id); ?></strong></p>
                        </div>
                        <div class="table-responsive order_table text-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Product</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // Loop through each processed cart item for this order.
                                    if ($result_cart->num_rows > 0):
                                        while ($cart_item = $result_cart->fetch_assoc()):
                                            // Calculate total for the cart item.
                                            $item_total = $cart_item['selling_price'] * $cart_item['quantity'];
                                    ?>
                                    <tr>
                                        <td class="image product-thumbnail" style="width: 80px;">
                                            <img src="uploads/shop/<?php echo htmlspecialchars($cart_item['image']); ?>" alt="<?php echo htmlspecialchars($cart_item['product_name']); ?>" style="max-width: 100%;">
                                        </td>
                                        <td>
                                            <h5><a href="shop-product.php?id=<?php echo htmlspecialchars($cart_item['product_id']); ?>"><?php echo htmlspecialchars($cart_item['product_name']); ?></a></h5>
                                        </td>
                                        <td><?php echo htmlspecialchars($cart_item['quantity']); ?></td>
                                        <td>kes<?php echo number_format($item_total, 2); ?></td>
                                    </tr>
                                    <?php 
                                        endwhile;
                                    else: 
                                    ?>
                                    <tr>
                                        <td colspan="4">No items found.</td>
                                    </tr>
                                    <?php endif; ?>
                                    <!-- Dynamic summary rows -->
                                    <tr>
                                        <th>SubTotal</th>
                                        <td class="product-subtotal" colspan="3">kes <?php echo number_format($order['cart_subtotal'], 2); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td colspan="3"><em>Kes <?php echo number_format($order['shipping_cost'], 2); ?></em></td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td colspan="3" class="product-subtotal">
                                            <span class="font-xl text-brand fw-900">Kes <?php echo number_format($order['total_amount'], 2); ?></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                        <div class="payment_method">
                            <div class="mb-25">
                                <h5>Payment</h5>
                            </div>
                            <div class="payment_option">
                                <div class="custome-radio">
                                    <input class="form-check-input" type="radio" required name="payment_option" id="exampleRadios3" checked>
                                    <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse" data-target="#bankTranfer" aria-controls="bankTranfer">
                                        Direct Bank Transfer
                                    </label>
                                    <div class="form-group collapse in" id="bankTranfer">
                                        <p class="text-muted mt-5">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.</p>
                                    </div>
                                </div>
                                <div class="custome-radio">
                                    <input class="form-check-input" type="radio" required name="payment_option" id="exampleRadios4">
                                    <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse" data-target="#checkPayment" aria-controls="checkPayment">
                                        Check Payment
                                    </label>
                                    <div class="form-group collapse in" id="checkPayment">
                                        <p class="text-muted mt-5">Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                    </div>
                                </div>
                                <div class="custome-radio">
                                    <input class="form-check-input" type="radio" required name="payment_option" id="exampleRadios5">
                                    <label class="form-check-label" for="exampleRadios5" data-bs-toggle="collapse" data-target="#paypal" aria-controls="paypal">
                                        Paypal
                                    </label>
                                    <div class="form-group collapse in" id="paypal">
                                        <p class="text-muted mt-5">Pay via PayPal; you can pay with your credit card if you don't have a PayPal account.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-fill-out btn-block mt-30">Place Order</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php 
$stmt_cart->close();
include 'includes/footer.php'; 
?>
