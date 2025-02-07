<?php
// example #1
function bad_function() {
    throw new \Exception('argh');
}
try {
    bad_function();
}
catch(\Throwable $e)
{
    echo $e->getMessage(); // argh
}
// this is run in BOTH cases(!)
echo 'foo';