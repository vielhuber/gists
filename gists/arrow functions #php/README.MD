### before
```php
array_map(function($v) { return 'php '.$v.' will be fun'; }, ['7.4'])
```

### after
```php
array_map(fn($v) => 'php '.$v.' will be fun', ['7.4'])
```

### arrow functions have access to outside scope
```php
$a = 'foo'; $b = 'bar';
$f = function($input) use($a) { return $a.$input.'baz'; }; echo $f($b);
echo (fn($input) => $a.$input.'baz')($b);
```