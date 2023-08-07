-- example
SELECT COUNT(*) FROM information_schema.constraint_column_usage where constraint_name = 'table_name_foreign_table_id_foreign';

-- general
WITH
    table_name AS (VALUES ('addresses')),
    foreign_table_id AS (VALUES ('club_id'))
SELECT COUNT(*) > 0 FROM information_schema.constraint_column_usage where constraint_name = (TABLE table_name)||'_'||(TABLE foreign_table_id)||'_foreign';

-- get all foreign keys for specific table
WITH
            table_name AS (VALUES ('addresses')),
            table_schema AS (VALUES ('public'))
SELECT      tc.constraint_name,
            kcu.column_name AS childcolumn,
            ccu.table_name  AS parenttable,
            ccu.column_name AS parentcolumn
FROM        information_schema.table_constraints tc
INNER JOIN  information_schema.key_column_usage kcu
ON          tc.constraint_name = kcu.constraint_name
INNER JOIN  information_schema.constraint_column_usage ccu
ON          tc.constraint_name = ccu.constraint_name
WHERE       tc.table_schema = (TABLE table_schema)
AND         tc.table_name = (TABLE table_name)
AND         tc.constraint_type = 'FOREIGN KEY'
AND         kcu.table_schema = (TABLE table_schema)
AND         ccu.table_schema = (TABLE table_schema);