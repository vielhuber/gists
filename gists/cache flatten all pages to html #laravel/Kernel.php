<?php
// app/Http/Kernel.php

// disable CsrfToken (because all files are static!)
protected $middleware = [
    ...
    //\App\Http\Middleware\VerifyCsrfToken::class,
];