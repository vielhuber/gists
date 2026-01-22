<?php
$haystack = 'liwseadavdgjhdavgsjhgsjahdavvg';
$needle = 'dav';
$positions = [];
$pos_last = 0;
while( ($pos_last = strpos($haystack, $needle, $pos_last)) !== false ) {
    $positions[] = $pos_last;
    $pos_last = $pos_last + strlen($needle);
}
print_r($positions);