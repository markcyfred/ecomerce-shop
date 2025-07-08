<?php
session_start();
include 'includes/header.php';
include 'admin/config/dbcon.php'; // defines $conn

// 1) Fetch and validate product ID
if (!isset($_GET['id'])) {
    echo "<p>Invalid product</p>";
    exit;
}
$product_id = intval($_GET['id']);

// 2) Query the product row
$sql = "SELECT * FROM products WHERE id = $product_id AND status = 1";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) === 0) {
    echo "<p>Product not found</p>";
    exit;
}
$product = mysqli_fetch_assoc($result);

// 3) Fetch primary image
$imgSql = "SELECT image_path FROM product_images WHERE product_id = $product_id AND is_primary = 1 LIMIT 1";
$imgRes = mysqli_query($conn, $imgSql);
$primaryImg = 'uploads/shop/default.png';
if ($imgRes && mysqli_num_rows($imgRes)) {
    $row = mysqli_fetch_assoc($imgRes);
    $primaryImg = $row['image_path'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['product_name']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
    <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
    <p>Price: KES <?php echo number_format($product['selling_price'], 2); ?></p>
    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

    <div class="product-actions d-flex align-items-center gap-3">
        <label for="quantity_wanted_<?php echo $product_id; ?>">Qty:</label>
        <input type="number" id="quantity_wanted_<?php echo $product_id; ?>" name="quantity_wanted" value="1" min="1" style="width: 60px;" />

        <!-- Single form for Add to Cart -->
        <form id="cartForm_<?php echo $product_id; ?>" method="POST" action="" class="d-inline">
            <input type="hidden" name="add_to_cart_btn" value="true">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
            <input type="hidden" name="selling_price" value="<?php echo $product['selling_price']; ?>">
            <input type="hidden" name="image" value="<?php echo htmlspecialchars($primaryImg); ?>">
            <input type="hidden" name="quantity" id="quantity_field_<?php echo $product_id; ?>" value="1">

            <a href="javascript:void(0)" class="btn btn-primary add-to-cart"
               onclick="
                    // sync quantity
                    var qty = document.getElementById('quantity_wanted_<?php echo $product_id; ?>').value;
                    document.getElementById('quantity_field_<?php echo $product_id; ?>').value = qty;
                    addToCart('cartForm_<?php echo $product_id; ?>');
               ">
                <i class="bi-cart-plus"></i> Add to Cart
            </a>
        </form>

        <!-- Wishlist button, outside of cart form -->
        <a href="javascript:void(0)" class="btn btn-outline-secondary st-wishlist-button"
           data-product-id="<?php echo $product_id; ?>"
           data-product-name="<?php echo htmlspecialchars($product['product_name']); ?>"
           data-selling-price="<?php echo $product['selling_price']; ?>"
           data-image="<?php echo htmlspecialchars($primaryImg); ?>">
            <i class="fi-rs-heart"></i> Favorite
        </a>
    </div>

    <!-- Notifications container -->
    <aside id="notifications" class="mt-3"><div class="container"></div></aside>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="ajax/ajax_function.js"></script>
<script src="/assets/js/cart-wishlist.js"></script>
</body>
</html>
