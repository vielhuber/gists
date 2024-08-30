#### /app/Jobs/TestQueue.php
```php
<?php
/* ... */
class TestQueue implements ShouldQueue
{
    /* ... */
    public $timeout = 10800;
    /* ... */
}
```

#### /config/queue.php
```php
	/* ... */
	'connections' => [
  		'database' => [
    		'driver' => 'database',
    		'table' => 'jobs',
    		'queue' => 'default',
    		'retry_after' => 10800
  		],
  		/* ... */
  	],
  	/* ... */
  ```
  
#### /etc/supervisord.d/laravel-worker.conf
```conf
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/xxx/artisan queue:work --sleep=3 --tries=1 --memory=768 --timeout=10800
autostart=true
autorestart=true
user=root
numprocs=16
redirect_stderr=true
stdout_logfile=/var/www/xxx/storage/logs/worker.log
stopwaitsecs=10800
```