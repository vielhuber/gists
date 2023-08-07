#!/bin/bash
cd /kunden/362380_80937/gists
GIT_SSH_COMMAND="ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no" git pull
env -i /usr/bin/php -f _sync.php
git add -A .
git commit -m "last update on `date +'%Y-%m-%d'`"
GIT_SSH_COMMAND="ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no" git push origin HEAD
