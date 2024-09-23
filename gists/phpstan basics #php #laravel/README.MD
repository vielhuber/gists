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
./vendor/bin/phpstan clear-result-cache # sometimes (especially when using wsl, the cache gets stale and changes don't reflext)
```

## vscode extension

- https://marketplace.visualstudio.com/items?itemName=SanderRonde.phpstan-vscode
- runs on every file change and shows errors in tab "Problems"