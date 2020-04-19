<?php
$username = '42';
$password = '42';

$content = "";
$content .= 'AuthName "Interner Bereich"'."\n";
$content .= 'AuthType Basic'."\n";
$content .= 'AuthUserFile '.str_replace('helper.php','.htpasswd',__file__)."\n";
$content .= 'require valid-user'."\n\n";
file_put_contents('.htaccess_new', $content);

$content = "";
$content .= $username.':{SHA}'.base64_encode(sha1($password, true));
file_put_contents('.htpasswd_new', $content);
