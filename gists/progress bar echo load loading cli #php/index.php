<?php
function progress($done, $total, $info = '', $width = 50, $char = '=') {
    $perc = round($done * 100 / $total);
    $bar = round(($width * $perc) / 100);
    echo sprintf(
        "%s[%s%s] %s\r",
        $info != '' ? $info.' ' : '',
        str_repeat($char, $bar).($perc < 100 ? '>' : ''),
        $perc == 100 ? $char : str_repeat(' ', $width-$bar),
        str_pad($perc, 3, ' ', STR_PAD_LEFT).'%',
    );
}

echo 'Searching for TOE (theory of everything)...';
echo PHP_EOL;
$i = 0;
while($i <= 100) {
    progress($i, 100, 'Loading...', 75, '#');
    usleep($i < 90 ? 10000 : 250000);
    $i++;
}
echo PHP_EOL;
echo 'Answer: 42';
echo PHP_EOL;