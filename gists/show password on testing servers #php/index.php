<?php
/* show password on testing */
if(
    strpos($_SERVER['HTTP_HOST'], 'close2dev') !== false &&
    !isset($_COOKIE['testing'])
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
        echo '
            <!DOCTYPE html>
            <html lang="de">
            <head>
                <meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1" />
                <meta name="robots" content="noindex" />
                <title>.</title>
                <style>
                    * { box-sizing: border-box;margin:0;padding:0; }
                    .form { position: absolute;top: 50%;transform: translateY(-50%);width:100%; }
                    .form__input { border:2px solid #000;padding:20px;text-align:center;width:300px;font-size:30px;font-weight:bold;max-width:90%;margin:0 auto;display:block;outline:none; }
                </style>
            </head>
            <body>
                <form class="form" method="post" autocomplete="off">
                    <input class="form__input" name="password" type="text" placeholder="" autofocus="autofocus" required="required" />
                </form>
            </body>
            </html>
        ';
        die();
    }
}