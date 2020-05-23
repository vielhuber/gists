- WordPress adds slashes to `$_POST/$_GET/$_REQUEST/$_COOKIE` regardless of what `get_magic_quotes_gpc()` returns
- So in the context of WordPress, stripslashes() or stipslashes_deep() should always be used when using those variables
```php
$vars = stripslashes_deep($_POST);
```