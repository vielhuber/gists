<?php
$input = explode(PHP_EOL, '2
2 2
3 2');
$T = $input[0];

for ($i = 1; $i <= $T; $i++) {
    $n = trim((string) explode(' ', $input[$i])[0]);
    $m = trim((string) explode(' ', $input[$i])[1]);
    if (bccomp($m,$n) > 0) { [$n, $m] = [$m, $n]; }
    $res = '1';
    $k = bcadd($n,$m);
    while (bccomp($k,$n) > 0) { $res = bcmul($res, $k); $k = bcsub($k,1); }   
    $k = $m;
    while (bccomp($k,0) > 0) { $res = bcdiv($res, $k); $k = bcsub($k,1); }
    echo bcmod($res, (string)(pow(10, 9) + 7));
    if( $i < $T ) { echo PHP_EOL; }
}
