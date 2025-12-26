#### /defines.php

```php
<?php
if (@$_SERVER['SERVER_ADMIN'] === 'david@vielhuber.de') {
    define('JPATH_CONFIGURATION', __DIR__ . '/configuration/local');
} else {
    define('JPATH_CONFIGURATION', __DIR__ . '/configuration/production');
}
```

#### /administrator/defines.php

```php
<?php
require_once dirname(__DIR__) . '/defines.php';
```

#### /configuration/local/configuration.php

```php
<?php
class JConfig
{
    /* ... */
    public $host = '...';
    public $user = '...';
    public $password = '...';
  	/* ... */
}
```

#### /configuration/production/configuration.php

```php
<?php
class JConfig
{
    /* ... */
    public $host = '...';
    public $user = '...';
    public $password = '...';
  	/* ... */
}
```


### obsolete solution

- problem: this does not work after saving in backend

#### /configuration.php

```php
class JConfig {
  ...
    public $host = null;
    public $user = null;
    public $password = null;
    public $db = null;
    public $log_path = null;
    public $tmp_path = null;
  ...

  public function __construct() {
    if( @$_SERVER['SERVER_ADMIN'] === 'david@vielhuber.de' ) {
        $this->debug = true;
        $this->host = '...';
        $this->user = '...';
        $this->password = '...';
        $this->db = '...';
        $this->log_path = __DIR__.'/logs';
        $this->tmp_path = __DIR__.'/tmp';
    }
    else {
      	$this->debug = false;
        $this->host = '...';
        $this->user = '...';
        $this->password = '...';
        $this->db = '...';
        $this->log_path = '...';
        $this->tmp_path = '...';
    }
  }
}
