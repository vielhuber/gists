# mysql
```sql
SELECT CONCAT_WS(
    ' ',
    NULLIF(contract.company_name,''),
    NULLIF(contract.last_name,''),
    NULLIF(contract.first_name,'')
) FROM members;
```

# sql
```sql
SELECT CONCAT_WS(
	' ',
	(CASE WHEN COALESCE(company_name,'')='' THEN NULL ELSE company_name END),
    (CASE WHEN COALESCE(first_name,'')='' THEN NULL ELSE first_name END),
	(CASE WHEN COALESCE(last_name,'')='' THEN NULL ELSE last_name END)
) FROM members;
```

# postgres
```sql
SELECT array_to_string(array_remove(array_remove(ARRAY[null,'foo',null,'bar',''], null), ''), ', ')
```