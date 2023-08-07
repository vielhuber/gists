### mysql/pgsql

```sql
SELECT * FROM foo LIMIT 10 OFFSET 20
```

### oracle

```sql
SELECT * FROM foo OFFSET 20 ROWS FETCH NEXT 10 ROWS ONLY;
```