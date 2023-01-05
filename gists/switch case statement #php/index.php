<?php
// shorthand
$var = 'foo';
switch ($var) {
    case 'foo': echo '1'; break;
    case 'bar': echo '2'; break;
    case 'baz': echo '3'; break;
}

// you can also have multiple cases
$var = 'bar';
switch($var) {
    case 'foo':
    case 'bar':
    case 'baz':
      echo 'matches 3 cases';
      break;
    case 'default':
      echo 'when nothing else matched';
      break;
}