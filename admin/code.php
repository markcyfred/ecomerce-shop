<?php
session_start();

include('../admin/config/dbcon.php');
include('../functions/myfunctions.php');

if (isset($_POST['add_category_btn'])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? 1 : 0;
    $popularity = isset($_POST['popularity']) ? 1 : 0;
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
else if (isset($_POST['update_category_btn']))
{
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? 1 : 0;
    $popularity = isset($_POST['popularity']) ? 1 : 0;
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];

    $new_image = $_FILES['image']['name']; 
    $old_image = $_POST['old_image'];

    if ($new_image != "")
    {
        $update_filename = $new_image;
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . "." . $image_ext;
    }
    else
    {
        $update_filename = $old_image;
    }

    $path = "../uploads";
    $update_query = "UPDATE categories SET name='$name', slug='$slug', description='$description',
     status='$status', popularity='$popularity', meta_title='$meta_title', meta_description='$meta_description',
      meta_keywords='$meta_keywords', image='$update_filename' WHERE id ='$category_id'";

    $update_query_run = mysqli_query($conn, $update_query);

    if($update_query_run)
    {
        if($_FILES['image']['name'] != "")
        {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
            if(file_exists(("../uploads/".$old_image)) && !empty($old_image))
            {
                unlink("../uploads/".$old_image);
            }
        }
        redirect("categories.php", "Category updated successfully", "success");
    }

    else
    {
        redirect("edit-category.php", "Category not updated", "error");
    }
}

//delete

else if(isset($_POST['delete_category_btn']))
{
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    $category_query = "SELECT * FROM categories WHERE id='$category_id'";
    $category_query_run = mysqli_query($conn, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image = $category_data['image'];

    $delete_query = "DELETE FROM categories WHERE id='$category_id'";

    $delete_query_run = mysqli_query($conn, $delete_query);

    if($delete_query_run)
    {

        if(file_exists("../uploads/".$image))
        {
            unlink("../uploads/".$image);
        }

        redirect("categories.php", "Category deleted successfully", "success");
    }
    else
    {
        redirect("categories.php", "Category not deleted", "error");
    }
}
?>
