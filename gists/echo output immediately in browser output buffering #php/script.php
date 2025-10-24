<?php
echo '1';
echo str_repeat(' ', 8192) . "\n"; // this must be sent since modern browsers buffer automatically
sleep(5);

echo '2';
echo str_repeat(' ', 8192) . "\n";
sleep(5);

echo '3';
echo str_repeat(' ', 8192) . "\n";
die();