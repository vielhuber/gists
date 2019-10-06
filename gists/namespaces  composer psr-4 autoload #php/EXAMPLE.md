### composer.json
```json
{
    "autoload": {
        "psr-4": {
            "Example\\": "src/"
        }
    }
}
```

### index.php
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

use Example\Bar7\Bar49\Gna;
use Example\Foo;
use Example\Baz;

Foo::foo();
Baz::baz();
Gna::gna();
```

### src\Foo.php
```php
<?php
namespace Example;
class Foo
{
    public static function foo()
    {
        echo 'foo';
    }
}
```

### src\Baz.php
```php
<?php
namespace Example;
class Baz
{
    public static function baz()
    {
        echo 'baz';
    }
}
```

### src\Bar7\Bar49\Gna.php
```php
<?php
namespace Example\Bar7\Bar49;
class Gna
{
    public static function gna()
    {
        echo 'gna';
    }
}
```