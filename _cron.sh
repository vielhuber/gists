#!/bin/bash
cd "$(dirname "$0")"
git pull
env -i /usr/bin/php -f _sync.php
git add -A .
git commit -m "last update on `date +'%Y-%m-%d'`"
git push origin HEAD
