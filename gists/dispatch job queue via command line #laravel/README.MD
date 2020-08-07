### dispatch job
- `php artisan queue:restart`
- `php artisan job:dispatch --env=production TestQueue argument1`

### test queue
- `php artisan queue:work --env=production --sleep=3 --tries=1 --memory=768 --timeout=3600`