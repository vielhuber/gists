## basics

**tl;dr**

- reset + rebuild: `clear && docker compose down --volumes && docker compose build --no-cache | tee logs/build.log`
- start: `docker compose up`
- login: `docker compose exec app /bin/bash`
- reset + rebuild + start: `clear && docker compose down --volumes && docker compose build --no-cache | tee logs/build.log && docker compose up`
- rebuild + start: `clear && docker compose build --no-cache | tee logs/build.log && docker compose up`
  
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
            # natively mount external applications
            - /usr/bin/php8.3:/host/php8.3
            - /var/www/custom:/host/custom
            # mount permanent data (folder on host must exist); example reads .env file in root folder
            - ${DOCKER_MOUNT_TMP}:/host/tmp
            - ~/.custom-app/permanent:/path/inside/host/permanent
            # permanently save vscode extensions
            - ~/.vscode-server-docker:/root/.vscode-server
            # local development (not needed on production, use COPY in Dockerfile there)
            - ./:/app
            # ignore node_modules and vendor directories to prevent overwriting container installs
            - /app/venv
            - /app/node_modules
            - /app/vendor
            - /app/_public
            # xserver
            - /tmp/.X11-unix:/tmp/.X11-unix:rw
        ports:
            - '8000:8000'
            - '8001:8001'
            - '5001:5001'
        environment:
            # these environment variables are only available after build
            - IS_DOCKER=1
            - DISPLAY=host.docker.internal:0
```

**`Dockerfile`**

- General instructions
- Defines which base image is used (e.g., Alpine Linux)
- Copies your code into the container
- Specifies which script is executed at build and startup
- `COPY/RUN` commands only run on build, `CMD` commands only run on start

```
FROM alpine:latest

# if you want to use ubuntu instead
#FROM ubuntu:latest

# copy (not needed, since we mount)
#COPY . /app

# build
RUN /app/docker-build.sh

# start
CMD ["/app/docker-start.sh"]
```

**`docker-build.sh`**

- Build script
- Runs automatically when the container builds
- Initializes the database (MariaDB setup, create users)
- Performs the final configuration
  
```
#!/usr/bin/env bash
cd /app

# set environment variables (for build and start)
echo 'export IS_DOCKER=1' >> /root/.bash_profile
export IS_DOCKER=1
echo 'export DISPLAY=host.docker.internal:0' >> /root/.bash_profile
export DISPLAY=host.docker.internal:0

# install packages
apt-get install -y git curl
pip install --no-cache-dir -r requirements.txt
npm install

...
```

**`docker-start.sh`**

- Start script
- Runs automatically when the container starts
- Repopulates config files
- Starts all services (e.g., with Supervisor: web server, Python app, etc.)
  
```
#!/usr/bin/env bash

# run some other scripts
./app/test.sh >> /app/logs/startup.log 2>&1

# run supervisor
exec /usr/bin/supervisord --nodaemon >> /app/logs/startup.log 2>&1
```

**`.dockerignore`**

- These folders/files are excluded from the copy (not mount!) process
- If you mount files that already exist inside docker, they get overwritten

```
.git
.gitignore
node_modules/
vendor/
```

## docker compose

#### purpose

- puts all parameters in a yaml file
- reduces number of command line options
- does the same as docker run

#### start
- ```docker compose up``` # normal start (cached)
- ```docker compose up -d``` # start in background
- ```docker compose up --build``` rebuild image
- ```docker compose up --build --no-cache``` rebuild image without cache
- ```docker compose up --build -d``` rebuild image and start in background

#### stop
- ```docker compose stop```

#### reset
- ```docker compose down --volumes```

#### login
- ```docker compose exec app /bin/bash```

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

#### vscode development

- Extension installieren: Dev Container
- STRG+Shift+P: Reopen in Container > `docker-compose.yml`
- Extensions installieren: Entwicklungscontainer > Wolke > Alle markieren > Installieren + `~/.vscode-server-docker:/root/.vscode-server` in `docker-compose.yml`
- Start: `code .` in WSL, dann in Container erneut öffnen (Popup rechts unten)
- Einstellungen anpassen: `.devcontainer/devcontainer.json`:

```
{
    "name": "DOCKER",
    "dockerComposeFile": ["../docker-compose.yml"],
    "service": "app",
    "workspaceFolder": "/app",
    "runServices": [],
    "shutdownAction": "none"
}
```

#### connect to database
- from host to docker
  - redirect port
    - add this to ```docker compose.yml```: ```mariadb: ports: 3307:3306```
    - connect to localhost:3307
  - connect in laravel
    - get ip with ```docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' project_mariadb_1```
    - change ```.env``` to ```DB_HOST=172.19.0.3``` (new ip) and ```DB_PORT=3306```
- from docker to host
  - use `host.docker.internal` with port `3306`

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