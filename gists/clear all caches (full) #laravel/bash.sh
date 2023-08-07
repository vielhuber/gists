# clear all caches
php artisan cache:clear && php artisan route:clear && php artisan config:clear && php artisan view:clear && composer dump-autoload && rm -rf bootstrap/cache/*/*

# clear sessions
rm -f storage/framework/sessions/*

# if you want to cache all routes etc.
php artisan config:cache && php artisan route:cache && php artisan optimize 