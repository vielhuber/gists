## old syntax

```php
$value = "hello world";

// short version
$result = function1(function2(function3($value)));

// long version
$result1 = function3($value);
$result2 = function2($result1);
$result = function1($result2);
```

## new syntax

```php
$value = "hello world";
$result = $value
    |> function3(...)
    |> function2(...)
    |> function1(...);
```

## example with values

```php    
$value = 'Lorem Ipsum';
$result = $value
    |> fn($x) => explode(' ', $x)
    |> fn($x) => implode('_', $x)
    |> strtolower(...)
; // lorem_ipsum
```