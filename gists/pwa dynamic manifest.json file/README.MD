### index.html

```html
...
<link rel="manifest" href="/app/_pwa/manifest.php" />
...
```

### manifest.json

```json
{
    "name": "%NAME%",
    "short_name": "%SHORT_NAME%",
    ...
}
```

### manifest.php

```php
<?php
$env = 'production';
if (strpos(@$_SERVER['HTTP_HOST'], 'local') !== false) { $env = 'local'; }
if (strpos(@$_SERVER['HTTP_HOST'], 'test') !== false) { $env = 'test'; }
$json = file_get_contents('manifest.json');
$json = str_replace('%NAME%', 'Appname' . ($env !== 'production' ? ' ' . ucfirst($env) : ''), $json);
$json = str_replace('%SHORT_NAME%', 'Appname' . ($env !== 'production' ? ' ' . ucfirst($env) : ''), $json);
header('Content-type: application/json');
echo $json;

```