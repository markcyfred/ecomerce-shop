<?php
session_start();
include('../admin/config/dbcon.php'); // Database connection

if (isset($_POST['add_to_cart_btn'])) {
     $product_id    = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
     $product_name  = $_POST['product_name'];
     $selling_price = $_POST['selling_price'];
     $image         = $_POST['image'];
     $quantity      = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
 
     if ($product_id <= 0 || empty($product_name) || empty($selling_price) || empty($image)) {
         echo json_encode(["status" => "error", "message" => "Missing product details"]);
         exit();
     }
 
     if ($quantity <= 0) {
         echo json_encode(["status" => "error", "message" => "Invalid quantity"]);
         exit();
     }
 
     if (isset($_SESSION['auth_user'])) {
         $user_id = $_SESSION['auth_user']['id'];
         $email   = $_SESSION['auth_user']['email'];
     } else {
         $user_id = NULL;
         $email   = NULL;
     }
 
     $session_id = session_id();
     if (empty($session_id)) {
         echo json_encode(["status" => "error", "message" => "Session issue. Try again."]);
         exit();
     }
 
     // Check if the product already exists in the cart
     $check_query = "SELECT id FROM cart WHERE product_id = ? AND (session_id = ? OR user_id = ?)";
     if ($stmt_check = mysqli_prepare($conn, $check_query)) {
         mysqli_stmt_bind_param($stmt_check, 'iss', $product_id, $session_id, $user_id);
         mysqli_stmt_execute($stmt_check);
         mysqli_stmt_store_result($stmt_check);
         $exists = mysqli_stmt_num_rows($stmt_check) > 0;
         mysqli_stmt_close($stmt_check);
     } else {
         echo json_encode(["status" => "error", "message" => "Error checking cart"]);
         exit();
     }
 
     if ($exists) {
         // Update quantity: set it to the new value provided
         $update_query = "UPDATE cart SET quantity = ? WHERE product_id = ? AND (session_id = ? OR user_id = ?)";
         if ($stmt_update = mysqli_prepare($conn, $update_query)) {
             mysqli_stmt_bind_param($stmt_update, 'iiss', $quantity, $product_id, $session_id, $user_id);
             if (mysqli_stmt_execute($stmt_update)) {
                 echo json_encode(["status" => "success", "message" => "Product updated successfully"]);
             } else {
                 echo json_encode(["status" => "error", "message" => "Product not updated"]);
             }
             mysqli_stmt_close($stmt_update);
         } else {
             echo json_encode(["status" => "error", "message" => "Error preparing update statement"]);
         }
     } else {
         // Insert new product in cart if not exists
         $insert_query = "INSERT INTO cart (product_id, product_name, selling_price, image, quantity, user_id, email, session_id, cart_order)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
         if ($stmt_insert = mysqli_prepare($conn, $insert_query)) {
             mysqli_stmt_bind_param($stmt_insert, 'issssiss', $product_id, $product_name, $selling_price, $image, $quantity, $user_id, $email, $session_id);
             if (mysqli_stmt_execute($stmt_insert)) {
                 echo json_encode(["status" => "success", "message" => "Product added to cart successfully"]);
             } else {
                 echo json_encode(["status" => "error", "message" => "Product not added to cart"]);
             }
             mysqli_stmt_close($stmt_insert);
         } else {
             echo json_encode(["status" => "error", "message" => "Error preparing insert statement"]);
         }
     }
     exit();
 }

