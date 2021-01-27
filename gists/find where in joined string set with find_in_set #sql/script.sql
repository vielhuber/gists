# foo
id
1
2
3

# bar
id | name | foo_id
3 | foo | 1
4 | bar | 2
5 | baz | 2

# query all entries in foo where connected bar rows have name "baz" => 2
SELECT id FROM test1
LEFT JOIN test2 ON test2.foo_id = test1.id
GROUP BY test1.id
HAVING FIND_IN_SET('baz', GROUP_CONCAT(test2.name));