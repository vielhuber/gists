<?php
var_dump($evil);
var_dump(gettype($evil)); // array
var_dump(gettype(key($evil))); // string
var_dump($evil[1]); // fails!
var_dump($evil['1']); // fails!
var_dump($evil[key($evil)]); // fails!
foreach($evil as $evil__key=>$evil__value)
{
  var_dump($evil__key); // '1' (string)
  var_dump($evil__value); // 'foo' (string)
  var_dump($evil[$evil__key]); // fails!
}