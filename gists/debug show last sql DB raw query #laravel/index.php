<?php
// variant 1
DB::enableQueryLog();
$user = User::find(42);
dd(DB::getQueryLog());

// variant 2
DB::table('foo')->where('bar','baz')->where('gnarr',5);
print_r([$data->toSql(),$data->getBindings()]);