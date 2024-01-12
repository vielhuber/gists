### index.html

```html
...
<link rel="manifest" href="_pwa/manifest.json" />
...
```

### manifest.json

```json
{
    "scope": "%SUBPATH%/",
    "start_url": "%SUBPATH%/index.html",
    "name": "%NAME%",
    "short_name": "%SHORT_NAME%",
    "environment": "%ENVIRONMENT%",
    "icons": [
        {
            "src": "%SUBPATH%/_pwa/icon-192x192.png",
            "sizes": "192x192",
            "type": "image/png"
        }
    ]
}
```

### .htaccess
```
Header add Service-Worker-Allowed /

<If "%{REQUEST_URI} =~ /app/">
RewriteEngine on
RewriteRule manifest\.json$ /app/_pwa/manifest.json.php [L,QSA]
</If>
<Else>
RewriteEngine on
RewriteRule manifest\.json$ /_pwa/manifest.json.php [L,QSA]
</Else>
```


### manifest.json.php

```php
<?php
$json = file_get_contents('manifest.json');

$env = 'production';
// determine based on host
if (strpos(@$_SERVER['HTTP_HOST'], 'local') !== false) { $env = 'local'; }
if (strpos(@$_SERVER['HTTP_HOST'], 'test') !== false) { $env = 'test'; }
// determine based on .env file
$env_file = file_get_contents('./../../../.env');
$env_file = explode(PHP_EOL, $env_file);
foreach ($env_file as $env_file__value) {
    if (strpos($env_file__value, 'APP_ENV') === 0) {
        $env = explode('=', $env_file__value)[1];
    }
}

$subpath = null;
if (strpos(@$_SERVER['REQUEST_URI'], 'app') === false) { $subpath = '' }
else { $subpath = '/app' }

$json = str_replace('%NAME%', 'Appname' . ($env !== 'production' ? ' ' . ucfirst($env) : ''), $json);
$json = str_replace('%SHORT_NAME%', 'Appname' . ($env !== 'production' ? ' ' . ucfirst($env) : ''), $json);
$json = str_replace('%ENVIRONMENT%', $env, $json);
$json = str_replace('%SUBPATH%', $subpath, $json); }

header('Content-type: application/json');
echo $json;

```