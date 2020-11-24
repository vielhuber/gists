### syntax

`$a <=> $b`

### explanation

- `0, if $a == b`
- `-1, if $a < $b`
- `1, if $a > $b`

### use case
```php
usort($arr, function($a,$b) {
	return $a <=> $b; // integers
    return strcmp($a <=> $b); // strings
});
```