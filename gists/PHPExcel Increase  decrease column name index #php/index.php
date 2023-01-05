<?php
$col = 'Z';
$shift = 10; // can also be negative
echo PHPExcel_Cell::stringFromColumnIndex(PHPExcel_Cell::columnIndexFromString($col)-1+$shift);