SELECT string_agg(col, ',') FROM table;

SELECT string_agg(col, ',' ORDER BY col ASC) FROM table

SELECT string_agg(DISTINCT col, ',' ORDER BY col ASC) FROM table

SELECT array_agg(intcol) FROM table;