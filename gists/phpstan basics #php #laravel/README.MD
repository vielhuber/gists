
## usage

```sh
# recommended command
pkill -f phpstan 2>/dev/null || true; php -d xdebug.mode=off vendor/bin/phpstan clear-result-cache 2>/dev/null || true; rm -rf .phpstan-cache; sync; timeout 300 php -d xdebug.mode=off -d opcache.enable_cli=1 vendor/bin/phpstan analyse --memory-limit=1G

# determine performance issues (exclude slowest files)
timeout 900 php -d xdebug.mode=off vendor/bin/phpstan analyse --debug -vvv --memory-limit=1G > phpstan.log

# more commands (with config file)
./vendor/bin/phpstan analyse
./vendor/bin/phpstan analyse --memory-limit=2G
./vendor/bin/phpstan clear-result-cache # sometimes (especially when using wsl, the cache gets stale and changes don't reflext)

# more commands (without config file)
./vendor/bin/phpstan analyse src tests
./vendor/bin/phpstan analyse --level 5 src tests
./vendor/bin/phpstan analyse --generate-baseline src tests
```

## installation

### plain

```sh
composer require --dev phpstan/phpstan
```

`phpstan.neon`:

```neon
parameters:

    paths:
        - path/to/subfolder/

    excludePaths:
        analyse:
            - path/to/slow/file1.php
            - path/to/slow/file2.php
            - path/to/slow/file3.php
        analyseAndScan:
            - %currentWorkingDirectory%/**/vendor/**
            - %currentWorkingDirectory%/**/node_modules/**
            - %currentWorkingDirectory%/**/_build/**
            - %currentWorkingDirectory%/**/_archive/**
            - %currentWorkingDirectory%/wp-content/uploads/**
            - /root/.vscode-server/**

    bootstrapFiles:
        - path/to/vendor/autoload.php
        - path/to/vendor/vielhuber/stringhelper/src/functions.php
        - path/to/vendor/dbhelper/src/static.php

    level: 3
    
    tmpDir: .phpstan-cache

    parallel:
        maximumNumberOfProcesses: 1
        jobSize: 5
        minimumNumberOfJobsPerProcess: 1
```

### laravel

```sh
composer require --dev "larastan/larastan:^2.0"
```

`phpstan.neon`:

```neon
includes:
    - vendor/larastan/larastan/extension.neon

parameters:

    paths:
        - app/
        - config/
        - database/
        - routes/
        - tests/

    excludePaths:
        analyse:
            - path/to/slow/file1.php
            - path/to/slow/file2.php
            - path/to/slow/file3.php
        analyseAndScan:
            - ~/.vs-code-server/*
            - '/root/.vscode-server/extensions/*'

    level: 3
    
    tmpDir: .phpstan-cache

    parallel:
        maximumNumberOfProcesses: 1
        jobSize: 5
        minimumNumberOfJobsPerProcess: 1
```

### wordpress

```sh
composer require --dev szepeviktor/phpstan-wordpress
```

`phpstan.neon`:

```neon
includes:
    - vendor/szepeviktor/phpstan-wordpress/extension.neon

parameters:

    paths:
        #- wp-config/themes/blank/
        - ./

    excludePaths:
        analyse:
            - path/to/slow/file1.php
            - path/to/slow/file2.php
            - path/to/slow/file3.php
        analyseAndScan:
            - %currentWorkingDirectory%/**/vendor/**
            - %currentWorkingDirectory%/**/node_modules/**
            - %currentWorkingDirectory%/**/_build/**
            - %currentWorkingDirectory%/**/_archive/**
            - %currentWorkingDirectory%/wp-content/uploads/**
            - /root/.vscode-server/**

    level: 3
    
    tmpDir: .phpstan-cache

    parallel:
        maximumNumberOfProcesses: 1
        jobSize: 5
        minimumNumberOfJobsPerProcess: 1
```

## .gitignore

`/.phpstan-cache/`

## vscode extension

- https://marketplace.visualstudio.com/items?itemName=SanderRonde.phpstan-vscode
- runs on every file change and shows errors in tab "Problems"
- plugin settings:

```json
"phpstan.singleFileMode": true,
"phpstan.enabled": true,
```