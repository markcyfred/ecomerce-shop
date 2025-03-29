<?php
session_start();

include('../admin/config/dbcon.php');
include('../functions/myfunctions.php');
//add category
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

//bulk endswitch

// --- Bulk Edit Backend ---
if (isset($_POST['bulk_edit_btn'])) {
    // Ensure the Excel file is provided
    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0) {

        // Determine if an image ZIP file is provided and valid
        $hasImages = (isset($_FILES['images_zip_edited']) && $_FILES['images_zip_edited']['error'] == 0);

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

        // --- Step 2: Extract Images from the ZIP file if provided ---
        $imagesMap = [];
        if ($hasImages) {
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
        }

        // --- Step 3: Process Each Row from the Bulk Edit File ---
        $destinationFolder = '../uploads/shop/';
        $successfulUpdates = 0; // Counter for successful updates

        foreach ($rows as $index => $data) {
            // Expecting at least 11 columns per row:
            // [0] Product ID, [1] Category, [2] Rating, [3] Discount, [4] Product Name, [5] Description, 
            // [6] Original Price, [7] Selling Price, [8] Quantity, [9] Featured, [10] Brand Name
            if (count($data) < 11) {
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
            $brand_name     = mysqli_real_escape_string($conn, trim($data[10]));

            // Set defaults (modify these as needed)
            $status   = 1;
            $trending = 1;
            $size     = 'medium';
            $productImage = ''; // Will be set if a matching new image is found

            // Check required fields
            if (empty($product_id) || empty($category_name) || empty($product_name)) {
                $errorMessages[] = "Row " . ($index + 2) . ": Product ID, Category and Product Name are required.";
                continue;
            }

            // --- Step 4: Check for a matching image if images were provided ---
            if ($hasImages) {
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
                        // Remove the image from the map so unmatched images can be reported later
                        unset($imagesMap[$productKey]);
                    } else {
                        $errorMessages[] = "Row " . ($index + 2) . ": Failed to save the image for product '$product_name'.";
                    }
                }
            }

            // --- Step 5: Update the existing product in the database ---
            // If a new image was found, retrieve the current image to remove it after a successful update
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
            $updateFields = "category_name='$category_name', rating='$rating', discount='$discount', product_name='$product_name', description='$description', original_price='$original_price', selling_price='$selling_price', quantity='$quantity', featured='$featured', status='$status', trending='$trending', size='$size', brand_name='$brand_name'";
            if (!empty($productImage)) {
                $updateFields .= ", image='$productImage'";
            }
            $update_query = "UPDATE products SET $updateFields WHERE id='$product_id'";

            if (!mysqli_query($conn, $update_query)) {
                $errorMessages[] = "Row " . ($index + 2) . ": Failed to update product ID '$product_id' - " . mysqli_error($conn);
            } else {
                $successfulUpdates++; // Increment counter on successful update

                // If update is successful and a new image was provided, delete the old image file
                if (!empty($productImage) && !empty($old_image) && file_exists($destinationFolder . $old_image)) {
                    unlink($destinationFolder . $old_image);
                }
            }
        }

        // --- Step 6: Report any unmatched images (if images were provided) ---
        if ($hasImages && !empty($imagesMap)) {
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
            if ($successfulUpdates > 0) {
                redirect("products.php", "Bulk edit completed successfully. Updated {$successfulUpdates} product(s).", "success");
            } else {
                redirect("products.php", "Bulk edit completed. Your edit is up to date. No changes made.", "success");
            }
        }

    } else {
        redirect("products.php", "Please upload the Excel file to continue.", "error");
    }
} else {
    header("Location: ../index.php");
}
