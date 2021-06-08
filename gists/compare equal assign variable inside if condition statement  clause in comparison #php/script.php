<?php
$a = 'bar';
if( ($b=$a) === 'bar' ) {
    echo 'foo';
}
echo $b;