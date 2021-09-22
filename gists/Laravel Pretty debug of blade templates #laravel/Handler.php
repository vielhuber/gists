<?php
// app/Exceptions/Handler.php
public function render($request, Exception $exception)
{
    // add whoops in existing render function
    if(config('app.debug') && !$request->ajax()) {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        return $whoops->handleException($exception);
    }
    return parent::render($request, $exception);
}