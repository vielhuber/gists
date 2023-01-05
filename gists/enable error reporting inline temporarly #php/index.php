<?php
// full error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// no error reporting
error_reporting(0);

// temporarily hide error reporting
$previous = error_reporting(0);
something_which_produces_warnings_which_can_safely_be_ignored();
error_reporting($previous);