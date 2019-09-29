-- columns
SELECT  'ALTER TABLE ' || quote_ident(c.table_schema) || '.'
  || quote_ident(c.table_name) || ' RENAME "' || c.column_name || '" TO ' || quote_ident(lower(c.column_name)) || ';' As ddlsql
  FROM information_schema.columns As c
  WHERE c.table_schema NOT IN('information_schema', 'pg_catalog') 
      AND c.column_name <> lower(c.column_name) 
  ORDER BY c.table_schema, c.table_name, c.column_name;
 
 -- tables
  SELECT 'ALTER TABLE ' || quote_ident(t.table_schema) || '.'
  || quote_ident(t.table_name) || ' RENAME TO ' || quote_ident(lower(t.table_name)) || ';' As ddlsql
  FROM information_schema.tables As t
  WHERE t.table_schema NOT IN('information_schema', 'pg_catalog') 
      AND t.table_name <> lower(t.table_name) 
  ORDER BY t.table_schema, t.table_name;