<?php
session_start();

include('../admin/config/dbcon.php');
include('../functions/myfunctions.php');
//add category
if (isset($_POST['add_category_btn'])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $popularity = $_POST['popularity'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];

    $image = $_FILES['image']['name'];

    $path = "../uploads";

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
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $popularity = $_POST['popularity'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $update_filename = $new_image;
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . "." . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $path = "../uploads";
    $update_query = "UPDATE categories SET name='$name', slug='$slug', description='$description',
        status='$status', popularity='$popularity', meta_title='$meta_title', meta_description='$meta_description',
        meta_keywords='$meta_keywords', image='$update_filename' WHERE id ='$category_id'";

    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        if ($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if (file_exists(("../uploads/" . $old_image)) && !empty($old_image)) {
                unlink("../uploads/" . $old_image);
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

        if (file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
        }

        redirect("categories.php", "Category deleted successfully", "success");
    } else {
        redirect("categories.php", "Category not deleted", "error");
    }
}
//add product//category_id	rating	status	discount	product_name	description	original_price	selling_price	image	quantity	trending
else if (isset($_POST['add_product_btn'])) {
    $category_name = $_POST['category_name'];
    $rating = $_POST['rating'];
    $status = $_POST['status'];
    $discount = $_POST['discount'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $quantity = $_POST['quantity'];
    $trending = $_POST['trending'];

    $image = $_FILES['image']['name'];

    $path = "../uploads/shop";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . "." . $image_ext;

    // Perform basic validation
    if (empty($category_name) || empty($rating) || empty($discount) || empty($product_name) || empty($description) || empty($original_price) || empty($selling_price) || empty($quantity)) {
        redirect("products-add.php", "Please fill all fields to continue.", "error");
        exit; // Stop further processing
    }
    // Escape string values
    $product_name = mysqli_real_escape_string($conn, $product_name);
    $description = mysqli_real_escape_string($conn, $description);
    //insert
    $product_query = "INSERT INTO products
            (category_name, rating, status, discount, product_name, description, original_price, selling_price, image, quantity, trending) 
            VALUES ('$category_name', '$rating', '$status', '$discount', '$product_name', '$description', '$original_price', '$selling_price', '$filename', '$quantity', '$trending')";

    $product_query_run = mysqli_query($conn, $product_query);

    if ($product_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        redirect("products-add.php", "Product Created successfully", "success");
    } else {
        redirect("products-add.php", "Something went wrong", "error");
    }
} 

else if (isset($_POST['update_product_btn']))
{
    $product_id = $_POST['product_id'];
    $category_name = $_POST['category_name'];
    $rating = $_POST['rating'];
    $status = $_POST['status'];
    $discount = $_POST['discount'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $quantity = $_POST['quantity'];
    $trending = $_POST['trending'];

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

    $update_product_query = "UPDATE products SET category_name='$category_name', rating='$rating', status='$status', discount='$discount', product_name='$product_name', description='$description', original_price='$original_price', selling_price='$selling_price', image='$update_filename', quantity='$quantity', trending='$trending' WHERE id ='$product_id'";
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
