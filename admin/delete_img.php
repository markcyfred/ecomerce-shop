<?php
session_start();

include('../admin/config/dbcon.php');
include('../functions/myfunctions.php');
header('Content-Type: application/json');

if (isset($_GET['id']) && isset($_GET['product_id'])) {
    $imageId   = mysqli_real_escape_string($conn, $_GET['id']);
    $productId = mysqli_real_escape_string($conn, $_GET['product_id']);

    // 1) Fetch the image row to see if it was marked primary, and get its file path
    $imageQuery = "
        SELECT image_path, is_primary 
        FROM product_images 
        WHERE id = '$imageId' 
          AND product_id = '$productId'
        LIMIT 1
    ";
    $imageResult = mysqli_query($conn, $imageQuery);

    if (mysqli_num_rows($imageResult) > 0) {
        $imageData   = mysqli_fetch_assoc($imageResult);
        $wasPrimary  = (int)$imageData['is_primary'] === 1;
        $imagePathDb = $imageData['image_path']; // e.g., "uploads/shop/xyz.jpg"
        $fullPath    = '../' . $imagePathDb;    // actual file system path

        // 2) Delete the image file from the server, if it exists
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }

        // 3) Delete the record from the database
        $deleteQuery  = "DELETE FROM product_images WHERE id = '$imageId' AND product_id = '$productId'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            // 4) If the deleted image was primary, promote the next available image (by lowest ID)
            if ($wasPrimary) {
                $nextQuery  = "
                    SELECT id 
                    FROM product_images 
                    WHERE product_id = '$productId' 
                    ORDER BY id ASC 
                    LIMIT 1
                ";
                $nextResult = mysqli_query($conn, $nextQuery);

                if (mysqli_num_rows($nextResult) === 1) {
                    $nextRow = mysqli_fetch_assoc($nextResult);
                    $nextId  = intval($nextRow['id']);

                    // Set that image as the new primary
                    mysqli_query(
                        $conn,
                        "UPDATE product_images 
                         SET is_primary = 1 
                         WHERE id = '$nextId' 
                           AND product_id = '$productId'"
                    );
                }
                // If no images remain, there simply won't be any primary record.
            }

            $_SESSION['message']     = "Image deleted successfully.";
            $_SESSION['messageType'] = "success";
        } else {
            $_SESSION['message']     = "Failed to delete image from database.";
            $_SESSION['messageType'] = "error";
        }
    } else {
        $_SESSION['message']     = "Image not found.";
        $_SESSION['messageType'] = "error";
    }

    header("Location: edit-product.php?id=$productId");
    exit(0);
} else {
    $_SESSION['message'] = "Invalid request.";
    header("Location: products.php");
    exit(0);
}
?>
