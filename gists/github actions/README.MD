### setup

- add ```/.github/workflows/ci.yml```
- see preset below that supports `phpunit`, `npm`, `mysql`, `postgres`, `sqlite`
- push with new version tag to github
- add a badge to `README.MD`: ```[![build status](https://github.com/username/repo/actions/workflows/ci.yml/badge.svg)](https://github.com/username/repo/actions)```
- enjoy

### environment variables

- can be defined in the yml file; if you want to use secret variables, define them additionally in Settings > Secrets > Actions > Repository secrets
- note that `$_ENV` is not available, so use `$_SERVER` instead (in case of https://github.com/vlucas/phpdotenv)

### check for ci inside php

- ```if( @$_SERVER['CI'] == 'true' ) { }```

### notes

- don't use special packages like https://github.com/mirromutth/mysql-action, https://github.com/php-actions/composer, https://github.com/php-actions/phpunit, do it the most native/manual way

### run github actions locally

- `curl https://raw.githubusercontent.com/nektos/act/master/install.sh | sudo bash`
- restart
- startup docker
- `./bin/act`
- caveat: not everything is working inside act (e.g. `systemd`)
