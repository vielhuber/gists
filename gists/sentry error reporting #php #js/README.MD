## WordPress

- install https://wordpress.org/plugins/wp-sentry-integration/
- add to `wp-config.php` (only inside the production environment):
```php
define( 'WP_SENTRY_PHP_DSN', 'https://********************************@********.ingest.sentry.io/*******' );
define( 'WP_SENTRY_BROWSER_DSN', 'https://********************************@********.ingest.sentry.io/*******' );
define( 'WP_SENTRY_ENV', str_replace('www.','',$_SERVER['HTTP_HOST']) );
define( 'WP_SENTRY_ERROR_TYPES', E_ALL & ~E_WARNING & ~E_NOTICE ); // add this to hide warnings/notices
```

## Laravel

- `composer require sentry/sentry-laravel`

- `php artisan sentry:publish --dsn=https://********************************@********.ingest.sentry.io/*******` (Enable Performance Monitoring: no, Want to send a test event: yes)

- update `.env` on production:

```sh
SENTRY_LARAVEL_DSN=https://********************************@********.ingest.sentry.io/*******
SENTRY_ENVIRONMENT=tld.com
```

- update `.env` on all other environments (where you don't want to get logs)

```sh
SENTRY_LARAVEL_DSN=null
SENTRY_ENVIRONMENT=null
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
      	'level' => 'debug' // use "warning" if you don't want to get "info" and "debug"
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
