### setup

- travis-ci.com > sign up with github
- add ```.travis.yml``` to your root folder

```yml
language: php
php:
    - 7.1
    - 7.2
    - 7.3
os:
    - linux
    #- osx (currently no support for php in travis ci)
    #- windows (currently no support for php in travis ci)
before_script:
    - composer install
script: ./vendor/bin/phpunit
```

- push with new version tag to github
- add a badge to README.MD: [![Build Status](https://travis-ci.org/vielhuber/project.svg?branch=master)](https://travis-ci.org/vielhuber/project)
- enjoy

### environment variables

- can be set via the project settings (and achieve something like a `.env` file on the travis instance)
- note that `$_ENV` is not available, so use `$_SERVER` instead (in case of https://github.com/vlucas/phpdotenv)