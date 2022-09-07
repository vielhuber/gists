#!/bin/bash
cd /path/to/project
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
php wp-cli.phar --allow-root cli cache clear
php wp-cli.phar --allow-root core update
php wp-cli.phar --allow-root core update-db
php wp-cli.phar --allow-root plugin update --all
php wp-cli.phar --allow-root theme update --all
php wp-cli.phar --allow-root language core update
php wp-cli.phar --allow-root language plugin update --all
php wp-cli.phar --allow-root language theme update --all
rm -f wp-cli.phar