<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../admin/config/dbcon.php');
include('../functions/myfunctions.php');
include('../middleware/adminMiddleware.php');

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

if (isset($_POST['add_product_btn'])) {
    $category_name  = mysqli_real_escape_string($conn, $_POST['category_name']);
    $rating         = isset($_POST['rating']) ? $_POST['rating'] : 0;
    $status         = isset($_POST['status']) ? $_POST['status'] : 0;
    $discount       = isset($_POST['discount']) ? $_POST['discount'] : 0;
    $product_name   = mysqli_real_escape_string($conn, $_POST['product_name']);
    $brand_name     = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $size           = mysqli_real_escape_string($conn, $_POST['size']);
    $featured       = mysqli_real_escape_string($conn, $_POST['featured']);
    $description    = mysqli_real_escape_string($conn, $_POST['description']);
    $original_price = isset($_POST['original_price']) ? $_POST['original_price'] : 0;
    $selling_price  = isset($_POST['selling_price']) ? $_POST['selling_price'] : 0;
    $quantity       = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
    $trending       = isset($_POST['trending']) ? $_POST['trending'] : 0;

    // Deal of the Day
    $deal_status = isset($_POST['deal_of_day_status']) ? 1 : 0;
    $deal_start  = !empty($_POST['deal_start']) ? $_POST['deal_start'] : null;
    $deal_end    = !empty($_POST['deal_end']) ? $_POST['deal_end'] : null;

    // Handle sale_out_limit
    $sale_out_limit = 'no limit'; // Default value
    if (isset($_POST['limit_type']) && $_POST['limit_type'] === 'limit') {
        $limit_val = isset($_POST['sale_out_limit']) && $_POST['sale_out_limit'] !== '' 
            ? (int)$_POST['sale_out_limit'] 
            : null;
        if (!is_null($limit_val) && $limit_val > 0) {
            $sale_out_limit = (string)$limit_val;
        }
    }

    // Insert product into products table
    $insert_product = "INSERT INTO products     
(category_name, rating, status, discount, product_name, brand_name, size, featured, description, original_price, selling_price, quantity, trending, deal_of_day_status, deal_start, deal_end, sale_out_limit) 
VALUES
        ('{$category_name}', {$rating}, {$status}, {$discount}, '{$product_name}', '{$brand_name}',
         '{$size}', '{$featured}', '{$description}', {$original_price}, {$selling_price}, {$quantity}, {$trending},
         {$deal_status}, " . (!is_null($deal_start) ? "'{$deal_start}'" : "NULL") . ", " .
        (!is_null($deal_end)   ? "'{$deal_end}'"   : "NULL")   . ", '{$sale_out_limit}')";

    $insert_result = mysqli_query($conn, $insert_product);

    if ($insert_result) {
        $product_id = mysqli_insert_id($conn); // Get the new product ID

        // === Multiple Image Upload Handling ===
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $uploadDir = "../uploads/shop/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['images']['name'] as $index => $imageName) {
                $imageTmpName = $_FILES['images']['tmp_name'][$index];
                $imageSize = $_FILES['images']['size'][$index];
                $imageError = $_FILES['images']['error'][$index];

                // Skip if error
                if ($imageError !== 0) continue;

                $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
                $uniqueName = uniqid("prod_", true) . "." . $imageExt;
                $uploadPath = $uploadDir . $uniqueName;

                if (move_uploaded_file($imageTmpName, $uploadPath)) {
                    // Insert into product_images table
                    $is_primary = ($index == 0) ? 1 : 0;
                    $alt_text = $product_name . ' image ' . ($index + 1);
                    $uploadPathEscaped = mysqli_real_escape_string($conn, $uploadPath);

                    $imageInsert = "INSERT INTO product_images (product_id, image_path, alt_text, is_primary)
                                    VALUES ('$product_id', '$uploadPathEscaped', '$alt_text', '$is_primary')";
                    mysqli_query($conn, $imageInsert);
                }
            }
        }

        $_SESSION['message'] = "Product added successfully with images.";
        $_SESSION['messageType'] = "success";
        header("Location: products.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to add product.";
        $_SESSION['messageType'] = "error";
        header("Location: products-add.php");
        exit();
    }
} else if (isset($_POST['update_product_btn'])) {
    // Escape string values
    $product_id    = mysqli_real_escape_string($conn, $_POST['product_id']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $rating        = mysqli_real_escape_string($conn, $_POST['rating']);
    $status        = mysqli_real_escape_string($conn, $_POST['status']);
    $discount      = mysqli_real_escape_string($conn, $_POST['discount']);
    $product_name  = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description   = mysqli_real_escape_string($conn, $_POST['description']);
    $original_price = mysqli_real_escape_string($conn, $_POST['original_price']);
    $selling_price = mysqli_real_escape_string($conn, $_POST['selling_price']);
    $quantity      = mysqli_real_escape_string($conn, $_POST['quantity']);
    $trending      = mysqli_real_escape_string($conn, $_POST['trending']);
    $size          = mysqli_real_escape_string($conn, $_POST['size']);
    $featured      = mysqli_real_escape_string($conn, $_POST['featured']);
    $brand_name    = mysqli_real_escape_string($conn, $_POST['brand_name']);

    // Handle sale_out_limit
    $sale_out_limit = 'no limit'; // Default value
    if (isset($_POST['limit_type']) && $_POST['limit_type'] === 'limit') {
        $limit_val = isset($_POST['sale_out_limit']) && $_POST['sale_out_limit'] !== '' 
            ? (int)$_POST['sale_out_limit'] 
            : null;
        if (!is_null($limit_val) && $limit_val > 0) {
            $sale_out_limit = (string)$limit_val;
        }
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

    // Update the main product info (except images)
    $update_product_query = "UPDATE products SET 
        category_name = '$category_name', 
        rating = '$rating', 
        status = '$status', 
        discount = '$discount', 
        product_name = '$product_name', 
        description = '$description', 
        original_price = '$original_price', 
        selling_price = '$selling_price', 
        quantity = '$quantity', 
        trending = '$trending',
        brand_name = '$brand_name', 
        size = '$size', 
        featured = '$featured', 
        deal_start = " . (!empty($deal_start) ? "'$deal_start'" : "NULL") . ", 
        deal_end = " . (!empty($deal_end) ? "'$deal_end'" : "NULL") . ", 
        deal_of_day_status = $deal_status_sql,
        sale_out_limit = '$sale_out_limit'
        WHERE id ='$product_id'";

    $update_product_query_run = mysqli_query($conn, $update_product_query);

    if ($update_product_query_run) {
        // Directory for uploads
        $uploadDir = "../uploads/shop/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Check if multiple new images are uploaded
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            // Optional: Delete old images from product_images table & filesystem if you want to replace all images
            // 1. Fetch old images
            $old_images_res = mysqli_query($conn, "SELECT image_path FROM product_images WHERE product_id = '$product_id'");
            while ($row = mysqli_fetch_assoc($old_images_res)) {
                $oldImagePath = "../" . $row['image_path'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // delete old image file
                }
            }
            // 2. Delete old image records
            mysqli_query($conn, "DELETE FROM product_images WHERE product_id = '$product_id'");

            // Upload new images and insert into product_images table
            foreach ($_FILES['images']['name'] as $index => $imageName) {
                $imageTmpName = $_FILES['images']['tmp_name'][$index];
                $imageError = $_FILES['images']['error'][$index];

                if ($imageError !== 0) continue; // skip errors

                $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
                $uniqueName = uniqid("prod_", true) . "." . $imageExt;
                $uploadPath = $uploadDir . $uniqueName;

                if (move_uploaded_file($imageTmpName, $uploadPath)) {
                    $is_primary = ($index == 0) ? 1 : 0;
                    $alt_text = $product_name . ' image ' . ($index + 1);
                    $uploadPathDB = mysqli_real_escape_string($conn, "uploads/shop/" . $uniqueName);

                    $imageInsert = "INSERT INTO product_images (product_id, image_path, alt_text, is_primary) 
                                    VALUES ('$product_id', '$uploadPathDB', '$alt_text', '$is_primary')";
                    mysqli_query($conn, $imageInsert);
                }
            }
        }

        redirect("products.php", "Product updated successfully with images", "success");
    } else {
        redirect("edit-product.php?id=" . $product_id, "Product not updated", "error");
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

    // Parse combined input like "#eco 7"
    $raw_input = $_POST['new_tag_name'] ?? '';
    preg_match('/^(#[^\s]+)\s*(\d*)$/', trim($raw_input), $matches);

    $new_tag_name = isset($matches[1]) ? mysqli_real_escape_string($conn, $matches[1]) : '';
    $order_num = isset($matches[2]) && is_numeric($matches[2]) ? (int)$matches[2] : 0;

    $product_ids = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];

    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    $status = mysqli_real_escape_string($conn, $_POST['status'] ?? 1);

    // 1. Remove the old tag from all products
    mysqli_query($conn, "UPDATE products SET featured = NULL WHERE featured = '$old_tag_name'");

    // 2. Assign the new tag to selected products
    if (!empty($product_ids)) {
        foreach ($product_ids as $prod_id) {
            $prod_id = mysqli_real_escape_string($conn, $prod_id);
            mysqli_query($conn, "UPDATE products SET featured = '$new_tag_name' WHERE id = '$prod_id'");
        }
    }

    // 3. Check if the new tag exists
    $checkTag = mysqli_query($conn, "SELECT * FROM tags WHERE tag_name = '$new_tag_name'");

    if (mysqli_num_rows($checkTag) > 0) {
        // 4. Tag exists, update it
        mysqli_query($conn, "
            UPDATE tags 
            SET 
                description = '$description', 
                order_num = '$order_num', 
                status = '$status', 
                updated_at = NOW() 
            WHERE tag_name = '$new_tag_name'
        ");
    } else {
        // 5. Tag does not exist, insert new
        mysqli_query($conn, "
            INSERT INTO tags (tag_name, description, order_num, status, created_at, updated_at)
            VALUES ('$new_tag_name', '$description', '$order_num', '$status', NOW(), NOW())
        ");
    }

    // 6. Check if old tag is still in use
    $checkOldTagQuery = "SELECT COUNT(*) as count FROM products WHERE featured = '$old_tag_name'";
    $oldTagResult = mysqli_query($conn, $checkOldTagQuery);
    $oldTagCount = mysqli_fetch_assoc($oldTagResult)['count'];

    if ($oldTagCount == 0) {
        // Delete the old tag if unused
        mysqli_query($conn, "DELETE FROM tags WHERE tag_name = '$old_tag_name'");
    }

    $_SESSION['message'] = "Tag updated successfully with full details.";
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
//add_banner_btn we  saving the image to uploads/banners id	title	subtitle	price	image	link	status	created_at	updated_at
if (isset($_POST['add_banner_btn'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $status = isset($_POST['status']) && $_POST['status'] == "1" ? 1 : 0;
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $banner_type = mysqli_real_escape_string($conn, $_POST['banner_type']);

    $banner_image = $_FILES['image']['name'];
    $path = "../uploads/banners/";

    // Validation
    if (empty($title) || empty($subtitle) || empty($price) || empty($link) || empty($banner_image) || empty($size) || empty($banner_type)) {
        redirect("add-banner.php", "Please fill all fields and select an image to continue.", "error");
        exit;
    }

    $image_ext = strtolower(pathinfo($banner_image, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($image_ext, $allowed_ext)) {
        redirect("add-banner.php", "Invalid image format. Allowed formats: jpg, jpeg, png, gif, webp.", "error");
        exit;
    }

    $filename = time() . "." . $image_ext;

    $banner_query = "INSERT INTO banners (title, subtitle, price, image, link, status, size, banner_type) 
                     VALUES ('$title', '$subtitle', '$price', '$filename', '$link', '$status', '$size', '$banner_type')";

    $banner_query_run = mysqli_query($conn, $banner_query);

    if ($banner_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . $filename);
        redirect("add-banner.php", "Banner created successfully", "success");
    } else {
        redirect("add-banner.php", "Something went wrong", "error");
    }
} else if (isset($_POST['update_banner_btn'])) {
    $banner_id = mysqli_real_escape_string($conn, $_POST['banner_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $status = isset($_POST['status']) && $_POST['status'] == "1" ? 1 : 0;
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $banner_type = mysqli_real_escape_string($conn, $_POST['banner_type']);

    $banner_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];
    $path = "../uploads/banners/";

    if (empty($title) || empty($subtitle) || empty($price) || empty($link) || empty($size) || empty($banner_type)) {
        redirect("banner.php", "Please fill all fields to continue.", "error");
        exit;
    }

    $update_query = "UPDATE banners SET 
                     title = '$title',
                     subtitle = '$subtitle',
                     price = '$price',
                     link = '$link',
                     status = '$status',
                     size = '$size',
                     banner_type = '$banner_type'";

    if (!empty($banner_image)) {
        $image_ext = strtolower(pathinfo($banner_image, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($image_ext, $allowed_ext)) {
            redirect("banner.php", "Invalid image format. Allowed formats: jpg, jpeg, png, gif, webp.", "error");
            exit;
        }

        $filename = time() . "." . $image_ext;
        $update_query .= ", image = '$filename'";
    }

    $update_query .= " WHERE id = '$banner_id'";

    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        if (!empty($banner_image)) {
            // Delete old image if exists
            if (file_exists($path . $old_image)) {
                unlink($path . $old_image);
            }
            move_uploaded_file($_FILES['image']['tmp_name'], $path . $filename);
        }
        redirect("banner.php", "Banner updated successfully", "success");
    } else {
        redirect("banner.php", "Something went wrong", "error");
    }
} else if (isset($_POST['delete_banner_btn'])) {
    $banner_id = mysqli_real_escape_string($conn, $_POST['banner_id']);

    $banner_query = "SELECT * FROM banners WHERE id='$banner_id'";
    $banner_query_run = mysqli_query($conn, $banner_query);
    $banner_data = mysqli_fetch_array($banner_query_run);
    $image = $banner_data['image'];

    $delete_query = "DELETE FROM banners WHERE id='$banner_id'";

    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {

        if (file_exists("../uploads/banners/" . $image)) {
            unlink("../uploads/banners/" . $image);
        }

        redirect("banner.php", "Banner deleted successfully", "success");
    } else {
        redirect("banner.php", "Banner not deleted", "error");
    }
}
// 1) Approve Feedback
if (isset($_POST['approve_feedback_btn'])) {
    $feedback_id = intval($_POST['feedback_id']);

    $update = "UPDATE feedback SET status = 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($stmt, "i", $feedback_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message']     = "Feedback approved successfully.";
        $_SESSION['messageType'] = "success";
    } else {
        $_SESSION['message']     = "Failed to approve feedback.";
        $_SESSION['messageType'] = "error";
    }

    mysqli_stmt_close($stmt);
    header("Location: manage-testimonials.php");
    exit();
}

// 2) Decline Feedback (set status = 2)
if (isset($_POST['decline_feedback_btn'])) {
    $feedback_id = intval($_POST['feedback_id']);

    $update = "UPDATE feedback SET status = 2 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($stmt, "i", $feedback_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message']     = "Feedback declined successfully.";
        $_SESSION['messageType'] = "success";
    } else {
        $_SESSION['message']     = "Failed to decline feedback.";
        $_SESSION['messageType'] = "error";
    }

    mysqli_stmt_close($stmt);
    header("Location: manage-testimonials.php");
    exit();
}

// 3) Delete Feedback
if (isset($_POST['delete_feedback_btn'])) {
    $feedback_id = intval($_POST['feedback_id']);

    // 3a) Retrieve image filename (if any) before deleting
    $query = "SELECT image FROM feedback WHERE id = ?";
    $stmt  = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $feedback_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $image);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // 3b) Delete the image file from uploads/feedback/ if it exists
    if (!empty($image)) {
        $imagePath = __DIR__ . "/../uploads/feedback/" . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // 3c) Delete the feedback record
    $delete = "DELETE FROM feedback WHERE id = ?";
    $stmt   = mysqli_prepare($conn, $delete);
    mysqli_stmt_bind_param($stmt, "i", $feedback_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message']     = "Feedback deleted successfully.";
        $_SESSION['messageType'] = "success";
    } else {
        $_SESSION['message']     = "Failed to delete feedback.";
        $_SESSION['messageType'] = "error";
    }

    mysqli_stmt_close($stmt);
    header("Location: manage-testimonials.php");
    exit();
}
//add_blog_category_btn id	name	image	slug	description	status	created_at	updated_at	 image wil be saved in uploads/blos/categories
if (isset($_POST['add_blog_category_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = !empty($_POST['slug']) ? strtolower(trim($_POST['slug'])) : strtolower(str_replace(" ", "-", $name));
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = $_POST['status'] == "1" ? 1 : 0;

    $image = $_FILES['image']['name'];
    $path = "../uploads/blogs/categories/";

    if (empty($name) || empty($slug) || empty($description) || empty($image)) {
        redirect("add-blog-category.php", "Please fill all fields and select an image to continue.", "error");
        exit;
    }

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array(strtolower($image_ext), $allowed_ext)) {
        redirect("add-blog-category.php", "Invalid image format. Allowed formats: jpg, jpeg, png, gif, webp.", "error");
        exit;
    }

    $filename = time() . "." . $image_ext;

    $query = "INSERT INTO blog_categories (name, slug, description, status, image) 
              VALUES ('$name', '$slug', '$description', '$status', '$filename')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . $filename);
        redirect("add-blog-category.php", "Blog category created successfully", "success");
    } else {
        redirect("add-blog-category.php", "Something went wrong: " . mysqli_error($conn), "error");
    }
} elseif (isset($_POST['update_blog_category_btn'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = !empty($_POST['slug']) ? strtolower(trim($_POST['slug'])) : strtolower(str_replace(" ", "-", $name));
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = $_POST['status'] == "1" ? 1 : 0;

    $image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];
    $path = "../uploads/blogs/categories/";

    if (empty($name) || empty($slug) || empty($description)) {
        redirect("edit-blog-category.php?id=" . $category_id, "Please fill all fields to continue.", "error");
        exit;
    }

    if (!empty($image)) {
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array(strtolower($image_ext), $allowed_ext)) {
            redirect("edit-blog-category.php?id=" . $category_id, "Invalid image format. Allowed formats: jpg, jpeg, png, gif, webp.", "error");
            exit;
        }
        $filename = time() . "." . $image_ext;
    } else {
        $filename = $old_image;
    }

    $query = "UPDATE blog_categories SET name='$name', slug='$slug', description='$description', status='$status', image='$filename' WHERE id='$category_id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (!empty($image)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . $filename);
            if (file_exists($path . $old_image) && !empty($old_image)) {
                unlink($path . $old_image);
            }
        }
        redirect("blog-category.php", "Blog category updated successfully", "success");
    } else {
        redirect("edit-blog-category.php?id=" . $category_id, "Something went wrong: " . mysqli_error($conn), "error");
    }
} elseif (isset($_POST['delete_blog_category'])) {
    $delete_blog_category_id = mysqli_real_escape_string($conn, $_POST['delete_blog_category_id']);

    $query = "SELECT * FROM blog_categories WHERE id='$delete_blog_category_id'";
    $result = mysqli_query($conn, $query);
    $category_data = mysqli_fetch_array($result);

    if (!$category_data) {
        redirect("blog-category.php", "Category not found", "error");
        exit();
    }

    $image = $category_data['image'];

    $delete_query = "DELETE FROM blog_categories WHERE id='$delete_blog_category_id'";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        if (file_exists("../uploads/blogs/categories/" . $image)) {
            unlink("../uploads/blogs/categories/" . $image);
        }
        redirect("blog-category.php", "Blog category deleted successfully", "success");
    } else {
        redirect("blog-category.php", "Blog category not deleted", "error");
    }
}
if (isset($_POST['add_blog_btn'])) {
    $category       = mysqli_real_escape_string($conn, $_POST['category']); // Now category name
    $title          = mysqli_real_escape_string($conn, $_POST['title']);
    $slug           = mysqli_real_escape_string($conn, $_POST['slug']);
    $description    = mysqli_real_escape_string($conn, $_POST['description']);
    $status         = isset($_POST['status']) ? $_POST['status'] : 0;

    // Lock author name to admin
    $author_name = "admin";

    // Sanitize slug (remove spaces and special chars)
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug), '-'));

    // Auto-generate meta_keywords from title if not provided
    $meta_keywords = '';
    if (!empty($_POST['meta_keywords'])) {
        $meta_keywords = mysqli_real_escape_string($conn, $_POST['meta_keywords']);
    } else {
        $clean_title = strtolower(trim(preg_replace('/[^a-zA-Z0-9\s]/', '', $title)));
        $tags_array = explode(" ", $clean_title);
        $meta_keywords = implode(",", array_unique($tags_array));
    }

    // Handle image upload
    $image = $_FILES['image']['name'];
    $image_filename = NULL;

    if ($image) {
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        $image_filename = time() . '-' . rand(1111, 9999) . '.' . $image_ext;
        $upload_path = "../uploads/blogs/";

        // Create directory if not exists
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $image_upload_success = move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $image_filename);

        if (!$image_upload_success) {
            $_SESSION['message'] = "Image upload failed.";
            $_SESSION['messageType'] = "error";
            header("Location: blogs-add.php");
            exit(0);
        }
    }

    // Insert query
    $insert_query = "INSERT INTO blogs 
        (category, title, slug, author_name, description, image, meta_keywords, status, published_date, created_at) 
        VALUES 
        ('$category', '$title', '$slug', '$author_name', '$description', '$image_filename', '$meta_keywords', '$status', CURDATE(), NOW())";

    $insert_result = mysqli_query($conn, $insert_query);

    if ($insert_result) {
        $_SESSION['message'] = "Blog added successfully!";
        $_SESSION['messageType'] = "success";
        header("Location: blogs.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong. Blog not added.";
        $_SESSION['messageType'] = "error";
        header("Location: blogs-add.php");
        exit(0);
    }
} elseif (isset($_POST['update_blog_btn'])) {
    $blog_id        = mysqli_real_escape_string($conn, $_POST['blog_id']);
    $category_id    = mysqli_real_escape_string($conn, $_POST['category_id']);  // from the form
    $title          = mysqli_real_escape_string($conn, $_POST['title']);
    $slug           = mysqli_real_escape_string($conn, $_POST['slug']);
    $author_name    = mysqli_real_escape_string($conn, $_POST['author_name']);
    $description    = mysqli_real_escape_string($conn, $_POST['description']);
    $meta_keywords  = mysqli_real_escape_string($conn, $_POST['meta_keywords']);
    $status         = isset($_POST['status']) ? $_POST['status'] : 0;

    // Sanitize slug (remove spaces and special characters)
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug), '-'));

    // Fetch category name from category_id
    $category_name = "";
    $cat_query = "SELECT name FROM blog_categories WHERE id = '$category_id' LIMIT 1";
    $cat_result = mysqli_query($conn, $cat_query);
    if ($cat_result && mysqli_num_rows($cat_result) > 0) {
        $cat_row = mysqli_fetch_assoc($cat_result);
        $category_name = mysqli_real_escape_string($conn, $cat_row['name']);
    } else {
        // Handle case where category_id is invalid
        $_SESSION['message'] = "Invalid category selected.";
        $_SESSION['messageType'] = "error";
        header("Location: blogs-edit.php?id=" . $blog_id);
        exit(0);
    }

    // Handle image upload (same as before)
    $image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];
    $image_filename = !empty($image) ? time() . '-' . rand(1111, 9999) . '.' . pathinfo($image, PATHINFO_EXTENSION) : $old_image;
    $upload_path = "../uploads/blogs/";

    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    if (!empty($image)) {
        $image_upload_success = move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $image_filename);
        if (!$image_upload_success) {
            $_SESSION['message'] = "Image upload failed.";
            $_SESSION['messageType'] = "error";
            header("Location: blogs-edit.php?id=" . $blog_id);
            exit(0);
        }
        if (file_exists($upload_path . $old_image)) {
            unlink($upload_path . $old_image);
        }
    } else {
        $image_filename = $old_image;
    }

    // Now update using category_name instead of category_id
    $update_query = "UPDATE blogs 
                     SET category='$category_name', title='$title', slug='$slug', author_name='$author_name', 
                         description='$description', image='$image_filename', meta_keywords='$meta_keywords', 
                         status='$status' 
                     WHERE id='$blog_id'";

    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        $_SESSION['message'] = "Blog updated successfully!";
        $_SESSION['messageType'] = "success";
        header("Location: blogs.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong. Blog not updated.";
        $_SESSION['messageType'] = "error";
        header("Location: blogs-edit.php?id=" . $blog_id);
        exit(0);
    }
}

