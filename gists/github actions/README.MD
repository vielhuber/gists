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
            - name: Checkout
              uses: actions/checkout@v3

            - name: Libraries
              run: sudo apt-get install -y diffutils exiftool

            - name: PHP
              uses: shivammathur/setup-php@v2
              with:
                  php-version: '8.1'
                  extensions: gd
                  tools: composer, phpunit

            - name: Composer
              run: composer install --no-interaction

            - name: PHPUnit
              run: ./vendor/bin/phpunit

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
                operating-system: ['ubuntu-latest', 'macos-latest', 'windows-latest']
                php-versions: ['7.4', '8.0', '8.1']

        name: ${{ matrix.operating-system }} (PHP ${{ matrix.php-versions }})

        steps:
            - name: Checkout
              uses: actions/checkout@v3
              
            - name: Libraries
              run:   |
                     if [ "$RUNNER_OS" == "Linux" ]; then
                          sudo apt-get install coreutils
                     elif [ "$RUNNER_OS" == "macOS" ]; then
                          brew install coreutils
                     elif [ "$RUNNER_OS" == "Windows" ]; then
                          choco install important_windows_software
                     fi
              shell: bash
              
            - name: PHP
              uses: shivammathur/setup-php@v2
              with:
                  php-version: '${{ matrix.php-versions }}'
                  extensions: mysqli, xdebug, mbstring, xmlrpc, gd, intl, xml, zip, soap, bcmath, imap, opcache, pgsql, pdo, imagick
                  tools: composer, phpunit

            - name: Composer
              run: composer install --no-interaction

            - name: PHPUnit
              run: ./vendor/bin/phpunit
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