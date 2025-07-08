<?php
include_once '../admin/config/dbcon.php';    
include_once '../init.php';
$session_id = session_id();
$user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

// Get cart totals
$cart_query = "
    SELECT 
        COALESCE(SUM(quantity), 0) as total_items,
        COALESCE(SUM(selling_price * quantity), 0) as total_price
    FROM cart 
    WHERE cart_status = 'unprocessed' 
    AND (
        session_id = ?
        " . ($user_id ? " OR user_id = ?" : "") . "
    )
";

$stmt = mysqli_prepare($conn, $cart_query);
if ($stmt) {
    if ($user_id) {
        mysqli_stmt_bind_param($stmt, 'ss', $session_id, $user_id);
    } else {
        mysqli_stmt_bind_param($stmt, 's', $session_id);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cart_data = mysqli_fetch_assoc($result);
    
    $total_items = (int)$cart_data['total_items'];
    $total_price = (float)$cart_data['total_price'];
    
    mysqli_stmt_close($stmt);
} else {
    $total_items = 0;
    $total_price = 0;
}

// Get cart items for dropdown
$items_query = "
    SELECT 
        cart.*, 
        product_images.image_path, 
        products.product_name, 
        products.selling_price 
    FROM cart 
    LEFT JOIN product_images ON product_images.product_id = cart.product_id AND product_images.is_primary = 1 
    JOIN products ON products.id = cart.product_id
    WHERE cart.cart_status = 'unprocessed' 
    AND (
        cart.session_id = ?
        " . ($user_id ? " OR cart.user_id = ?" : "") . "
    )
";

$stmt = mysqli_prepare($conn, $items_query);
if ($stmt) {
    if ($user_id) {
        mysqli_stmt_bind_param($stmt, 'ss', $session_id, $user_id);
    } else {
        mysqli_stmt_bind_param($stmt, 's', $session_id);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Build dropdown HTML
    $dropdown_html = '';
    if (mysqli_num_rows($result) > 0) {
        while ($item = mysqli_fetch_assoc($result)) {
            $dropdown_html .= '<div class="cart-item" data-cart-id="' . $item['id'] . '">';
            $dropdown_html .= '<div class="cart-image">';
            $dropdown_html .= '<a href="shop-product.php?id=' . $item['product_id'] . '">';
            $dropdown_html .= '<img src="' . ($item['image_path'] ?: 'uploads/shop/default.png') . '" alt="' . htmlspecialchars($item['product_name']) . '" width="90" height="90" style="object-fit:contain;">';
            $dropdown_html .= '</a></div>';
            $dropdown_html .= '<div class="cart-info">';
            $dropdown_html .= '<span class="product-name"><a href="shop-product.php?id=' . $item['product_id'] . '">' . htmlspecialchars(mb_strlen($item['product_name']) > 30 ? mb_substr($item['product_name'], 0, 30) . '…' : $item['product_name']) . '</a></span>';
            $dropdown_html .= '<div><span class="product-quantity">' . $item['quantity'] . ' x</span> <span class="product-price">Kes ' . number_format($item['selling_price'], 2) . '</span></div>';
            $dropdown_html .= '<a class="remove-from-cart" href="#" data-cart-id="' . $item['id'] . '" title="Remove from cart"><i class="material-icons pull-xs-left">delete</i></a>';
            $dropdown_html .= '</div></div>';
        }
    } else {
        $dropdown_html .= '<div class="no-more-item"><div class="no-img"></div><div class="empty-text">Your cart is empty.</div><a rel="nofollow" href="shop.php" class="continue"><button type="button" class="btn btn-primary">Continue shopping</button></a></div>';
    }
    
    mysqli_stmt_close($stmt);
} else {
    $dropdown_html = '<div class="no-more-item"><div class="no-img"></div><div class="empty-text">Error loading cart items.</div></div>';
}

header('Content-Type: application/json');
echo json_encode([
    'count' => $total_items,
    'total_price' => $total_price,
    'dropdown' => $dropdown_html
]); 