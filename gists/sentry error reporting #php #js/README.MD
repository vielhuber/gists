## WordPress

- install https://wordpress.org/plugins/wp-sentry-integration/
- add to `wp-config.php` (beneath your production environment):
```php
define( 'WP_SENTRY_PHP_DSN', 'https://********************************@********.ingest.sentry.io/*******' );
define( 'WP_SENTRY_BROWSER_DSN', 'https://********************************@********.ingest.sentry.io/*******' );
define( 'WP_SENTRY_ENV', str_replace('www.','',$_SERVER['HTTP_HOST']) );
define( 'WP_SENTRY_ERROR_TYPES', E_ALL & ~E_WARNING & ~E_NOTICE ); // add this to hide warnings/notices
```

## Laravel

- `composer require sentry/sentry-laravel`

- `php artisan sentry:publish --dsn=https://********************************@********.ingest.sentry.io/*******` (Enable Performance Monitoring: no, Want to send a test event: yes)

- `.env`
```sh
SENTRY_LARAVEL_DSN=https://********************************@********.ingest.sentry.io/*******
SENTRY_ENVIRONMENT=tld.com
```

- `config/logging.php`
```php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'sentry'], // add 'sentry'
    ],
    // add channel
    'sentry' => [
        'driver' => 'sentry',
      	'level' => 'debug'
    ],
],
```

- `routes/web.php`

```php
Route::get('/debug-sentry', function () {
    \Log::info('this should be logged');
    throw new Exception('a real exception');
});
```
