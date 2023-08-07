<?php
// simple
if( $a = get_some_field() ) {
 	echo $a;
}
function get_some_field() { return 'foo'; }
 
// multiple
if( $a = get_some_field_1() ?? get_some_field_2() ?? get_some_field_3() ) {
 	echo $a;
}
function get_some_field_1() { return null; }
function get_some_field_2() { return null; }
function get_some_field_3() { return 'foo'; }

// complex
$a = 'bar';
if( ($b=$a) === 'bar' ) {
    echo 'foo';
}
echo $b;