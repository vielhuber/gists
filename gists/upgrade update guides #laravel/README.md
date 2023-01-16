### 5.2 => 5.3

- check current version with php artisan --version
- update all packages in composer.json (get version numbers from packagist.org)
- download fresh copy of laravel 5.3.16 from github in parallel directory to compare files
- remove boot argument in app/Providers/EventServiceProvider.php, app/Providers/RouteServiceProvider.php, app/Providers/AuthServiceProvider.php
- copy 4 new files from github 5.3 app/Http/Controllers/Auth to 5.2 and merge those files with the existing 2 files. after that delete AuthController.php and PasswordController.php
- insert into config/app.php
  - providers: Illuminate\Notifications\NotificationServiceProvider::class
  - aliases: 'Notification' => Illuminate\Support\Facades\Notification::class
