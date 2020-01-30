### installation

#### modify path environment
- add the relative path ```./vendor/bin``` (or ```.\vendor\bin``` on windows) to your PATH environment  
- if not, use ```./vendor/bin/phpunit``` for ```phpunit``` instead

#### install phpunit via composer per project
- mkdir phpunit-test  
- cd phpunit-test  
- composer require --dev phpunit/phpunit  
- phpunit --version

#### setup configuration file
- put phpunit.xml in root folder

#### setup tests in /tests/ folder
- warning: class name must be the same as filename AND must end with "Test"
- function names must start with "test"
- the return types :void must be existent on the inherited methods setUp etc. (otherwise phpunit >=8 throws an error)

#### add .phpunit.result.cache to gitignore
- vim .gitignore
- /.phpunit.result.cache
- this file is used by phpunit to speed up tests (you can also disable the creation of the file with the flag --do-not-cache-result or cacheResult=false in phpunit.xml)

### usage

#### run
```
phpunit
phpunit --filter testUpdateFailure # run a specific method (in all tests)
phpunit --filter testUpdateFailure tests/Feature/MenuTest # run a specific method (in specific test)
```

#### psr4
if you want to use traits / class inheritance in phpunit, simply do the following steps:
- add this to your composer.json: ```"autoload": { "psr-4": { "Tests\\": "tests/" } }```
- do a ```composer dump-autoload```
- add ```namespace Tests;``` on top of each test file
- now you can use classes from other classes (that are not tests)