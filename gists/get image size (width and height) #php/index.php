<?php
list($width, $height) = getimagesize($_SERVER['DOCUMENT_ROOT'].'/path/to/image.jpg');

//or
$size = getimagesize($_SERVER['DOCUMENT_ROOT'].'/path/to/image.jpg');
echo $size[0]; // width
echo $size[1]; // height