## setup

#### set up a bare repository
- git init --bare vielhuber.git

#### allow permission
- copy content of id_rsa.pub (client) to file ~/.ssh/authorized_keys (server)

#### correct permissions
- chmod 700 ~/.ssh
- chmod 600 ~/.ssh/authorized_keys
- chmod 600 ~/.ssh/id_rsa
- chmod 600 ~/.ssh/id_rsa.pub

#### clone repository on local machine in current dir (after setting up ssh keys)
- git clone ssh://username@vielhuber.de:22/~/vielhuber.git .

#### clone in existing dir
- cd project
- mkdir tmp
- cd tmp
- git clone repo.git .
- cd ..
- mv tmp/.git .git
- rmdir tmp

#### change host / remote url

##### check
- git remote -v

##### set (change origin url)
- git remote set-url origin ssh://username@vielhuber.de:22/~/vielhuber.git
- git remote set-url origin git@gitlab.com:c2nm/vielhuber.git
- git remote set-url origin https://gitlab.com/c2nm/vielhuber.git
- git remote set-url origin https://username:password@gitlab.com/c2nm/vielhuber.git
- git remote set-url origin https://david%40close2.de@gitlab.com/c2nm/vielhuber.git

##### add another remote
- git remote add customname git@github.com:organization/repo.git

##### push to specific remote
- `git push`: push current branch to remote `origin` (`origin` ist connected to all branches by default)
- `git push origin`: push current branch to remote `origin` (same as `git push` in a normal scenario)
- `git push origin master`: push branch `master` to remote `origin` (same as `git push` in a normal scenario)
- `git push --all`: pushes all branches instead of the current one
- `git push --mirror`: pushes all branches, tags, notes, ...

##### push to all remotes
- `git remote | xargs -L1 git push --all`: push all branches to all remotes
- `git remote | xargs -L1 -I R git push R master`: only push master to all remotes
- another option is to add a new remote with multiple endpoints
  - `git remote add all git@gitlab.com:xxx/A.git`
  - `git remote set-url --add all git@github.com:xxx/B.git``
  - `git push all --all`

#### settings

##### git config locations (down to up)
- `/etc/gitconfig` # system (often empty)
- `~/.gitconfig` # global/user
- `/var/www/project/.git/config` # project
- `git config --list` # show settings
- `git config --list --show-origin` # see where your config settings come from

##### ignore warnings for line endings
- git config --global core.safecrlf false

##### ignore files with the following file in the root directory of repository
- .gitignore
```
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
```  

#### remove cached files
if gitignore is not working for a specific file/folder (this does not delete the folder but remove it from git):
- git rm -rf --cached specific-file
- git rm -rf --cached specific-folder/
- find . -type f -name "*.*" | xargs git rm -rf --cached

#### if you want to delete the folder also from history
- git filter-branch --tree-filter 'rm -rf custom/directory/' --prune-empty HEAD
- git for-each-ref --format="%(refname)" refs/original/ | xargs -n 1 git update-ref -d
- echo /custom/directory/ >> .gitignore
- git add .gitignore
- git commit -m 'removing /custom/directory/ from git history'
- git gc
- git push origin master --force

#### if you have further problems, reinitialize everything:
- git pull; git add -A .; git commit -m "commit everything first"; git push origin master;
- git rm -rf --cached .
- git add .
- git commit -m ".gitignore is now working"
- git push origin master

#### see latest diffs / changes
- git diff

#### get current commit hash (outputs: 6e559cb)
- git rev-parse --short HEAD

#### go to specific commit
- git log --oneline -n 10 # show last commits and fetch commit hash
- git checkout 6e559cb # go to that commit
- git checkout master # go back to current head

#### go to specific commit (create a branch from it)
- git checkout -b some_new_test_branch 6e559cb

#### setting author details
- git config --global user.name "David Vielhuber"
- git config --global user.email david@vielhuber.de

#### clean up repo
- git gc

#### rename folder (from filesystem and from git, this is important when git needs to track the history properly)
- git mv oldfolder newfolder

#### delete file (from filesystem and from git, this is important when git needs to track the history properly)
- git rm file

#### show commit message and diff for commit
- git show dbdd0fb9

#### find any commit with a particular snippet of code (and also show diff and commit message)
- git log -S "foobar" --patch
- git log -S "foobar" -- .
- git log -S "foobar" --since=2009.1.1 --until=2010.1.1 -- .

#### show latest changes of every line of specific file (to blame somebody for introducing a bug)
- git blame path/to/file
- git blame path/to/file -L 100,200 # show only specific lines

#### revise commit history
- git rebase --interactive

#### disable rebase on pull (remove the following lines of config files)
```
[pull]
	rebase = true
