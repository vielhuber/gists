<?php
$xls = new ExcelHelper;
$file->engine = 'spout'; // alternative: phpexcel
$file->type = 'xlsx'; // alternative: csv
$file->data = [['a1','b1'],['a2','b2']];
$file->formatTitle();
$file->download();