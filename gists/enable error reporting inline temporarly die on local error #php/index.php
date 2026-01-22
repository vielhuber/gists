<?php
/* full error reporting */
error_reporting(E_ALL);
ini_set('display_errors', '1');

/* no error reporting */
error_reporting(0);

/* temporarily hide error reporting */
$previous = error_reporting(0);
something_which_produces_warnings_which_can_safely_be_ignored();
error_reporting($previous);

/* recommended approach */
if (@$_SERVER['SERVER_ADMIN'] !== 'david@vielhuber.de') {
    ini_set('display_errors', 1);
    error_reporting(E_ERROR | E_PARSE);
}
else {
    ini_set('display_errors', 1);
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING | E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE | E_RECOVERABLE_ERROR | E_DEPRECATED | E_USER_DEPRECATED);
  	// die on every error
    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        // skip @
        if (!(error_reporting() & $errno)) {
            return false;
        }
        die('Fatal Error: ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
    });
}