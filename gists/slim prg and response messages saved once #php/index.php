<?php
// include controller
require_once('controller.php');

// fetch saved message
$message = null;
if( @__x($_COOKIE['message']) )
{
    $message = base64_decode($_COOKIE['message']);
    setcookie('message', '', time()-3600, '/');
}

// output view (header)
echo '<div id="content">';

// output message
if( @__x($message) )
{
  echo $message;   
}

// output view (main)
echo '<form method="post" action="form.php">';
  echo '<input type="submit" />';
echo '</form>';

// output view (footer)
echo '</div>';