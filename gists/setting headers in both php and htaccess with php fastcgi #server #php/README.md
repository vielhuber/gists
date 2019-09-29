### problem

- if you set headers in php in an fastcgi environment, all headers from htaccess are ignored
- if you both set the same headers in php and htaccess, then in all other environments we get errors (because of merged origins etc)
- reference: https://stackoverflow.com/questions/53259981/htaccess-headers-being-ignored-by-apache

### solution

```php
$phpSapiName = substr(php_sapi_name(), 0, 3);
if ($phpSapiName === 'cgi' || $phpSapiName === 'fpm') {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type, Authorization');
}
header('Content-Type: image/svg+xml');
header('Content-Length: ' . filesize($file));
readfile($file);
die();
```