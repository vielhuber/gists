<?php
// config/database.php
'connections' => [
  'testing' => [
    'driver' => 'sqlite',
    'database' => env('DB_DATABASE_TESTING'),
    'prefix' => ''
  ],
  /*...*/
]