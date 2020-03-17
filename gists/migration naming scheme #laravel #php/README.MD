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
        	____table1.php
        	____table2.php
```

### use case
- we don't like laravels default naming scheme; we can trick it by using 4 times "_"
- before launch: the migrations folder does not replicate schema changes over time, but always the current schema (that means: you can add in the past columns as if everything was clean)
- after launch: we do both migration (and data manipulation) via specific migrations via `php artisan migrate --path=/database/migrations/post/2020-03-17/`
