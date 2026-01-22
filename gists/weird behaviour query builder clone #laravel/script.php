<?php
function m1($foo) { $foo->where('col3','baz'); }
$foo = Foo::where('col1','foo');
$foo->where('col2','bar');
m1($foo);
$foo->get(); // SELECT * FROM foo WHERE col1 = 'foo' AND col2 = 'bar' AND col3 = 'baz'

function m2($foo) { $foo = clone $foo; $foo->where('col3','baz'); return $foo; }
$foo = Foo::where('col1','foo');
$foo->where('col2','bar');
$foo2 = m2($foo);
$foo->get(); // SELECT * FROM foo WHERE col1 = 'foo' AND col2 = 'bar'
$foo2->get(); // SELECT * FROM foo WHERE col1 = 'foo' AND col2 = 'bar' AND col3 = 'baz'