```

#### set tags for latest commit (important for packages on packagist/composer)
- git tag -a 1.0.0 -m ""
- git push --tags

#### delete tag
- git push --delete origin 1.0.0 # remotely
- git tag -d 1.0.0 # locally, also important

#### fetch tags
- git describe --tags # shows current tag number
- git rev-parse --abbrev-ref HEAD # shows current branch
- git describe origin/master --abbrev=0 --tags # shows latest tag of master branch

#### clone with autocrlf false (if you fetch linux bash scripts on windows and run on wsl)
- git clone git@bitbucket.org:vielhuber/lamp.git . --config core.autocrlf=false

#### if ip address of remote server changed: WARNING: POSSIBLE DNS SPOOFING DETECTED! / WARNING: REMOTE HOST IDENTIFICATION HAS CHANGED!
- variant 1
  - nano ~/.ssh/known_hosts
  - delete specific line (or all lines)
- variant 2
  - ssh-keygen -f "~/.ssh/known_hosts" -R host.tld

## workflow

### see changed files
- git status

### see changed files and also untracked files
- git status -u

### see changed content locally
- git diff

### check if there is a pull needed from remote
- git remote show origin

### pull (this does fetch and merge!)
- git pull

### push
- git add -A .; git commit -m "ticket message"; git push origin master

### add an alias to combine all 3 commands
C:\Program Files (x86\Git\etc\gitconfig
```
[alias]
	acp = ! git add -A . && git commit -m . && git push origin master
