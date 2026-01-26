## basics

**tl;dr**

- Reset + rebuild: `docker compose down --volumes && docker-compose up --build`
- Rebuild: `docker-compose up --build`

**`Dockerfile`**

- General instructions
- Defines which base image is used (e.g., Alpine Linux)
- Specifies which script is executed at startup (→ docker.sh)
- Copies your code into the container
- Can also install software (PHP, Python, Node, MariaDB, etc.)

```
FROM alpine:latest
# copy files, not needed, since we always mount (also on production because of git clone)
#COPY . /app
# start script
COPY docker.sh /docker.sh
RUN chmod +x /docker.sh
CMD ["/docker.sh"]
```

**`docker.sh`**

- Startup script
- Runs automatically when the container starts
- Initializes the database (MariaDB setup, create users)
- Starts all services (e.g., with Supervisor: web server, Python app, etc.)
- Performs the final configuration
  
```
#!/bin/sh
cd /app
pip install --no-cache-dir -r requirements.txt
npm install
...
```  
  
**`docker-compose.yml`**

- Orchestration script
- Tells Docker how to build the Dockerfile
- Defines environment variables (DB passwords, etc.)
- Mapped ports (e.g., 8080 → 80)
- Mounted volumes (e.g., your code, logs)
- Can manage multiple containers (e.g., app + separate DB)
  
```
services:
    app:
        build: .
        volumes:
            - ./:/app
        ports:
            - '8080:8080'
```

**`.dockerignore`**

- These folders/files are excluded from the copy process
- Not needed when you only mount

```
.git
.gitignore
node_modules/
vendor/
```

**Sequence**

`docker-compose up => docker-compose.yml => Dockerfile => docker.sh`

## docker compose

#### purpose

- puts all parameters in a yaml file
- reduces number of command line options
- does the same as docker run

#### start
- ```docker compose up``` # normal start (cached)
- ```docker compose up -d``` # start in background
- ```docker compose up --build``` rebuild image
- ```docker compose up --build -d``` rebuild image and start in background

#### stop
- ```docker compose stop```

#### reset
- ```docker compose down --volumes```

#### login
- ```docker compose exec app /bin/sh```

#### commands
- ```docker compose exec app php artisan migrate```

#### process
- ```Dockerfile =[docker build]=> Docker image =[docker run]=> Docker container```

#### build new image
- ```docker build -t name .```
- ```docker build .```

#### update remote image
- ```docker compose pull```
- ```docker compose pull nginx```

#### legacy
- `docker-compose` is a deprecated old project, which is replaced with `docker compose`
- the arguments are (now) mainly compatible

#### run command inside docker compose.yml
 ```
app:
    command: sh -c 'echo "foo"'
```

#### connect to database
- redirect port
  - add this to ```docker compose.yml```: ```mariadb: ports: 3307:3306```
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

## build a custom docker image

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
- `docker rename old-name new-name` # rename container