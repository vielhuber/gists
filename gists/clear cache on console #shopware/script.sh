# 3 commands
php bin/console sw:cache:clear
php bin/console sw:rebuild:seo:index
php bin/console sw:warm:cache:http

# profihost
cd ~/www.tld.com/; /usr/local/php5.6/bin/php -z /usr/local/php_extensions/php5.6/ioncube.so bin/console sw:rebuild:seo:index