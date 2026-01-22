/* 1px src tag to pass html validation */
echo '<img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="adaptive"';
  foreach(array('desktop'=>'large','tablet'=>'medium','mobile'=>'thumbnail') as $device=>$size) {
    echo ' data-src-'.$device.'="'.array_shift(array_values(wp_get_attachment_image_src(get_post_thumbnail_id($i->ID),$size,false))).'"';
  }
echo ' alt="" />';
echo '<div class="adaptive"';
  foreach(array('desktop'=>'large','tablet'=>'medium','mobile'=>'thumbnail') as $device=>$size) {
    echo ' data-background-image-'.$device.'="'.array_shift(array_values(wp_get_attachment_image_src(get_post_thumbnail_id($s->ID),$size,false))).'"';
  }
echo '></div>';