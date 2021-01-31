.htaccess
```
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /subfolder/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /subfolder/index.php [L]
</IfModule>
```

### database

- siteurl: ```https://www.tld.com/subfolder```
- home: ```https://www.tld.co/subfolder```