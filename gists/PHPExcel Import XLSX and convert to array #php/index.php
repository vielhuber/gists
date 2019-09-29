<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/phpexcel/PHPExcel/IOFactory.php');
$phpexcel_filename = $_SERVER['DOCUMENT_ROOT'].'/import.xlsx';
$phpexcel_filetype = PHPExcel_IOFactory::identify($phpexcel_filename);
$phpexcel_objReader = PHPExcel_IOFactory::createReader($phpexcel_filetype);
$phpexcel_objPHPExcel = $phpexcel_objReader->load($phpexcel_filename);

// convert one sheet
$phpexcel_sheet = $phpexcel_objPHPExcel->getSheet(0); 
$phpexcel_highestRow = $phpexcel_sheet->getHighestRow(); 
$phpexcel_highestColumn = $phpexcel_sheet->getHighestColumn(); 
$phpexcel_array = $phpexcel_sheet->toArray();
echo '<pre>';
print_r($phpexcel_array);
echo '</pre>';

// output all cells of this sheet
for($row = 1; $row <= $phpexcel_sheet->getHighestRow(); $row++) {
    $toCol = $phpexcel_sheet->getHighestColumn(); $toCol++;
    for($col = "A"; $col != $toCol; $col++) {
        echo $objPHPExcel->getActiveSheet()->getCell($col.$row)->getValue();
    }
}

// iterate through all sheets
foreach($phpexcel_objPHPExcel->getWorksheetIterator() as $phpexcel_sheet_nr=>$phpexcel_sheet) {
   // ...
}
?>