/* declare first */
SET @variable_name := column;
/* use */
SELECT variable_name FROM table

/* inline declaration */
SELECT @variable_name := column FROM table WHERE variable_name = 'foo'

/* alternative declaration */
SET @variable_name = column;

/* dynamic statements */
SET @variable_name = '* FROM foo';
PREPARE stmt1 FROM CONCAT('SELECT ',@variable_name,' LIMIT 1');
EXECUTE stmt1;
DEALLOCATE PREPARE stmt1;