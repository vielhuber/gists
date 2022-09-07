## preparation

### server
- install [woocommerce](https://de.wordpress.org/plugins/woocommerce/)
- install [license manager for woocommerce](https://de.wordpress.org/plugins/license-manager-for-woocommerce/)
- setup a product (downloadable with encrypted link)
- setup licenses + generator
- add logic in `server.php` to your `functions.php`

### plugin
- add logic to your plugins code (see `test.php` for a full example)
- zip `test/test.php` to `test.zip`
- install plugin manually (for the first time, to test further updates)

## workflow

### make a new release

- update plugin code
- zip `test/test.php` to `test.zip`
- make an api call to
  - https://tld.com/wp-json/v1/release
  - Basic Auth: username and password of an administrator
  - POST data
    - name: Test
    - version: 1.0.1
    - required: 5
    - tested: 5.7
    - file: base64 string of updated plugin zip
    - icon: base64 string of plugin icon