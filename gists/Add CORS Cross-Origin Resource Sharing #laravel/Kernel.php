<?php
// app/Http/Kernel.php
protected $middleware = [
  \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
  \App\Http\Middleware\Cors::class
];