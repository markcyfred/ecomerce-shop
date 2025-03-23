<?php
require '../vendor/autoload.php';
require '../admin/config/dbcon.php'; // Ensure $conn is set

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

// Ensure products were selected
if (!isset($_POST['bulk_edit_export_btn']) || empty($_POST['selected_products'])) {
    die("No products selected for bulk edit.");
}

// Get the selected product IDs
$selected_ids = $_POST['selected_products'];
$ids = implode(',', array_map('intval', $selected_ids));

// 1. Create the spreadsheet for bulk edit template (Excel file)
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// 2. Define headers (first column is Product ID for bulk edit)
$headers = [
    'Product ID',     // Used to match existing record
    'Category Name',  // data[0]
    'Rating',         // data[1]
    'Discount',       // data[2]
    'Product Name',   // data[3]
    'Description',    // data[4]
    'Original Price', // data[5]
    'Selling Price',  // data[6]
    'Quantity',       // data[7]
    'Featured'        // data[8]
];

// 3. Write headers in row 1
$startRow = 1;
$startCol = 'A';
$col = $startCol;
foreach ($headers as $header) {
    $sheet->setCellValue($col . $startRow, $header);
    $col++;
}

// 4. Style the header row
$lastCol = chr(ord($startCol) + count($headers) - 1); // e.g., 'J'
$headerRange = $startCol . $startRow . ':' . $lastCol . $startRow;
$sheet->getStyle($headerRange)->applyFromArray([
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4CAF50'],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
]);

// 5. Apply borders to all cells up to row 100
$fullRange = $startCol . $startRow . ':' . $lastCol . '100';
$sheet->getStyle($fullRange)->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
]);

// 6. Freeze the header row
$sheet->freezePane($startCol . ($startRow + 1));

// 7. Auto-adjust column widths
foreach (range($startCol, $lastCol) as $c) {
    $sheet->getColumnDimension($c)->setAutoSize(true);
}

// 8. Fetch and write selected product data starting from row 2
$query = "SELECT * FROM products WHERE id IN ($ids)";
$result = mysqli_query($conn, $query);
$rowNum = 2;
$productsData = []; // to store data for image zipping
if ($result && mysqli_num_rows($result) > 0) {
    while ($product = mysqli_fetch_assoc($result)) {
        $productsData[] = $product; // store for later use
        $sheet->setCellValue('A' . $rowNum, $product['id']);
        $sheet->setCellValue('B' . $rowNum, $product['category_name']);
        $sheet->setCellValue('C' . $rowNum, $product['rating']);
        $sheet->setCellValue('D' . $rowNum, $product['discount']);
        $sheet->setCellValue('E' . $rowNum, $product['product_name']);
        $sheet->setCellValue('F' . $rowNum, $product['description']);
        $sheet->setCellValue('G' . $rowNum, $product['original_price']);
        $sheet->setCellValue('H' . $rowNum, $product['selling_price']);
        $sheet->setCellValue('I' . $rowNum, $product['quantity']);
        $sheet->setCellValue('J' . $rowNum, $product['featured']);
        $rowNum++;
    }
} else {
    die("No matching products found.");
}

// ------------------------------------------------------------------
// 9. Data Validation
// ------------------------------------------------------------------

// (A) Category Name from DB (Column B => B2:B100)
$categories = [];
$catQuery = "SELECT name FROM categories";
$catResult = mysqli_query($conn, $catQuery);
if ($catResult) {
    while ($row = mysqli_fetch_assoc($catResult)) {
        $categories[] = $row['name'];
    }
}
if (empty($categories)) {
    $categories = ['Default Category'];
}
$categoryList = '"' . implode(',', $categories) . '"';
for ($row = 2; $row <= 100; $row++) {
    $validation = $sheet->getCell('B' . $row)->getDataValidation();
    $validation->setType(DataValidation::TYPE_LIST);
    $validation->setErrorStyle(DataValidation::STYLE_STOP);
    $validation->setAllowBlank(false);
    $validation->setShowInputMessage(true);
    $validation->setShowErrorMessage(true);
    $validation->setFormula1($categoryList);
    $validation->setShowDropDown(true);
    $validation->setErrorTitle("Invalid Category");
    $validation->setError("Please select a valid category from the drop-down arrow.");
}

