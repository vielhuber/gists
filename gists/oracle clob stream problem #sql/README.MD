-   there is a weird problem on oracle databases when reading a clob column in php
-   the content is not served at all or stripped of
-   some information can be found here: https://stackoverflow.com/questions/41387557/php-stream-get-contents-behaves-strangely-reading-an-lob-from-a-database

#### variant 1 (doesnt show anything)

```php
use Medoo\Medoo;
$db = new Medoo([ 'database_type' => 'oracle', 'database_name' => '**database**', 'server' => '**host**', 'username' => '**username**', 'password' => '**password**', 'port' => '**port**', 'charset' => '**charset**' ]);
$db->select('table', 'col', ['id' => '42'])[0]
```

#### variant 2 (does show only a part on big clob content)

```php
$db = new Medoo([...]);
stream_get_contents($db->select('table', 'col', ['id' => '42'])[0]);
```

#### variant 3 (does show only a part on big clob content)

```php
$db = new Medoo([...]);
fpassthru($db->select('table', 'col', ['id' => '42'])[0]);
```

#### variant 4 (does show only a part on big clob content)

```php
$connection = new PDO(
    'oci:dbname=//' . '**host**' . ':' . '**port**' . '/' . '**database**' . ';charset=' . '**charset**',
    '**username**',
    '**password**'
);
$statement = $connection->prepare("select col from table where id = :id");
$statement->execute(['id' => 42]);
$statement->fetch(); // fails
stream_get_contents($statement->fetch()); // fails
fpassthru($statement->fetch()); // fails
```

#### variant 5 (works)

```php
$connection = oci_connect(
    '**username**',
    '**password**',
    '//' . '**host**' . '/' . '**database**',
    '**charset**'
);
$statement = oci_parse($connection, "select col from table where id = :id");
oci_bind_by_name($statement, ':id', 42, -1, SQLT_INT);
oci_execute($statement);
$result = oci_fetch_assoc($statement);
$result['col']->load();
```
