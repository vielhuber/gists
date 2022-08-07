- the following works with apache >= 2.4
- if you want to exclude legacy environments like mamp on windows, surround it with `<IfModule !mod_win32.c></IfModule>`
- if you want to allow OPTIONS requests, replace with `<If "%{HTTP_HOST} =~ /prod\.tld/ && %{REQUEST_METHOD} != 'OPTIONS'">`

```
AuthType Basic
AuthName "Passwortgeschützter Bereich"
<If "%{HTTP_HOST} =~ /prod\.tld/">
AuthUserFile /.../.../.htpasswd
require valid-user
</If>
<If "%{HTTP_HOST} =~ /test\.tld/">
AuthUserFile /.../.../.htpasswd
require valid-user
</If>
<If "%{HTTP_HOST} =~ /local\.tld/">
AuthUserFile /mnt/c/htdocs/.../.../.htpasswd
require valid-user
</If>
```