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
- enjoy