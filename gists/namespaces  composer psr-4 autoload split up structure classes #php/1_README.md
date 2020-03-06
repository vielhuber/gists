### namespaces

- namespaces are a virtual directory structure for your classes
- without namespaces, there is a potential conflict between class names in different packages
- with namespaces, you can have same class names / function names in different namespaces (they do not collide)
- important: there is NO connection between namespaces and your file structure (this connection only comes into play when using psr-4 autoloading)
- three simple rules for creating classes:
   - always add namespaces to every file your classes sit in
   - always include one class per file
   - always name the file the same as the class


### examples

#### 1
```php
// example without namespace
class Vielhuber_Database_Syncer {}
```
```php
// example with namespace
namespace vielhuber\database;
class Syncer {}
```


#### 2
```php
// NamespaceTest.php
<?php
namespace NamespaceTest;
function test() { echo '42'; }
```

```php
// Test1.php
<?php
require_once('NamespaceTest.php');
test(); // does not work, because we have no namespace declared
```

```php
// Test2.php
<?php
namespace NamespaceTest;
require_once('NamespaceTest.php');
test(); // does work, because we are in the same namespace
```

```php
// Test3.php
<?php
namespace NamespaceTest\Subnamespace;
require_once('NamespaceTest.php');
test(); // does not work, because subnamespaces don't inherit
```

```php
// Test4.php
<?php
require_once('NamespaceTest.php');
NamespaceTest\test(); // does work, because we call the function directly
```


### composer

- you can autoload all the different class files in one of the following ways
  - simply require_once every single file (that works)
  - use the classmap in the autoload attribute in composer.json
  - use the psr-4 standard (recommended)
- step 1: add the **main folder** to composer.json (src could be any other folder name):
```json
{
    "autoload": {
        "psr-4": {
	        "ExampleNamespace\\": "src/"
    	}
    }
}
```
- step 2: ```composer dump-autoload```
- step 3: ```require_once(__DIR__ . '/vendor/autoload.php');``` and start using the classes
- three simple rules for using classes:
   - just use the same namespace and reference other classes in the same namespace: $foo = new Foo;
   - use another namespace or no namespace at all and reference other classes in different namespaces: 
       - option 1: ```$foo = new \Full\Path\To\Foo();```
       - option 2: ```use Full\Path\To\Foo; $foo = new Foo();```
       - option 3: ```namespace Example; $foo = new Foo();```
   - also use aliases for duplicate classes or for convenience: ```use Full\Path\To\Foo as Bar; $foo = new Bar();```