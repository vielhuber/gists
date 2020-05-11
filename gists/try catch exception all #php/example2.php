<?php
// example #2
try
{
    echo 'foo';
    throw new \Exception('argh');
    echo 'baz';
}
catch(\Exception $e)
{
    echo 'bar';
}
// outputs: foobar