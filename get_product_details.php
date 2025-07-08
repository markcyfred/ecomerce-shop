<?php
include 'admin/config/dbcon.php';

// Validate product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product ID']);
    exit;
}

$product_id = intval($_GET['id']);

// Fetch product details
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.id = $product_id AND p.status = 1";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
    exit;
}

$product = mysqli_fetch_assoc($result);

// Format the response
$response = [
    'id' => $product['id'],
    'product_name' => $product['product_name'],
    'description' => $product['description'],
    'image' => $product['image'],
    'selling_price' => number_format($product['selling_price'], 2),
    'original_price' => number_format($product['original_price'], 2),
    'rating' => floatval($product['rating']),
    'rating_count' => intval($product['rating_count'] ?? 0),
    'brand' => $product['brand'] ?? 'N/A',
    'category_name' => $product['category_name'],
    'stock' => intval($product['quantity'])
];

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response); 