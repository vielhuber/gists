
## installation

# set up a bare repository
git init --bare vielhuber.git

# clone repository on the same machine
git clone vielhuber.git vielhuber.de

# install git windows on local machine
Use Git and optional Unix tools from the Windows Command Prompt
Use OpenSSH

# create ssh files locally
Git Bash
ssh-keygen -t rsa
Standardpfad (C:\Users\Name\.ssh\id_rsa)
Keine Passphrase
PuTTYGen
Conversions => Import key => id_rsa => Save private key => putty_id_rsa.ppk

# save ssh files remotely
Im Benutzer-Verzeichnis „~“ den Ordner .ssh erstellen und dorthin wechseln
Inhalt von id_rsa.pub in neue Datei ~/.ssh/authorized_keys einfügen

# ggf. nötig
chmod 700 ~/.ssh
chmod 600 ~/.ssh/authorized_keys
chmod 600 ~/.ssh/id_rsa
chmod 600 ~/.ssh/id_rsa.pub

# test connection 
Git Bash
ssh –T ssh-362380-dv@vielhuber.de

# connect via link
Verknüpfung „SSH“ erstellen mit Inhalt
"C:\Program Files (x86)\PuTTY\putty.exe" -ssh ssh-457678-ps@umfrage.jetzt -i "C:\Users\ASUS-Laptop\.ssh\putty_id_rsa.ppk"

# clone repository on local machine in current dir (after setting up ssh keys)
git clone ssh://username@vielhuber.de:22/~/vielhuber.git .



### clone in existing dir
cd project
mkdir tmp
cd tmp
git clone repo.git .
cd ..
mv tmp/.git .git
rmdir tmp






## change host / remote url

# check
git remote -v
# set
git remote set-url origin ssh://username@vielhuber.de:22/~/vielhuber.git
# check
git remote -v






## settings

# git config locations (down to up)
C:\Program Files (x86)\Git\etc\gitconfig    # system
C:\Users\David\.gitconfig                   # user/global
C:\MAMP\htdocs\vielhuber.de\.git\config     # project
git config --list --show-origin # see where your config settings come from


# ignore warnings for line endings
git config --global core.safecrlf false


# ignore files with the following file in the root directory of repository
.gitignore
  # ignore a folder called "cache" in the folder, .gitignore lies in
  /cache/
  # ignore all folders named "cache"
  cache/
  # ignore a specific subfolder
  /folder/subfolder/
  # ignore a file called "foo.php" in the folder, .gitignore lies in
  /foo.php
  # ignore all files named "foo.php"
  foo.php
  # ignore all files in folder except the folder itself (first create an empty file named .gitkeep inside the folder)
  /folder/*
  !/folder/.gitkeep
  
  # all in root folder (the slash is important)
  /*
  # except some folders (and files in root)
  !/folder/
  !file
  
  
# When gitignore is not working for a specific file/folder:
# this does not delete the folder but remove it from git
git rm -rf --cached specific-file
git rm -rf --cached specific-folder/


# if you want to delete the folder also from history
git filter-branch --tree-filter 'rm -rf custom/directory/' --prune-empty HEAD
git for-each-ref --format="%(refname)" refs/original/ | xargs -n 1 git update-ref -d
echo /custom/directory/ >> .gitignore
git add .gitignore
git commit -m 'removing /custom/directory/ from git history'
git gc
git push origin master --force



# Gitignore: If you have further problems, reinitialize everything:
git pull; git add -A .; git commit -m "commit everything first"; git push origin master;
git rm -rf --cached .
git add .
git commit -m ".gitignore is now working"
git push origin master


# see latest diffs / changes
git diff

# If you want to revert the last commit, replace a0d3fe6 with the ID of the commit you want to forget
git reset --hard a0d3fe6
git push -f origin master

# get current commit hash (outputs: 6e559cb)
git rev-parse --short HEAD

# go to specific commit
git log --oneline -n 10 # show last commits and fetch commit hash
git checkout 6e559cb # go to that commit
git checkout master # go back to current head

# go to specific commit (create a branch from it!)
git checkout -b some_new_test_branch 6e559cb

# setting author details
git config --global user.name "David Vielhuber"
git config --global user.email david@vielhuber.de
# clean up repo
git gc


# disable rebase on pull
# remove the following lines of config files
[pull]
	rebase = true


# set tags for latest commit (important for packages on packagist/composer)
git tag -a 1.0.0 -m ""
git push --tags

# delete tag
git push --delete origin 1.0.0 # remotely
git tag -d 1.0.0 # locally, also important


# fetch tags
git describe --tags # shows current tag number
git rev-parse --abbrev-ref HEAD # shows current branch
git describe origin/master --abbrev=0 --tags # shows latest tag of master branch


# clone with autocrlf false (if you fetch linux bash scripts on windows and run on wsl)
git clone git@bitbucket.org:vielhuber/lamp.git . --config core.autocrlf=false


## workflow

# see changed files
git status

# see changed files and also untracked files
git status -u

# see changed content locally
git diff

# check if there is a pull needed from remote
git remote show origin

# pull
git pull

# push
git add -A .; git commit -m "ticket message"; git push origin master


# add an alias to combine all 3 commands
C:\Program Files (x86\Git\etc\gitconfig
[alias]
	acp = ! git add -A . && git commit -m . && git push origin master
Usage: git acp

# alternative
npm install -g git-upload


## branches

# pull a branch from remote (from branch-name remote to branch-name local)
git fetch origin branch-name:branch-name

# pull all branches from remote to local
git fetch

# show all branches locally
git branch

# show all branches (locally and remotely)
git branch -r

# create new branch locally
git branch branch-name

# change to branch locally
git checkout branch-name
git checkout master
git switch branch-name
git switch master

# create new branch and change to it in one command
git checkout -b branch-name
git switch --create branch-name
git switch -c branch-name

# commit changes inside a branch locally
git add -A .; git commit -m "ticket message"

# merge changes from a branch INTO master locally 
git checkout branch-name
git add -A .; git commit -m "commit first!"
git checkout master
git merge branch-name
git push origin master

# merge A in B and push B
git checkout B
git merge A
git push origin HEAD

# merge changes without a merge message
git merge branch-name --no-edit

# delete branch locally
git branch -d branch-name
git branch --delete branch-name

# delete branch locally (forced)
git branch -D branch-name
git branch --delete --force branch_name

# delete branch remotely
git push origin --delete branch-name
git push origin :branch-name

# delete branch both locally and remotely
git push origin --delete branch-name
git branch --delete --force branch_name

# make changes
git add -A .
git commit -m "ticket message"

# push changes to remote branch
git push origin branch-name

# permanently "connect" your local branch with the remote branch
git branch --set-upstream-to=origin/develop develop

# push changes to remote branch and permanently "connect" your local branch with the remote branch
git push --set-upstream origin branch-name




# make a pull request on github (for an external project)
# go to github.com to the repository you want to make a pull request
# click "Fork"
git clone https://github.com/vielhuber/MSYS2-packages .
git branch new-branch
git checkout new-branch
# make all changes
git add -A .
git commit -m "made changes appearing in the pull request"
git push --set-upstream origin new-branch
# go to the forked repository
# click "Compare & pull request"






## conflicts

# please commit your changes or stash them before you can merge

   # discard single file (undo changes)
   git checkout specific-file
   git checkout -- specific-file
   git checkout folder/*/*.json
   git checkout folder/ # resets all files within that folder
   git restore specific-file

   # possibility 1: remove untracked files
   rm path/to/file

   # possibility 2: reset all
   git reset --hard

   # possibility 3:
   git stash
   git pull
   git stash pop

