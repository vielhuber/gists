### build a custom docker image

#### build image

- `docker pull ubuntu:latest` // pull latest ubuntu image you want to build upon
- `docker run -it --name test-container ubuntu:latest` // create and start container "test-container" of image "ubuntu:latest" with an interactive shell
- `exit` // exit from interactive shell
- `docker exec -it test-container bash` // reopen bash / connect to image
- make all necessary changes
- `exit` // exit from interactive shell
- `docker commit test-container vielhuber/testimage:latest` # create new image from container with name "testimage" and tag "latest"
- `docker login`
  - if you get the error message `error storing credentials - err: exit status 1, out: Zur Verarbeitung dieses Befehls sind nicht genügend Speicherressourcen verfügbar`, clear all entries in the credential manager starting with "Adobe App" (run `rundll32.exe keymgr.dll, KRShowKeyMgr` and manually delete all entries)
- `docker push vielhuber/testimage:latest` // push local image to dockerhub

#### fetch image

- `docker run -d -it --name testimage vielhuber/testimage:latest` # create and start new container from image in detached mode

#### other commands

- `docker images` # show all images
- `docker ps -a` # show all containers
- `docker image rm ubuntu:latest` # remove image with name "ubuntu" and tag "latest"
- `docker rm ubuntu:latest` # remove container with name "ubuntu" and tag "latest"
- `docker start test-container` # start container
- `docker stop test-container` # stop container

### docker-compose

#### start
- ```docker-compose up```
- ```docker-compose up --d```

#### stop
- ```docker-compose stop```

#### reset
- ```docker-compose down --volumes```

#### login
- ```docker-compose exec php-fpm /bin/sh```

#### commands
- ```docker-compose exec php-fpm php artisan migrate```

#### process
- ```Dockerfile =[docker build]=> Docker image =[docker run]=> Docker container```

#### build new image
- ```docker build -t name .```
- ```docker build .```

#### update remote image
- ```docker-compose pull```
- ```docker-compose pull nginx```

#### run command inside docker-compose.yml
 ```
php-fpm:
	command: sh -c 'echo "foo"'
```

#### connect to database
- redirect port
  - add this to ```docker-compose.yml```: ```mariadb: ports: 3307:3306```
  - connect to localhost:3307
- connect in laravel
  - get ip with ```docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' project_mariadb_1```
  - change ```.env``` to ```DB_HOST=172.19.0.3``` (new ip) and ```DB_PORT=3306```

#### wsl compatibility
- networking only works, when changing ports from ```127.0.0.1:8080:80``` to ```8080:80```
- permissions only work, when manually giving special folders write permissions:
```
chmod 00777 /path/to/project/storage
chmod 00777 /path/to/project/bootstrap/cache 
find /path/to/project/storage -type d -exec chmod 00777 {} \;
find /path/to/project/storage -type f -exec chmod 00777 {} \;
find /path/to/project/bootstrap/cache -type d -exec chmod 00777 {} \;
find /path/to/project/bootstrap/cache -type f -exec chmod 00777 {} \;
```
