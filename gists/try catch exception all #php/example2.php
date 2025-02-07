<?php
// example #2
try {
    echo 'foo';
    throw new \Exception('argh');
    echo 'baz';
}
catch(\Throwable $e) {
    echo 'bar';
}
// outputs: foobar