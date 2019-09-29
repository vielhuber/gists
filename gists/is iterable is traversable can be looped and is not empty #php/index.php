<?php
function can_be_looped($a)
{
	if( is_array($a) && !empty($a) ) { return true; }
    if( is_object($a) && !empty((array)$a) ) { return true; }
	if( $a instanceof \Traversable && !empty($a) ) { return true; }
	return false;
}