if (isset($_POST['delete_blog_btn'])) {
    // Make sure to get the correct POST key
    $delete_blog_id = mysqli_real_escape_string($conn, $_POST['delete_blog_id']);

    // Get image filename to delete from server
    $query = "SELECT image FROM blogs WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $delete_blog_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $image);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Delete the image file if exists
    if (!empty($image)) {
        $imagePath = "../uploads/blogs/" . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete the blog record from database
    $delete = "DELETE FROM blogs WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete);
    mysqli_stmt_bind_param($stmt, "i", $delete_blog_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Blog deleted successfully.";
        $_SESSION['messageType'] = "success";
    } else {
        $_SESSION['message'] = "Failed to delete blog.";
        $_SESSION['messageType'] = "error";
    }

    mysqli_stmt_close($stmt);

    header("Location: blogs.php");
    exit();
} 

//add_promocode_btn  Full texts id code discount_type discount_value min_purchase max_discount start_date end_date usage_limit usage_count status created_at updated_at
if (isset($_POST['add_promocode_btn'])) {
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $discount_type = mysqli_real_escape_string($conn, $_POST['discount_type']);
    $discount_value = mysqli_real_escape_string($conn, $_POST['discount_value']);
    $min_purchase = mysqli_real_escape_string($conn, $_POST['min_purchase']);
    $max_discount = mysqli_real_escape_string($conn, $_POST['max_discount']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $usage_limit = mysqli_real_escape_string($conn, $_POST['usage_limit']);
    $status = isset($_POST['status']) ? 1 : 0;

    if (empty($code) || empty($discount_type) || empty($discount_value) || empty($min_purchase) || empty($max_discount) || empty($start_date) || empty($end_date)) {
        redirect("promocodes.php", "Please fill all fields to continue.", "error");
        exit;
    }

    $query = "INSERT INTO promocodes (code, discount_type, discount_value, min_purchase, max_discount, start_date, end_date, usage_limit, status) 
              VALUES ('$code', '$discount_type', '$discount_value', '$min_purchase', '$max_discount', '$start_date', '$end_date', '$usage_limit', '$status')";

    if (mysqli_query($conn, $query)) {
        redirect("promocodes.php", "Promocode created successfully", "success");
    } else {
        redirect("promocodes.php", "Something went wrong: " . mysqli_error($conn), "error");
    }
} elseif (isset($_POST['update_promocode_btn'])) {
    $promocode_id = mysqli_real_escape_string($conn, $_POST['promocode_id']);
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $discount_type = mysqli_real_escape_string($conn, $_POST['discount_type']);
    $discount_value = mysqli_real_escape_string($conn, $_POST['discount_value']);
    $min_purchase = mysqli_real_escape_string($conn, $_POST['min_purchase']);
    $max_discount = mysqli_real_escape_string($conn, $_POST['max_discount']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);   
    $usage_limit = mysqli_real_escape_string($conn, $_POST['usage_limit']);
    $status = isset($_POST['status']) ? 1 : 0;
    if (empty($code) || empty($discount_type) || empty($discount_value) || empty($min_purchase) || empty($max_discount) || empty($start_date) || empty($end_date)) {
        redirect("edit-promocode.php?id=" . $promocode_id, "Please fill all fields to continue.", "error");
        exit;
    }
    $query = "UPDATE promocodes SET 
              code = '$code', 
              discount_type = '$discount_type', 
              discount_value = '$discount_value', 
              min_purchase = '$min_purchase', 
              max_discount = '$max_discount', 
              start_date = '$start_date', 
              end_date = '$end_date', 
              usage_limit = '$usage_limit', 
              status = '$status' 
              WHERE id = '$promocode_id'";
    if (mysqli_query($conn, $query)) {
        redirect("promocodes.php", "Promocode updated successfully", "success");
        exit;
    } else {
        redirect("promocode-edit.php?id=" . $promocode_id, "Something went wrong: " . mysqli_error($conn), "error");
        exit;
    }
} elseif (isset($_POST['delete_promocode_btn'])) {
    $promocode_id = mysqli_real_escape_string($conn, $_POST['promocode_id']);

    $query = "DELETE FROM promocodes WHERE id = '$promocode_id'";
    if (mysqli_query($conn, $query)) {
        redirect("promocodes.php", "Promocode deleted successfully", "success");
    } else {
        redirect("promocodes.php", "Promocode not deleted: " . mysqli_error($conn), "error");
    }
}

// Update order (ERP-style)
if (isset($_POST['update_order_btn'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);
    $shipment_number = mysqli_real_escape_string($conn, $_POST['shipment_number']);
    $cart_subtotal = mysqli_real_escape_string($conn, $_POST['cart_subtotal']);
    $shipping_cost = mysqli_real_escape_string($conn, $_POST['shipping_cost']);
    $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
    $discount = mysqli_real_escape_string($conn, $_POST['discount']);
    $destination = mysqli_real_escape_string($conn, $_POST['destination']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
    $user_lat = mysqli_real_escape_string($conn, $_POST['user_lat']);
    $user_lng = mysqli_real_escape_string($conn, $_POST['user_lng']);
    $destination_lat = mysqli_real_escape_string($conn, $_POST['destination_lat']);
    $destination_lng = mysqli_real_escape_string($conn, $_POST['destination_lng']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $distance = mysqli_real_escape_string($conn, $_POST['distance']);
    $precise_location_name = mysqli_real_escape_string($conn, $_POST['precise_location_name']);
    $location_method = mysqli_real_escape_string($conn, $_POST['location_method']);

    $update = mysqli_query($conn, "UPDATE checkout SET order_status='$order_status', shipment_number='$shipment_number', cart_subtotal='$cart_subtotal', shipping_cost='$shipping_cost', total_amount='$total_amount', discount='$discount', destination='$destination', state='$state', postcode='$postcode', user_lat='$user_lat', user_lng='$user_lng', destination_lat='$destination_lat', destination_lng='$destination_lng', status='$status', distance='$distance', precise_location_name='$precise_location_name', location_method='$location_method' WHERE id='$order_id'");
    if ($update) {
        redirect('orders-view.php', 'Order updated successfully', 'success');
    } else {
        redirect('edit-order.php?id=' . $order_id, 'Order not updated', 'error');
    }
}

// Route creation logic (from create-route.php, now here)
if (isset($_POST['create_route_btn'])) {
    $route_name = mysqli_real_escape_string($conn, $_POST['route_name']);
    $route_code = mysqli_real_escape_string($conn, $_POST['route_code']);
    $distance_km = floatval($_POST['distance_km']);
    $estimated_time = mysqli_real_escape_string($conn, $_POST['estimated_time']);
    $stops_coords = isset($_POST['stops_coords']) ? json_decode($_POST['stops_coords'], true) : [];

    // Use first as start, last as end, in between as stops
    $start_location_name = $end_location_name = '';
    $start_lat = $start_lng = $end_lat = $end_lng = null;
    if (count($stops_coords) > 0) {
        $start_location_name = $stops_coords[0]['name'];
        $start_lat = $stops_coords[0]['lat'];
        $start_lng = $stops_coords[0]['lng'];
        $end_location_name = $stops_coords[count($stops_coords)-1]['name'];
        $end_lat = $stops_coords[count($stops_coords)-1]['lat'];
        $end_lng = $stops_coords[count($stops_coords)-1]['lng'];
    }

    // Insert into routes table
    $route_sql = "INSERT INTO routes (route_name, route_code, start_name, start_lat, start_lng, end_name, end_lat, end_lng, distance_km, estimated_time)
                  VALUES ('$route_name', '$route_code', '$start_location_name', $start_lat, $start_lng, '$end_location_name', $end_lat, $end_lng, $distance_km, '$estimated_time')";
    if (mysqli_query($conn, $route_sql)) {
        $route_id = mysqli_insert_id($conn);
        // Insert only intermediate stops (not first or last)
        if ($stops_coords && is_array($stops_coords)) {
            $order = 1;
            for ($i = 1; $i < count($stops_coords) - 1; $i++) {
                $stop = $stops_coords[$i];
                $stop_name = mysqli_real_escape_string($conn, $stop['name']);
                $stop_lat = floatval($stop['lat']);
                $stop_lng = floatval($stop['lng']);
                $stop_sql = "INSERT INTO route_stops (route_id, stop_order, stop_name, stop_lat, stop_lng)
                             VALUES ($route_id, $order, '$stop_name', $stop_lat, $stop_lng)";
                mysqli_query($conn, $stop_sql);
                $order++;
            }
        }
        $_SESSION['message'] = 'Route created successfully!';
        header('Location: manage-routes.php');
        exit;
    } else {
        $_SESSION['message'] = 'Error creating route: ' . mysqli_error($conn);
        header('Location: create-route.php');
        exit;
    }
}

if (isset($_POST['update_route_btn'])) {
    $route_id = intval($_POST['route_id']);
    $route_name = mysqli_real_escape_string($conn, $_POST['route_name']);
    $route_code = mysqli_real_escape_string($conn, $_POST['route_code']);
    $distance_km = floatval($_POST['distance_km']);
    $estimated_time = mysqli_real_escape_string($conn, $_POST['estimated_time']);
    $stops_coords = isset($_POST['stops_coords']) ? json_decode($_POST['stops_coords'], true) : [];

    // Use first as start, last as end, in between as stops
    $start_location_name = $end_location_name = '';
    $start_lat = $start_lng = $end_lat = $end_lng = null;
    if (count($stops_coords) > 0) {
        $start_location_name = $stops_coords[0]['name'];
        $start_lat = $stops_coords[0]['lat'];
        $start_lng = $stops_coords[0]['lng'];
        $end_location_name = $stops_coords[count($stops_coords)-1]['name'];
        $end_lat = $stops_coords[count($stops_coords)-1]['lat'];
        $end_lng = $stops_coords[count($stops_coords)-1]['lng'];
    }

    // Update routes table
    $route_sql = "UPDATE routes SET route_name='$route_name', route_code='$route_code', start_name='$start_location_name', start_lat=$start_lat, start_lng=$start_lng, end_name='$end_location_name', end_lat=$end_lat, end_lng=$end_lng, distance_km=$distance_km, estimated_time='$estimated_time' WHERE id=$route_id";
    $route_update = mysqli_query($conn, $route_sql);

    if ($route_update) {
        // Remove old stops
        mysqli_query($conn, "DELETE FROM route_stops WHERE route_id=$route_id");
        // Insert new stops (intermediate only)
        if ($stops_coords && is_array($stops_coords)) {
            $order = 1;
            for ($i = 1; $i < count($stops_coords) - 1; $i++) {
                $stop = $stops_coords[$i];
                $stop_name = mysqli_real_escape_string($conn, $stop['name']);
                $stop_lat = floatval($stop['lat']);
                $stop_lng = floatval($stop['lng']);
                $stop_sql = "INSERT INTO route_stops (route_id, stop_order, stop_name, stop_lat, stop_lng) VALUES ($route_id, $order, '$stop_name', $stop_lat, $stop_lng)";
                mysqli_query($conn, $stop_sql);
                $order++;
            }
        }
        $_SESSION['message'] = 'Route updated successfully!';
        $_SESSION['messageType'] = 'success';
        header('Location: edit-route.php?id=' . $route_id);
        exit;
    } else {
        $_SESSION['message'] = 'Error updating route: ' . mysqli_error($conn);
        $_SESSION['messageType'] = 'error';
        header('Location: edit-route.php?id=' . $route_id);
        exit;
    }
}

//delete_route_btn
else if (isset($_POST['delete_route_btn'])) {
    $route_id = mysqli_real_escape_string($conn, $_POST['route_id']);
    // Delete stops first
    $delete_stops = mysqli_query($conn, "DELETE FROM route_stops WHERE route_id='$route_id'");
    // Delete the route
    $delete_route = mysqli_query($conn, "DELETE FROM routes WHERE id='$route_id'");
    if ($delete_route) {
        redirect("manage-routes.php", "Route deleted successfully!", "success");
    } else {
        redirect("manage-routes.php", "Failed to delete route.", "error");
    }
}