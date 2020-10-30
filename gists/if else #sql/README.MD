### mysql
```sql
IF(1=1, 'foo', IF(1=2, 'bar', 'baz'))
```

### postgresql
```sql
CASE WHEN 1=1 THEN 'foo' WHEN 1=2 THEN 'bar' ELSE 'baz' END;
```