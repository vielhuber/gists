<?php
$url = 'https://www.määh.com';

// this works only with the idna package
if( filter_var(idn_to_ascii($url), FILTER_VALIDATE_URL) === false ) { echo 'NO'; } else { echo 'OK'; }

// this works only with the idna package
if( filter_var(str_replace(['ä','ö','ü'], ['ae', 'oe', 'ue'], $url), FILTER_VALIDATE_URL) === false ) { echo 'NO'; } else { echo 'OK'; }