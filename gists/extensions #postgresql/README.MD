### general
- extensions are a collection of sql objects like functions and enhance postgres with neat helpers like levensthein
- extensions need to be installed per database
- they survive dumps/restores
- they don't survive a complete database drop
- it's recommended to put installation of the extensions in your (laravel) db migrations

### this packages is needed
```sh
yum install postgresql11-contrib
```

### show all installable extensions
```sql
SELECT * FROM pg_available_extensions
```

### show installed extensions
```sql
SELECT * FROM pg_extension
```

### install new extension on current database
```sql
CREATE EXTENSION IF NOT EXISTS fuzzystrmatch;
```

### remove extension
```sql
DROP EXTENSION IF EXISTS fuzzystrmatch;
```
