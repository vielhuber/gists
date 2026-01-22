## mysql

#### create uuid
```sql
SELECT UUID();
```

## postgres

#### create uuid
```sql
SELECT uuid_in(md5(random()::text || now()::text)::cstring);
```

#### convert uuid to int
```sql
('x' || translate(id::text, '-', ''))::bit(128)
```

#### convert int to uuid
```sql
LPAD(TO_HEX(id), 32, '0')::uuid
```

#### use max/min
```sql
MAX(id::text)::uuid
```