### setup

- add ```/.github/workflows/ci.yml```

#### simple

```yml
name: CI

env:
    CI: true
    SECRET_VARIABLE_1: ${{ secrets.SECRET_VARIABLE_1 }}
    SECRET_VARIABLE_2: ${{ secrets.SECRET_VARIABLE_2 }}
    SECRET_VARIABLE_3: ${{ secrets.SECRET_VARIABLE_3 }}

on: [push]

jobs:
    build-test:
        runs-on: ubuntu-latest

        steps:
            - name: Checkout code
              uses: actions/checkout@v3

            - name: Install libraries
              run: sudo apt-get install -y diffutils exiftool

            - name: Install composer
              uses: php-actions/composer@v6
              with:
                  php_version: '8.1'
                  version: 2.x

            - name: PHPUnit tests
              uses: php-actions/phpunit@v3
              with:
                  php_extensions: gd
```

#### advanced

```yml
name: CI

env:
    CI: true
    SECRET_VARIABLE_1: ${{ secrets.SECRET_VARIABLE_1 }}
    SECRET_VARIABLE_2: ${{ secrets.SECRET_VARIABLE_2 }}
    SECRET_VARIABLE_3: ${{ secrets.SECRET_VARIABLE_3 }}

on: [push]

jobs:
    build-test:
        runs-on: ${{ matrix.operating-system }}

        strategy:
            matrix:
                operating-system: [ubuntu-latest]
                php-versions: ['7.4', '8.0', '8.1']

        name: ${{ matrix.operating-system }} (PHP ${{ matrix.php-versions }})

        steps:
            - name: Checkout code
              uses: actions/checkout@v3
              
            - name: Install libraries
              run: sudo apt-get install -y diffutils exiftool

            - name: Install composer
              uses: php-actions/composer@v6
              with:
                  version: latest
                  php_version: '${{ matrix.php-versions }}'
                  php_extensions: mysqli xdebug mbstring xmlrpc gd intl xml zip soap bcmath imap opcache pgsql pdo imagick

            - name: PHPUnit tests
              uses: php-actions/phpunit@v3
              with:
                  version: latest
                  php_version: '${{ matrix.php-versions }}'
                  php_extensions: mysqli xdebug mbstring xmlrpc gd intl xml zip soap bcmath imap opcache pgsql pdo imagick
```

- push with new version tag to github
- add a badge to `README.MD`: ```[![build status](https://github.com/username/repo/actions/workflows/ci.yml/badge.svg)](https://github.com/username/repo/actions)```
- enjoy

### environment variables

- can be defined in the yml file; if you want to use secret variables, define them additionally in Settings > Secrets > Actions > Repository secrets
- note that `$_ENV` is not available, so use `$_SERVER` instead (in case of https://github.com/vlucas/phpdotenv)

### check for travis CI inside php

- ```if( @$_SERVER['CI'] == 'true' ) { }```

### other

- hotloaded functions in `composer.json` > `autoload` > `files` don't work. add them manually to your test with `include_once './src/functions.php';`