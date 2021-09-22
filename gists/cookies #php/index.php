<?php
// unset
unset($_COOKIE['cookie']); setcookie('cookie', '', time() - 3600, '/');

// set
setcookie('cookie', $value, time()+60*60*24*1, '/');
$_COOKIE['cookie'] = $value; // immediately set it for current request

// get
$_COOKIE['cookie']

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