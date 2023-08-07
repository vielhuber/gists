<?php
for ($i = 100; $i >= 0; $i--) {
     /* every output should not be smaller than the previous one, so otherwise you get output formatting errors */
    echo str_pad($i, 4, '0', STR_PAD_LEFT)."\r";
    usleep(1000);
}
echo PHP_EOL; /* important on the end */

for ($i = 0; $i <= 100; $i++) {
    echo "Loading... {$i}%\r";
    usleep(10000);
}
echo PHP_EOL;

for ($i = 100; $i >= 0; $i--) {
    //echo $i."\r"; /* this does not work properly */
    echo str_pad($i, 99, ' ', STR_PAD_RIGHT)."\r"; /* this works */
    usleep(10000);
}
echo PHP_EOL;
