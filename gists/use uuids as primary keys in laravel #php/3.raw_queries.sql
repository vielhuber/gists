SELECT * FROM (

    /* drop constraints */
    SELECT 'ALTER TABLE "' || nspname || '"."' || relname || '" DROP CONSTRAINT "' || conname || '";'
    FROM pg_constraint 
    INNER JOIN pg_class ON conrelid=pg_class.oid 
    INNER JOIN pg_namespace ON pg_namespace.oid=pg_class.relnamespace 
    ORDER BY CASE WHEN contype='f' THEN 0 ELSE 1 END,contype,nspname,relname,conname
     
) as t UNION ALL SELECT * FROM (
         
    /* drop default values */
    SELECT 'ALTER TABLE ' || kcu.table_name || ' ALTER COLUMN ' || kcu.column_name || ' DROP DEFAULT;'
    FROM information_schema.table_constraints tco
    JOIN information_schema.key_column_usage kcu 
    ON kcu.constraint_name = tco.constraint_name
    AND kcu.constraint_schema = tco.constraint_schema
    AND kcu.constraint_name = tco.constraint_name
    AND kcu.table_name NOT IN ('table_1', 'table_2', 'table_3') -- tables to exclude
    WHERE tco.constraint_type = 'PRIMARY KEY'
  
) as t UNION ALL SELECT * FROM (

    /* convert ids from bigint to uuid */
    SELECT 'ALTER TABLE ' || kcu.table_name || ' ALTER COLUMN ' || kcu.column_name || ' SET DATA TYPE UUID USING LPAD(TO_HEX(' || kcu.column_name || '), 32, ''0'')::UUID;'
    FROM information_schema.table_constraints tco
    JOIN information_schema.key_column_usage kcu 
    ON kcu.constraint_name = tco.constraint_name
    AND kcu.constraint_schema = tco.constraint_schema
    AND kcu.constraint_name = tco.constraint_name
    AND kcu.table_name NOT IN ('table_1', 'table_2', 'table_3') -- tables to exclude
    WHERE (tco.constraint_type = 'PRIMARY KEY' OR tco.constraint_type = 'FOREIGN KEY')
  
) as t UNION ALL SELECT * FROM (

    /* special rules */
    SELECT 'ALTER TABLE table_4 ALTER COLUMN col_1 SET DATA TYPE UUID USING LPAD(TO_HEX(col_1), 32, ''0'')::UUID;'
) as t UNION ALL SELECT * FROM (
    SELECT 'ALTER TABLE table_5 ALTER COLUMN col_1 SET DATA TYPE UUID USING LPAD(TO_HEX(col_1), 32, ''0'')::UUID;'

) as t UNION ALL SELECT * FROM (

    /* restore constraints */
    SELECT 'ALTER TABLE "' || nspname || '"."' || relname || '" ADD CONSTRAINT "' || conname || '" ' || pg_get_constraintdef(pg_constraint.oid) || ';'
    FROM pg_constraint
    INNER JOIN pg_class ON conrelid=pg_class.oid
    INNER JOIN pg_namespace ON pg_namespace.oid=pg_class.relnamespace
    ORDER BY CASE WHEN contype='f' THEN 0 ELSE 1 END DESC,contype DESC,nspname DESC,relname DESC,conname DESC
        
) as t