<?php
// app/Providers/EventServiceProvider.php

// ...
    protected $listen = [
        'App\Events\TestEvent' => [
            'App\Listeners\TestListener',
        ],
    ];
// ...