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
if (strpos(@$_SERVER['HTTP_HOST'], 'local') !== false) { $env = 'local'; }
if (strpos(@$_SERVER['HTTP_HOST'], 'test') !== false) { $env = 'test'; }

$subpath = null;
if (strpos(@$_SERVER['REQUEST_URI'], 'app') === false) { $subpath = '' }
else { $subpath = '/app' }

$json = str_replace('%NAME%', 'Appname' . ($env !== 'production' ? ' ' . ucfirst($env) : ''), $json);
$json = str_replace('%SHORT_NAME%', 'Appname' . ($env !== 'production' ? ' ' . ucfirst($env) : ''), $json);
$json = str_replace('%SUBPATH%', $subpath, $json); }

header('Content-type: application/json');
echo $json;

```