## laravel >=9

- on laravel 9 you can use the built in trait
- however if you want to have more control you also can use the custom trait below

```php
/* ... */
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Test extends Model
{
    use HasUuids;
  	/* ... */
}
```

## laravel <=8


- create trait `app/Traits/hasUuid.php`

```php
<?php
namespace App\Traits;
use Illuminate\Support\Str;

trait hasUuid
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::orderedUuid()->toString();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
```

- extend all models

```php
/* ... */
use App\Traits\hasUuid;

class Test extends Model
{
    use hasUuid;
  	/* ... */
}
```

## migrate all existing columns

### postgresql

#### links

- https://blog.hagander.net/automatically-dropping-and-creating-constraints-131/
- https://dataedo.com/kb/query/postgresql/list-all-primary-keys-and-their-columns
- https://stackoverflow.com/a/49429112/2068362

#### raw queries

```sql
SELECT * FROM (

	/* drop constraints */
	SELECT 'ALTER TABLE "'||nspname||'"."'||relname||'" DROP CONSTRAINT "'||conname||'";'
			 FROM pg_constraint 
			 INNER JOIN pg_class ON conrelid=pg_class.oid 
			 INNER JOIN pg_namespace ON pg_namespace.oid=pg_class.relnamespace 
			 ORDER BY CASE WHEN contype='f' THEN 0 ELSE 1 END,contype,nspname,relname,conname
     
) as t UNION ALL SELECT * FROM (
         
	/* drop default values */
	SELECT 'ALTER TABLE ' || kcu.table_name || ' ALTER COLUMN ' || kcu.column_name || ' DROP DEFAULT;'
			 FROM information_schema.table_constraints tco
			 JOIN information_schema.key_column_usage kcu 
						ON kcu.constraint_name = tco.constraint_name
						AND kcu.constraint_schema = tco.constraint_schema
						AND kcu.constraint_name = tco.constraint_name
						AND kcu.table_name NOT IN ('table_1', 'table_2', 'table_3') -- tables to exclude
			 WHERE tco.constraint_type = 'PRIMARY KEY'
  
) as t UNION ALL SELECT * FROM (

	/* convert ids from bigint to uuid */
	SELECT 'ALTER TABLE ' || kcu.table_name || ' ALTER COLUMN ' || kcu.column_name || ' SET DATA TYPE UUID USING LPAD(TO_HEX(' || kcu.column_name || '), 32, ''0'')::UUID;'
			 FROM information_schema.table_constraints tco
			 JOIN information_schema.key_column_usage kcu 
						ON kcu.constraint_name = tco.constraint_name
						AND kcu.constraint_schema = tco.constraint_schema
						AND kcu.constraint_name = tco.constraint_name
						AND kcu.table_name NOT IN ('table_1', 'table_2', 'table_3') -- tables to exclude
			 WHERE (tco.constraint_type = 'PRIMARY KEY' OR tco.constraint_type = 'FOREIGN KEY')
  
) as t UNION ALL SELECT * FROM (

	/* restore constraints (run this before and execute after!) */
	SELECT 'ALTER TABLE "'||nspname||'"."'||relname||'" ADD CONSTRAINT "'||conname||'" '||pg_get_constraintdef(pg_constraint.oid)||';'
			 FROM pg_constraint
			 INNER JOIN pg_class ON conrelid=pg_class.oid
			 INNER JOIN pg_namespace ON pg_namespace.oid=pg_class.relnamespace
			 ORDER BY CASE WHEN contype='f' THEN 0 ELSE 1 END DESC,contype DESC,nspname DESC,relname DESC,conname DESC
		
) as t
```

#### as a migration

```php
<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
class MigrateUuid extends Migration
{
    public function up()
    {
        $query = <<<'EOD'
            SELECT * FROM (
            /* ... */
        EOD;

        $queries = DB::select(DB::raw($query));
        $count = count($queries);
        $count_cur = 0;
        foreach ($queries as $queries__value) {
            DB::statement(current((array) $queries__value));
            echo round((++$count_cur * 100) / $count) . '%' . PHP_EOL;
        }
    }

    public function down()
    {
    }
}
```

#### clear sessions

```sh
rm -f storage/framework/sessions/*
```