Usage: git acp
```

### alternative
- npm install -g git-upload

## branches

### tl;dr
- git checkout -b branch-name
- git push --set-upstream origin branch-name

### pull a branch from remote (from branch-name remote to branch-name local)
- git fetch origin branch-name:branch-name

### pull all branches from remote to local
- git fetch

### show all branches locally
- git branch

### show all branches (locally and remotely)
- git branch -r

### create new branch locally
- git branch branch-name

### change to branch locally
- git checkout branch-name
- git checkout master
- git switch branch-name
- git switch master

### change to last active branch
- git checkout -

### create new branch and change to it in one command
- git checkout -b branch-name
- git switch --create branch-name
- git switch -c branch-name

### commit changes inside a branch locally
- git add -A .; git commit -m "ticket message"

### merge changes from a branch INTO master locally 
- git checkout branch-name
- git add -A .; git commit -m "commit first!"
- git checkout master
- git merge branch-name
- git push origin master

### merge A in B and push B
- git checkout A
- git pull
- git checkout B
- git pull
- git merge A
- git push origin HEAD
- git checkout A

### merge changes without a merge message
- git merge branch-name --no-edit

### delete branch locally
- git branch -d branch-name
- git branch --delete branch-name

### delete branch locally (forced)
- git branch -D branch-name
- git branch --delete --force branch_name

### delete branch remotely
- git push origin --delete branch-name
- git push origin :branch-name

### delete branch both locally and remotely
- git push origin --delete branch-name
- git branch --delete --force branch_name
- git fetch --prune # update local list of branches

### make changes
- git add -A .
- git commit -m "ticket message"

### push changes to remote branch
- git push origin branch-name

### permanently "connect" your local branch with the remote branch
- git branch --set-upstream-to=origin/develop develop

### push changes to remote branch and permanently "connect" your local branch with the remote branch
- git push --set-upstream origin branch-name

### rename a branch (locally and remotely)
- git checkout old-name
- git branch -m new-name
- git push origin :old-name new-name
- git push origin -u new-name
- Now your local and remote branch is OK, but other colleagues don't see the new branch. So they have to do:
  - git branch -d old-name
  - git remote update origin --prune
  - git pull
 
### check if one branch consists another branch
- `git checkout special-branch`
- `git branch --merged` # list all branches that the current branch contains
- `git branch --merged | grep -q "other-branch$" && echo "yes" || echo "no"`
- `git branch --merged | grep -q "other-branch$\|and-another-branch$" && echo "yes" || echo "no"` # multiple other branches

### checkout all branches locally
- `git branch -a | grep -v HEAD | perl -ne 'chomp($_); s|^\*?\s*||; if (m|(.+)/(.+)| && not $d{$2}) {print qq(git branch --track $2 $1/$2\n)} else {$d{$_}=1}' | csh -xfs`

## pull request
#### make a pull request on github (for an external project), go to github.com to the repository you want to make a pull request, click "Fork"
- git clone https://github.com/vielhuber/MSYS2-packages .
- git branch new-branch
- git checkout new-branch
#### make all changes
- git add -A .
- git commit -m "made changes appearing in the pull request"
- git push --set-upstream origin new-branch
#### go to the forked repository
#### click "Compare & pull request"


## a note on merging
- git merge foo merges the branch foo into the current checked out branch
- if no conflict has been found it is automatically committed (fast forward)
- if a conflict has been found it is not automatically comitted (no fast forward)
- to get a clean log, always use `--no-ff`
- you also can set this globally via `git config --global pull.ff only && git config --global merge.ff false`

#### undo (uncomitted) changes from a merge where conflicts have happened
- git merge --abort

#### undo (uncomitted) changes from a merge where no conflict has happened
- git reset --hard; git clean -df;

#### undo (comitted) changes from a merge where no conflicts appeared
- git reset --merge ORIG_HEAD
- git reset --hard origin/master # if the command above is not working

#### how to merge always with a commit
- git merge branch --no-ff

#### how to merge without a commit
- git merge branch --no-commit --no-ff

#### put together / squash all commits from branch in one single commit (good for code reviews)

##### with git diff
- `git diff master..special-branch` // show all changes between special-branch and master
- `git diff master..special-branch --name-only` // show only changed files

##### temporarily in another branch
- `git checkout master` # switch to branch to compare to
- `git checkout -b special-branch--squashed` # create new branch from it
- `git merge --squash special-branch` # merge branch with changes into current branch
- do code review
- `git reset --hard; git clean -df` # undo uncomitted changes
- `git checkout master` # switch back to master
- `git branch --delete special-branch--squashed` # delete special branch locally

##### permanently in another branch

- `git checkout branch-name`
- `git merge master` # merge current state into the branch to only view the differences (if you want to compare to another branch, use "develop" etc. instead of "master")
- `git push origin HEAD`
- `git reset --soft master`
- `git add -A . && git commit -m "squash"`
- `git pull --no-ff`
- `git push origin HEAD`

##### permanently in master
- `git checkout master`
- `git merge --squash feature/XX-XX`
- `git commit -m "feature/XX-XX"`
- `git push origin HEAD`

## conflicts

### please commit your changes or stash them before you can merge

#### discard single file (undo changes)
- git checkout specific-file
- git checkout -- specific-file
- git checkout folder/*/*.json
- git checkout folder/ # resets all files within that folder
- git restore specific-file

#### possibility 1: remove untracked files
- rm path/to/file

#### possibility 2: undo last git pull or a git merge
- git reset --hard

#### possibility 3:
- git stash
- git pull
- git stash pop

### automatic merge failed; fix conflicts and then commit the result

#### if you pushed accidently the conflicted files
- simply search for "<<<<<<<" or "=======" or ">>>>>>>" and fix it by hand
- then do: git add -A .; git commit -m "fix merge conflicts"; git push origin HEAD

#### if a merge tool is available (usually not on shared hosts)
- git mergetool
      
#### download the conflicted files, use WinMerge to fix conflicts, upload the conflicted files
#### the git add -A .; git commit "fixed conflicts"; git push origin HEAD

### revert to last committed state (to undo a git pull or a git merge)
- git reset --hard HEAD
- git reset --hard # same as above

### remove untracked files
#### recommended way
- git clean -dn
- git clean -df
#### variants
- git clean -n # remove untracked files (only show, not remove)
- git clean -f # remove untracked files
- git clean -dn # remove untracked files and empty untracked directories (only show, not remove)
- git clean -df # remove untracked files and empty untracked directories
- git clean -di # interactively remove untracked files and empty untracked directories
- git clean -dnx # remove untracked files and empty untracked directories and all ignored files (only show, not remove)
- git clean -dnX # remove only ignored files (only show, not remove)
- rm file # simply remove the file (this is also possible)

### revert ALL changes since the last commit (revert to HEAD of master), also remove files created in gitignore
- git reset --hard HEAD
- git clean -fdx

### revert all changes (undo last git pull)
- git reset --hard
- git clean -df

### undo last commit that has not been pushed yet
- git reset --hard HEAD~1

### remove big file unintentionally committed (but not pushed)
- git rm --cached giant_file
- vim .gitignore # add giant_file
- git commit --amend -CHEAD
- git push origin HEAD

### pull with merge conflicts that result from different line endings
- git pull -Xignore-space-at-eol

### change commit message of last pushed commit
- git commit --amend -m "New commit message"
- git push --force

#### undo commit that has been pushed
- replace a0d3fe6 with the ID of the commit you want to undo: `git log --oneline -n 10`
- option 1 (without rewriting history, recommended way)
  - locally
    - git revert --no-commit a0d3fe6
        - if the commit was a merge, do: git revert --no-commit -m 1 a0d3fe6
		- if theres some error about cherry picking, do: git cherry-pick --abort
    - git commit -m "Reverted a0d3fe6"
    - git push origin HEAD
  - remotely (on all clients)
    - git pull
- option 2 (with rewriting history, this resets master to specific commit (forget all changes up until now))
  - locally
    - git reset --hard a0d3fe6
    - git push -f origin master
  - remotely (on all clients)
    - git fetch origin
    - git reset --hard origin/master

## fix corrupt repo

- messages
  - error: object file .git/objects/... is empty
  - fatal: loose object ... (stored in .git/objects/...) is corrupt
- fix #1
  - ```find .git/objects/ -type f -empty | xargs rm``` # remove any empty object files
  - ```git fetch -p``` # fetch down missing objects
  - ```git fsck --full``` # object store check
- fix #2
  - ```cp -R project project-backup # create backup``` (if needed)
  - ```git clone xxx/xxx.git project-restore```
  - ```cd project-restore && git checkout feature/foo # checkout specific branch``` (if needed)
  - ```rm -rf project/.git```
  - ```mv project-restore/.git project```
  - ```rm -rf project-restore```
  - ```rm -rf project-backup``` # delete backup (if needed)

