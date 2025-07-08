<?php
session_start();
include('../admin/config/dbcon.php'); // Database connection

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $session_id = session_id();
    $user_id = $_SESSION['auth_user']['id'] ?? 0;

    // Fetch product details including available stock
    $query = "
        SELECT 
            p.*, 
            c.name AS category_name, 
            pi.image_path,
            CASE 
                WHEN LOWER(p.sale_out_limit) = 'no limit' THEN 'no limit'
                WHEN LOWER(p.sale_out_limit) = 'no_limit' THEN 'no limit'
                WHEN LOWER(p.sale_out_limit) = 'nolimit' THEN 'no limit'
                WHEN p.sale_out_limit IS NULL THEN 'no limit'
                WHEN p.sale_out_limit = '' THEN 'no limit'
                ELSE p.sale_out_limit 
            END as sale_out_limit
        FROM products p
        LEFT JOIN categories c 
            ON p.category_name = c.name
        LEFT JOIN product_images pi 
            ON pi.product_id = p.id 
            AND pi.is_primary = 1
        WHERE p.id = $product_id 
          AND p.status = 1
        LIMIT 1
    ";
    $result = mysqli_query($conn, $query);

    if ($product = mysqli_fetch_assoc($result)) {
        $available_stock = intval($product['quantity']);

        // Check if the product is already in the cart
        $cart_query = "
            SELECT id, quantity 
            FROM cart
            WHERE product_id = $product_id
              AND (session_id = '$session_id' 
                   OR user_id = $user_id)
            LIMIT 1
        ";
        $cart_result = mysqli_query($conn, $cart_query);
        $cart_data = mysqli_fetch_assoc($cart_result);

        $in_cart = ($cart_data !== null);
        $cart_quantity = min(intval($cart_data['quantity'] ?? 1), $available_stock);

        // Fetch all images for the gallery
        $imageQuery = mysqli_query($conn, "
            SELECT image_path 
            FROM product_images 
            WHERE product_id = {$product_id}
            ORDER BY is_primary DESC, id ASC
        ");
        $images = [];
        while ($row = mysqli_fetch_assoc($imageQuery)) {
            $images[] = $row['image_path'];
        }
        if (count($images) === 0) {
            // Fallback if no images found
            $images[] = 'uploads/shop/default.png';
        }

        // After fetching product details, check cart status
        $cart_status = 0;
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $user_id = (int)$_SESSION['user_id'];
            $cart_query = mysqli_query($conn, "SELECT quantity FROM cart WHERE product_id = {$product_id} AND user_id = {$user_id}");
            if ($cart_result = mysqli_fetch_assoc($cart_query)) {
                $cart_status = $cart_result['quantity'];
            }
        }

        // Add cart status to the product data
        $product['in_cart'] = $cart_status;
        ?>
        <!-- ======== START: Custom CSS ======== -->
        <style>
        .qc-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }
        .qc-image-wrapper {
            flex: 1 1 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .qc-main-image {
            width: 100%;
            max-width: 500px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .qc-thumbnails {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .qc-thumbnail {
            width: 60px;
            height: 60px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        .qc-thumbnail.selected {
            border-color: #007bff;
        }
        .qc-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .qc-details {
            flex: 1 1 300px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }
        .qc-title {
            font-size: 1.5em;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        .qc-category,
        .qc-price,
        .qc-stock {
            margin-bottom: 8px;
            color: #555;
        }
        .qc-price {
            font-size: 1.25em;
            color: #c0392b;
        }
        .qc-stock .in-stock {
            color: #27ae60;
            font-weight: 500;
        }
        .qc-stock .out-stock {
            color: #e74c3c;
            font-weight: 500;
        }
        .qc-description {
            flex: 1;
            margin-bottom: 15px;
            color: #444;
            line-height: 1.4;
            max-height: 150px;
            overflow-y: auto;
            padding-right: 5px;
        }
        .qc-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            margin-bottom: 15px;
        }
        .qc-quantity-wrapper {
            display: flex;
            align-items: center;
        }
        .qc-quantity-btn {
            width: 32px;
            height: 32px;
            background: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2em;
            user-select: none;
            transition: background 0.2s;
        }
        .qc-quantity-btn:hover {
            background: #e0e0e0;
        }
        .qc-quantity-input {
            width: 60px;
            text-align: center;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 0 5px;
            font-size: 1em;
        }
        .qc-submit-btn {
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background 0.2s;
        }
        .qc-submit-btn:hover {
            background: #0056b3;
        }
        .qc-submit-btn.success {
            background: #28a745;
        }
        .qc-submit-btn:disabled {
            background: #aaa;
            cursor: not-allowed;
        }
        .qc-payment {
            text-align: center;
            margin-top: 20px;
        }
        .qc-payment img {
            max-width: 200px;
        }
        .qc-note {
            font-size: 0.9em;
            color: #27ae60;
            margin-top: 5px;
        }
        </style>
        <!-- ======== END: Custom CSS ======== -->

        <div class="qc-container">
            <!-- LEFT: Images -->
            <div class="qc-image-wrapper">
                <img 
                    id="qc-main-image-<?= $product['id']; ?>" 
                    src="<?= htmlspecialchars($images[0]); ?>" 
                    alt="<?= htmlspecialchars($product['product_name']); ?>" 
                    class="qc-main-image"
                >
                <?php if (count($images) > 1): ?>
                    <div class="qc-thumbnails" id="qc-thumbs-<?= $product['id']; ?>">
                        <?php foreach ($images as $idx => $imgPath):
                            $safeThumb = htmlspecialchars($imgPath);
                            $selectedClass = $idx === 0 ? 'selected' : '';
                        ?>
                            <div 
                                class="qc-thumbnail <?= $selectedClass; ?>" 
                                data-index="<?= $idx; ?>"
                            >
                                <img src="<?= $safeThumb; ?>" alt="Thumbnail <?= $idx + 1; ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- RIGHT: Details & Add-to-Cart -->
            <div class="qc-details">
                <div class="qc-title"><?= htmlspecialchars($product['product_name']); ?></div>
                <div class="qc-category"><strong>Category:</strong> <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized'); ?></div>
                <div class="qc-price"><strong>Price:</strong> KES <?= number_format($product['selling_price'], 2); ?></div>
                <div class="qc-stock">
                    <strong>Stock:</strong>
                    <?php if ($available_stock > 0): ?>
                        <span class="in-stock"><?= $available_stock; ?> available</span>
                    <?php else: ?>
                        <span class="out-stock">Out of stock</span>
                    <?php endif; ?>
                </div>
                <div class="qc-description">
                    <?= nl2br(htmlspecialchars($product['description'])); ?>
                </div>
                 
        
                <form 
                    id="qc-form-<?= $product['id']; ?>" 
                    class="qc-form" 
                    method="POST"
                >
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <input type="hidden" name="add_to_cart_btn" value="true">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['product_name']); ?>">
                    <input type="hidden" name="selling_price" value="<?= $product['selling_price']; ?>">
                    <input type="hidden" name="image" value="<?= htmlspecialchars($product['image_path']); ?>">

                    <!-- Quantity -->
                    <div class="qc-quantity-wrapper">
                        <div 
                            class="qc-quantity-btn" 
                            id="qc-decrease-<?= $product['id']; ?>"
                        >−</div>
                        <input 
                            type="number" 
                            name="quantity" 
                            id="qc-quantity-input-<?= $product['id']; ?>" 
                            class="qc-quantity-input" 
                            value="<?= $cart_quantity; ?>" 
                            min="1" 
                            max="<?= $product['sale_out_limit'] === 'no limit' ? $available_stock : min($available_stock, $product['sale_out_limit']); ?>"
                            data-max-stock="<?= $available_stock; ?>"
                            data-max-limit="<?= $product['sale_out_limit']; ?>"
                            <?= $available_stock === 0 ? 'disabled' : ''; ?>
                        >
                        <div 
                            class="qc-quantity-btn" 
                            id="qc-increase-<?= $product['id']; ?>"
                        >＋</div>
                    </div>
                    <?php if ($in_cart): ?>
                        <div class="qc-note">Already in cart. You can increase quantity.</div>
                    <?php endif; ?>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="qc-submit-btn <?= $in_cart ? 'success' : ''; ?>"
                        id="qc-submit-btn-<?= $product['id']; ?>"
                    >
                        <?= $in_cart ? 'Update Cart' : 'Add to Cart'; ?>
                    </button>
                </form>

                <!-- Payment Badge -->
                <div class="qc-payment">
                    <img 
                        src="assets/img/payment-badge.png" 
                        alt="Payment Options"
                    >
                </div>
            </div>
        </div>

        <!-- ======== START: Custom JavaScript ======== -->
        <script>
        (function() {
            const prodId = "<?= $product['id']; ?>";
            const maxStock = <?= $available_stock; ?>;
            const inCart = <?= $in_cart ? 'true' : 'false'; ?>;
            const cartQuantity = <?= $in_cart ? $in_cart : 0; ?>;

            // Update button state based on cart status
            function updateButtonState() {
                const btn = document.getElementById("qc-submit-btn-" + prodId);
                if (btn) {
                    if (inCart) {
                        btn.classList.add('success');
                        btn.textContent = 'Update Cart';
                    } else {
                        btn.classList.remove('success');
                        btn.textContent = 'Add to Cart';
                    }
                }
            }

            // Call on load
            updateButtonState();

            // Thumbnail click → change main image
            const thumbContainer = document.getElementById("qc-thumbs-" + prodId);
            if (thumbContainer) {
                const thumbnails = thumbContainer.querySelectorAll(".qc-thumbnail");
                thumbnails.forEach(function(th) {
                    th.addEventListener("click", function() {
                        const idx = parseInt(this.getAttribute("data-index"), 10);
                        const newSrc = <?= json_encode($images); ?>[idx];
                        document.getElementById("qc-main-image-" + prodId).src = newSrc;

                        // Toggle selected class
                        thumbnails.forEach(t => t.classList.remove("selected"));
                        this.classList.add("selected");
                    });
                });
            }

            // Quantity buttons
            const btnInc = document.getElementById("qc-increase-" + prodId);
            const btnDec = document.getElementById("qc-decrease-" + prodId);
            const qtyInput = document.getElementById("qc-quantity-input-" + prodId);

            if (btnInc && qtyInput) {
                btnInc.addEventListener("click", function() {
                    let val = parseInt(qtyInput.value) || 1;
                    const maxStock = parseInt(qtyInput.getAttribute('data-max-stock'));
                    const maxLimit = qtyInput.getAttribute('data-max-limit');
                    
                    // Calculate max allowed based on sale_out_limit
                    let maxAllowed;
                    if (maxLimit === 'no limit' || maxLimit === 'no_limit' || maxLimit === 'nolimit') {
                        maxAllowed = maxStock; // Only check against available stock
                    } else {
                        maxAllowed = Math.min(maxStock, parseInt(maxLimit)); // Check against both stock and admin-set limit
                    }
                    
                    if (val < maxAllowed) {
                        qtyInput.value = val + 1;
                    } else {
                        let message = '';
                        if (maxLimit === 'no limit' || maxLimit === 'no_limit' || maxLimit === 'nolimit') {
                            message = `Only ${maxStock} items available in stock`;
                        } else {
                            message = `Maximum order limit is ${maxLimit} items`;
                        }
                        
                        Swal.fire({
                            position: 'top-end',
                            icon: 'info',
                            title: message,
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true
                        });
                    }
                });
            }
            if (btnDec && qtyInput) {
                btnDec.addEventListener("click", function() {
                    let val = parseInt(qtyInput.value) || 1;
                    if (val > 1) {
                        qtyInput.value = val - 1;
                    }
                });
            }

            // Handle form submission
            const form = document.getElementById("qc-form-" + prodId);
            if (form) {
                form.addEventListener("submit", function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    
                    // Disable button
                    const submitBtn = document.getElementById("qc-submit-btn-" + prodId);
                    submitBtn.disabled = true;
                    
                    fetch('ajax/code.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Show success message
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 2000,
                                toast: true
                            });
                            
                            // Update button state
                            submitBtn.classList.add('success');
                            submitBtn.textContent = 'Update Cart';
                            
                            // Update product card button if it exists
                            const cardBtn = document.querySelector(`#cartForm_${prodId} .add-to-cart`);
                            if (cardBtn) {
                                cardBtn.classList.remove('btn-primary');
                                cardBtn.classList.add('btn-success');
                                cardBtn.textContent = `In Cart (${qtyInput.value})`;
                                cardBtn.disabled = true;
                            }
                            
                            // Update cart count
                            if (typeof updateCartCount === 'function') {
                                updateCartCount();
                            }
                        } else {
                            // Show error message
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 2000,
                                toast: true
                            });
                            
                            // Re-enable button
                            submitBtn.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'An error occurred while adding the product to the cart.',
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true
                        });
                        submitBtn.disabled = false;
                    });
                });
            }
        })();
        </script>
        <!-- ======== END: Custom JavaScript ======== -->
        <?php
    } else {
        echo "<div style='color: #c0392b; font-weight: bold;'>Product not found.</div>";
    }
} else {
    echo "<div style='color: #e67e22; font-weight: bold;'>Invalid request.</div>";
}
?>
