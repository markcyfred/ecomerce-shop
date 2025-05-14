<?php
session_start();
include('../admin/config/dbcon.php'); // Database connection

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']); // Ensure integer value
    $session_id = session_id();
    $user_id = $_SESSION['auth_user']['id'] ?? 0;

    // Fetch product details including available stock
    $query = "SELECT products.*, categories.name AS category_name 
              FROM products 
              LEFT JOIN categories ON products.category_name = categories.name 
              WHERE products.id = $product_id AND products.status = 1 LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($product = mysqli_fetch_assoc($result)) {
        $available_stock = intval($product['quantity']); // Ensure integer stock value

        // Check if the product is already in the cart
        $cart_query = "SELECT id, quantity FROM cart 
                       WHERE product_id = $product_id 
                       AND (session_id = '$session_id' OR user_id = $user_id) 
                       LIMIT 1";

        $cart_result = mysqli_query($conn, $cart_query);
        $cart_data = mysqli_fetch_assoc($cart_result);

        $in_cart = $cart_data ? true : false;
        $cart_quantity = min($cart_data['quantity'] ?? 1, $available_stock); // Ensure it does not exceed stock
?>
        <div class="row">
            <div class="col-md-6">
                <img src="uploads/shop/<?= $product['image']; ?>" class="img-fluid" alt="<?= $product['product_name']; ?>">
            </div>
            <div class="col-md-6">
                <h3><?= $product['product_name']; ?></h3>
                <p><strong>Category:</strong> <?= $product['category_name']; ?></p>
                <p><strong>Price:</strong> <span class="text-danger">Kes<?= $product['selling_price']; ?></span></p>
                <p><strong>Available Stock:</strong> <?= $available_stock; ?></p>
                <p><?= nl2br($product['description']); ?></p>

                <form class="quick-cart-form" id="quickCartForm_<?= $product['id']; ?>" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <input type="hidden" name="add_to_cart_btn" value="true">
                    <input type="hidden" name="product_name" value="<?= $product['product_name']; ?>">
                    <input type="hidden" name="selling_price" value="<?= $product['selling_price']; ?>">
                    <input type="hidden" name="image" value="<?= $product['image']; ?>">

                    <!-- Quantity -->
                    <div class="input-group mb-3">
                        <!-- Decrease button -->
                        <button type="button" class="quantity-decrease" id="decrease-<?= $product['id']; ?>">-</button>

                        <!-- Quantity input field -->
                        <input type="number" name="quantity" class="form-control text-center quantity-input"
                            value="<?= $cart_quantity; ?>" min="1" max="<?= $available_stock; ?>"
                            id="quantity-input-<?= $product['id']; ?>">

                        <!-- Increase button -->
                        <button type="button" class="quantity-increase" id="increase-<?= $product['id']; ?>">+</button>
                    </div>

                    <!-- Display "Already in Cart" message if applicable -->
                    <?php if ($in_cart): ?>
                        <p class="text-success in-cart-message"><strong>Already in Cart.</strong> Increase quantity if needed.</p>
                    <?php endif; ?>

                    <!-- Button Logic -->
                    <button type="submit" class="btn <?= $in_cart ? 'btn-success' : 'btn-primary'; ?>">
                        <?= $in_cart ? 'Update Cart' : 'Add to Cart'; ?>
                    </button>
                </form>

            </div>
        </div>

        <script>
            // Quantity increase/decrease handlers using jQuery
            $("#quickCartForm_<?= $product['id']; ?> .quantity-increase").on("click", function() {
                let input = $("#quickCartForm_<?= $product['id']; ?> .quantity-input");
                let maxStock = <?= $available_stock; ?>;
                let currentVal = parseInt(input.val());
                if (currentVal < maxStock) {
                    input.val(currentVal + 1);
                }
            });

            $("#quickCartForm_<?= $product['id']; ?> .quantity-decrease").on("click", function() {
                let input = $("#quickCartForm_<?= $product['id']; ?> .quantity-input");
                let currentVal = parseInt(input.val());
                if (currentVal > 1) {
                    input.val(currentVal - 1);
                }
            });

            // AJAX for quick cart form submission using SweetAlert2
            $("#quickCartForm_<?= $product['id']; ?>").on("submit", function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();
                $.ajax({
                    url: 'ajax/code.php', // Adjust the path to your AJAX handler if needed
                    type: 'POST',
                    data: formData,
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
                                width: 'auto',
                                padding: '0.1em',
                                background: 'white',
                                customClass: {
                                    popup: 'small-swal'
                                }
                            });
                            // Update button text and style to reflect the product is in the cart
                            form.find("button[type='submit']")
                                .text("Update Cart")
                                .removeClass("btn-primary")
                                .addClass("btn-success");
                            // Append "Already in Cart" message if not already there
                            if (form.find(".in-cart-message").length === 0) {
                                form.append('<p class="text-success in-cart-message"><strong>Already in Cart.</strong> Increase quantity if needed.</p>');
                            }
                        } else {
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
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'An error occurred while processing your request.',
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
            });
        </script>
<?php
    } else {
        echo "<p class='text-danger'>Product not found.</p>";
    }
} else {
    echo "<p class='text-danger'>Invalid request.</p>";
}
?>