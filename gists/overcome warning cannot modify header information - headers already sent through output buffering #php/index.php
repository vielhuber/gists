<?php
$case = 1;

/* if output buffering is on, then headers can be sent even after output has been generated */
/* so this should work */
if( $case === 1 ) {
	echo '.';
	header('HTTP/1.1 200 OK');
}

/* but not lets overflow the default limit of 4096 */
/* this should produce an error */
if( $case === 2 ) {
	for( $i = 0; $i <= 4096; $i++ ) { echo '.'; }
	header('HTTP/1.1 200 OK');
}

/* not let's make this work again with ob_start */
if( $case === 3 ) {
	ob_start();
	for( $i = 0; $i <= 4096; $i++ ) { echo '.'; }
	header('HTTP/1.1 200 OK');
	ob_end_flush();
}