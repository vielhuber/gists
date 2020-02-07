## local usage

- just create ```/wp-content/plugins/pluginname/pluginname.php```
- enable the plugin in the wordpress backend

## submission

- create a ```readme.txt``` file and validate via https://de.wordpress.org/plugins/developers/readme-validator/
- zip the folder "pluginname" (the folder must be a subfolder inside the zip directory)
- submit via https://de.wordpress.org/plugins/developers/add/
- wait for manual verification
- setup svn/github actions (TODO)

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
  - wget https://github.com/humbug/php-scoper/releases/download/0.13.1/php-scoper.phar
  - without config
    - php php-scoper.phar add-prefix --no-config
  - with config
    - php php-scoper.phar add-prefix  --config scoper.inc.php
    ```php
    <?php
    declare(strict_types=1);
    return [
        // don't prefix the following namespaces
        'whitelist' => [
            'GtbabelWordPress\*', // all global/native/class based functions in the wordpress plugin class (you must add a namespace "namespace GtbabelWordPress;" inside the file before!)
            'vielhuber\gtbabel\*', // all global/native/class based functions in the main wordpress class
        ],
        'files-whitelist' => [
            'uninstall.php', // the uninstall file
            'helpers.php', // all hotloaded global functions by the composer package itself
            'vendor/vielhuber/stringhelper/stringhelper.php', // all libraries with global functions that are hotloaded
        ],
        // all global functions/classes should NOT be prefixed
        'whitelist-global-constants' => true,
        'whitelist-global-classes' => true,
        'whitelist-global-functions' => true,
        // correct custom code
        'patchers' => [
            function (string $filePath, string $prefix, string $content): string {
                // DOMXPath is wrongly prefixed
                if (strpos($filePath,'src/Dom.php') !== false) {
                    $content = str_replace('\\'.$prefix.'\\DOMXpath', '\\DOMXpath', $content);
                }
                return $content;
            }
        ]
    ];
    ```
  - cd build
  - composer dump-autoload
  
 
  