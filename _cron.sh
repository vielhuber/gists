#!/bin/bash
cd /kunden/362380_80937/gists
git pull
env -i /usr/local/bin/php72 -f _sync.php
git add -A .
git commit -m "last update on `date +'%Y-%m-%d'`"
git push origin HEAD