## make a release of current development branch and push it on master

### PRODUCTION
#### check if you are on master and everything is up to date; if not, push to master or pull from master
- git status
- git remote show origin
#### checkout develop branch, pull from develop branch
- git checkout develop
- git pull origin develop
#### do laravel specific stuff
- npm install; npm update; composer self-update; composer update --no-scripts; composer install --no-scripts; composer dump-autoload; grunt buildCss -force; php artisan cache:clear
#### if composer.lock has changed, we do not need it
- git checkout -- composer.lock
#### fully test everything
#### then switch back to master (page should be broken now, because your vendor is not in sync with old master)
- git checkout master

### LOCAL
#### checkout develop branch locally
- git checkout develop
#### create new branch from develop branch
- git checkout -b release-0.5 develop
#### checkout master branch
- git checkout master
#### update master branch (if needed)
- git pull origin master
#### merge release into master
- git merge release-0.5
#### push master on remote
- git push origin master
#### push branch remotely
- git checkout release-0.5
- git push origin release-0.5
#### delete local branch
- git checkout develop
- git branch -d release-0.5
#### tag master
- git tag -a 0.5 -m "March release" master
- git push --tags

### PRODUCTION
#### pull new things on production
- git pull origin master
#### due to this bug (http://stackoverflow.com/questions/2432579/git-your-branch-is-ahead-by-x-commits), we also need to do a git fetch (which ist he same as git pull)
- git fetch

### show commit count by author name
- git shortlog -sn --all --no-merges

### git flow
#### init once (accept all defaults with -d)
- git flow init -d
#### show all features
- git flow feature
#### start a new feature
- gimkdir -p "testcd testvue clicvcvfileztecpa@vueopfalsenpm run buildnpm incnpmcccd helnpm run builduglifyjsuinuglifyjs-webpack-pluginuglifyjs-webpack-plugincvccdf .cd ..cd ..cd uglcgit clone v . . git command# create new branch and change to it in one commandgit checkout -b branch-namegit checkout -b chroot-bugfixccPfolder" && cd "testcd testvue clicvcvfileztecpa@vueopfalsenpm run buildnpm incnpmcccd helnpm run builduglifyjsuinuglifyjs-webpack-pluginuglifyjs-webpack-plugincvccdf .cd ..cd ..cgit@gitlab.com:c2nm/elobau.git

