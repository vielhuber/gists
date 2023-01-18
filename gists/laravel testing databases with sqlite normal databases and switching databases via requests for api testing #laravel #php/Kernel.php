<?php
// app/Http/Kernel.php
/*...*/
protected $middleware = [
  /*...*/
  \App\Http\Middleware\SetTestingDatabase::class,
];