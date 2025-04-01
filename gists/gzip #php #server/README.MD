#### enable in apache/php

  - this is done by default
  - check via `cat /etc/apache2/mods-available/deflate.conf`

#### enable in iis

  - Windows-Features aktivieren/deaktivieren
  - Webserver (IIS) > Webserver > Leistung > Komprimieren dynamischer Inhalte
  - IIS > nebro > Komprimierung > 2 Haken setzen

#### disable in .htaccess

```
# disable gzip compression on localhost
<IfModule mod_deflate.c>
    SetEnv no-gzip 1
</IfModule>
```

#### check in php

```php
$url = 'http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($ch);
curl_close($ch);
if (stripos($response, 'Content-Encoding: gzip') !== false) { echo 'on'; } else { echo 'off'; }
```

#### check via curl

- `curl -i --compressed https://tld.com`

#### check in chrome

- network > first request > check header `Content-Encoding: gzip`

