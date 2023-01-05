<?php
function __x($input) {
    if( $input === null || $input === '' || trim($input) === '' || (is_array($input) && empty($input)) || (is_object($input) && empty((array)$input)) ) { return false; }
    return true;
}