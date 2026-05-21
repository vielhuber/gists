<?php
function image_orientate($source, $quality = 90, $destination = null)
{
    if ($destination === null) {
        $destination = $source;
    }
    $info = getimagesize($source);
    if ($info['mime'] === 'image/jpeg') {
        $exif = @exif_read_data($source);
        if (!empty($exif['Orientation']) && in_array($exif['Orientation'], [2, 3, 4, 5, 6, 7, 8])) {
            $image = imagecreatefromjpeg($source);
            if (in_array($exif['Orientation'], [3, 4])) {
                $image = imagerotate($image, 180, 0);
            }
            if (in_array($exif['Orientation'], [5, 6])) {
                $image = imagerotate($image, -90, 0);
            }
            if (in_array($exif['Orientation'], [7, 8])) {
                $image = imagerotate($image, 90, 0);
            }
            if (in_array($exif['Orientation'], [2, 5, 7, 4])) {
                imageflip($image, IMG_FLIP_HORIZONTAL);
            }
            imagejpeg($image, $destination, $quality);
        }
    }
    return true;
}