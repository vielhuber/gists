<?php
if( @$_SERVER['SERVER_ADMIN'] === 'david@vielhuber.de' || @$_SERVER['NAME'] === 'DAVID-DESKTOP' )
{
    define('DB_NAME', 'example');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_HOST', 'localhost');
}
elseif( @$_SERVER['SERVER_ADMIN'] === 'foo@bar.com' )
{
    define('DB_NAME', 'example');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_HOST', 'localhost');
}
elseif( strpos(@$_SERVER['HTTP_HOST'], 'testing') !== false )
{
    define('DB_NAME', 'xxxxxxxx');
    define('DB_USER', 'xxxxxxxx');
    define('DB_PASSWORD', 'xxxxxxxx');
    define('DB_HOST', 'localhost');
}
else
{
    define('DB_NAME', 'xxxxxxxx');
    define('DB_USER', 'xxxxxxxx');
    define('DB_PASSWORD', 'xxxxxxxx');
    define('DB_HOST', 'localhost');
}

define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
define('DIEONDBERROR', true);