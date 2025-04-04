#### installation

```sh
composer require vlucas/phpdotenv
```

#### .env

```.env
FOO=bar
BAR="baz"
BAZ=true
```

#### read

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__); // .env must be in current dir, otherwise use \Dotenv\Dotenv::createImmutable(dirname(__DIR__)) or \Dotenv\Dotenv::createImmutable('/foo/bar') etc.
$dotenv->load();
// don't use getenv or $_ENV (since this is not working reliably, e.g. in ci build pipelines)
echo @$_SERVER['FOO'];
echo @$_SERVER['BAR'];
// get boolean values
!!($_SERVER['BAZ'] ?? false)
```