//ADD TO FAVORITE 
if (isset($_POST['add_to_favorite_btn'])) {
    $product_id    = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $product_name  = $_POST['product_name'];
    $selling_price = $_POST['selling_price'];
    $image         = $_POST['image'];
    $quantity      = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($product_id <= 0 || empty($product_name) || empty($selling_price) || empty($image)) {
        echo json_encode(["status" => "error", "message" => "Missing product details"]);
        exit();
    }

    if ($quantity <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid quantity"]);
        exit();
    }

    if (isset($_SESSION['auth_user'])) {
        $user_id = $_SESSION['auth_user']['id'];
        $email   = $_SESSION['auth_user']['email'];
    } else {
        $user_id = NULL;
        $email   = NULL;
    }

    $session_id = session_id();
    if (empty($session_id)) {
        echo json_encode(["status" => "error", "message" => "Session issue. Try again."]);
        exit();
    }

    // Check if the product already exists in favorites
    $check_query = "SELECT id FROM favorite WHERE product_id = ? AND (session_id = ? OR user_id = ?)";
    if ($stmt_check = mysqli_prepare($conn, $check_query)) {
        mysqli_stmt_bind_param($stmt_check, 'iss', $product_id, $session_id, $user_id);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        $exists = mysqli_stmt_num_rows($stmt_check) > 0;
        mysqli_stmt_close($stmt_check);
    } else {
        echo json_encode(["status" => "error", "message" => "Error checking favorite"]);
        exit();
    }

    if ($exists) {
        echo json_encode(["status" => "error", "message" => "Product already in favorites"]);
    } else {
        // Insert new favorite product if not exists, including the quantity field
        $insert_query = "INSERT INTO favorite (product_id, product_name, selling_price, image, quantity, user_id, email, session_id, created_at, updated_at)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        if ($stmt_insert = mysqli_prepare($conn, $insert_query)) {
            mysqli_stmt_bind_param($stmt_insert, 'isssisss', $product_id, $product_name, $selling_price, $image, $quantity, $user_id, $email, $session_id);
            if (mysqli_stmt_execute($stmt_insert)) {
                echo json_encode(["status" => "success", "message" => "Product added to favorites"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Product not added to favorites"]);
            }
            mysqli_stmt_close($stmt_insert);
        } else {
            echo json_encode(["status" => "error", "message" => "Error preparing insert statement"]);
        }
    }
    exit();
}







// Check if the request is for updating cart quantity via AJAX
if (isset($_POST['update']) && $_POST['update'] === 'update_added_to_cart') {

    // Get the action and cart item id from POST
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $cartItemId = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    // Validate the required fields
    if ($cartItemId <= 0 || !in_array($action, array('increase', 'decrease'))) {
        echo json_encode(["status" => "error", "message" => "Invalid request parameters."]);
        exit();
    }

    // Get the cart item data from the database
    $query = "SELECT * FROM cart WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $cartItemId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $item = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }

    if (!$item) {
        echo json_encode(["status" => "error", "message" => "Cart item not found."]);
        exit();
    }

    // Set the current cart quantity
    $quantity = $item['quantity'];

    if ($action === 'increase') {
        // Check available stock from products table before increasing
        $productId = $item['product_id'];
        $productQuery = "SELECT quantity FROM products WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $productQuery)) {
            mysqli_stmt_bind_param($stmt, 'i', $productId);
            mysqli_stmt_execute($stmt);
            $resultProduct = mysqli_stmt_get_result($stmt);
            $product = mysqli_fetch_assoc($resultProduct);
            mysqli_stmt_close($stmt);
        }

        if (!$product) {
            echo json_encode(["status" => "error", "message" => "Product not found in inventory."]);
            exit();
        }

        // The available stock in the product table
        $available_stock = (int)$product['quantity'];

        // If current quantity equals available stock, do not allow an increase.
        if ($quantity >= $available_stock) {
            echo json_encode(["status" => "error", "message" => "Insufficient stock available. Order cannot exceed available quantity of {$available_stock}."]);
            exit();
        }

        // If stock is available, increase quantity by one
        $quantity++;
    } elseif ($action === 'decrease') {
        // Prevent quantity from dropping below 1
        if ($quantity > 1) {
            $quantity--;
        } else {
            echo json_encode(["status" => "error", "message" => "Quantity cannot be less than 1."]);
            exit();
        }
    }

    // Update the cart record with the new quantity
    $update_query = "UPDATE cart SET quantity = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $update_query)) {
        mysqli_stmt_bind_param($stmt, 'ii', $quantity, $cartItemId);
        if (mysqli_stmt_execute($stmt)) {

            // Calculate new subtotal for this cart item
            $new_subtotal = $item['selling_price'] * $quantity;

            // Optionally, calculate the overall cart total based on session id
            $session_id = session_id();
            $total_query = "SELECT SUM(selling_price * quantity) AS total FROM cart WHERE session_id = ?";
            if ($stmt_total = mysqli_prepare($conn, $total_query)) {
                mysqli_stmt_bind_param($stmt_total, 's', $session_id);
                mysqli_stmt_execute($stmt_total);
                $result_total = mysqli_stmt_get_result($stmt_total);
                $row_total = mysqli_fetch_assoc($result_total);
                $new_total = $row_total['total'];
                mysqli_stmt_close($stmt_total);
            } else {
                $new_total = 0;
            }

            // Return a success response
            echo json_encode([
                "status"       => "success",
                "message"      => "Cart updated successfully.",
                "new_quantity" => $quantity,
                "new_subtotal" => number_format($new_subtotal, 2),
                "new_total"    => number_format($new_total, 2)
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update the cart."]);
        }
        mysqli_stmt_close($stmt);
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Error preparing the update statement."]);
        exit();
    }
}


