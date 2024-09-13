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

### loop namings

```php
$countries = ['Europe' => 'Germany'];

// bad
foreach($countries as $countries__key => $countries__value) { }

// good
foreach($countries as $continent => $country) { }

$dataToTest = [7, 42];

// bad
foreach($dataToTest as $dataToTest__value) { }

// good
foreach($dataToTest as $testValue) { }
```

### prevent abbreviations

```php
// bad
$model->calc()
  
// good
$model->calculate()
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

### prevent arrays (2)

```php
// bad
$foo = (object) ['foo' => 'bar', 'bar' => 'baz']; // anonymous object with properties 'foo' and 'bar'

// good
$foo = (new Foo())->foo('bar')->bar('baz')->get(); // Foo object with properties 'foo' and 'bar'
```

### use classes / use getters / prevent arrays

```php
// bad
$mapping = getMapping('test'); // ['foo' => 42, 'bar' => 7]

// good
$mapping = (new MappingGetter())->value('test')->get(); // Mapping object
class Mapping {
 	public ?int $foo; 
  	public ?int $bar;
}
class MappingGetter {
  	public string $value;
 	public function value($value) { $this->value = $value; return $this; }
  	public function get() {
      $mapping = (new Mapping());
      $mapping->foo = 42;
      $mapping->bar = 7;
      /* ... more logic ... */
      return $mapping;
    }
}
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

### prevent duplicate database calls

```php
// bad
$model = Model::orderBy('id');
$count = $model->count(); // counts in db
$model = $model->get();

// good
$model = Model::orderBy('id');
$model = $model->get();
$count = $model->count(); // counts in collection
```

### output console commands

```php
// bad
echo $msg . PHP_EOL; // with newline in command
echo $msg . ' '; // without newline in command
echo str_pad($msg, 99, ' ', STR_PAD_RIGHT) . "\r"; // with overwrite in command
(new \Symfony\Component\Console\Output\ConsoleOutput())->writeln($msg); // with newline in controller
(new \Symfony\Component\Console\Output\ConsoleOutput())->info($msg); // without newline in controller
(new \Symfony\Component\Console\Output\ConsoleOutput())->write(str_pad($msg, 99, ' ', STR_PAD_RIGHT) . "\r"); // with overwrite in controller

// good
$this->info($msg); // with newline in command
$this->output->write($msg); // without newline in command
$this->output->write(str_pad($msg, 99, ' ', STR_PAD_RIGHT) . "\r"); // with overwrite in command
ConsoleOutputHelper::info($msg); // with newline in controller
ConsoleOutputHelper::write($msg); // without newline in controller
ConsoleOutputHelper::overwrite($msg); // with overwrite in controller
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

### prevent too much function calls

```php
// bad
foo($value, true, true, false, 42)
  
// good
foo(value: $value, save: true, cache: true, force: false, amount: 42)
$foo->withSave()->withCache()->withoutForce()->withAmount(42)->calculate($value);
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
protected ?int $foo;
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