<?php
$a = $b = 0; $c = 86400;
while($a++ < $c) if( $a % 60 < 30 && $a % 3600 < 1800 && $a % 43200 < 21600 ) $b++;
echo $b/$c; // 0.125