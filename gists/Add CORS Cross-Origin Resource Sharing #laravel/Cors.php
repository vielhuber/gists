<?php
// app/Http/Middleware/Cors.php
class Cors {
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Authorization');
      		// WARNING: Do not use "*" here (does not work on Mac Chrome)
    }
}