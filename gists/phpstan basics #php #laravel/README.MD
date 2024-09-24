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

    level: 0
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

    level: 0
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
        - wp-config/themes/blank/

    level: 0
```

## usage

```sh
# without config
./vendor/bin/phpstan analyse src tests
./vendor/bin/phpstan analyse --level 5 src tests
./vendor/bin/phpstan analyse --generate-baseline src tests

# with config
./vendor/bin/phpstan analyse
./vendor/bin/phpstan analyse --memory-limit=2G
./vendor/bin/phpstan clear-result-cache # sometimes (especially when using wsl, the cache gets stale and changes don't reflext)
```

## vscode extension

- https://marketplace.visualstudio.com/items?itemName=SanderRonde.phpstan-vscode
- runs on every file change and shows errors in tab "Problems"
- useful plugin setting:
	- enable "single file mode"