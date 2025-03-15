<?php
session_start();

include('../admin/config/dbcon.php');
include('../functions/myfunctions.php');
//add category
if (isset($_POST['add_category_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $popularity = mysqli_real_escape_string($conn, $_POST['popularity']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($conn, $_POST['meta_keywords']); 

    $image = $_FILES['image']['name'];

    $path = "../uploads/categories";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . "." . $image_ext;

    // Perform basic validation
    if (empty($name) || empty($slug) || empty($description) || empty($meta_title) || empty($meta_description) || empty($meta_keywords)) {
        redirect("add-category.php", "Please fill all fields to continue.", "error");
        exit; // Stop further processing
    }

    try {
        //insert
        $cate_query = "INSERT INTO categories
            (name, slug, description, status, popularity, meta_title, meta_description, meta_keywords, image) 
            VALUES ('$name', '$slug', '$description', '$status', '$popularity', '$meta_title', '$meta_description', '$meta_keywords', '$filename')";

        $cate_query_run = mysqli_query($conn, $cate_query);

        if ($cate_query_run) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
            redirect("add-category.php", "Category Created successfully", "success");
        } else {
            throw new Exception("Something went wrong");
        }
    } catch (mysqli_sql_exception $e) {
        // Check if the error is due to duplicate entry
        if ($e->getCode() == 1062) {
            redirect("add-category.php", "Please choose a different slug.", "error");
        } else {
            redirect("add-category.php", "An unexpected error occurred.", "error");
        }
    }
}
//update
else if (isset($_POST['update_category_btn'])) {
    //escape string values
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $popularity = mysqli_real_escape_string($conn, $_POST['popularity']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($conn, $_POST['meta_keywords']);


    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $update_filename = $new_image;
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . "." . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $path = "../uploads/categories";
    $update_query = "UPDATE categories SET name='$name', slug='$slug', description='$description',
        status='$status', popularity='$popularity', meta_title='$meta_title', meta_description='$meta_description',
        meta_keywords='$meta_keywords', image='$update_filename' WHERE id ='$category_id'";

    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        if ($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists(("../uploads/categories/" . $old_image)) && !empty($old_image)) {
                unlink("../uploads/categories/" . $old_image);
            }
        }
        redirect("categories.php", "Category updated successfully", "success");
    } else {
        redirect("edit-category.php", "Category not updated", "error");
    }
}
//delete
else if (isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    $category_query = "SELECT * FROM categories WHERE id='$category_id'";
    $category_query_run = mysqli_query($conn, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image = $category_data['image'];

    $delete_query = "DELETE FROM categories WHERE id='$category_id'";

    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {

        if (file_exists("../uploads/categories/" . $image)) {
            unlink("../uploads/categories/" . $image);
        }

        redirect("categories.php", "Category deleted successfully", "success");
    } else {
        redirect("categories.php", "Category not deleted", "error");
    }
}
//add product//category_id	rating	status	discount	product_name	description	original_price	selling_price	image	quantity	trending
if (isset($_POST['add_to_cart_btn'])) {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $product_name = $_POST['product_name'];
    $selling_price = $_POST['selling_price'];
    $image = $_POST['image'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($product_id <= 0 || empty($product_name) || empty($selling_price) || empty($image)) {
        redirect("cart.php", "Missing product details", "error");
        exit();
    }

    if ($quantity <= 0) {
        redirect("cart.php", "Invalid quantity", "error");
        exit();
    }

    if (isset($_SESSION['auth_user'])) {
        // Logged-in user, fetch user_id and email
        $user_id = $_SESSION['auth_user']['id'];
        $email = $_SESSION['auth_user']['email'];
    } else {
        // Not logged-in user
        $user_id = NULL;
        $email = NULL;
    }

    // Retrieve the current session ID
    $session_id = session_id();
    if (empty($session_id)) {
        error_log("Session ID is empty");
        redirect("cart.php", "Session issue. Try again.", "error");
        exit();
    }

    // Insert or update cart entry
    $cart_query = "
        INSERT INTO cart (product_id, product_name, selling_price, image, quantity, user_id, email, session_id, cart_order)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)
        ON DUPLICATE KEY UPDATE quantity = quantity + ?";

    if ($stmt = mysqli_prepare($conn, $cart_query)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'issssissi', $product_id, $product_name, $selling_price, $image, $quantity, $user_id, $email, $session_id, $quantity);

        if (mysqli_stmt_execute($stmt)) {
            redirect("../index.php", "Product added to cart successfully", "success");
        } else {
            error_log("MySQL Error: " . mysqli_error($conn));
            redirect("../index.php", "Product not added to cart", "error");
        }

        // Close prepared statement
        mysqli_stmt_close($stmt);
    } else {
        error_log("MySQL Prepare Error: " . mysqli_error($conn));
        redirect("../index.php", "Error preparing statement", "error");
    }
}

