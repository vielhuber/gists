<?php
function generateCustomerId($input, $algo, $length = 10)
{
   return substr(number_format(hexdec(hash($algo,$input)),0,'',''),0,$length);  
}

/* usage */
$input = 1337;
$input = 'string';
echo generateCustomerId($input, 'crc32', 3);

/* duplicate checker */
$algos = hash_algos(); // use this if you want to check all available algos
$algos = ['crc32']; // this is one of the best algos that don't generate duplicates for ids < 10.000.000
foreach($algos as $algos__value)
{
    echo 'checking algo '.$algos__value.': ';
    for($i = 0, $finished = []; $i < 10000000; $i++)
    {
        $hash = generateCustomerId($i,$algos__value);
        if( array_key_exists($hash,$finished) ) { echo('conflict between '.$i.' and '.$finished[$hash].''); echo PHP_EOL.PHP_EOL; continue 2; }
        $finished[$hash] = $i;
    }
    echo 'NO CONFLICT';
    echo PHP_EOL;
}