<?php
// config/broadcasting.php

// ...
  'pusher' => [
      'driver' => 'pusher',
      'key' => env('PUSHER_KEY'),
      'secret' => env('PUSHER_SECRET'),
      'app_id' => env('PUSHER_APP_ID'),
      'options' => [
        'cluster' => 'eu',
        'encrypted' => false
      ],
  ],
// ...