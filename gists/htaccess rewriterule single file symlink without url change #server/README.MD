#### option 1: apache (requires mod_proxy)

```
RewriteRule ^test.js$ /foo/bar/baz.js [L,NE,P]
```

#### option 2: symlink (works everywhere)

```sh
ln -s ./foo/bar/baz.js ./test.js
```