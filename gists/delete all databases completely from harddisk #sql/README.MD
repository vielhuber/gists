# variant 1
sudo service mysql stop
killall -KILL mysqld
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
innodb_force_recovery = 1 # go from 1 to 6 and try to restart
sudo service mysql start

# variant 2
mysqld --initialize

# variant 3
rm -rf /var/lib/mysql/ib*