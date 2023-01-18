- you cannot use custom functions, subqueries etc. in virtual tables

### virtual columns
- take no disk space
- recommended when data changes happen often
```sql
CREATE TABLE orders_items(
...
`total_item_price` decimal(10,2) AS (`quantity` * `product_price`),
...
);
```

### stored columns
- takes disk space
- recommended when data changes happen rarely
```sql
CREATE TABLE orders_items(
...
`total_item_price` decimal(10,2) AS (`quantity` * `product_price`) STORED,
...
);
```