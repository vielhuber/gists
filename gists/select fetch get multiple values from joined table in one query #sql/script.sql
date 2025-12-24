table1
id | name
1 | test1
2 | test2
3 | test3

table2
id | key | value | foreign_id
1 | foo | test3 | 1
2 | bar | test4 | 1
3 | baz | test5 | 1
4 | foo | test6 | 2
5 | foo | test7 | 3
6 | baz | test8 | 3

# variant1
SELECT
	table1.id,
    MAX(CASE WHEN table2.key = 'foo' THEN table2.value ELSE NULL END) as foo,
    MAX(CASE WHEN table2.key = 'bar' THEN table2.value ELSE NULL END) as bar,
    MAX(CASE WHEN table2.key = 'baz' THEN table2.value ELSE NULL END) as baz
FROM
	table1
LEFT JOIN
	table2 ON table2.table_id = table1.id
GROUP BY
	table1.id
    
# variant2 (faster)
SELECT
	table1.id,
    j1.value as foo,
    j2.value as bar,
    j3.value as baz
FROM
	table1
LEFT JOIN table2 j1 ON j1.table_id = table1.id AND j1.key = 'foo'
LEFT JOIN table2 j2 ON j2.table_id = table1.id AND j2.key = 'bar'
LEFT JOIN table2 j3 ON j3.table_id = table1.id AND j3.key = 'baz'
GROUP BY
	table1.id
    
result
id | foo | bar | baz
1 | test3 | test4 | test5
2 | test6 | null | null
3 | test7 | null | test8