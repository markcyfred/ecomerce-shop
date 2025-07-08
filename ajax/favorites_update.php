<?php
session_start();
include('../admin/config/dbcon.php');

header('Content-Type: application/json');

$session_id = session_id();
$user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

// Fetch favorites
$fav_query = "
    SELECT f.*, pi.image_path 
    FROM favorite f
    LEFT JOIN product_images pi 
    ON pi.product_id = f.product_id 
    AND pi.is_primary = 1 
    WHERE f.session_id = '$session_id'
    " . ($user_id ? " OR f.user_id = '$user_id'" : "") . "
";
$fav_result = mysqli_query($conn, $fav_query);

$fav_items = [];
$fav_count = 0;

if ($fav_result && mysqli_num_rows($fav_result) > 0) {
    while ($row = mysqli_fetch_assoc($fav_result)) {
        $fav_items[] = $row;
        $fav_count++;
    }
}

// Generate HTML for favorites
$fav_html = '';
if (!empty($fav_items)) {
    foreach ($fav_items as $item) {
        $name = $item['product_name'];
        $short_name = mb_substr($name, 0, 20);
        $fav_html .= '<div class="wishlist-item">';
        $fav_html .= '<div class="wishlist-img">';
        $fav_html .= '<a href="shop-product.php?id=' . $item['product_id'] . '">';
        $fav_html .= '<img src="' . ($item['image_path'] ?: 'uploads/shop/default.png') . '" alt="' . htmlspecialchars($name) . '" style="width:70px; object-fit:contain; border-radius:6px;">';
        $fav_html .= '</a></div>';
        $fav_html .= '<div class="wishlist-title">';
        $fav_html .= '<a href="shop-product.php?id=' . $item['product_id'] . '">' . htmlspecialchars($short_name) . (mb_strlen($name) > 20 ? '...' : '') . '</a>';
        $fav_html .= '<h4>KES ' . number_format($item['selling_price'], 2) . '</h4>';
        $fav_html .= '</div>';
        $fav_html .= '<div class="wishlist-delete">';
        $fav_html .= '<a href="#" class="remove-favorite" data-id="' . $item['id'] . '"><i class="fi-rs-cross-small"></i></a>';
        $fav_html .= '</div></div>';
    }
} else {
    $fav_html = '<div class="empty-wishlist-message">Your wishlist is empty</div>';
}

// Prepare response
$response = [
    'status' => 'success',
    'fav_count' => $fav_count,
    'fav_html' => $fav_html
];

echo json_encode($response); 