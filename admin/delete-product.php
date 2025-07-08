<?php
session_start();

include('../admin/config/dbcon.php');
include('../functions/myfunctions.php');

if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Get product data to remove main image
    $product_query = "SELECT * FROM products WHERE id='$product_id'";
    $product_query_run = mysqli_query($conn, $product_query);

    if (mysqli_num_rows($product_query_run) > 0) {
        $product_data = mysqli_fetch_array($product_query_run);
        $main_image = $product_data['image'];

        // Delete all related product images
        $images_query = "SELECT image_path FROM product_images WHERE product_id = '$product_id'";
        $images_query_run = mysqli_query($conn, $images_query);

        if (mysqli_num_rows($images_query_run) > 0) {
            while ($img = mysqli_fetch_assoc($images_query_run)) {
                $imagePath = "../" . $img['image_path'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        // Delete image records from product_images table
        mysqli_query($conn, "DELETE FROM product_images WHERE product_id = '$product_id'");

        // Delete the product record
        $delete_query = "DELETE FROM products WHERE id='$product_id'";
        $delete_query_run = mysqli_query($conn, $delete_query);

        if ($delete_query_run) {
            // Delete main image if it exists
            $main_image_path = "../uploads/shop/" . $main_image;
            if (file_exists($main_image_path)) {
                unlink($main_image_path);
            }

            redirect("products.php", "Product and images deleted successfully", "success");
        } else {
            redirect("products.php", "Failed to delete product", "error");
        }
    } else {
        redirect("products.php", "Product not found", "error");
    }
} else {
    redirect("products.php", "Invalid request", "error");
}
?>
