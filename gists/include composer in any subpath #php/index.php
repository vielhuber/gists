<?php
$i = 0;
while($i < 5)
{
    if( file_exists( __DIR__.'/'.str_repeat('../',$i).'vendor/autoload.php' ) )
    {
        require_once __DIR__.'/'.str_repeat('../',$i).'vendor/autoload.php';
        break;
    }
    $i++;
}