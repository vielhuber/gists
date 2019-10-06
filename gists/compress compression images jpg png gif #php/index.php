<?php
function compress($source, $quality, $destination = null)
{
  if( $destination === null )
  {
    $destination = $source;
  }
  $info = getimagesize($source);
  if ($info['mime'] === 'image/jpeg') 
  {
    $image = imagecreatefromjpeg($source);
    imagejpeg($image, $destination, $quality);
  }
  elseif ($info['mime'] === 'image/png') 
  {
    $image = imagecreatefrompng($source);
    imagepng($image, $destination, round((100-$quality)/10));
  }
  elseif ($info['mime'] === 'image/gif') 
  {
    $image = imagecreatefromgif($source);
    imagetruecolortopalette($image, false, 16);
    imagegif($image, $destination);
  }
  return true;
}

compress('path/to/input.jpg', 70);
compress('path/to/input.jpg', 70, 'path/to/output.jpg');