- if you want to store sensitive information very easily on the server (and not on the client) and don't want to use a database
- a session cookie is stored on the client to identify the user
- the session cookie ends until the user closes the browser (but it can be extended)
- sessions can also be used on backends that are called via javascript

### start session
```php
session_start();
```

### extend session (at least in minimum, not accurate!)
```php
$session_time = 60 * 60 * 24 * 30; // 30 days
ini_set('session.gc_maxlifetime', $session_time);
session_set_cookie_params($session_time);
session_start();
```

###  store data
```php
$_SESSION['foo'] = 'bar';
$_SESSION['bar'] = ['baz' => 'gnarr'];
```

###  get data
```php
echo $_SESSION['foo'];
```

### delete data
```php
unset($_SESSION['foo']);
```

### destroy session
  ```php
session_unset(); // clear $_SESSION, equivalent of $_SESSION = []
session_destroy(); // clears the session data on the server
```
