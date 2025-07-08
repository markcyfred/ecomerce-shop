<?php
require '../vendor/autoload.php';
require '../admin/config/dbcon.php'; // Ensure $conn is set

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

// 1. Clear any output buffers to avoid ZIP corruption
while (ob_get_level()) {
    ob_end_clean();
}

session_start();

// 2. Validate request
if (!isset($_POST['bulk_edit_export_btn']) || empty($_POST['selected_products'])) {
    $_SESSION['message'] = "No products selected for bulk edit export.";
    $_SESSION['messageType'] = "error";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

// 3. Retrieve selected product IDs
$selected_ids = $_POST['selected_products'];
$ids = implode(',', array_map('intval', $selected_ids));

// 4. Initialize Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// 5. Define headers
$headers = [
    'Product ID', 'Category Name', 'Rating', 'Discount',
    'Product Name', 'Description', 'Original Price',
    'Selling Price', 'Quantity', 'Featured', 'Brand Name'
];

// 6. Write headers to row 1
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue("{$col}1", $header);
    $col++;
}

// 7. Style header row
$lastCol = chr(ord('A') + count($headers) - 1);
$sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
]);

// 8. Apply borders to full range
$sheet->getStyle("A1:{$lastCol}100")->applyFromArray([
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
]);

// 9. Freeze header row
$sheet->freezePane('A2');

// 10. Auto-size columns
foreach (range('A', $lastCol) as $c) {
    $sheet->getColumnDimension($c)->setAutoSize(true);
}

// 11. Fetch products and write data
$query = "SELECT * FROM products WHERE id IN ($ids)";
$result = mysqli_query($conn, $query);
$rowNum = 2;
$productsData = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($product = mysqli_fetch_assoc($result)) {
        $productsData[] = $product;
        $sheet->fromArray([
            $product['id'],
            $product['category_name'],
            $product['rating'],
            $product['discount'],
            $product['product_name'],
            $product['description'],
            $product['original_price'],
            $product['selling_price'],
            $product['quantity'],
            $product['featured'],
            $product['brand_name'],
        ], null, "A{$rowNum}");
        $rowNum++;
    }
} else {
    die("No matching products found.");
}

// 12. Data Validation (Category, Rating, Brand, Featured)
// Category
$categories = [];
$catRes = mysqli_query($conn, "SELECT name FROM categories");
while ($r = mysqli_fetch_assoc($catRes)) {
    $categories[] = $r['name'];
}
if (empty($categories)) $categories = ['Default Category'];
$catList = '"' . implode(',', $categories) . '"';
for ($r = 2; $r <= 100; $r++) {
    $dv = $sheet->getCell("B{$r}")->getDataValidation();
    $dv->setType(DataValidation::TYPE_LIST)
       ->setAllowBlank(false)
       ->setShowDropDown(true)
       ->setFormula1($catList);
}
// Rating
$rateList = '"1,2,3,4,5"';
for ($r = 2; $r <= 100; $r++) {
    $dv = $sheet->getCell("C{$r}")->getDataValidation();
    $dv->setType(DataValidation::TYPE_LIST)
       ->setAllowBlank(false)
       ->setShowDropDown(true)
       ->setFormula1($rateList);
}
// Brand
$brands = [];
$brRes = mysqli_query($conn, "SELECT brand_name FROM brands");
while ($r = mysqli_fetch_assoc($brRes)) {
    $brands[] = $r['brand_name'];
}
if (empty($brands)) $brands = ['Default Brand'];
$brList = '"' . implode(',', $brands) . '"';
for ($r = 2; $r <= 100; $r++) {
    $dv = $sheet->getCell("K{$r}")->getDataValidation();
    $dv->setType(DataValidation::TYPE_LIST)
       ->setAllowBlank(false)
       ->setShowDropDown(true)
       ->setFormula1($brList);
}
// Featured
$featured = [];
$enumRes = mysqli_query($conn, "SHOW COLUMNS FROM products LIKE 'featured'");
if ($enumRes && $er = mysqli_fetch_assoc($enumRes)) {
    if (preg_match("/^enum\\((.*)\\)$/", $er['Type'], $m)) {
        foreach (explode(',', $m[1]) as $val) {
            $featured[] = trim($val, " '");
        }
    }
}
if (empty($featured)) {
    $tags = mysqli_query($conn, "SELECT featured FROM products WHERE featured != ''");
    $all = [];
    while ($t = mysqli_fetch_assoc($tags)) {
        foreach (explode(',', $t['featured']) as $tag) {
            $tag = trim($tag);
            if ($tag && !in_array($tag, $all)) $all[] = $tag;
        }
    }
    $featured = $all;
}

$featList = '"' . implode(',', $featured) . '"';
for ($r = 2; $r <= 100; $r++) {
    $dv = $sheet->getCell("J{$r}")->getDataValidation();
    $dv->setType(DataValidation::TYPE_LIST)
       ->setAllowBlank(false)
       ->setShowDropDown(true)
       ->setFormula1($featList);
}

// 13. Save Excel to temp
$tempExcel = tempnam(sys_get_temp_dir(), 'excel_') . '.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($tempExcel);

// 14. Create ZIP (overwrite)
$zip = new ZipArchive();
$tempZip = tempnam(sys_get_temp_dir(), 'zip_') . '.zip';
if ($zip->open($tempZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    die("Could not open ZIP archive");
}
// Add Excel
$zip->addFile($tempExcel, 'bulk_edit_template.xlsx');

// 15. Add all images into one 'images/' folder
$baseDir = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR;
$counter = 1;
foreach ($productsData as $p) {
    $pid = (int) $p['id'];
    $imgRes = mysqli_query($conn, "SELECT image_path FROM product_images WHERE product_id='$pid'");
    while ($img = mysqli_fetch_assoc($imgRes)) {
        $rel = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $img['image_path']);
        $abs = $baseDir . $rel;
        if (is_file($abs)) {
            $ext = pathinfo($abs, PATHINFO_EXTENSION);
            $clean = preg_replace('/[^a-zA-Z0-9_ -]/', '', $p['product_name']);
            $zipPath = "images/{$clean}_{$counter}.{$ext}";
            $zip->addFile($abs, $zipPath);
            $counter++;
        }
    }
}

$zip->close();
@unlink($tempExcel);

// 16. Send ZIP download
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="bulk_edit_export_' . time() . '.zip"');
header('Content-Length: ' . filesize($tempZip));
flush();
readfile($tempZip);
@unlink($tempZip);
exit;
?>
