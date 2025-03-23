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
else if (isset($_POST['add_product_btn'])) {
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

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . "." . $image_ext;

    // Perform basic validation
    if (empty($category_name) || empty($rating) || empty($status) || empty($discount) || empty($product_name) || empty($description) || empty($original_price) || empty($selling_price) || empty($quantity) || empty($trending) || empty($size) || empty($featured)) {
        redirect("products-add.php", "Please fill all fields to continue.", "error");
        exit; // Stop further processing
    }

    $add_product_query = "INSERT INTO products
            (category_name, rating, status, discount, product_name, description, original_price, selling_price, image, quantity, trending, size, featured) 
            VALUES ('$category_name', '$rating', '$status', '$discount', '$product_name', '$description', '$original_price', '$selling_price', '$filename', '$quantity', '$trending', '$size', '$featured')";

    $add_product_query_run = mysqli_query($conn, $add_product_query);

    if ($add_product_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename
        );
        redirect("products-add.php", "Product Created successfully", "success");
    } else {
        redirect("products-add.php", "Something went wrong", "error");
    }
}
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// --- Step 1: Process the Bulk Upload files ---
if (isset($_POST['bulk_upload_btn'])) {
    // Ensure both files are provided
    if (isset($_FILES['bulk_file']) && $_FILES['bulk_file']['error'] == 0 &&
        isset($_FILES['image_zip']) && $_FILES['image_zip']['error'] == 0) {

        // Process bulk file (CSV/Excel)
        $fileName = $_FILES['bulk_file']['name'];
        $fileTmp  = $_FILES['bulk_file']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $rows = [];
        $errorMessages = [];

        if ($fileExt === 'csv') {
            if (($handle = fopen($fileTmp, "r")) !== FALSE) {
                $header = fgetcsv($handle, 1000, ","); // Skip header row
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $rows[] = $data;
                }
                fclose($handle);
            } else {
                redirect("products-add.php", "Unable to open the CSV file for reading.", "error");
                exit;
            }
        } elseif ($fileExt === 'xlsx') {
            try {
                $spreadsheet = IOFactory::load($fileTmp);
                $sheet = $spreadsheet->getActiveSheet();
                $rowsArray = $sheet->toArray();
                array_shift($rowsArray); // Remove header row
                $rows = $rowsArray;
            } catch(Exception $e) {
                redirect("products-add.php", "An error occurred while reading the Excel file: " . $e->getMessage(), "error");
                exit;
            }
        } else {
            redirect("products-add.php", "Please upload a file in CSV or XLSX format.", "error");
            exit;
        }

        // Filter out rows that are completely blank
        $rows = array_filter($rows, function($row) {
            return !empty(array_filter($row, function($cell) {
                return trim($cell) !== '';
            }));
        });

        if (count($rows) === 0) {
            redirect("products-add.php", "No data found in the file. Please check the content.", "error");
            exit;
        }

        // --- Step 2: Extract Images from the ZIP file ---
        $imagesMap = [];
        $zip = new ZipArchive;
        if ($zip->open($_FILES['image_zip']['tmp_name']) === TRUE) {
            // Loop through all files in the zip
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $entry = $zip->getNameIndex($i);
                // Skip directories
                if (substr($entry, -1) == '/') {
                    continue;
                }
                $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
                // Check if it is an allowed image type
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    // Use the base name (without extension) as the key (normalized)
                    $baseName = strtolower(trim(pathinfo($entry, PATHINFO_FILENAME)));
                    // Get file content
                    $fileContent = $zip->getFromIndex($i);
                    $imagesMap[$baseName] = [
                        'content'   => $fileContent,
                        'extension' => $ext,
                        'original'  => $entry // keep the original name if needed
                    ];
                }
            }
            $zip->close();
        } else {
            redirect("products-add.php", "Failed to open the image zip file.", "error");
            exit;
        }

        // --- Step 3: Process Each Row from the Bulk File ---
        foreach ($rows as $index => $data) {
            // Expecting at least 9 columns per your current structure
            if (count($data) < 9) {
                $errorMessages[] = "Row " . ($index+2) . ": Missing one or more required columns.";
                continue;
            }

            // Retrieve values and sanitize inputs (make sure $conn is your DB connection)
            $category_name  = mysqli_real_escape_string($conn, trim($data[0]));
            $rating         = mysqli_real_escape_string($conn, trim($data[1]));
            $discount       = mysqli_real_escape_string($conn, trim($data[2]));
            $product_name   = mysqli_real_escape_string($conn, trim($data[3]));
            $description    = mysqli_real_escape_string($conn, trim($data[4]));
            $original_price = mysqli_real_escape_string($conn, trim($data[5]));
            $selling_price  = mysqli_real_escape_string($conn, trim($data[6]));
            $quantity       = mysqli_real_escape_string($conn, trim($data[7]));
            $featured       = mysqli_real_escape_string($conn, trim($data[8]));

            // Set defaults
            $status   = 1;
            $trending = 1;
            $size     = 'medium';
            $productImage = 'default.png';

            // Check required fields
            if (empty($category_name) || empty($product_name)) {
                $errorMessages[] = "Row " . ($index+2) . ": Both Category and Product Name fields are required.";
                continue;
            }

            // Check for duplicate product names
            $check_query = "SELECT id FROM products WHERE product_name = '$product_name'";
            $check_result = mysqli_query($conn, $check_query);
            if (mysqli_num_rows($check_result) > 0) {
                $errorMessages[] = "Row " . ($index+2) . ": Product '$product_name' already exists.";
                continue;
            }

            // --- Step 4: Match the product name to an image from the ZIP ---
            $productKey = strtolower(trim($product_name));
            if (isset($imagesMap[$productKey])) {
                $imageData = $imagesMap[$productKey];
                // Create a safe filename (you can adjust this to your naming conventions)
                $newFilename = preg_replace('/\s+/', '_', $product_name) . '.' . $imageData['extension'];
                $destinationFolder = '../uploads/shop/';
                if (!is_dir($destinationFolder)) {
                    if (!mkdir($destinationFolder, 0755, true)) {
                        $errorMessages[] = "Row " . ($index+2) . ": The directory '$destinationFolder' does not exist and could not be created.";
                        continue;
                    }
                }
                // Check if the directory is writable
                if (!is_writable($destinationFolder)) {
                    $errorMessages[] = "Row " . ($index+2) . ": The directory '$destinationFolder' is not writable.";
                    continue;
                }

                // Save the image file to the destination folder
                $imageSavePath = $destinationFolder . $newFilename;
                $imageSaveResult = file_put_contents($imageSavePath, $imageData['content']);

                if ($imageSaveResult !== false) {
                    $productImage = $newFilename;
                    // Remove the image from the map so that later we know which images were unmatched
                    unset($imagesMap[$productKey]);
                } else {
                    $errorMessages[] = "Row " . ($index+2) . ": Failed to save the image for product '$product_name' at '$imageSavePath'.";
                    
                    // Additional directory checks
                    if (!is_dir($destinationFolder)) {
                        $errorMessages[] = "Error: The directory '$destinationFolder' does not exist.";
                    } elseif (!is_writable($destinationFolder)) {
                        $errorMessages[] = "Error: The directory '$destinationFolder' is not writable.";
                    }
                }
            } else {
                // Optionally add an error message if the product did not have a matching image
                $errorMessages[] = "Row " . ($index+2) . ": No matching image found for product '$product_name'.";
            }

            // Insert into the database with the appropriate image
            $insert_query = "INSERT INTO products 
                (category_name, rating, status, discount, product_name, description, original_price, selling_price, image, quantity, trending, size, featured) 
                VALUES ('$category_name', '$rating', '$status', '$discount', '$product_name', '$description', '$original_price', '$selling_price', '$productImage', '$quantity', '$trending', '$size', '$featured')";

            if (!mysqli_query($conn, $insert_query)) {
                $errorMessages[] = "Row " . ($index+2) . ": Failed to insert record - " . mysqli_error($conn);
            }
        }

        // --- Step 5: Report any unmatched images ---
        if (!empty($imagesMap)) {
            $unmatched = [];
            foreach ($imagesMap as $key => $data) {
                $unmatched[] = $data['original'];
            }
            $errorMessages[] = "The following images did not match any product: " . implode(', ', $unmatched);
        }

        // --- Step 6: Redirect with message ---
        if (count($errorMessages) > 0) {
            $message = "Bulk upload completed with errors. Please review the following messages:<br><ul>";
            foreach ($errorMessages as $error) {
                $message .= "<li>$error</li>";
            }
            $message .= "</ul>";
            redirect("products-add.php", $message, "error");
        } else {
            redirect("products-add.php", "Bulk upload completed successfully.", "success");
        }
    } else {
        redirect("products-add.php", "Please upload both the bulk file and the image ZIP file to continue.", "error");
    }
}


