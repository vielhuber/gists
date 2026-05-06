### setup

- add ```/.github/workflows/ci.yml```
- see preset below that supports `phpunit`, `npm`, `mysql`, `postgres`, `sqlite`
- push with new version tag to github
- add a badge to `README.MD`: ```[![build status](https://github.com/username/repo/actions/workflows/ci.yml/badge.svg)](https://github.com/username/repo/actions)```
- enjoy

### environment variables

- `.env`
  - can be defined in the yml file
  - if you want to use secret variables, define them additionally in Settings > Secrets > Actions > Repository secrets > `SECRET_VARIABLE_1`
  - note that `$_ENV` is not available, so use `$_SERVER` instead (in case of https://github.com/vlucas/phpdotenv, also replace `$dotenv->load();` with `$dotenv->safeLoad();`)
  - alternatively create an .env file from the secrets (see action below)
- `config.json`
  - `base64 -w 0 config.json | clip.exe`
  - store the json file as base64 in Settings > Secrets > Actions > Repository secrets > `CONFIG_JSON_BASE64`
  - add this to your ci.yml
```yml
- name: Create config.json from secret
  run: echo "${{ secrets.CONFIG_JSON_BASE64 }}" | base64 -d > config.json
```

### check for ci inside php

- ```if( @$_SERVER['CI'] == 'true' || @$_ENV['CI'] == 'true' || getenv('CI') == 'true' || getenv('ACT_TOOLSDIRECTORY') != '' ) { }```

### notes

- don't use special packages like https://github.com/mirromutth/mysql-action, https://github.com/php-actions/composer, https://github.com/php-actions/phpunit, do it the most native/manual way

### run github actions locally

- installation: `curl --proto '=https' --tlsv1.2 -sSf https://raw.githubusercontent.com/nektos/act/master/install.sh | sudo bash`
- run: `./bin/act -P ubuntu-22.04=catthehacker/ubuntu:act-22.04 --bind --secret-file .env`
- run + keep: `./bin/act -P ubuntu-22.04=catthehacker/ubuntu:act-22.04 --bind --secret-file .env --reuse`
- ssh: `docker exec -it $(docker ps -q --filter "ancestor=catthehacker/ubuntu:act-latest") bash`

#### `.gitignore`

```
.env
/bin/act
```

#### `.env`

```
SECRET_VARIABLE_1=FOO
```

