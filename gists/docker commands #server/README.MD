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
- connect directly
  - get ip with ```docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' project_mariadb_1```
  - this does not work due to wsl2 / firewall

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