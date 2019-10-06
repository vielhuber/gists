### namespaces

- namespaces are a virtual directory structure for your classes
- without namespaces, there is a potential conflict between class names in different packages
- important: there is NO connection between namespaces and your file structure (this connection only comes into play when using psr-4 autoloading)
- example without namespaces
```php
class Vielhuber_Database_Syncer {}
```
- example with namespaces
```php
namespace Vielhuber\Database;
class Syncer {}
```
- three simple rules for creating classes:
   - always add namespaces to every file your classes sit in
   - always include one class per file
   - always name the file the same as the class


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
       - option 1: ```$foo = new \Full\Path\To\Foo;```
       - option 2: ```use Full\Path\To\Foo; $foo = new Foo;```
   - also use aliases for duplicate classes or for convenience: ```use Full\Path\To\Foo as Bar; $foo = new Bar;```