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
//add_product_btn
if (isset($_POST['add_product_btn'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $rating        = (isset($_POST['rating']) && is_numeric($_POST['rating'])) ? $_POST['rating'] : 0;
    $status        = isset($_POST['status']) ? 1 : 0;
    $discount      = (isset($_POST['discount']) && is_numeric($_POST['discount'])) ? $_POST['discount'] : 0;
    $product_name  = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description   = mysqli_real_escape_string($conn, $_POST['description']);
    $original_price= (isset($_POST['original_price']) && is_numeric($_POST['original_price'])) ? $_POST['original_price'] : 0;
    $selling_price = (isset($_POST['selling_price']) && is_numeric($_POST['selling_price'])) ? $_POST['selling_price'] : 0;
    $quantity      = (isset($_POST['quantity']) && is_numeric($_POST['quantity'])) ? $_POST['quantity'] : 0;
    $trending      = isset($_POST['trending']) ? 1 : 0;
    $size          = mysqli_real_escape_string($conn, $_POST['size']);
    $featured      = isset($_POST['featured']) ? 1 : 0;
    $brand_name    = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $deal_of_day_status = isset($_POST['deal_of_day_status']) ? 1 : 0;


    // Handle Image Upload
    if (!empty($_FILES['image']['name'])) {
        $image         = $_FILES['image']['name'];
        $path          = "../uploads/shop";
        $image_ext     = pathinfo($image, PATHINFO_EXTENSION);
        $filename      = time() . "." . $image_ext;
        $image_tmp     = $_FILES['image']['tmp_name'];

        // Validate image extension (optional but recommended)
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array(strtolower($image_ext), $allowed_extensions)) {
            redirect("products-add.php", "Invalid image format. Only JPG, PNG, and GIF allowed.", "error");
            exit;
        }
    } else {
        $filename = NULL; // No image uploaded
    }

    // Capture Deal of the Day inputs
    $deal_of_day = isset($_POST['deal_of_day_status']) ? 1 : 0;
    $deal_start = NULL;
    $deal_end   = NULL;
    
    if ($deal_of_day) {
        if (!empty($_POST['deal_start']) && !empty($_POST['deal_end'])) {
            $deal_start = mysqli_real_escape_string($conn, $_POST['deal_start']);
            $deal_end   = mysqli_real_escape_string($conn, $_POST['deal_end']);
        }
    }

    // Basic validation: Ensure required fields are filled
    if (empty($category_name) || empty($product_name) || empty($description) || empty($size)) {
        redirect("products-add.php", "Please fill all required fields.", "error");
        exit;
    }

    // Insert product into the database
    $add_product_query = "INSERT INTO products 
            (category_name, rating, status, discount, product_name, description, original_price, selling_price, image, quantity, trending, size, featured, brand_name , deal_of_day_status, deal_start, deal_end) 
            VALUES (
                '$category_name', 
                '$rating', 
                '$status', 
                '$discount', 
                '$product_name', 
                '$description', 
                '$original_price', 
                '$selling_price', 
                " . ($filename ? "'$filename'" : "NULL") . ", 
                '$quantity', 
                '$trending', 
                '$size', 
                '$featured', 
                '$brand_name',
                '$deal_of_day_status', 
                " . (!empty($deal_start) ? "'$deal_start'" : "NULL") . ", 
                " . (!empty($deal_end) ? "'$deal_end'" : "NULL") . "
            )";

    $add_product_query_run = mysqli_query($conn, $add_product_query);

    if ($add_product_query_run) {
        if ($filename) {
            move_uploaded_file($image_tmp, "$path/$filename");
        }
        redirect("products-add.php", "Product Created Successfully", "success");
    } else {
        redirect("products-add.php", "Something went wrong", "error");
    }
}

else if (isset($_POST['update_product_btn'])) {
    // Escape string values
    $product_id    = mysqli_real_escape_string($conn, $_POST['product_id']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $rating        = mysqli_real_escape_string($conn, $_POST['rating']);
    $status        = mysqli_real_escape_string($conn, $_POST['status']);
    $discount      = mysqli_real_escape_string($conn, $_POST['discount']);
    $product_name  = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description   = mysqli_real_escape_string($conn, $_POST['description']);
    $original_price= mysqli_real_escape_string($conn, $_POST['original_price']);
    $selling_price = mysqli_real_escape_string($conn, $_POST['selling_price']);
    $quantity      = mysqli_real_escape_string($conn, $_POST['quantity']);
    $trending      = mysqli_real_escape_string($conn, $_POST['trending']);
    $size          = mysqli_real_escape_string($conn, $_POST['size']);
    $featured      = mysqli_real_escape_string($conn, $_POST['featured']);
    $brand_name    = mysqli_real_escape_string($conn, $_POST['brand_name']);

    // Image update
    $path          = "../uploads/shop";
    $old_image     = $_POST['old_image'];
    $new_image     = $_FILES['image']['name'];
    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . "." . $image_ext;
    } else {
        $update_filename = $old_image;
    }
    
    // Deal of the Day inputs
    $deal_of_day = isset($_POST['deal_of_day']) ? 1 : 0;
    if ($deal_of_day) {
        $deal_start = (!empty($_POST['deal_start'])) ? mysqli_real_escape_string($conn, $_POST['deal_start']) : "";
        $deal_end   = (!empty($_POST['deal_end'])) ? mysqli_real_escape_string($conn, $_POST['deal_end']) : "";
    } else {
        $deal_start = "";
        $deal_end   = "";
    }
    // Capture deal status from the dropdown.
    $deal_status = isset($_POST['deal_of_day_status']) ? mysqli_real_escape_string($conn, $_POST['deal_of_day_status']) : "";
    $deal_status_sql = ($deal_status === "" || $deal_status === "NULL") ? "NULL" : "'$deal_status'";

    // Build update query, including deal fields and deal status.
    $update_product_query = "UPDATE products SET 
        category_name = '$category_name', 
        rating = '$rating', 
        status = '$status', 
        discount = '$discount', 
        product_name = '$product_name', 
        description = '$description', 
        original_price = '$original_price', 
        selling_price = '$selling_price', 
        image = '$update_filename', 
        quantity = '$quantity', 
        trending = '$trending',
        brand_name = '$brand_name', 
        size = '$size', 
        featured = '$featured', 
        deal_start = " . (!empty($deal_start) ? "'$deal_start'" : "NULL") . ", 
        deal_end = " . (!empty($deal_end) ? "'$deal_end'" : "NULL") . ", 
        deal_of_day_status = $deal_status_sql
        WHERE id ='$product_id'";
    
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
        redirect("edit-product.php?id=" . $product_id, "Product not updated", "error");
    }
} else {
    header("Location: ../index.php");
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


//


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


//add_brand_btn , image willl be saved to brands folder brand_name	brand_image	brand_description	status
if (isset($_POST['add_brand_btn'])) {
    $brand_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $brand_description = mysqli_real_escape_string($conn, $_POST['brand_description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $brand_image = $_FILES['brand_image']['name'];

    $path = "../uploads/brands";

    $image_ext = pathinfo($brand_image, PATHINFO_EXTENSION);
    $filename = time() . "." . $image_ext;

    // Perform basic validation
    if (empty($brand_name) || empty($brand_description)) {
        redirect("add-brand.php", "Please fill all fields to continue.", "error");
        exit; // Stop further processing
    }

    $add_brand_query = "INSERT INTO brands
            (brand_name, brand_image, brand_description, status) 
            VALUES ('$brand_name', '$filename', '$brand_description', '$status')";

    $add_brand_query_run = mysqli_query($conn, $add_brand_query);

    if ($add_brand_query_run) {
        move_uploaded_file($_FILES['brand_image']['tmp_name'], $path . '/' . $filename);
        redirect("add-brand.php", "Brand Created successfully", "success");
    } else {
        redirect("add-brand.php", "Something went wrong", "error");
    }
}
//update_brand_btn
else if (isset($_POST['update_brand_btn'])) {
    //escape string values
    $brand_id = mysqli_real_escape_string($conn, $_POST['brand_id']);
    $brand_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $brand_description = mysqli_real_escape_string($conn, $_POST['brand_description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $new_image = $_FILES['brand_image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $update_filename = $new_image;
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . "." . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $path = "../uploads/brands";
    $update_query = "UPDATE brands SET brand_name='$brand_name', brand_description='$brand_description', status='$status', brand_image='$update_filename' WHERE id ='$brand_id'";
    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        if ($_FILES['brand_image']['name'] != "") {
            move_uploaded_file($_FILES['brand_image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists(("../uploads/brands/" . $old_image)) && !empty($old_image)) {
                unlink("../uploads/brands/" . $old_image);
            }
        }
        redirect("brands.php", "Brand updated successfully", "success");
    } else {
        redirect("edit-brand.php", "Brand not updated", "error");
    }
}

//delete_brand_btn
else if (isset($_POST['delete_brand_btn'])) {
    $brand_id = mysqli_real_escape_string($conn, $_POST['brand_id']);

    $brand_query = "SELECT * FROM brands WHERE id='$brand_id'";
    $brand_query_run = mysqli_query($conn, $brand_query);
    $brand_data = mysqli_fetch_array($brand_query_run);
    $image = $brand_data['brand_image'];

    $delete_query = "DELETE FROM brands WHERE id='$brand_id'";

    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {

        if (file_exists("../uploads/brands/" . $image)) {
            unlink("../uploads/brands/" . $image);
        }

        redirect("brands.php", "Brand deleted successfully", "success");
    } else {
        redirect("brands.php", "Brand not deleted", "error");
    }
}

//add_featured_tag_btn
// Assign featured tag to selected products
if (isset($_POST['add_featured_tag_btn'])) {
    $tag = mysqli_real_escape_string($conn, $_POST['tag_name']);
    $product_ids = $_POST['product_ids'] ?? [];

    if (!empty($tag)) {
        if (empty($product_ids)) {
            // Find one available dummy product to assign tag to (limit 1)
            $dummyResult = mysqli_query($conn, "SELECT id FROM products WHERE status=0 AND (featured IS NULL OR featured = '') LIMIT 1");
            if (mysqli_num_rows($dummyResult) > 0) {
                $dummy = mysqli_fetch_assoc($dummyResult);
                $product_ids = [$dummy['id']];
            } else {
                // No available dummy product - you may want to handle this case
                $_SESSION['message'] = "No available dummy products to assign the tag. Please select a product.";
                $_SESSION['messageType'] = "error";
                header("Location: featured-tags-manage.php");
                exit();
            }
        }

        // Assign tag to selected products (or dummy)
        foreach ($product_ids as $product_id) {
            $product_id = intval($product_id);
            mysqli_query($conn, "UPDATE products SET featured = '$tag' WHERE id = $product_id");
        }

        $_SESSION['message'] = "Featured tag assigned successfully!";
        $_SESSION['messageType'] = "success";
    } else {
        $_SESSION['message'] = "Please enter a tag name.";
        $_SESSION['messageType'] = "error";
    }

    header("Location: featured-tags-manage.php");
    exit();
}

if (isset($_POST['delete_tag_btn'])) {
    $tag_to_delete = mysqli_real_escape_string($conn, $_POST['tag_delete']);

    // Step 1: Remove the tag from all products
    $query = "UPDATE products SET featured = '' WHERE featured = '$tag_to_delete'";
    $result = mysqli_query($conn, $query);

    // Step 2: Check if the tag is used in any other products
    $checkQuery = "SELECT COUNT(*) as count FROM products WHERE featured = '$tag_to_delete'";
    $checkResult = mysqli_query($conn, $checkQuery);
    $countRow = mysqli_fetch_assoc($checkResult);
    $usedCount = $countRow['count'];

    // Step 3: If not used, delete it from the tags table
    if ($usedCount == 0) {
        $deleteTagQuery = "DELETE FROM tags WHERE tag_name = '$tag_to_delete'";
        mysqli_query($conn, $deleteTagQuery);
    }

    $_SESSION['message'] = $result ? "Tag removed from products and synced with tags." : "Failed to remove tag.";
    $_SESSION['messageType'] = $result ? "success" : "error";
    header("Location: featured-tags-manage.php");
    exit();
}


if (isset($_POST['update_featured_tag_btn'])) {
    $old_tag_name = mysqli_real_escape_string($conn, $_POST['old_tag_name']);
    $new_tag_name = mysqli_real_escape_string($conn, $_POST['new_tag_name']);
    $product_ids = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];

    // 1. Update all products currently using the old tag
    mysqli_query($conn, "UPDATE products SET featured = NULL WHERE featured = '$old_tag_name'");

    // 2. Assign the new tag to selected products
    if (!empty($product_ids)) {
        foreach ($product_ids as $prod_id) {
            $prod_id = mysqli_real_escape_string($conn, $prod_id);
            mysqli_query($conn, "UPDATE products SET featured = '$new_tag_name' WHERE id = '$prod_id'");
        }
    }

    $_SESSION['message'] = "Tag updated successfully.";
    $_SESSION['messageType'] = "success";
    header("Location: featured-tags-manage.php");
    exit();
}
if (isset($_POST['assign_featured_tag_btn'])) {
    // Choose tag from new tag input or existing tag dropdown
    $new_tag = trim(mysqli_real_escape_string($conn, $_POST['new_tag_name'] ?? ''));
    $existing_tag = trim(mysqli_real_escape_string($conn, $_POST['existing_tag'] ?? ''));

    // Determine the tag to assign
    $tag = !empty($new_tag) ? $new_tag : (!empty($existing_tag) ? $existing_tag : '');

    $product_ids = $_POST['product_ids'] ?? [];

    if (empty($tag)) {
        $_SESSION['message'] = "Please select an existing tag or enter a new tag name.";
        $_SESSION['messageType'] = "error";
        header("Location: featured-tags-manage.php");
        exit();
    }

    // If no products selected, try to assign tag to one dummy product (status=0 and no featured tag)
    if (empty($product_ids)) {
        $dummyResult = mysqli_query($conn, "SELECT id FROM products WHERE status = 0 AND (featured IS NULL OR featured = '') LIMIT 1");
        if (mysqli_num_rows($dummyResult) > 0) {
            $dummy = mysqli_fetch_assoc($dummyResult);
            $product_ids = [$dummy['id']];
        } else {
            $_SESSION['message'] = "No products selected and no dummy product available to assign the tag. Please select at least one product.";
            $_SESSION['messageType'] = "error";
            header("Location: featured-tags-manage.php");
            exit();
        }
    }

    // Assign tag to all selected product IDs
    $stmt = $conn->prepare("UPDATE products SET featured = ? WHERE id = ?");
    if (!$stmt) {
        $_SESSION['message'] = "Database error: " . $conn->error;
        $_SESSION['messageType'] = "error";
        header("Location: featured-tags-manage.php");
        exit();
    }

    foreach ($product_ids as $pid) {
        $pid = intval($pid);
        $stmt->bind_param("si", $tag, $pid);
        $stmt->execute();
    }
    $stmt->close();

    $_SESSION['message'] = "Featured tag assigned successfully!";
    $_SESSION['messageType'] = "success";
    header("Location: featured-tags-manage.php");
    exit();
}
if (isset($_POST['sync_tags'])) {
    $query = "SELECT DISTINCT featured FROM products WHERE featured IS NOT NULL AND featured != ''";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $_SESSION['message'] = "Failed to fetch product tags.";
        $_SESSION['messageType'] = "error";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $featuredTags = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $featuredTags[] = $row['featured'];
    }

    // Get current tags and count
    $tagsResult = mysqli_query($conn, "SELECT id, tag_name FROM tags ORDER BY id ASC");
    $existingTags = [];
    $existingTagNames = [];

    while ($row = mysqli_fetch_assoc($tagsResult)) {
        $existingTags[] = $row;
        $existingTagNames[] = $row['tag_name'];
    }

    // If tag count is already 10, deny access
    if (count($existingTags) >= 10) {
        $_SESSION['message'] = "Maximum tag limit reached (10). Please request access from admin.";
        $_SESSION['messageType'] = "error";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $inserted = 0;
    $deleted = 0;

    // Insert missing tags
    foreach ($featuredTags as $tag) {
        if (!in_array($tag, $existingTagNames)) {
            $safeTag = mysqli_real_escape_string($conn, $tag);

            // Calculate today's date
            $today = date('Ymd');

            // Assign the next available ID (simulate)
            $newId = 1;
            $usedIds = array_column($existingTags, 'id');
            while (in_array($newId, $usedIds)) {
                $newId++;
            }

            if (count($existingTags) + $inserted >= 10) {
                $_SESSION['message'] = "Only limited tag slots are available. Contact admin.";
                $_SESSION['messageType'] = "error";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            $description = "{$newId}#ecommerce{$today}";
            $query = "INSERT INTO tags (tag_name, description) VALUES ('$safeTag', '$description')";
            $insertResult = mysqli_query($conn, $query);

            if ($insertResult) {
                $inserted++;
                $usedIds[] = $newId; // mark id as used
            }
        }
    }

    // Delete unused tags
    foreach ($existingTagNames as $tag) {
        if (!in_array($tag, $featuredTags)) {
            $safeTag = mysqli_real_escape_string($conn, $tag);
            $deleteResult = mysqli_query($conn, "DELETE FROM tags WHERE tag_name = '$safeTag'");
            if ($deleteResult) $deleted++;
        }
    }

    if ($inserted === 0 && $deleted === 0) {
        $_SESSION['message'] = "No changes detected. Tags are already up to date.";
        $_SESSION['messageType'] = "info";
    } else {
        $_SESSION['message'] = "Tags synced successfully. Inserted: $inserted, Deleted: $deleted.";
        $_SESSION['messageType'] = "success";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
