<?php
session_start();

include('../admin/config/dbcon.php');
include('../functions/myfunctions.php');
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// --- Step 1: Process the Bulk Upload files ---
if (isset($_POST['bulk_upload_btn'])) {
    // Ensure both bulk CSV/Excel and image ZIP are provided
    if (!empty($_FILES['bulk_file']) && $_FILES['bulk_file']['error'] === UPLOAD_ERR_OK
        && !empty($_FILES['image_zip']) && $_FILES['image_zip']['error'] === UPLOAD_ERR_OK) {

        // Read the bulk file into rows
        $bulkTmp = $_FILES['bulk_file']['tmp_name'];
        $bulkExt = strtolower(pathinfo($_FILES['bulk_file']['name'], PATHINFO_EXTENSION));
        $rows    = [];
        $errors  = [];

        if ($bulkExt === 'csv') {
            if (($h = fopen($bulkTmp, 'r')) !== false) {
                fgetcsv($h, 1000, ',');
                while ($r = fgetcsv($h, 1000, ',')) {
                    $rows[] = $r;
                }
                fclose($h);
            } else {
                redirect('products-add.php', 'Unable to open CSV.', 'error');
            }
        } elseif (in_array($bulkExt, ['xls','xlsx'])) {
            try {
                $ss  = IOFactory::load($bulkTmp);
                $arr = $ss->getActiveSheet()->toArray();
                array_shift($arr);
                $rows = $arr;
            } catch (Exception $e) {
                redirect('products-add.php', 'Error reading Excel: ' . $e->getMessage(), 'error');
            }
        } else {
            redirect('products-add.php', 'Bulk file must be CSV or XLSX.', 'error');
        }

        // Filter out blank rows
        $rows = array_filter($rows, fn($r) => array_filter($r, fn($c) => trim($c) !== ''));
        if (empty($rows)) {
            redirect('products-add.php', 'No data found in bulk file.', 'error');
        }

        // Extract images from ZIP, grouping by baseKey (strip trailing _digits)
        $imagesMap = [];
        $zip = new ZipArchive;
        if ($zip->open($_FILES['image_zip']['tmp_name']) === true) {
            $allowed = ['jpg','jpeg','png','gif','webp','bmp','svg'];
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                if (substr($name, -1) === '/') continue;
                $extn = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (!in_array($extn, $allowed)) continue;
                $rawBase = pathinfo($name, PATHINFO_FILENAME);
                $baseKey = strtolower(preg_replace('/_[0-9]+$/', '', $rawBase));
                $imagesMap[$baseKey][] = [
                    'content'  => $zip->getFromIndex($i),
                    'ext'      => $extn,
                    'original' => $name
                ];
            }
            $zip->close();
        } else {
            redirect('products-add.php', 'Cannot open image ZIP.', 'error');
        }

        // Prepare uploads directory
        $dest = __DIR__ . '/../uploads/shop/';
        if (!is_dir($dest)) mkdir($dest, 0755, true);

        // Process each row and insert products
        foreach ($rows as $idx => $r) {
            if (count($r) < 9) {
                $errors[] = "Row " . ($idx+2) . ": missing columns.";
                continue;
            }
            list($cat,$rate,$disc,$pname,$desc,$orig,$sell,$qty,$feat) = array_map(
                fn($v) => mysqli_real_escape_string($conn, trim($v)), $r
            );
            if (empty($cat) || empty($pname)) {
                $errors[] = "Row " . ($idx+2) . ": Category & Name required.";
                continue;
            }
            // check duplicate
            $chk = mysqli_query($conn, "SELECT id FROM products WHERE product_name='$pname'");
            if (mysqli_num_rows($chk) > 0) {
                $errors[] = "Row " . ($idx+2) . ": Product '$pname' exists.";
                continue;
            }
            // defaults
            $status   = 1;
            $trending = 1;
            $size     = 'medium';

            // insert product
            $ins = "INSERT INTO products
                (category_name,rating,status,discount,product_name,description,original_price,selling_price,quantity,trending,size,featured)
                VALUES
                ('$cat','$rate','$status','$disc','$pname','$desc','$orig','$sell','$qty','$trending','$size','$feat')";
            if (!mysqli_query($conn, $ins)) {
                $errors[] = "Row " . ($idx+2) . ": DB insert error - " . mysqli_error($conn);
                continue;
            }
            $pid = mysqli_insert_id($conn);

            // save images for this product
            $key = strtolower($pname);
            if (isset($imagesMap[$key])) {
                $first = true;
                foreach ($imagesMap[$key] as $i => $img) {
                    $fname = uniqid('prod_') . '.' . $img['ext'];
                    file_put_contents($dest . $fname, $img['content']);
                    $isPrimary = $first ? 1 : 0;
                    $alt = mysqli_real_escape_string($conn, "$pname image " . ($i+1));
                    $pathDB = mysqli_real_escape_string($conn, "uploads/shop/$fname");
                    mysqli_query($conn, "INSERT INTO product_images
                        (product_id,image_path,alt_text,is_primary)
                        VALUES
                        ('$pid','$pathDB','$alt',$isPrimary)");
                    $first = false;
                }
                unset($imagesMap[$key]);
            }
        }

        // unmatched images report
        if (!empty($imagesMap)) {
            $left = [];
            foreach ($imagesMap as $grp) foreach ($grp as $img) $left[] = $img['original'];
            $errors[] = 'Unmatched images: ' . implode(', ', $left);
        }

        // redirect result
        if ($errors) {
            $msg = "Bulk upload completed with errors:<ul><li>" . implode("</li><li>", $errors) . "</li></ul>";
            redirect('products-add.php',$msg,'error');
        } else {
            redirect('products-add.php','Bulk upload successful.','success');
        }
    } else {
        redirect('products-add.php','Please upload both bulk file and images ZIP.','error');
    }
}


