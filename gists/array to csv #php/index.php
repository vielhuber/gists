<?php
$arr = [
    ['foo', 'bar', 'baz'],
    ['foo', 'bar', 'baz'],
    ['foo', 'bar', 'baz'],
];
$fp = fopen('output.csv', 'wb');
foreach($arr as $arr__fields)
{
    fputcsv($fp, $arr__fields, ';', '"');
}
fclose($fp);