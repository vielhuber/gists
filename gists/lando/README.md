## installation
- https://docs.devwithlando.io/installation/installing.html > Bleeding Edge > Development Builds
- http://installer.kalabox.io/lando-latest-dev.exe
- Install with docker
- Install lando
- Install without git
- Docker Community Edition 2.0.0.0-beta1 => General > Switch Version Edge

#### modify global host
- C:\Users\David\.lando\config.yml
- ```proxyDomain: local.vielhuber.de```

## hosts
- DomainFactory
- A-Records
- local.vielhuber.de => 127.0.0.1
- *.local.vielhuber.de => 127.0.0.1

## ssl

### add
- run cmd as administrator
- ```certutil -addstore -f "ROOT" C:\Users\David\.lando\certs\local.vielhuber.de.pem```
### remove
- note the seialnumber from the command above
- ```certutil -delstore "ROOT" serial-number```


## commands

#### start/init lando app
lando start

#### get info of started lando app
lando info

#### list all lando apps
lando list

#### destroy a lando app
- lando destroy
- lando destroy -y

#### shutdown every running app (not docker)
lando poweroff

#### lando ssh
lando ssh appserver