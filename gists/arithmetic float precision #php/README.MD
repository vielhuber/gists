- never compare floats (because internally some floats like 0.1 or 0.7 cannot be represented accurately)
```php
$x = 8 - 6.4;
$y = 1.6;

// wrong
var_dump($x == $y); // false

// correct
var_dump(round($x,2) == round($y,2)); // true
```

- another approach is to use bc math functions
```php
$x = bcsub('8', '6.4', 8);
$y = '1.6';

var_dump(bccomp($x, $y, 8)); // 0 (true)
```