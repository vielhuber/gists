### prevent static classes

```php
// bad
Example::calculate($obj)
  
// good
(new Example($obj))->calculate()
```

### cases

```php
// camel case
$variableFooBar
function fooBarBaz() {}
  
// pascal case
class ExampleClass {}

// snake case
$variable_in_template
Foo::first()->variable_from_db
```

### prevent arrays

```php
// bad
exampleFunction(['foo' => 'bar', 'bar' => 'baz'])
  
// good
exampleFunction(foo: 'bar', bar: 'baz')
```

### function chaining

```php
// bad
$value = $foo->calc(save: true);

// good
$foo->save()->calc()->getValue();
```

### use framework functions

```php
// bad
$str = trim($str);
$str = mb_strtoupper($str);
$str = str_replace(' ', '', $str);

// good
$str = Str::of($str)->trim()->upper()->replace(' ', '')->toString();
```

### prevent too much nesting

```php
// bad
function log($msg) : void {
  if(...) {
	echo $msg;
  }
}

// good
function log($msg) {
  if(!...) {
   	return; 
  }
  echo $msg;
}
```

### prevent too much nesting (2)

```php
// bad
if($a === true) {
	if($b === true) {
    	if($c === true) {
        	return 42;
        }
    }
}
return 7;

// good
if($a !== true) { return 7; }
if($b !== true) { return 7; }
if($c !== true) { return 7; }
return 42;
```

### prevent else

```php
// bad
if($foo) {

}
elseif($bar) {

}

// good
if($foo) {

}
if($bar && !$foo) {

}
```

### outsource long code parts

```php
// bad
$isSpecial = false;
if($foo) { $isSpecial = true; }
if($bar && !$foo) { $isSpecial = false; }
if($isSpecial) {
  //...
}

// good
function isSpecial() {
  if($foo) { return true; }
  if($bar) { return false; }
  return false;
}
if($this->isSpecial()) {
  //...
}
```

### use carbon instead of strings

```php
// bad
date('Y')-10

// good
Carbon::now()->subYears(10)->year
```

### use php type hinting

```php
// bad
public static function foo($a, $b, $c = false) {}

// good
public function foo(int $a, ?string $b, bool $c = false): void {}
```

### use jobs to dispatch long running tasks

```php
// bad
longRunningTask();

// good
CalculateLongRunningTaskQueue::dispatch();
```

### comment functions (e.g. using copilot)

```php
// bad
public function foo(): ?float {}

// good
/**
 * Calculate the value for our example.
 *
 * @return float|null
 */
public function foo(): ?float {}
```