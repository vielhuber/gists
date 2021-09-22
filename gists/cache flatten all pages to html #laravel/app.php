<?php
// config/app.php
'providers' => [
    ...
    Spatie\ResponseCache\ResponseCacheServiceProvider::class,
];
'aliases' => [
    ...
   'ResponseCache' => Spatie\ResponseCache\ResponseCacheFacade::class,
];