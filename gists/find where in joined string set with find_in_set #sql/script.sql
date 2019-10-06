table `test`
name		parents
foo			1
bar			1,7
baz			7,2

SELECT * FROM test WHERE FIND_IN_SET(7,parents); // [bar, baz]