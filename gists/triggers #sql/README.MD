### show all triggers
```sql
SHOW TRIGGERS;
```

### drop old trigger if exists
```sql
DROP TRIGGER IF EXISTS `trigger-col1-updated-at`;
```

### create new trigger
```sql
DELIMITER $$
 
CREATE TRIGGER `trigger-col1-updated-at`
BEFORE UPDATE
ON tbl1 FOR EACH ROW
BEGIN
    -- your specific condition here
    IF COALESCE(OLD.col1,'') <> COALESCE(NEW.col1,'') THEN
        SET NEW.updated_at = NOW();
    END IF;
END$$
 
DELIMITER ;
```

### update existing trigger
```sql
SELECT CONCAT('DROP TRIGGER IF EXISTS `', trigger_name, '`;', CHAR(13), 'DELIMITER $$', CHAR(13), 'CREATE TRIGGER `', TRIGGER_NAME, '` ', ACTION_TIMING, ' ', EVENT_MANIPULATION, ' ON ', EVENT_OBJECT_SCHEMA, '.', EVENT_OBJECT_TABLE, ' FOR EACH ROW ', ACTION_STATEMENT, '$$', CHAR(13), 'DELIMITER ;') AS command
FROM information_schema.triggers
WHERE EVENT_OBJECT_SCHEMA = 'dbname'
AND TRIGGER_NAME = 'triggername';
```