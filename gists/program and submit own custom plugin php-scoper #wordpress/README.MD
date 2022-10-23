## local usage

- just create ```/wp-content/plugins/pluginname/pluginname.php```
- enable the plugin in the wordpress backend

## submission

- create a ```readme.txt``` file and validate via https://de.wordpress.org/plugins/developers/readme-validator/
- always sanitize, escape, validate, use nonces after post requests
- zip the folder "pluginname" (the folder must be a subfolder inside the zip directory)
- submit via https://de.wordpress.org/plugins/developers/add/
- wait for manual verification (correspondence is done via email, the plugin is initially checked by humans, but when doing updates, this is not done)
- translation of ```readme.txt```:
  - translate via https://translate.wordpress.org (choose language, go to plugin, choose "Stable Readme (latest release)", export as po, translate, import)
  - get yourself a translation editor (PTE) (https://make.wordpress.org/polyglots/handbook/plugin-theme-authors-guide/pte-request/#plugin-theme-author-translation-review-pte-request)
  - approve your own translations you submitted

## release

- create an assets folder with the following files: `banner-1544x500.png`, `banner-772x250.png`, `icon-256x256.png`, `icon-128x128.png`, `screenshot-1.png`, `screenshot-2.png`, `screenshot-3.png`
- see deployment script

## dependencies

- if you use composer packages inside your wordpress plugin, this is tedious
- you have to publish your vendor folder completely
- problem: if another plugin uses (different) versions of the same dependencies, they clash
- solution: https://github.com/humbug/php-scoper
  - replace composer embedding with:
  ```php
  if( file_exists(__DIR__ . '/vendor/scoper-autoload.php') ) { require_once __DIR__ . '/vendor/scoper-autoload.php'; }
  else { require_once __DIR__ . '/vendor/autoload.php'; }
  ```
  - ```wget https://github.com/humbug/php-scoper/releases/download/0.13.1/php-scoper.phar```
  - with config (recommended, see below)
    - ```php php-scoper.phar add-prefix  --config scoper.inc.php```
  - without config
    - ```php php-scoper.phar add-prefix --no-config```
  - ```cd build```
  - ```composer dump-autoload```