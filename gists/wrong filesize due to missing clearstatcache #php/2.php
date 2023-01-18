<?php
function w($m) { $h = fopen('f', 'w'); fwrite($h, $m); fclose($h); clearstatcache(); }
function r() { $h = fopen('f', 'r'); $c = fread($h, filesize('f')); fclose($h); echo $c; }
w('foo'); r(); // foo
w('foobar'); r(); // foobar