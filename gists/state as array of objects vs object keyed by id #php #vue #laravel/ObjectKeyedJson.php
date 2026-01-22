<?php
// you can also use this as a middleware and apply it to every response
namespace App\Http\Middleware;
use Closure;
class ObjectKeyedJson
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if($response instanceof \Illuminate\Http\JsonResponse)
        {
            $json_array = $response->getData();
            $json_array = $this->recursivelyConvertArraysToObjects($json_array);
            $response->setData($json_array);
        }
        return $response;
    }
    private function recursivelyConvertArraysToObjects($arr)
    {
        /* see above */
    }
}