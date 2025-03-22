<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Create a new spreadsheet instance
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Define where the table starts to simulate margins
$startRow = 2;    // Leave row 1 empty (top margin)
$startCol = 'B';  // Leave column A empty (left margin)

// Define the template headers (without Status, Trending, and Size)
$headers = [
    'Category Name', 'Rating', 'Discount', 'Product Name', 'Description',
    'Original Price', 'Selling Price', 'Quantity', 'Featured'
];

// Set the headers starting at cell B2
$col = $startCol;
foreach ($headers as $header) {
    $sheet->setCellValue($col . $startRow, $header);
    $col++;
}

// Calculate the last column letter for our header row
$lastCol = chr(ord($startCol) + count($headers) - 1);
$headerRange = $startCol . $startRow . ':' . $lastCol . $startRow;

// Apply styling to the header row: green background, white bold centered text, and borders
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

// Freeze pane so the header row remains visible. Since headers are in row 2, freeze starting at B3.
$sheet->freezePane($startCol . ($startRow + 1));

// Optionally, set auto column width for better visibility
for ($col = $startCol; $col <= $lastCol; $col++) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Set custom page margins (for printing or page setup)
$margins = $sheet->getPageMargins();
$margins->setTop(1);
$margins->setRight(0.75);
$margins->setLeft(0.75);
$margins->setBottom(1);

// Optionally define a print area that includes the header row only
$sheet->getPageSetup()->setPrintArea($startCol . $startRow . ':' . $lastCol . $startRow);

// Set HTTP headers for download and output the Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="bulk_upload_template.xlsx"');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
