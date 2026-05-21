<?php
$title = 'Titel der Seite';
$url = 'http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$image_url = 'http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST'].'/images/foo.png';
$image_width = 500;
$image_height = 500;
echo '<meta property="og:type" content="profile">' . PHP_EOL;
echo '<meta property="og:title" content="'.$title.'">' . PHP_EOL;
echo '<meta property="og:url" content="'.$url.'">' . PHP_EOL;
echo '<meta property="og:image" content="'.$image_url.'">' . PHP_EOL;
/* very important, because otherwise the first sharer does not see the image */
echo '<meta property="og:image:width" content="'.$image_width.'">' . PHP_EOL;
echo '<meta property="og:image:height" content="'.$image_height.'">' . PHP_EOL;