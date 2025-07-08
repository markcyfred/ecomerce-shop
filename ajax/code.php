<?php
session_start();
include('../admin/config/dbcon.php'); // Database connection

// Function to generate unique tokens
function generateUniqueToken($prefix = '') {
    $token = $prefix . '_' . uniqid() . '_' . bin2hex(random_bytes(16));
    return $token;
}

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
     $check_query = "SELECT id FROM cart WHERE product_id = ? AND (session_id = ? OR user_id = ?) AND (cart_status IS NULL OR cart_status = 'unprocessed')";
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
         $update_query = "UPDATE cart SET quantity = ? WHERE product_id = ? AND (session_id = ? OR user_id = ?) AND (cart_status IS NULL OR cart_status = 'unprocessed')";
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
         $cart_token = generateUniqueToken('cart');
         $insert_query = "INSERT INTO cart (token, product_id, product_name, selling_price, image, quantity, user_id, email, session_id, cart_order, cart_status)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 'unprocessed')";
         if ($stmt_insert = mysqli_prepare($conn, $insert_query)) {
             mysqli_stmt_bind_param($stmt_insert, 'sissssiss', $cart_token, $product_id, $product_name, $selling_price, $image, $quantity, $user_id, $email, $session_id);
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

// Handle favorites (both add and remove)
if (isset($_POST['add_to_favorite_btn']) || isset($_POST['remove_favorite'])) {
    $product_id    = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $product_name  = $_POST['product_name'] ?? '';
    $selling_price = $_POST['selling_price'] ?? '';
    $image         = $_POST['image'] ?? '';
    $quantity      = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $is_remove     = isset($_POST['remove_favorite']) && $_POST['remove_favorite'] === true;

    if ($product_id <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid product ID"]);
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

    if ($is_remove) {
        // Remove from favorites
        $delete_query = "DELETE FROM favorite WHERE product_id = ? AND (session_id = ? OR user_id = ?)";
        if ($stmt = mysqli_prepare($conn, $delete_query)) {
            mysqli_stmt_bind_param($stmt, 'iss', $product_id, $session_id, $user_id);
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Product removed from favorites",
                    "product_id" => $product_id
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to remove from favorites"
                ]);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Error preparing delete statement"
            ]);
        }
    } else {
        // Add to favorites
        // Check if already in favorites
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
            // Insert new favorite
            $insert_query = "INSERT INTO favorite (product_id, product_name, selling_price, image, quantity, user_id, email, session_id, created_at, updated_at)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
            if ($stmt_insert = mysqli_prepare($conn, $insert_query)) {
                mysqli_stmt_bind_param($stmt_insert, 'isssisss', $product_id, $product_name, $selling_price, $image, $quantity, $user_id, $email, $session_id);
                if (mysqli_stmt_execute($stmt_insert)) {
                    echo json_encode([
                        "status" => "success",
                        "message" => "Product added to favorites",
                        "product_id" => $product_id
                    ]);
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Failed to add to favorites"
                    ]);
                }
                mysqli_stmt_close($stmt_insert);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error preparing insert statement"
                ]);
            }
        }
    }
    exit();
}

// Check if the request is for updating cart quantity via AJAX
if (isset($_POST['update']) && $_POST['update'] === 'update_added_to_cart') {
    $cart_id = $_POST['id'];
    $quantity = $_POST['quantity'];
    
    // Validate quantity
    if($quantity < 1) {
        echo json_encode(['status' => 'error', 'message' => 'Quantity must be at least 1']);
        exit;
    }
    
    // Update cart quantity
    $update_query = "UPDATE cart SET quantity = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, 'ii', $quantity, $cart_id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update cart']);
    }
    mysqli_stmt_close($stmt);
    exit;
}

