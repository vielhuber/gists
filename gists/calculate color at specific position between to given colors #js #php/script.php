<?php
function colorBlend($start, $end, $ratio) {
    if(strpos($start,'#') !== 0) { $start = '#'.$start; }
    if(strpos($end,'#') !== 0) { $end = '#'.$end; }
    list($r1,$g1,$b1) = str_split(ltrim($start,'#'),2);
    list($r2,$g2,$b2) = str_split(ltrim($end,'#'),2);
    $r_avg = (hexdec($r1)*(1-$ratio)+hexdec($r2)*$ratio);
    $g_avg = (hexdec($g1)*(1-$ratio)+hexdec($g2)*$ratio);
    $b_avg = (hexdec($b1)*(1-$ratio)+hexdec($b2)*$ratio);
    return '#'.sprintf("%02s",dechex($r_avg)).sprintf("%02s",dechex($g_avg)).sprintf("%02s",dechex($b_avg));
}
echo colorBlend('#FF0000','#008000',0.5);