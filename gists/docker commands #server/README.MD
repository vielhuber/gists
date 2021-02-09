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

#### run command inside docker-compose.yml
 ```
php-fpm:
	command: sh -c 'echo "foo"'
```