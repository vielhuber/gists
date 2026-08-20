<?php
// show password on testing
if(
 strpos($_SERVER['HTTP_HOST'], 'vielhuber') !== false &&
 !is_admin() &&
 !isset($_COOKIE['testing']) &&
 $pagenow != 'wp-login.php'
) {
 if( isset($_POST['password']) && $_POST['password'] === '42' )
 {
 setcookie('testing', '1', time()+60*60*24*1, '/');
 header('Location: ' . $_SERVER['REQUEST_URI']);
 die();
 }
 else
 {
 header('HTTP/1.0 404 Not Found');
 echo '<!DOCTYPE html>
<html lang="de">
<head>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1" />
 <meta name="robots" content="noindex" />
 <title>'.get_bloginfo('name').'</title>
 
</head>
<body>
 <form method="post" autocomplete="off">
 <input name="password" type="text" placeholder="" autofocus="autofocus" required="required" />
 </form>
</body>
</html>';
 die();
 }
}