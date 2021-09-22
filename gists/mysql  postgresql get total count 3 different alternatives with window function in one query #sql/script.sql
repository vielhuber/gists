# 2 queries (best)
SELECT col1, col2, col3 FROM bar ORDER BY col4 LIMIT 10;
SELECT COUNT(*) FROM bar;

# postgres
SELECT col1, col2, col3, count(*) OVER() AS full_count FROM bar ORDER BY col4 LIMIT 10;

# mysql (deprecated and slow!)
SELECT SQL_CALC_FOUND_ROWS col1, col2, col3 FROM bar ORDER BY col4 LIMIT 10;
SELECT FOUND_ROWS();