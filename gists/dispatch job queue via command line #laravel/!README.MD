### on every code change, don't forget to restart
- `php artisan queue:restart`

### test queue locally
- `php artisan queue:work --env=production --sleep=3 --tries=1 --memory=768 --timeout=3600`

### get queue size
```php
\Illuminate\Support\Facades\Queue::size();
```
```sql
SELECT COUNT(*) FROM jobs
```

### clear queue
- `php artisan queue:clear`

### use named queues
- `ExampleQueue::dispatch()->onQueue('queue_name');`
- `php artisan queue:work --queue=queue_name`
- `Queue::size('queue_name')`
- `php artisan queue:clear --queue=queue_name`

### dispatch job with helper below
- `php artisan job:dispatch --env=production TestQueue argument1`
