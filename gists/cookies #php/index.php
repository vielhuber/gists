<?php
// unset
unset($_COOKIE['cookie']); setcookie('cookie', '', time() - 3600, '/');

// set
setcookie('cookie', $value, time()+60*60*24*1, '/');
if (headers_sent()) { setcookie('cookie', $value, time()+60*60*24*1, '/'); } // prevent "headers already sent" error
$_COOKIE['cookie'] = $value; // immediately set it for current request

// get
$_COOKIE['cookie']
urldecode($_COOKIE['meinCookie']) // use this with umlauts when stored in js via encodeURIComponent
  
// check
if(isset($_COOKIE['cookie'])){ /* ... */ }

// set cookies without urlencode
setrawcookie(...)
  
/* store arrays in a cookie */
// set
$array = ['foo','bar'];
$array = serialize($array);
setcookie('cookie', $array, time()+60*60*24*1, '/');
// get
$array = $_COOKIE['cookie'];
$array = stripslashes($array); // because setcookie adds backslashes \ before "
$array = unserialize($array);