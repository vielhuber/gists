<?php
if( isset($_SERVER['REQUEST_URI']) )
{
    $url = $_SERVER['REQUEST_URI'];
    if( substr($url, 0, 1) == '/' ) { $url = substr($url, 1); }
    $mapping = [
        'index.php?url=with&parameters=1' => 'https://www.tld.com/foo',
        'index.php?anotherurl=with&parameters=1' => 'https://www.tld.com/bar',
    ];
    if( array_key_exists( $url, $mapping ) )
    {
        header( 'Location: '.$mapping[$url], true, 301 );
        die();
    }
}