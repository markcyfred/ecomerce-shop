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
