<?php
session_start();

include('../admin/config/dbcon.php');
include('../functions/myfunctions.php');

// Delete product with confirmation dialog using GET parameter
if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Retrieve the product data first to get the image filename
    $product_query = "SELECT * FROM products WHERE id='$product_id'";
    $product_query_run = mysqli_query($conn, $product_query);

    if (mysqli_num_rows($product_query_run) > 0) {
        $product_data = mysqli_fetch_array($product_query_run);
        $image = $product_data['image'];

        // Delete the product record
        $delete_query = "DELETE FROM products WHERE id='$product_id'";
        $delete_query_run = mysqli_query($conn, $delete_query);

        if ($delete_query_run) {
            // Remove the associated image file if it exists
            if (file_exists("../uploads/shop/" . $image)) {
                unlink("../uploads/shop/" . $image);
            }
            redirect("products.php", "Product deleted successfully", "success");
        } else {
            redirect("products.php", "Product not deleted", "error");
        }
    } else {
        redirect("products.php", "Product not found", "error");
    }
} else {
    redirect("products.php", "Invalid Request", "error");
}
?>
