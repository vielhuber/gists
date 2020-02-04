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
  - wget https://github.com/humbug/php-scoper/releases/download/0.13.1/php-scoper.phar
  - php php-scoper.phar add-prefix