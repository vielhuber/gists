<?php
if (!function_exists('libtest_test1')) {
    function libtest_test1(...$args)
    {
        return \vielhuber\libtest\__::test1(...$args);
    }
}

if (!function_exists('libtest_test2')) {
    function libtest_test2(...$args)
    {
        return \vielhuber\libtest\__::test2(...$args);
    }
}

/* ... */