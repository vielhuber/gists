<?php
// variant 1
DB::enableQueryLog();
$user = User::find(42); // you can do anything here, also DB::select
dd(DB::getQueryLog());
var_dump(
  vsprintf(
    str_replace('?', '%s', str_replace('?', "'?'", DB::getQueryLog()[0]['query'])),
    DB::getQueryLog()[0]['bindings']
  )
);

// variant 2
$data = DB::table('foo')->where('bar','baz')->where('gnarr',5); // this is restricted to DB::table or Model calls
print_r([$data->toSql(),$data->getBindings()]);
var_dump(
  vsprintf(
    str_replace('?', '%s', str_replace('?', "'?'", $data->toSql())),
    $data->getBindings()
  )
);