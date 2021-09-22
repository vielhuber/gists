<?php
// app\Http\Middleware\LogRequests.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // do not log option requests
        if( $request->isMethod('options') )
        {
            return;
        }
        $request_json = json_encode([ $request->path(), $request->method(), $request->except(['password','password2','password_repeat']) ]);
        $response_json = json_encode([ $response->status(), $response ]);
        // only log when errors appear
        if( !preg_match('/success(.{0,3})false/i', $response_json) )
        {
            return;
        }
        Log::info('app.requests', ['request' => $request_json, 'response' => $response_json]);
    }
}

