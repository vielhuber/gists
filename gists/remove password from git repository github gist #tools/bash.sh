#!/bin/bash

set -x

PASSWORD="AzaISAD9yn0LPcJU66euM4NeR1vedhU1TMT3bkj";
GIT_REPO="git@gist.github.com:GIST_ID.git"

# delete password from head (since bfg does not modify the current state)
git clone $GIT_REPO repo
cd repo
find . -type f -name "*" -not -path './.git/*' -print0 | xargs -0 sed -i -e 's/'"$PASSWORD"'/***REMOVED***/g'
git status
git add -A .
git commit -m "Clean history."
git push origin HEAD
cd ..
rm -rf repo

# delete password from history
git clone --mirror $GIT_REPO repo.git
echo "$PASSWORD" > passwords.txt
wget -O bfg.jar https://repo1.maven.org/maven2/com/madgag/bfg/1.14.0/bfg-1.14.0.jar
java -jar bfg.jar --replace-text passwords.txt repo.git
cd repo.git
git reflog expire --expire=now --all && git gc --prune=now --aggressive
git push
cd ..
rm -rf repo.git bfg.jar passwords.txt repo.git.bfg-report