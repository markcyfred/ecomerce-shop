<?php
require '../vendor/autoload.php';
require '../admin/config/dbcon.php'; // Make sure this file sets $conn as your mysqli connection

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

// 1. Create the spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// 2. Define headers in the order your bulk upload code expects
$headers = [
    'Category Name', // data[0]
    'Rating',        // data[1]
    'Discount',      // data[2]
    'Product Name',  // data[3]
    'Description',   // data[4]
    'Original Price',// data[5]
    'Selling Price', // data[6]
    'Quantity',      // data[7]
    'Featured'       // data[8]
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
$lastCol = chr(ord($startCol) + count($headers) - 1); // E.g. 'I'
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

// ------------------------------------------------------------------
// 8. Data Validation
// ------------------------------------------------------------------

// (A) Category Name from DB (column A => A2:A100)
$categories = [];
$catQuery = "SELECT name FROM categories";
$catResult = mysqli_query($conn, $catQuery);
if ($catResult) {
    while ($row = mysqli_fetch_assoc($catResult)) {
        $categories[] = $row['name'];
    }
}
// Fallback if no categories
if (empty($categories)) {
    $categories = ['Default Category'];
}
$categoryList = '"' . implode(',', $categories) . '"';

for ($row = 2; $row <= 100; $row++) {
    $validation = $sheet->getCell('A' . $row)->getDataValidation();
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

// (B) Rating (column B => B2:B100) => 1,2,3,4,5
$ratingList = '"1,2,3,4,5"';
for ($row = 2; $row <= 100; $row++) {
    $validation = $sheet->getCell('B' . $row)->getDataValidation();
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

// (C) Featured (column I => I2:I100) => from enum('new','best_selling','trending','popular', etc.)
$featuredEnum = [];

// Try to get enum values first
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

// If no enum values found, get all distinct featured tags from products table
if (empty($featuredEnum)) {
    $all_tags = [];
    $tagsQuery = "SELECT featured FROM products WHERE featured IS NOT NULL AND featured != ''";
    $tagsResult = mysqli_query($conn, $tagsQuery);

    if ($tagsResult) {
        while ($row = mysqli_fetch_assoc($tagsResult)) {
            $tags = explode(',', $row['featured']);
            foreach ($tags as $tag) {
                $trimmed = trim($tag);
                if ($trimmed !== '' && !in_array($trimmed, $all_tags)) {
                    $all_tags[] = $trimmed;
                }
            }
        }
    }
    $featuredEnum = $all_tags;
}

$featuredList = '"' . implode(',', $featuredEnum) . '"';

for ($row = 2; $row <= 100; $row++) {
    $validation = $sheet->getCell('I' . $row)->getDataValidation();
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

// 9. Output the file as an Excel download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="bulk_upload_template.xlsx"');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
