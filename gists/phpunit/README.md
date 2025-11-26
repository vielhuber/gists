### installation

#### install phpunit via composer per project
- `mkdir phpunit-test`
- `cd phpunit-test`
- `composer require --dev phpunit/phpunit`
- `./vendor/bin/phpunit --version`

#### setup configuration file
- create `phpunit.xml` in root folder (see content below)

#### setup tests in /tests/ folder
- warning: class name must be the same as filename AND must end with "Test"
- function names must start with "test"
- the return types :void must be existent on the inherited methods setUp etc. (otherwise phpunit >=8 throws an error)

#### add .phpunit.result.cache to gitignore
- `vim .gitignore`
- `/.phpunit.result.cache`
- `/.phpunit.cache`
- this file is used by phpunit to speed up tests (you can also disable the creation of the file with the flag --do-not-cache-result or cacheResult=false in phpunit.xml)

#### optional: modify path environment
- add the relative path ```./vendor/bin``` (or ```.\vendor\bin``` on windows) to your PATH environment  
- if not, use ```./vendor/bin/phpunit``` for ```phpunit``` instead

### usage

#### run
```
phpunit
phpunit --filter "/::testUpdateFailure$/" # run a specific method (in all tests)
phpunit --filter testUpdateFailure # run a specific method (in all tests) beginning with testUpdateFailure
phpunit --filter "/::testUpdateFailure$/" tests/Feature/MenuTest # run a specific method (in specific test)
phpunit --testdox # show detailed test names and run times
phpunit --debug # show intermediate states
```

#### psr4
if you want to use traits / class inheritance in phpunit, simply do the following steps:
- add this to your composer.json: ```"autoload": { "psr-4": { "Tests\\": "tests/" } }```
- do a ```composer dump-autoload```
- add ```namespace Tests;``` on top of each test file
- now you can use classes from other classes (that are not tests)

#### failed tests

- with `stopOnFailure="false"` in `phpunit.xml`, phpunit does not stop if a test fails
- you can use the command line argument `--stop-on-failure` to circumvent this behaviour
- however if inside a single test multiple assertions are made, phpunit also stops on the first wrong assertion (even with this setting)
- to overcome this, collect the failures manually and make a dummy assertion like `$this->assertTrue(false);` at the end

#### logging

- phpunit does not show `echo` statements
- instead, use this:
  - `fwrite(STDERR, var_export($msg, true));`
  - `fwrite(STDERR, print_r($msg . PHP_EOL, true));`
  - `fwrite(STDERR, serialize($msg));`
- helper function
```
function log($msg) {
  if (!is_string($msg)) {
    $msg = serialize($msg);
  }
  fwrite(STDERR, print_r($msg . PHP_EOL, true));
}
$this->log('...');
```

#### variables

- if you make changes to globals like ```$_SERVER```, these changes are not resetted after a test has finished
- do reach some form of isolation, use the option ```backupGlobals="true"``` (now all global variables are reset before each test)