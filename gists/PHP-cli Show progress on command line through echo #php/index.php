<?php
for ($i = 0; $i <= 100; $i++) {
    echo "Loading... {$i}%\r";
    usleep(10000);
}

for ($i = 100; $i >= 0; $i-) {
    echo str_pad($i, 4, '0', STR_PAD_LEFT)."\r"; // every output should not be smaller than the previous one, so otherwise you get output formatting errors
    usleep(10000);
}