# automatic merge failed; fix conflicts and then commit the result

   # if a merge tool is available (usually not on shared hosts)
   git mergetool
   
   # if you pushed accidently the conflicted files
   # simply search for "<<<<<<<" or "=======" or ">>>>>>>" and fix it by hand
   
   # download the conflicted files, use WinMerge to fix conflicts, upload the conflicted files
   # the git add -A .; git commit "fixed conflicts"; git push origin HEAD

   # go to the state before git pull
   git merge --abort

### remove untracked files
rm file # simply remove the file
git clean -f -n # do this for all files (just test which files would be removed)
git clean -f # remove them all


### revert ALL changes since the last commit (revert to HEAD of master), also remove files created in gitignore
git reset --hard HEAD
git clean -fdx

### revert all changes
git reset --hard
git clean -df


# make a release of current development branch and push it on master

# PRODUCTION
# check if you are on master and everything is up to date; if not, push to master or pull from master
git status
git remote show origin
# checkout develop branch, pull from develop branch
git checkout develop
git pull origin develop
# do laravel specific stuff
npm install; npm update; composer self-update; composer update --no-scripts; composer install --no-scripts; composer dump-autoload; grunt buildCss -force; php artisan cache:clear
# if composer.lock has changed, we do not need it
git checkout -- composer.lock
# fully test everything
# then switch back to master (page should be broken now, because your vendor is not in sync with old master)
git checkout master

# LOCAL
# checkout develop branch locally
git checkout develop
# create new branch from develop branch
git checkout -b release-0.5 develop
# checkout master branch
git checkout master
# update master branch (if needed)
git pull origin master
# merge release into master
git merge release-0.5
# push master on remote
git push origin master
# push branch remotely
git checkout release-0.5
git push origin release-0.5
# delete local branch
git checkout develop
git branch -d release-0.5
# tag master
git tag -a 0.5 -m "March release" master
git push --tags

# PRODUCTION
# pull new things on production
git pull origin master
# due to this bug (http://stackoverflow.com/questions/2432579/git-your-branch-is-ahead-by-x-commits), we also need to do a git fetch (which ist he same as git pull)
git fetch




### show commit count by author name
git shortlog -sn --all --no-merges







### git flow
# init once (accept all defaults with -d)
git flow init -d
# show all features
git flow feature
# start a new feature
gimkdir -p "testcd testvue clicvcvfileztecpa@vueopfalsenpm run buildnpm incnpmcccd helnpm run builduglifyjsuinuglifyjs-webpack-pluginuglifyjs-webpack-plugincvccdf .cd ..cd ..cd uglcgit clone v . . git command# create new branch and change to it in one commandgit checkout -b branch-namegit checkout -b chroot-bugfixccPfolder" && cd "testcd testvue clicvcvfileztecpa@vueopfalsenpm run buildnpm incnpmcccd helnpm run builduglifyjsuinuglifyjs-webpack-pluginuglifyjs-webpack-plugincvccdf .cd ..cd ..cgit@gitlab.com:c2nm/elobau.git




# interesting note

- if you change a branch with uncommitted files, these files get "transferred" to the other branch(!)
- therefore always commit changes before changing branches





## ignore changes

### variant 1: .gitignore
- new files are ignored on every machine
- files already added / committed must be removed and after that are ignored on every machine

### variant 2: .git/info/exclude
- this is a "local version" of .gitignore and can be extremely useful
- new files are ignored only on this local machine

### variant 3: --skip-worktree
- if files are already in git and you simply want to ignore all changes made locally, use skip-worktree
#### ignore:
- git update-index --skip-worktree path/to/file
#### check:
- git ls-files -v | grep ^S
#### undo ignore:
- git update-index --no-skip-worktree path/to/file