// Handle updating the cart when the user logs in
if (isset($_SESSION['auth_user'])) {
    $user_id = $_SESSION['auth_user']['id'];
    $email = $_SESSION['auth_user']['email'];
    
    // Update cart entries for this user
    $update_query = "
        UPDATE cart
        SET user_id = ?, email = ?
        WHERE session_id = ? AND user_id IS NULL";
    
    if ($stmt = mysqli_prepare($conn, $update_query)) {
        // Bind parameters to update cart with user data
        mysqli_stmt_bind_param($stmt, 'iss', $user_id, $email, $session_id);
        
        if (mysqli_stmt_execute($stmt)) {
            // Optional: redirect or show success
            redirect("cart.php", "Cart updated with your details", "success");
        } else {
            error_log("MySQL Error: " . mysqli_error($conn));
        }
        
        // Close prepared statement
        mysqli_stmt_close($stmt);
    } else {
        error_log("MySQL Prepare Error: " . mysqli_error($conn));
    }
}


else if (isset($_POST['update_product_btn']))
{

    //escape string values
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $discount = mysqli_real_escape_string($conn, $_POST['discount']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $original_price = mysqli_real_escape_string($conn, $_POST['original_price']);
    $selling_price = mysqli_real_escape_string($conn, $_POST['selling_price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $trending = mysqli_real_escape_string($conn, $_POST['trending']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $featured = mysqli_real_escape_string($conn, $_POST['featured']);


    $image = $_FILES['image']['name'];

    $path = "../uploads/shop";


    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $update_filename = $new_image;
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . "." . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $update_product_query = "UPDATE products SET category_name='$category_name', rating='$rating', status='$status', discount='$discount', product_name='$product_name', description='$description', original_price='$original_price', selling_price='$selling_price', image='$update_filename', quantity='$quantity', trending='$trending', size='$size', featured='$featured' WHERE id ='$product_id'";
    $update_product_query_run = mysqli_query($conn, $update_product_query);

    if ($update_product_query_run) {
        if ($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists(("../uploads/shop/" . $old_image)) && !empty($old_image)) {
                unlink("../uploads/shop/" . $old_image);
            }
        }
        redirect("products.php", "Product updated successfully", "success");
    } else {
        redirect("edit-product.php", "Product not updated", "error");
    }

}
else
{
    header("Location: ../index.php");
}

//delete product with dialog of confirm to delete
if (isset($_POST['delete_product_btn'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    $product_query = "SELECT * FROM products WHERE id='$product_id'";
    $product_query_run = mysqli_query($conn, $product_query);
    $product_data = mysqli_fetch_array($product_query_run);
    $image = $product_data['image'];

    $delete_query = "DELETE FROM products WHERE id='$product_id'";

    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {

        if (file_exists("../uploads/shop/" . $image)) {
            unlink("../uploads/shop/" . $image);
        }

        redirect("products.php", "Product deleted successfully", "success");
    } else {
        redirect("products.php", "Product not deleted", "error");
    }
}

if (isset($_POST['update_user_btn'])) {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role_as = $_POST['role_as'];
    $user_status = $_POST['user_status'];  // Corrected to use 'user_status'
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $path = "../uploads/profile";
    $profile_picture = $_FILES['profile_picture']['name'];

    if (!empty($profile_picture)) {
        // Get the current profile picture from the database
        $query = "SELECT profile_picture FROM users WHERE id = '$user_id' LIMIT 1";
        $result = mysqli_query($conn, $query);
        $current_image = mysqli_fetch_assoc($result)['profile_picture'];

        // Generate a new filename for the uploaded image
        $profile_picture_ext = pathinfo($profile_picture, PATHINFO_EXTENSION);
        $filename = time() . "." . $profile_picture_ext;

        // Update the user data including the new profile picture
        $update_user_query = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', role_as='$role_as', user_status='$user_status', password='$hashed_password', profile_picture='$filename' WHERE id='$user_id'";
        $update_user_query_run = mysqli_query($conn, $update_user_query);

        if ($update_user_query_run) {
            // Remove the current image if it exists
            if (!empty($current_image) && file_exists($path . '/' . $current_image)) {
                unlink($path . '/' . $current_image);
            }

            // Save the new profile picture
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $path . '/' . $filename);
            redirect("users-manage.php", "User updated successfully", "success");
        } else {
            redirect("edit-user.php", "User not updated", "error");
        }
    } else {
        // Update the user data without changing the profile picture
        $update_user_query = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', role_as='$role_as', user_status='$user_status', password='$hashed_password' WHERE id='$user_id'";
        $update_user_query_run = mysqli_query($conn, $update_user_query);

        if ($update_user_query_run) {
            redirect("users-manage.php", "User updated successfully", "success");
        } else {
            redirect("edit-user.php", "User not updated", "error");
        }
    }
}


//add_user
if (isset($_POST['add_user'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $role_as = mysqli_real_escape_string($conn, $_POST['role_as']);
    $user_status = mysqli_real_escape_string($conn, $_POST['user_status']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    $path = "../uploads/profile";
    $profile_picture = $_FILES['profile_picture']['name'];

    if ($password != $confirm_password) {
        redirect("users-add.php", "Passwords do not match", "error");
        exit;
    }

    // Check if the email already exists in the database
    $email_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $email_check_result = mysqli_query($conn, $email_check_query);
    
    if (mysqli_num_rows($email_check_result) > 0) {
        // Email already exists
        redirect("users-add.php", "Email is already registered", "error");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $profile_picture_ext = pathinfo($profile_picture, PATHINFO_EXTENSION);
    $filename = time() . "." . $profile_picture_ext;

    $add_user_query = "INSERT INTO users
            (first_name, last_name, email, phone, role_as, user_status, password, profile_picture) 
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$role_as', '$user_status', '$hashed_password', '$filename')";

    $add_user_query_run = mysqli_query($conn, $add_user_query);

    if ($add_user_query_run) {
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $path . '/' . $filename);
        redirect("users-manage.php", "User Created successfully", "success");
    } else {
        redirect("users-add.php", "Something went wrong", "error");
    }
}

//delete_user_btn
if (isset($_POST['delete_user_btn'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['id']);

    $user_query = "SELECT * FROM users WHERE id='$user_id'";
    $user_query_run = mysqli_query($conn, $user_query);
    $user_data = mysqli_fetch_array($user_query_run);
    $profile_picture = $user_data['profile_picture'];

    $delete_query = "DELETE FROM users WHERE id='$user_id'";

    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {

        if (file_exists("../uploads/profile/" . $profile_picture)) {
            unlink("../uploads/profile/" . $profile_picture);
        }
        
        redirect("users-manage.php", "User deleted successfully", "success");
    } else {
        redirect("users-manage.php", "User not deleted", "error");
    }
}
if (isset($_POST['add_to_cart_btn'])) {
    $product_id = isset($_POST['product_id']) ? (int)mysqli_real_escape_string($conn, $_POST['product_id']) : 0;
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $selling_price = mysqli_real_escape_string($conn, $_POST['selling_price']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $quantity = isset($_POST['quantity']) ? (int)mysqli_real_escape_string($conn, $_POST['quantity']) : 1;

    if ($product_id <= 0 || empty($product_name) || empty($selling_price) || empty($image)) {
        redirect("cart.php", "Missing product details", "error");
        exit();
    }

    if ($quantity <= 0) {
        redirect("cart.php", "Invalid quantity", "error");
        exit();
    }

    if (isset($_SESSION['auth_user'])) {
        $user_id = $_SESSION['auth_user']['id'];
        $email = $_SESSION['auth_user']['email'];
    } else {
        $user_id = NULL;
        $email = NULL;
    }

    // Retrieve the current session ID
    $session_id = session_id();
    if (empty($session_id)) {
        error_log("Session ID is empty");
        redirect("cart.php", "Session issue. Try again.", "error");
        exit();
    }

    // Insert or update cart entry
    $cart_query = "
        INSERT INTO cart (product_id, product_name, selling_price, image, quantity, user_id, email, session_id, cart_order)
        VALUES ('$product_id', '$product_name', '$selling_price', '$image', '$quantity', '$user_id', '$email', '$session_id', 1)
        ON DUPLICATE KEY UPDATE quantity = quantity + '$quantity'";

    $cart_query_run = mysqli_query($conn, $cart_query);

    if ($cart_query_run) {
        redirect("../index.php", "Product added to cart successfully", "success");
    } else {
        error_log("MySQL Error: " . mysqli_error($conn)); // Log errors
        redirect("../index.php", "Product not added to cart", "error");
    }
}