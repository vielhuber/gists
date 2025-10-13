- put this in `.htaccess` of your root folder:

```
# fetch media from production
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{HTTP_HOST} \.local|vielhuber\.dev$ [NC]
RewriteRule ^wp-content\/uploads\/(.*)$ https://www.tld.com/wp-content/uploads/$1 [R=302,L]
```


- if you use the plugin "WebP Converter for Media", put this on bottom of `/wp-content/uploads/.htaccess`:

```
# fetch media from production
<IfModule mod_rewrite.c>
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{HTTP_HOST} \.local|close2dev\.de$ [NC]
  RewriteRule ^(.*)$ https://www.tld.com/wp-content/uploads/$1 [R=302,L]
</IfModule>
```

- ignore the uploads folder through these line in `.gitignore`

```
/wp-content/themes/uploads
```