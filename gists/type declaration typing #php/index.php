<?php
// the following example uses input type declarations and return type declarations
function fun(int $i): array {
    return [$i+5, $i-5];
}
fun(5);