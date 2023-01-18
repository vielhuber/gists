<?php
if( strpos(get_sub_field('link'), 'youtube') !== false )
{
  $video_id = get_sub_field('link');
  $video_id = substr($video_id, strrpos($video_id,'watch?v=')+strlen('watch?v='));
  echo '<iframe ';
      echo 'src="https://www.youtube.com/embed/'.$video_id.'?rel=0&amp;showinfo=0" ';
      echo 'width="560" ';
      echo 'height="315" ';
      echo 'allow="autoplay; fullscreen" allowfullscreen';
  echo '></iframe>';
}
elseif( strpos(get_sub_field('link'), 'vimeo') !== false )
{
    $video_id = get_sub_field('link');
    $video_id = filter_var($video_id, FILTER_SANITIZE_NUMBER_INT);
    echo '<iframe ';
        echo 'src="https://player.vimeo.com/video/'.$video_id.'?color=dddddd&title=0&byline=0&portrait=0" ';
        echo 'width="500" ';
        echo 'height="281" ';
        echo 'allow="autoplay; fullscreen" webkitallowfullscreen mozallowfullscreen allowfullscreen';
    echo '></iframe>';
}