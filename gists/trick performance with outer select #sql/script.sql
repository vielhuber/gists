// consider the following example:
// - table is a very large table 
// - the statements in the SELECT section are very load intense
// - the statements in the WHERE section are not very load intense

// variant a (bad performance, because select queries get applied to all rows because of order by)
SELECT
	table1.col1,
    table1.col2,
    table3.col1,
    (SELECT subtable.col4 FROM subtable WHERE subtable.col1 = table1.col1),
    (SELECT subtable.col5 FROM subtable WHERE subtable.col2 = table2.col1),
    (SELECT subtable.col6 FROM subtable WHERE subtable.col3 = table3.col1)
FROM
	table1,
    table2,
    table3
WHERE
	table1.col1 = 'foo' AND
    table2.col2 = 'bar' AND
    table3.col3 = 'baz'
ORDER BY
	table1.col1
LIMIT
	20

// variant 2 (good performance, because queries in select only get applied to 20 rows and not to ALL rows)
SELECT
	table1__col1,
    table1__col2,
    table3__col1,
    (SELECT subtable.col4 FROM subtable WHERE subtable.col1 = table1__col1),
    (SELECT subtable.col5 FROM subtable WHERE subtable.col2 = table2__col1),
    (SELECT subtable.col6 FROM subtable WHERE subtable.col3 = table3__col1)
FROM
(
SELECT
    table1.col1 as table1__col1,
    table1.col2 as table1__col2,
    table2.col1 as table2__col1
    table3.col1 as table3__col1
FROM
	table1,
    table2,
    table3
WHERE
	table1.col1 = 'foo' AND
    table2.col2 = 'bar' AND
    table3.col3 = 'baz'
ORDER BY
	table1.col1
LIMIT
	20
) as t