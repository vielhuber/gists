### prevent static classes

```php
// bad
Example::calculate($obj)
  
// good
(new Example($obj))->calculate()
```

### prevent static arguments

```php
// bad
public static int $foo;

// good
public int $foo;
```

### loops

```php
$countries = ['Europe' => 'Germany'];

// bad
foreach($countries as $countries__key => $countries__value) { }

// good
foreach($countries as $continent => $country) { }
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

// bad
(new Foo(data: 'bar'))->calc()
  
// good
(new Foo())->setData(data: 'bar')->calc()
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
public static function foo($a, $b = null, $c = false) {}

// good
protected function foo(int $a, ?string $b = null, bool $c = false): void {}

// bad
public $foo;

// good
protected int $foo;
```

### use jobs to dispatch long running tasks

```php
// bad
longRunningTask();

// good
CalculateLongRunningTaskQueue::dispatch();
```

### multiline comments

```php
// bad
// this is
// a multiline
// comment

// bad
/*
this is
a multiline
comment
*/

// good
/**
 * this is
 * a multiline
 * comment
 */
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