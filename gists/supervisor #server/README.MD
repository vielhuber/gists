## installation

- `apt-get install -y supervisor`

## start/stop

- `systemctl start supervisor`
- `systemctl stop supervisor`

## commands

- `supervisorctl status` # status
- `supervisorctl reload` # reread and restart
- `supervisorctl reread` # reread conf files
- `supervisorctl update` # start new programs
- `supervisorctl start test` # starts test
- `supervisorctl stop test` # stops test
- `supervisorctl stop all` # starts all
- `supervisorctl start all` # sops all

## run standalone inside containers

- `exec /usr/bin/supervisord --nodaemon`

## config

- `/etc/supervisor/conf.d/test.conf`

```
[program:mysql-server]
command=/usr/bin/mysqld_safe --datadir=/var/lib/mysql --user=mysql --port=3306 --bind-address=0.0.0.0
directory=/
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
stdout_logfile=/var/log/supervisor/mysql.log
stderr_logfile=/var/log/supervisor/mysql_err.log
priority=1
startretries=1
startsecs=10

[program:apache-server]
command=/usr/sbin/apache2ctl -D FOREGROUND
directory=/
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
stdout_logfile=/var/log/supervisor/apache.log
stderr_logfile=/var/log/supervisor/apache_err.log
priority=1
startretries=1
startsecs=10

[program:php-worker]
command=/bin/bash -c 'sleep 10 && exec /usr/bin/php /path/to/worker/worker.php'
directory=/path/to/worker
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
stdout_logfile=/var/log/supervisor/worker.log
stderr_logfile=/var/log/supervisor/worker_err.log
priority=999
startretries=3
startsecs=5
numprocs=10
```