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
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// don't use getenv or $_ENV (since this is not working reliably, e.g. in ci build pipelines)
echo @$_SERVER['FOO'];
echo @$_SERVER['BAR'];
// get boolean values
!!($_SERVER['BAZ'] ?? false)
```