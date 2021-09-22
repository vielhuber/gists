## mysql
```sql
CREATE TABLE IF NOT EXISTS test (
	id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	updated_at datetime(0) DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) NOT NULL
)
```

## postgres
```sql
CREATE TABLE IF NOT EXISTS test (
	id SERIAL NOT NULL PRIMARY KEY,
	updated_at TIMESTAMP without time zone NULL
)
-- create a simple trigger
CREATE OR REPLACE FUNCTION update_modified_column() RETURNS TRIGGER AS $$
BEGIN NEW.modified = now(); RETURN NEW; END;
$$ language 'plpgsql';
CREATE TRIGGER update_customer_modtime BEFORE UPDATE ON test FOR EACH ROW EXECUTE PROCEDURE update_modified_column();
```