## interesting note

- if you change a branch with uncommitted files, these files get "transferred" to the other branch(!)
- therefore always commit changes before changing branches
- if you switch between branches with a lot of code changes, and branch A consists of committed files that are seen untracked on branch B, suddenly on branch B you get all this untracked files. run `git clean -df` after changing branches solves this problem

## stash

- tl;dr: ```git stash -u; git stash pop```
- stashes are for code changes you don't want to commit but save for later usage (for example to quickly change to another branch or to pull first)
- stashes are ONLY local and not transmitted to remote
- `git stash`: stash everything, that has not yet been committed
- `git stash push`: equivalent to `git stash`
- `git stash save`: deprecated
- `git stash push -m "note about this stash"`
- `git stash --include-untracked` / `git stash -u`: stashes also untracked files
- `git stash --all` / `git stash -a`: stashes both untracked and ignored files (warning, this stashes full node_modules folder)
- `git stash list`: show current stashes
- `git stash show`: show stash
- `git stash apply`: take out stash, but leave it in stash list
- `git stash pop`: take out stash and remove it from stash list
- `git stash pop stash@{2}`: take out specific stash
- `git stash drop stash@{0}`: delete stash and delete num from list
- `git stash clear`: delete all stashes
- `git stash branchname`: you can stash branches (but this is not the normal use case)

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


## rename main folders
- if you rename a main folder, make changes on files and merge from another branch (where those files were already changed, but in the original folder structure), this leads to annoying conflicts
- recipe to get that working:
  - rename the folder in master
    - git checkout master
    - make file changes
    - git mv main-folder new-main-folder
    - git add -A . && git commit -m "." && git push origin HEAD
  - now when we want to merge a branch with the old path
    - git checkout master
    - git mv new-main-folder main-folder
    - git add -A . && git commit -m "." && git push origin HEAD
    - git merge another-branch
    - git push origin HEAD
    - git mv main-folder new-main-folder
    - git add -A . && git commit -m “.” && git push origin HEAD

## cleanup

- links
  - https://docs.gitlab.com/ee/user/project/repository/reducing_the_repo_size_using_git.html
- solutions
  - git filter-repo (does delete remotes)
  - bfg (has problems with paths: https://github.com/rtyley/bfg-repo-cleaner/issues/187)
  - git filter-branch (is not recommended by git itself anymore)
- show biggest 50 files in history:
  - `git filter-repo --analyze && cat .git/filter-repo/analysis/directories-all-sizes.txt`
- remove path from history
  - solution with git filter-repo (problem: gitlab does not update its quota!)
```
mkdir tmp
cd tmp
git clone git@gitlab.com:xxx/xxx.git .` # make a fresh clone first
git-filter-repo --path path/to/exclude/ --invert-paths
`git remote add origin git@gitlab.com:xxx/xxx.git # git-filter-repo removes all origins; readd them
git push --set-upstream origin main --force` OR `git push origin --force 'refs/heads/*'
cd ..
rm -rf tmp/
# all teammembers need to make a fresh clone of the repo
```
  - solution with git filter-branch

```
mkdir tmp
cd tmp
git clone git@gitlab.com:xxx/xxx.git .

# create tracking branches of all branches
for remote in `git branch -r | grep -v /HEAD`; do git checkout --track $remote ; done

# remove DIRECTORY_NAME from all commits, then remove the refs to the old commits (repeat these two commands for as many directories that you want to remove)
git filter-branch --index-filter 'git rm -rf --cached --ignore-unmatch DIRECTORY_NAME/' --prune-empty --tag-name-filter cat -- --all
git for-each-ref --format="%(refname)" refs/original/ | xargs -n 1 git update-ref -d

# ensure all old refs are fully removed
rm -Rf .git/logs .git/refs/original

# perform a garbage collection to remove commits with no refs
git gc --prune=all --aggressive

# force push all branches to overwrite their history (use with caution!)
git push origin --all --force
git push origin --tags --force
```