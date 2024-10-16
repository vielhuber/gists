### on every code change, don't forget to restart
- `php artisan queue:restart`

### production (normally used with supervisor)
- `php artisan queue:work --sleep=3 --tries=1 --memory=768 --timeout=10800`

### test queue locally
- `php artisan queue:work --env=production --sleep=3 --tries=1 --memory=768 --timeout=3600`
- `php artisan queue:listen --env=production --sleep=3 --tries=1 --memory=768 --timeout=3600` # does not need restarts, but is less more efficient

### get queue size
```php
\Illuminate\Support\Facades\Queue::size();
```

```php
DB::table('jobs')->where('queue', 'default')->where('payload', 'like', '%CustomNameQueue%')->count()
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