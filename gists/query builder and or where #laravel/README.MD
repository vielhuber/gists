```sql
SELECT *
FROM table
WHERE
    col1 = 'foo'
    AND
    col2 = 'foo'
    AND (
      col3 = 'foo'
      OR
      col4 = 'foo'
      OR
      col5 = 'foo'
    )
    AND
    (
       col3 = 'foo'
       OR
       (
         col4 = 'foo'
         AND
         col5 = 'foo'
       )
    )
    AND
    (
       col3 = 'foo'
       AND
       (
         col4 = 'foo'
         OR
         col5 = 'foo'
       )
    );
```

```php
DB::table('table')
    ->where('col1', 'foo')
    ->where('col2', 'foo')
    ->where(function($query) {
        $query->where('col3', 'foo')
              ->orWhere('col4', 'foo')
              ->orWhere('col5', 'foo');
    })
    ->where(function($query) {
        $query->where('col3', 'foo')
              ->orWhere(function($query) {
                  $query->where('col4', 'foo')
                        ->where('col5', 'foo');
              });
    })
    ->where(function($query) {
        $query->where('col3', 'foo')
              ->where(function($query) {
                  $query->where('col4', 'foo')
                        ->orWhere('col5', 'foo');
              });
    })
    ->get();
```