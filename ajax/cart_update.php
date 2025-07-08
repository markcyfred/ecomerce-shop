<?php
session_start();
include('../admin/config/dbcon.php');

header('Content-Type: application/json');

$session_id = session_id();
$user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

// Fetch cart items
$cart_query = "
    SELECT cart.*, product_images.image_path 
    FROM cart 
    LEFT JOIN product_images 
    ON product_images.product_id = cart.product_id 
    AND product_images.is_primary = 1 
    WHERE (cart.cart_status IS NULL OR cart.cart_status = 'unprocessed') 
    AND (
        cart.session_id = '$session_id'
        " . ($user_id ? " OR cart.user_id = '$user_id'" : "") . "
    )
";
$cart_result = mysqli_query($conn, $cart_query);

$total_items = 0;
$total_price = 0;
$cart_items = [];
$shipping_cost = 0;

if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $cart_items[] = $row;
        $total_items += $row['quantity'];
        $total_price += ($row['selling_price'] * $row['quantity']);
    }
}

// Generate cart HTML
$cart_html = '';
if (!empty($cart_items)) {
    foreach ($cart_items as $item) {
        $cart_html .= '<div class="cart-item" data-cart-id="' . $item['id'] . '">';
        $cart_html .= '<div class="cart-image">';
        $cart_html .= '<a href="shop-product.php?id=' . $item['product_id'] . '">';
        $cart_html .= '<img src="' . ($item['image_path'] ?: 'uploads/shop/default.png') . '" alt="' . htmlspecialchars($item['product_name']) . '" width="90" height="90" style="object-fit:contain;">';
        $cart_html .= '</a></div>';
        $cart_html .= '<div class="cart-info">';
        $cart_html .= '<span class="product-name">';
        $cart_html .= '<a href="shop-product.php?id=' . $item['product_id'] . '">';
        $name = $item['product_name'];
        $cart_html .= htmlspecialchars(mb_strlen($name) > 30 ? mb_substr($name, 0, 30) . '…' : $name);
        $cart_html .= '</a></span>';
        $cart_html .= '<div>';
        $cart_html .= '<span class="product-quantity">' . $item['quantity'] . ' x</span>';
        $cart_html .= '<span class="product-price">Kes ' . number_format($item['selling_price'], 2) . '</span>';
        $cart_html .= '</div>';
        $cart_html .= '<a class="remove-from-cart" href="#" data-cart-id="' . $item['id'] . '" title="Remove from cart">';
        $cart_html .= '<i class="material-icons pull-xs-left">delete</i>';
        $cart_html .= '</a></div></div>';
    }
} else {
    $cart_html = '<div class="no-more-item"><div class="no-img"></div><div class="empty-text">Your cart is empty.</div><a rel="nofollow" href="shop.php" class="continue"><button type="button" class="btn btn-primary">Continue shopping</button></a></div>';
}

// Prepare response
$response = [
    'status' => 'success',
    'total_items' => $total_items,
    'total_price' => number_format($total_price, 2),
    'shipping_cost' => number_format($shipping_cost, 2),
    'cart_html' => $cart_html,
    'cart_items' => array_map(function($item) {
        return [
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity']
        ];
    }, $cart_items)
];

// Get cart items
$cart_items = array();
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
    $cart_query = mysqli_query($conn, "SELECT c.*, p.product_name, p.selling_price, p.image 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = {$user_id}");
    while ($item = mysqli_fetch_assoc($cart_query)) {
        $cart_items[] = array(
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'product_name' => $item['product_name'],
            'selling_price' => $item['selling_price'],
            'image' => $item['image']
        );
    }
}

// Add cart items to response
$response['cart_items'] = $cart_items;

echo json_encode($response);
?>