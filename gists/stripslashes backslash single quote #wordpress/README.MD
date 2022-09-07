- WordPress adds slashes to `$_POST`/`$_GET`/`$_COOKIE`/`$_REQUEST` regardless of what `get_magic_quotes_gpc()` returns
- So in the context of WordPress, `stripslashes()` or `stripslashes_deep(`) should always be used when using those variables
```php
$vars = stripslashes_deep($_POST);
```
- To have this behaviour globally, add this to your `functions.php`:
```php
$_POST = array_map( 'stripslashes_deep', $_POST );
$_GET = array_map( 'stripslashes_deep', $_GET );
$_COOKIE = array_map( 'stripslashes_deep', $_COOKIE );
$_REQUEST = array_map( 'stripslashes_deep', $_REQUEST );
```