//bulk endswitch

// Validate inputs
if (!isset($_POST['bulk_edit_btn'])) {
    header("Location: ../index.php");
    exit;
}
if (empty($_FILES['excel_file']) || $_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
    redirect("products.php", "Please upload the Excel/CSV file.", "error");
}
$hasImages = (!empty($_FILES['images_zip_edited']) && $_FILES['images_zip_edited']['error'] === UPLOAD_ERR_OK);

// Read spreadsheet rows
$tmp  = $_FILES['excel_file']['tmp_name'];
$ext  = strtolower(pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION));
$rows = [];
if ($ext === 'csv') {
    if (($h = fopen($tmp,'r')) !== false) {
        fgetcsv($h, 1000, ',');
        while ($r = fgetcsv($h, 1000, ',')) {
            $rows[] = $r;
        }
        fclose($h);
    }
} elseif (in_array($ext, ['xls','xlsx'])) {
    $ss  = IOFactory::load($tmp);
    $arr = $ss->getActiveSheet()->toArray();
    array_shift($arr);
    $rows = $arr;
} else {
    redirect("products.php", "Invalid file type; only CSV/XLSX allowed.", "error");
}
// filter empty rows
$rows = array_filter($rows, fn($r) => array_filter($r, fn($c) => trim($c) !== ''));
if (empty($rows)) {
    redirect("products.php", "No data found in the file.", "error");
}

// Unzip images grouped by base name without trailing underscore+digits
$imagesMap = [];
if ($hasImages) {
    $zip = new ZipArchive;
    if ($zip->open($_FILES['images_zip_edited']['tmp_name']) === true) {
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);
            if (substr($name, -1) === '/') continue;
            $extn = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            // Accept common image formats including webp
            $allowed = ['jpg','jpeg','png','gif','webp','bmp','svg'];
            if (!in_array($extn, $allowed)) continue;

            $rawBase = pathinfo($name, PATHINFO_FILENAME);
            $baseKey = preg_replace('/_[0-9]+$/', '', $rawBase);
            $baseKey = strtolower($baseKey);

            $imagesMap[$baseKey][] = [
                'content'  => $zip->getFromIndex($i),
                'ext'      => $extn,
                'original' => $name
            ];
        }
        $zip->close();
    } else {
        redirect("products.php", "Unable to open images ZIP.", "error");
    }
}

// Process rows and update
$dest = __DIR__ . '/../uploads/shop/';
if (!is_dir($dest)) mkdir($dest, 0755, true);
$errors       = [];
$successCount = 0;

foreach ($rows as $idx => $r) {
    if (count($r) < 11) {
        $errors[] = "Row " . ($idx+2) . ": missing columns.";
        continue;
    }
    list($pid,$cat,$rate,$disc,$pname,$desc,$orig,$sell,$qty,$feat,$brand) = array_map(
        fn($v) => mysqli_real_escape_string($conn, trim($v)),
        $r
    );
    if (empty($pid) || empty($pname)) {
        $errors[] = "Row " . ($idx+2) . ": Product ID & Name required.";
        continue;
    }
    // Update product fields
    $sql = "UPDATE products SET
        category_name='$cat', rating='$rate', discount='$disc',
        product_name='$pname', description='$desc',
        original_price='$orig', selling_price='$sell',
        quantity='$qty', featured='$feat', brand_name='$brand'
      WHERE id='$pid'";
    if (!mysqli_query($conn, $sql)) {
        $errors[] = "Row " . ($idx+2) . ": DB error - " . mysqli_error($conn);
        continue;
    }
    // Handle images replacement
    $key = strtolower($pname);
    if (isset($imagesMap[$key])) {
        // Delete old file records and files
        $oldRes = mysqli_query($conn, "SELECT image_path FROM product_images WHERE product_id='$pid'");
        while ($old = mysqli_fetch_assoc($oldRes)) {
            $oldFile = __DIR__ . '/../' . $old['image_path'];
            if (is_file($oldFile)) unlink($oldFile);
        }
        mysqli_query($conn, "DELETE FROM product_images WHERE product_id='$pid'");

        // Insert new images
        $first = true;
        foreach ($imagesMap[$key] as $i => $img) {
            $filename = uniqid('prod_') . '.' . $img['ext'];
            file_put_contents($dest . $filename, $img['content']);
            $isPrimary = $first ? 1 : 0;
            $altText   = mysqli_real_escape_string($conn, "$pname image " . ($i+1));
            $pathDB    = mysqli_real_escape_string($conn, "uploads/shop/$filename");
            mysqli_query($conn, "INSERT INTO product_images
                (product_id, image_path, alt_text, is_primary)
                VALUES
                ('$pid', '$pathDB', '$altText', $isPrimary)");
            $first      = false;
        }
        unset($imagesMap[$key]);
    }
    $successCount++;
}

// Report unmatched images
if (!empty($imagesMap)) {
    $left = [];
    foreach ($imagesMap as $group) {
        foreach ($group as $img) {
            $left[] = $img['original'];
        }
    }
    $errors[] = "Unmatched images: " . implode(', ', $left);
}

// Final redirect
if ($errors) {
    $msg = "Completed with errors:<ul><li>" . implode("</li><li>", $errors) . "</li></ul>";
    redirect("products.php", $msg, "error");
} else {
    redirect("products.php", "Bulk upload succeeded: $successCount products updated.", "success");
}
?>