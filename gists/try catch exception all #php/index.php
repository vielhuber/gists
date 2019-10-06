<?php
// example #1
function bad_function()
{
    throw new \Exception('argh');
}
try
{
    bad_function();
}
catch(\Exception $e)
{
    echo $e->getMessage(); // argh
}
// this is run in BOTH cases(!)
echo 'foo';
?>



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
?>