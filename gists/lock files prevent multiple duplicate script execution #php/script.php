<?php
$lock = fopen(sys_get_temp_dir() . '/' . md5(__FILE__) . '.lock', 'c');
if (!flock($lock, LOCK_EX | LOCK_NB)) {
    echo 'current script already running...';
    die();
}

echo 'script running...';
sleep(10);

// this is not needed, because the lock is released on script end (also on error)
//fclose($lock);