## plain

### installation

```sh
composer require --dev phpstan/phpstan
```

### usage

```sh
./vendor/bin/phpstan analyse src tests
./vendor/bin/phpstan analyse --level 5 src tests
./vendor/bin/phpstan analyse --generate-baseline src tests
```

## laravel

### installation
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

    level: 0
```

### usage

```sh
./vendor/bin/phpstan analyse
./vendor/bin/phpstan analyse --memory-limit=2G
./vendor/bin/phpstan analyse --memory-limit=2G --clear-result-cache
```