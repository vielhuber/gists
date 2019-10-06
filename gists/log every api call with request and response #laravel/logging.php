<?php
/* ... */ 
'channels' => [
  'stack' => [
    'driver' => 'stack',
    'channels' => ['daily'],
  ],
  'daily' => [
    'driver' => 'daily',
    'path' => storage_path('logs/laravel.log'),
    'level' => 'debug',
    'days' => 7,
  ],
/* ... */