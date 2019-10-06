<?php
// app/Http/Middleware/SetTestingDatabase.php
namespace App\Http\Middleware;

use Closure;
use Config;

class SetTestingDatabase
{
    public function handle($request, Closure $next)
    {
        if( $request->header('Testing') == '1' )
        {
            Config::set('database.default', 'testing');
        }
        return $next($request);
    }
}