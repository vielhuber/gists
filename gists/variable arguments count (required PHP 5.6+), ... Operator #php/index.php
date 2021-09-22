// Use ... in function declaration to have a dynamic amount of arguments
foo("that","rocks");
function foo(...$args) {
   call_user_func_array('bar',$args);
}
function bar(...$args) {
   print_r($args);
}

// alternative
foo("that","rocks");
function foo(...$args) { // packs it into an array
   bar(...$args); // unpacks it into split arguments
}
function bar($arg1, $arg2) {
   print_r($arg1);
   print_r($arg2);
}

// Fallback syntax for PHP < 5.6
function fallback() {
   print_r(func_get_args());
}
fallback('foo');
fallback('foo','bar');

// Use ... in function call to unpack an array into the argument list
function add($a, $b) {
   echo $a+$b;
}
add(...[1,2]); // 3

// Fallback syntax for PHP < 5.6
call_user_func_array('add', [1,2]);