### naming convention in migrations folder

```
/database/migrations
	/pre
    	___table1.php
		___table2.php
		___table3.php
		___zzz_foreign_keys.php
    /post
    	/2020-03-17
        	2020_03_17_0001_table1.php
        	2020_03_17_0002_table2.php
        	2020_03_17_0003_foreign_keys.php
        	2020_03_17_0004_data.php // <== here we seed after launch
```

### prevent duplicate names

before:
```php
class Data extends Migration { /* ... */ }
```
after:
```php
return new class () extends Migration { /* ... */ };
```

### use case

- we don't like laravels default naming scheme; we can trick it by using 4 times "_"
- before launch: the migrations folder does not replicate schema changes over time, but always the current schema (that means: you can add in the past columns as if everything was clean)
- after launch: we do both migration (and data manipulation/insertion/seeding) via specific migrations via `php artisan migrate --path=/database/migrations/post/2020-03-17/`
