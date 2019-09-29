-- general idea
SELECT * FROM table WHERE 'foo' LIKE CONCAT('%', table_col, '%')

-- if you want to find all rows where specific col is in comma separated string

-- variant 1
SELECT * FROM table WHERE CONCAT(',','7,8,9',',') LIKE CONCAT('%,', table_col, ',%')

-- variant 2 (postgresql)
SELECT * FROM table WHERE table_col = any(string_to_array('7,8,9', ',')::int[])

-- variant 3 (mysql)
SELECT * FROM table WHERE FIND_IN_SET(table_col, '7,8,9')