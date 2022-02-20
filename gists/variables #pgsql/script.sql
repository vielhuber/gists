-- original
SELECT * FROM tbl WHERE col1 = 42 AND col2 = 'foo';

-- with variables
WITH
    var1 AS (VALUES (42)),
    var2 AS (VALUES ('foo'))
SELECT * FROM tbl WHERE col1 = (TABLE var1) AND col2 = (TABLE var2);