//update_product_btn


else if (isset($_POST['update_product_btn'])) {

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
} else {
    header("Location: ../index.php");
}

// --- Bulk Edit Backend ---
if (isset($_POST['bulk_edit_btn'])) {
    // Ensure both files are provided
    if (
        isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0 &&
        isset($_FILES['images_zip_edited']) && $_FILES['images_zip_edited']['error'] == 0
    ) {

        // Process bulk edit file (CSV/Excel)
        $fileName = $_FILES['excel_file']['name'];
        $fileTmp  = $_FILES['excel_file']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $rows = [];
        $errorMessages = [];

        if ($fileExt === 'csv') {
            if (($handle = fopen($fileTmp, "r")) !== FALSE) {
                $header = fgetcsv($handle, 1000, ","); // Skip header row
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $rows[] = $data;
                }
                fclose($handle);
            } else {
                redirect("products.php", "Unable to open the CSV file for reading.", "error");
                exit;
            }
        } elseif ($fileExt === 'xlsx') {
            try {
                $spreadsheet = IOFactory::load($fileTmp);
                $sheet = $spreadsheet->getActiveSheet();
                $rowsArray = $sheet->toArray();
                array_shift($rowsArray); // Remove header row
                $rows = $rowsArray;
            } catch(Exception $e) {
                redirect("products.php", "An error occurred while reading the Excel file: " . $e->getMessage(), "error");
                exit;
            }
        } else {
            redirect("products.php", "Please upload a file in CSV or XLSX format.", "error");
            exit;
        }

        // Filter out rows that are completely blank
        $rows = array_filter($rows, function($row) {
            return !empty(array_filter($row, function($cell) {
                return trim($cell) !== '';
            }));
        });

        if (count($rows) === 0) {
            redirect("products.php", "No data found in the file. Please check the content.", "error");
            exit;
        }

        // --- Step 2: Extract Images from the ZIP file ---
        $imagesMap = [];
        $zip = new ZipArchive;
        if ($zip->open($_FILES['images_zip_edited']['tmp_name']) === TRUE) {
            // Loop through all files in the zip
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $entry = $zip->getNameIndex($i);
                // Skip directories
                if (substr($entry, -1) == '/') {
                    continue;
                }
                $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    // Use the base name (without extension) as the key (normalized)
                    $baseName = strtolower(trim(pathinfo($entry, PATHINFO_FILENAME)));
                    $fileContent = $zip->getFromIndex($i);
                    $imagesMap[$baseName] = [
                        'content'   => $fileContent,
                        'extension' => $ext,
                        'original'  => $entry
                    ];
                }
            }
            $zip->close();
        } else {
            redirect("products.php", "Failed to open the image ZIP file.", "error");
            exit;
        }

        // --- Step 3: Process Each Row from the Bulk Edit File ---
        $destinationFolder = '../uploads/shop/';
        foreach ($rows as $index => $data) {
            // Expecting at least 10 columns per row:
            // [0] Product ID, [1] Category, [2] Rating, [3] Discount, [4] Product Name, [5] Description, 
            // [6] Original Price, [7] Selling Price, [8] Quantity, [9] Featured
            if (count($data) < 10) {
                $errorMessages[] = "Row " . ($index + 2) . ": Missing one or more required columns.";
                continue;
            }

            // Retrieve and sanitize inputs (ensure $conn is your DB connection)
            $product_id     = mysqli_real_escape_string($conn, trim($data[0]));
            $category_name  = mysqli_real_escape_string($conn, trim($data[1]));
            $rating         = mysqli_real_escape_string($conn, trim($data[2]));
            $discount       = mysqli_real_escape_string($conn, trim($data[3]));
            $product_name   = mysqli_real_escape_string($conn, trim($data[4]));
            $description    = mysqli_real_escape_string($conn, trim($data[5]));
            $original_price = mysqli_real_escape_string($conn, trim($data[6]));
            $selling_price  = mysqli_real_escape_string($conn, trim($data[7]));
            $quantity       = mysqli_real_escape_string($conn, trim($data[8]));
            $featured       = mysqli_real_escape_string($conn, trim($data[9]));

            // Set defaults (you can modify these as needed)
            $status   = 1;
            $trending = 1;
            $size     = 'medium';
            $productImage = ''; // Will be set if a matching new image is found

            // Check required fields
            if (empty($product_id) || empty($category_name) || empty($product_name)) {
                $errorMessages[] = "Row " . ($index + 2) . ": Product ID, Category and Product Name are required.";
                continue;
            }

            // --- Step 4: Check for a matching image in the ZIP ---
            $productKey = strtolower(trim($product_name));
            if (isset($imagesMap[$productKey])) {
                $imageData = $imagesMap[$productKey];
                $image_ext = $imageData['extension'];
                // Generate new filename similar to normal edit
                $update_filename = time() . "." . $image_ext;
                if (!is_dir($destinationFolder)) {
                    if (!mkdir($destinationFolder, 0755, true)) {
                        $errorMessages[] = "Row " . ($index + 2) . ": The directory '$destinationFolder' could not be created.";
                        continue;
                    }
                }
                if (!is_writable($destinationFolder)) {
                    $errorMessages[] = "Row " . ($index + 2) . ": The directory '$destinationFolder' is not writable.";
                    continue;
                }
                $imageSavePath = $destinationFolder . $update_filename;
                $imageSaveResult = file_put_contents($imageSavePath, $imageData['content']);
                if ($imageSaveResult !== false) {
                    $productImage = $update_filename;
                    // Remove the image from map so unmatched images can be reported later
                    unset($imagesMap[$productKey]);
                } else {
                    $errorMessages[] = "Row " . ($index + 2) . ": Failed to save the image for product '$product_name'.";
                }
            }

            // --- Step 5: Update the existing product in the database ---
            // If a new image is found, retrieve the current image to remove it after a successful update
            $old_image = "";
            if (!empty($productImage)) {
                $selectQuery = "SELECT image FROM products WHERE id='$product_id'";
                $selectResult = mysqli_query($conn, $selectQuery);
                if ($selectResult && mysqli_num_rows($selectResult) > 0) {
                    $row = mysqli_fetch_assoc($selectResult);
                    $old_image = $row['image'];
                }
            }

            // Build the update query. If a new image was saved, include it in the update.
            $updateFields = "category_name='$category_name', rating='$rating', discount='$discount', product_name='$product_name', description='$description', original_price='$original_price', selling_price='$selling_price', quantity='$quantity', featured='$featured', status='$status', trending='$trending', size='$size'";
            if (!empty($productImage)) {
                $updateFields .= ", image='$productImage'";
            }
            $update_query = "UPDATE products SET $updateFields WHERE id='$product_id'";

            if (!mysqli_query($conn, $update_query)) {
                $errorMessages[] = "Row " . ($index + 2) . ": Failed to update product ID '$product_id' - " . mysqli_error($conn);
            } else {
                // If update is successful and a new image was provided, delete the old image file
                if (!empty($productImage) && !empty($old_image) && file_exists($destinationFolder . $old_image)) {
                    unlink($destinationFolder . $old_image);
                }
            }
        }

        // --- Step 6: Report any unmatched images ---
        if (!empty($imagesMap)) {
            $unmatched = [];
            foreach ($imagesMap as $key => $data) {
                $unmatched[] = $data['original'];
            }
            $errorMessages[] = "The following images did not match any product: " . implode(', ', $unmatched);
        }

        // --- Step 7: Redirect with appropriate message ---
        if (count($errorMessages) > 0) {
            $message = "Bulk edit completed with errors. Please review the following messages:<br><ul>";
            foreach ($errorMessages as $error) {
                $message .= "<li>$error</li>";
            }
            $message .= "</ul>";
            redirect("products.php", $message, "error");
        } else {
            redirect("products.php", "Your edit is up to date. No changes made.", "success");
        }

    } else {
        redirect("products.php", "Please upload both the Excel file and the image ZIP file to continue.", "error");
    }
} else {
    header("Location: ../index.php");
}
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if (isset($_POST['zip_for_me_btn'])) {
    // Validate that an Excel file and multiple image files were uploaded
    if (
        isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0 &&
        isset($_FILES['images']) && !empty($_FILES['images']['name'][0])
    ) {
        // --- Step 1: Process the Excel File ---
        $fileName = $_FILES['excel_file']['name'];
        $fileTmp  = $_FILES['excel_file']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $rows = [];

        if ($fileExt === 'csv') {
            if (($handle = fopen($fileTmp, "r")) !== false) {
                // Assume first row is header
                $header = fgetcsv($handle, 1000, ",");
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    $rows[] = $data;
                }
                fclose($handle);
            } else {
                die("Error: Unable to open the CSV file.");
            }
        } elseif ($fileExt === 'xlsx') {
            try {
                $spreadsheet = IOFactory::load($fileTmp);
                $sheet = $spreadsheet->getActiveSheet();
                $rowsArray = $sheet->toArray();
                array_shift($rowsArray); // Remove header row
                $rows = $rowsArray;
            } catch(Exception $e) {
                die("Error reading Excel file: " . $e->getMessage());
            }
        } else {
            die("Error: Please upload a CSV or XLSX file.");
        }
        
        // Build mapping: Assume column 0 is Product ID and column 4 is Product Name
        $mapping = [];
        foreach ($rows as $row) {
            if (count($row) >= 5) {
                $productId = trim($row[0]);
                $productName = trim($row[4]);
                $mapping[$productId] = $productName;
            }
        }
        if (empty($mapping)) {
            die("Error: No valid product data found in the Excel file.");
        }
        
        // --- Step 2: Process the Uploaded Images ---
        // Create a new temporary ZIP archive for renamed images
        $newZipFile = tempnam(sys_get_temp_dir(), 'zip_') . '.zip';
        $newZip = new ZipArchive;
        if ($newZip->open($newZipFile, ZipArchive::CREATE) !== true) {
            die("Error: Could not create a new ZIP archive.");
        }
        
        // Loop through each uploaded image file
        $numFiles = count($_FILES['images']['name']);
        for ($i = 0; $i < $numFiles; $i++) {
            if ($_FILES['images']['error'][$i] === 0) {
                $originalName = $_FILES['images']['name'][$i];
                $tmpName = $_FILES['images']['tmp_name'][$i];
                $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $baseName = pathinfo($originalName, PATHINFO_FILENAME);
                    // Extract numeric product id from the file name (digits at the end)
                    if (preg_match('/(\d+)$/', $baseName, $matches)) {
                        $prodId = $matches[1];
                        if (isset($mapping[$prodId])) {
                            // New file name: "ProductName [ID].ext"
                            $newFileName = $mapping[$prodId] . ' ' . $prodId . '.' . $ext;
                            $fileContent = file_get_contents($tmpName);
                            $newZip->addFromString($newFileName, $fileContent);
                        } else {
                            echo "Warning: No mapping found for image $originalName<br>";
                        }
                    } else {
                        echo "Warning: Could not extract product ID from $originalName<br>";
                    }
                } else {
                    echo "Warning: Unsupported file type for $originalName<br>";
                }
            } else {
                echo "Warning: Error uploading file $originalName<br>";
            }
        }
        $newZip->close();
        
        // --- Step 3: Prompt the User to Download the New ZIP ---
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="renamed_images.zip"');
        header('Content-Length: ' . filesize($newZipFile));
        readfile($newZipFile);
        unlink($newZipFile);
        exit;
        
    } else {
        die("Error: Please upload both an edited Excel file and the product images.");
    }
} else {
    die("Error: Invalid request.");
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
