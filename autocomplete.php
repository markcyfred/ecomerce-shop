<?php
include 'admin/config/dbcon.php';

$term     = '%'.mysqli_real_escape_string($conn, $_GET['term']).'%';
$category = intval($_GET['category'] ?? 0);

$sql = "SELECT id, product_name
        FROM products
        WHERE product_name LIKE ?
          AND (? = 0 OR category_id = ?)
        LIMIT 5";

$stmt = $conn->prepare($sql);
$stmt->bind_param('sii', $term, $category, $category);
$stmt->execute();
$res = $stmt->get_result();

$out = [];
while ($row = $res->fetch_assoc()) {
  $out[] = [
    'label' => $row['product_name'],
    'value' => $row['product_name'],
    'id'    => $row['id']
  ];
}

header('Content-Type: application/json');
echo json_encode($out);
