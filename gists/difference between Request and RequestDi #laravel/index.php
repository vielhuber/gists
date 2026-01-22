<?php
use Request; /* this is a general facade */
use Illuminate\Http\Request as RequestDi; /* this is the dependency injected class, use alias to avoid name clashing */
/* use Input; */ /* this does not exist anymore! use "Request" instead */
Route::get('test', function () {
    echo '<form method="post">';
    echo '<input type="hidden" name="_token" value="' . csrf_token() . '" />';
    echo '<input type="hidden" name="foo[bar]" value="1" />';
    echo '<input type="submit" value="Absenden" />';
    echo '</form>';
});
Route::post('test', function (RequestDi $request) {
    dd([
        Request::all(),
        $request->all(),
        Request::input('foo.bar'),
        $request->input('foo.bar'),
        Request::get('foo.bar'),
        $request->get('foo.bar') /* does not work */
    ]);
});