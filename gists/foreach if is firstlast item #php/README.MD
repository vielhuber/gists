### solution without keys
```php
$array = ['foo', 'bar', 'bar', 0, false, null, 'baz'];
foreach ($array as $value) {
  $is_last = next($array) === false && key($array) === null; // warning: this moves the internal pointer one forward, so just call it once
  /* ... */
  if( $is_last ) {}
}
foreach ($array as $value) {
  $is_first = prev($array) === false && key($array) === null; if($is_first) { reset($array);next($array); } else { next($array);next($array); } // warning: this moves the internal pointer one forward, so just call it once
  /* ... */
  if( $is_first ) {}
}
```


### solution with keys
```php
// check if key is first key in foreach loop
function __fkey($array__key,$array) {
	if( array_keys($array)[0] === $array__key ) {
		return true;
	}
	return false;
}

// check if key is last key in foreach loop
function __lkey($array__key,$array) {
	if( array_keys($array)[count(array_keys($array))-1] === $array__key ) {
		return true;
	}
	return false;
}

$array = [true, false, false];
$array = ['a','b','c'];
$array = ['no' => 1, 2 => 'foo', 'bar' => 'bar'];

foreach($array as $array__key=>$array__value) {
    echo $array__value."\n";
    if( __fkey($array__key,$array) ) { echo "FIRST\n"; }
    if( __lkey($array__key,$array) ) { echo "LAST\n"; }
}
```