//REMOVE FROM CART 
if (isset($_POST['delete']) && $_POST['delete'] === 'delete_added_to_cart') {
    $cart_id = $_POST['id'];
    $session_id = session_id();
    $user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Build the WHERE clause based on user authentication
        $where_clause = "id = ? AND (session_id = ?";
        if ($user_id) {
            $where_clause .= " OR user_id = ?";
        }
        $where_clause .= ")";
        
        // Delete cart item
        $delete_query = "DELETE FROM cart WHERE $where_clause";
        $stmt = mysqli_prepare($conn, $delete_query);
        
        if ($stmt) {
            if ($user_id) {
                mysqli_stmt_bind_param($stmt, 'iss', $cart_id, $session_id, $user_id);
            } else {
                mysqli_stmt_bind_param($stmt, 'is', $cart_id, $session_id);
            }
            
            if(mysqli_stmt_execute($stmt)) {
                // Get updated cart totals
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
                
                $stmt_totals = mysqli_prepare($conn, $cart_query);
                if ($stmt_totals) {
                    if ($user_id) {
                        mysqli_stmt_bind_param($stmt_totals, 'ss', $session_id, $user_id);
                    } else {
                        mysqli_stmt_bind_param($stmt_totals, 's', $session_id);
                    }
                    
                    mysqli_stmt_execute($stmt_totals);
                    $result = mysqli_stmt_get_result($stmt_totals);
                    $cart_data = mysqli_fetch_assoc($result);
                    
                    // Commit transaction
                    mysqli_commit($conn);
                    
                    // Send response
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Item removed successfully',
                        'total_items' => (int)$cart_data['total_items'],
                        'total_price' => (float)$cart_data['total_price']
                    ]);
                } else {
                    throw new Exception('Error preparing totals statement');
                }
                mysqli_stmt_close($stmt_totals);
            } else {
                throw new Exception('Failed to remove item from cart');
            }
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception('Error preparing delete statement');
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

//CLEAR CART
if (isset($_POST['clear_cart']) && $_POST['clear_cart'] === 'clear_cart') {
    $session_id = session_id();
    $user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;
    
    // Build the WHERE clause based on user authentication
    $where_clause = "cart_status = 'unprocessed' AND (session_id = ?";
    if ($user_id) {
        $where_clause .= " OR user_id = ?";
    }
    $where_clause .= ")";
    
    // Clear the cart
    $clear_query = "DELETE FROM cart WHERE $where_clause";
    $stmt = mysqli_prepare($conn, $clear_query);
    
    if ($stmt) {
        if ($user_id) {
            mysqli_stmt_bind_param($stmt, 'ss', $session_id, $user_id);
        } else {
            mysqli_stmt_bind_param($stmt, 's', $session_id);
        }
        
        if(mysqli_stmt_execute($stmt)) {
            // Clear all session variables related to cart and discounts
            unset($_SESSION['promo_code']);
            unset($_SESSION['discount_amount']);
            unset($_SESSION['discount_code']);
            unset($_SESSION['cart_total']);
            unset($_SESSION['cart_items']);
            
            // Reset cart totals in session
            $_SESSION['cart_total'] = 0;
            $_SESSION['cart_items'] = 0;
            $_SESSION['discount_amount'] = 0;
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Cart cleared successfully',
                'total_items' => 0,
                'total_price' => '0.00',
                'total_discount' => '0.00',
                'final_total' => '0.00'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to clear cart'
            ]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error preparing clear statement'
        ]);
    }
    exit;
}

// Handle cart totals update
if (isset($_POST['update_cart_totals'])) {
    $session_id = session_id();
    $user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;
    
    // Clear all session variables related to cart and discounts
    unset($_SESSION['promo_code']);
    unset($_SESSION['discount_amount']);
    unset($_SESSION['discount_code']);
    unset($_SESSION['cart_total']);
    unset($_SESSION['cart_items']);
    
    // Reset cart totals in session
    $_SESSION['cart_total'] = 0;
    $_SESSION['cart_items'] = 0;
    $_SESSION['discount_amount'] = 0;
    
    // Clear any existing cart items
    $clear_query = "DELETE FROM cart WHERE session_id = ?";
    $stmt = mysqli_prepare($conn, $clear_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $session_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Cart totals updated',
        'total_items' => 0,
        'total_price' => '0.00',
        'total_discount' => '0.00',
        'final_total' => '0.00'
    ]);
    exit;
}

//pull cart total 
$session_id = session_id();
$user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

$cart_query = "SELECT * FROM cart WHERE session_id = '$session_id'" . ($user_id ? " OR user_id = '$user_id'" : "");
$cart_result = mysqli_query($conn, $cart_query);

$total_price = 0;
$total_discount = 0;

if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $total_price += ($row['selling_price'] * $row['quantity']);
        if (isset($row['original_price'])) {
            $item_discount = ($row['original_price'] - $row['selling_price']) * $row['quantity'];
            $total_discount += $item_discount;
        }
    }
}

echo json_encode([
    'total' => number_format($total_price, 2),
    'discount' => number_format($total_discount, 2),
    'final_total' => number_format($total_price - $total_discount, 2)
]);

//feedback
