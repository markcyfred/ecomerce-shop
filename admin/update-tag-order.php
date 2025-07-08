<?php
// update-tag-order.php

header('Content-Type: application/json');

// Include database configuration (defines $conn as mysqli connection)
require '../admin/config/dbcon.php';
if (!isset($conn) || $conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

// Read the raw JSON input
$input = file_get_contents('php://input');
if (empty($input)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "No input data provided"]);
    exit;
}

// Decode JSON input
$data = json_decode($input, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid JSON input"]);
    exit;
}

// Validate 'ids' parameter
if (!isset($data['ids']) || !is_array($data['ids'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "'ids' parameter is required and must be an array"]);
    exit;
}
$ids = $data['ids'];
if (count($ids) === 0) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "'ids' array must not be empty"]);
    exit;
}

// Prepare the SQL statement for updating order_num
$stmt = $conn->prepare("UPDATE tags SET order_num = ? WHERE id = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Failed to prepare database statement"]);
    exit;
}

// Optional: Begin transaction to ensure atomic updates
$conn->begin_transaction();

try {
    // Loop through each ID and update its order
    foreach ($ids as $index => $id) {
        // Validate each ID is a positive integer
        if (!is_int($id) || $id <= 0) {
            throw new Exception("Invalid ID in 'ids' array: " . json_encode($id));
        }
        $order = $index + 1; // order_num starts from 1

        // Bind parameters and execute
        $stmt->bind_param("ii", $order, $id);
        if (!$stmt->execute()) {
            // Execution error
            throw new Exception("Database execution error");
        }
    }

    // Commit transaction if all updates succeeded
    $conn->commit();
    echo json_encode(["success" => true, "message" => "Order updated successfully"]);
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

// Cleanup
$stmt->close();
$conn->close();
?>
