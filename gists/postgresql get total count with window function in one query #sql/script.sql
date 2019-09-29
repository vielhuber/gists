# 2 queries
SELECT foo FROM bar LIMIT 10;
SELECT COUNT(*) FROM bar;

# postgres
SELECT foo, count(*) OVER() AS full_count FROM bar LIMIT 10;

# mysql
SELECT SQL_CALC_FOUND_ROWS foo FROM bar LIMIT 10;
SELECT FOUND_ROWS();