// (B) Rating (Column C => C2:C100) => "1,2,3,4,5"
$ratingList = '"1,2,3,4,5"';
for ($row = 2; $row <= 100; $row++) {
    $validation = $sheet->getCell('C' . $row)->getDataValidation();
    $validation->setType(DataValidation::TYPE_LIST);
    $validation->setErrorStyle(DataValidation::STYLE_STOP);
    $validation->setAllowBlank(false);
    $validation->setShowInputMessage(true);
    $validation->setShowErrorMessage(true);
    $validation->setFormula1($ratingList);
    $validation->setShowDropDown(true);
    $validation->setErrorTitle("Invalid Rating");
    $validation->setError("Please select a rating between 1 and 5 from the drop-down arrow.");
}

// (C) Featured (Column J => J2:J100)
// Fetch enum values from the products table for the 'featured' column
$featuredEnum = [];
$enumQuery = "SHOW COLUMNS FROM products LIKE 'featured'";
$enumResult = mysqli_query($conn, $enumQuery);
if ($enumResult && $enumRow = mysqli_fetch_assoc($enumResult)) {
    if (preg_match("/^enum\((.*)\)$/", $enumRow['Type'], $matches)) {
        $vals = explode(",", $matches[1]);
        $vals = array_map(function ($v) {
            return trim($v, " '");
        }, $vals);
        $featuredEnum = $vals;
    }
}
if (empty($featuredEnum)) {
    $featuredEnum = ['new','best_selling','trending','popular'];
}
$featuredList = '"' . implode(',', $featuredEnum) . '"';
for ($row = 2; $row <= 100; $row++) {
    $validation = $sheet->getCell('J' . $row)->getDataValidation();
    $validation->setType(DataValidation::TYPE_LIST);
    $validation->setErrorStyle(DataValidation::STYLE_STOP);
    $validation->setAllowBlank(false);
    $validation->setShowInputMessage(true);
    $validation->setShowErrorMessage(true);
    $validation->setFormula1($featuredList);
    $validation->setShowDropDown(true);
    $validation->setErrorTitle("Invalid Featured Value");
    $validation->setError("Please select a valid 'featured' value from the drop-down arrow.");
}

// ------------------------------------------------------------------
// 10. Save the Excel file (for bulk edit template) to a temporary location
$tempExcelFile = tempnam(sys_get_temp_dir(), 'excel_') . '.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($tempExcelFile);

// ------------------------------------------------------------------
// 11. Create a ZIP archive containing both the Excel file and the images
$zip = new ZipArchive();
$tempZipFile = tempnam(sys_get_temp_dir(), 'zip_') . '.zip';
if ($zip->open($tempZipFile, ZipArchive::CREATE) !== true) {
    die("Could not open archive");
}

// Add the Excel file to the ZIP archive with a desired name
$zip->addFile($tempExcelFile, 'bulk_edit_template.xlsx');

// Directory where images are stored
$uploadDir = realpath(__DIR__ . '/../uploads/shop') . DIRECTORY_SEPARATOR;

// Loop over each product to add its image
// Loop over each product to add its image
foreach ($productsData as $product) {
     $originalImage = $product['image'];
     $imagePath = $uploadDir . $originalImage;
     if (file_exists($imagePath)) {
         // Sanitize product name: remove unwanted characters and replace underscores with spaces.
         $sanitizedName = preg_replace('/[^a-zA-Z0-9_ -]/', '', $product['product_name']);
         $sanitizedName = str_replace('_', ' ', $sanitizedName);
         $ext = pathinfo($originalImage, PATHINFO_EXTENSION);
         $newFileName = $sanitizedName . ' ' . $product['id'] . '.' . $ext;
         
         // Add the image to the ZIP using the new file name
         $zip->addFile($imagePath, $newFileName);
     }
 }
 
$zip->close();

// Clean up the temporary Excel file as it's now in the ZIP
unlink($tempExcelFile);

// ------------------------------------------------------------------
// 12. Output the ZIP file for download (containing both the Excel file and images)
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="bulk_edit_export_' . time() . '.zip"');
header('Content-Length: ' . filesize($tempZipFile));
readfile($tempZipFile);

// Clean up the temporary ZIP file
unlink($tempZipFile);
exit;
?>
