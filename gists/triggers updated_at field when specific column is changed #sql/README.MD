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
    IF OLD.col1 <> NEW.col1 THEN
        SET NEW.updated_at = NOW();
    END IF;
END$$
 
DELIMITER ;
```