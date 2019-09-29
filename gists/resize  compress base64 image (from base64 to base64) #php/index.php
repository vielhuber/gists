<?php
$base64_input = '...';

$image_old = str_replace('data:image/jpeg;base64,', '', $base64_input);
$image_old = base64_decode($image_old);
$image_old = imagecreatefromstring($image_old);

$width_old = imagesx($image_old);
$height_old = imagesy($image_old);
$width_new = 400;
$height_new = ($width_new*($height_old/$width_old));
$image_new = imagecreatetruecolor($width_new, $height_new);
imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $width_new, $height_new, $width_old, $height_old);
ob_start();
imagejpeg($image_new);
$base64_output = ob_get_contents();
ob_end_clean();
$base64_output = base64_encode($base64_output);

$base64_output = 'data:image/jpeg;base64,'.$base64_output;