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

#### always accept authenticity

- if you get the warning `The authenticity of host 'github.com' can't be established.`, you can:
  - option 1: `ssh-keyscan github.com >> ~/.ssh/known_hosts`
  - option 2: `GIT_SSH_COMMAND="ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no" git pull`

#### change host / remote url

##### check
- git remote -v

##### set (change origin url)
- git remote set-url origin ssh://username@vielhuber.de:22/~/vielhuber.git
- git remote set-url origin git@gitlab.com:vielhuber/vielhuber.git
- git remote set-url origin https://gitlab.com/vielhuber/vielhuber.git
- git remote set-url origin https://username:password@gitlab.com/vielhuber/vielhuber.git
- git remote set-url origin https://david%40close2.de@gitlab.com/vielhuber/vielhuber.git

##### add another remote
- git remote add customname git@github.com:organization/repo.git
- git remote remove customname

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
if gitignore is not working for a specific file/folder (this does not(!) delete the folder but remove it from git):
- git rm -rf --cached specific-file
- git rm -rf --cached specific-folder/
- find . -type f -name ".DS_Store" | xargs git rm -rf --cached

#### if you want to delete the folder also from history (deprecated, see below for a better answer)
- git filter-branch --tree-filter 'rm -rf custom/directory/' --prune-empty HEAD
- git for-each-ref --format="%(refname)" refs/original/ | xargs -n 1 git update-ref -d
- echo /custom/directory/ >> .gitignore
- git add .gitignore
- git commit -m 'removing /custom/directory/ from git history'
- git gc
- git push origin master --force

#### if you have further problems, reinitialize everything
- git pull; git add -A .; git commit -m "commit everything first"; git push origin master;
- git rm -rf --cached .
- git add .
- git commit -m ".gitignore is now working"
- git push origin master

#### see latest diffs / changes
- git diff

#### see latest diffs / changes (ignoring prettier changes!)
- `git diff -w --word-diff-regex=[^[:space:]] --color | grep --color=never -P '\e\[3[12]m'`

#### get current commit hash (outputs: 6e559cb)
- git rev-parse --short HEAD
- git log --pretty=format:'%h' -n 1

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

#### pull interactive rebased history on production / other server
- git fetch origin
- git reset --hard origin/main # replace main with branch

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

### show status in pretty/short format
- git status -sbu

### show changed files in absolute path
- git -C /var/www/html/foo/bar/ status

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

#### option 1
- `git config --global alias.clone-branches '! git branch -a | sed -n "/\/HEAD /d; /\/master$/d; /remotes/p;" | xargs -L1 git checkout -t'`
- `git clone-branches`
- `git checkout master` (or main)

#### option 2
- `git clone --mirror git@github.com:foo/bar.git ./.git`
- `git config --bool core.bare false`
- `git checkout master` (or main)




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
- git checkout -- . # discard all modified files
- git checkout -- # preview of the command above
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
- git flow feature start

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

## backup git repository

- backup: `git bundle create repo.bundle --all`
- restore: `git clone repo.bundle`

## migrate / copy whole git repository
- `git clone --mirror git@gitlab.com:vielhuber/old.git .`
- `git remote set-url origin git@gitlab.com:vielhuber/new.git`
- `git push --mirror`
- set the default branch via web interface if necessary (e.g. gitea only detects `main` as a default branch but not `master`)

## cleanup history

### solutions
- `git filter-repo` (does delete remotes: https://htmlpreview.github.io/?https://github.com/newren/git-filter-repo/blob/docs/html/git-filter-repo.html#INTERNALS)
- `bfg` (has problems with paths: https://github.com/rtyley/bfg-repo-cleaner/issues/187)
- `git filter-branch` (is officially not recommended: https://git-scm.com/docs/git-filter-branch#SAFETY)

### analyze
- `git filter-repo --analyze && cat .git/filter-repo/analysis/directories-all-sizes.txt`
- `git-sizer --verbose`
  
### remove data

#### prerequisites / requirements
- all files that should be removed from history need to be already removed from `HEAD` (`git rm -rf --cached ...`) and ignored in `.gitignore`
- you should have backuped your local working repo with `git bundle create repo.bundle --all`

#### same vs. new repo
- pushing the reduced size to the same repo can be difficult
- `git filter-repo` therefore removes remotes and recommends adding a new fresh repository
- read more for the reasons here: https://htmlpreview.github.io/?https://github.com/newren/git-filter-repo/blob/docs/html/git-filter-repo.html#DISCUSSION
- however, it's possible to push to the same repo

#### other developers / testing / production
- for all distributed copies of the repo, you will need to request they do a pull with rebasing
- if a user with their own local copy of the repository did a simple `git pull && git push`, this would result in the big files being reintroduced into the central repository
- options:
  - poor man's fresh clone
    - `rm -rf .git && git clone ... temp && mv temp/.git ./.git && rm -rf temp`
    - if modified files are present now, discard or push them
      - `git checkout -- .` or `git add -A . && git commit -m "Push obscure file changes." && git push`
  - start from scratch
    - `rm -rf repo && git clone xxx .`
  - ugly pull with rebase
    - `git pull -r`: 
    - the user still has the big repo size locally, but count potentially reintroduce the wrong (bigger) history

#### gitea (same/new repo)
- `mkdir tmp-repo`
- `cd tmp-repo`
- `git clone git@git.tld.com:foo/bar.git .`
- `cp .git/config /tmp/config-backup`
- `git filter-repo --invert-paths --path path/to/exclude/ --path another/path/to/exclude/` # exclude files with `git filter-repo --invert-paths --path-glob '*.blend'`
- option 1: same repo
  - `mv /tmp/config-backup .git/config`
  - `git push origin --mirror`
  - login on the remote command line and run in the repo-folder
    - `sudo -u git git reflog expire --expire=now --all`
    - `sudo -u git git gc --aggressive --prune=now` 
  - if you face memory limit issues, modify the git configuration
    - `sudo -u git git config --global pack.windowMemory "100m"`
    - `sudo -u git git config --global pack.packSizeLimit "100m"`
    - `sudo -u git git config --global pack.threads "1"`
  - check size locally: `git gc && git count-objects -vH`
  - check size remotely: https://git.tld.com/foo/bar (if in web ui the size does not change, make a slight modification to a file and push again normally)
- option 2: new repo
  - `git remote add origin git@git.tld.com:foo/bar-new.git`
  - `git push origin --force --all`
  - check size locally: `git gc && git count-objects -vH`
  - check size remotely: https://git.tld.com/foo/bar
- `cd ..`
- `rm -rf tmp-repo`
  
#### github (same/new repo)
- https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/removing-sensitive-data-from-a-repository
- `mkdir tmp-repo`
- `cd tmp-repo`
- `git clone git@github.com:foo/bar.git .`
- `cp .git/config /tmp/config-backup`
- `git filter-repo --invert-paths --path path/to/exclude/`
- option 1: same repo
  - `mv /tmp/config-backup .git/config`
  - `git push origin --force --all`
  - check size locally: `git gc && git count-objects -vH`
  - check size remotely: latest after ~24 hours at https://github.com/settings/repositories (if it is a repo of an organization, first add your private account to https://github.com/foo/bar/settings/access)
- option 2: new repo
  - `git remote add origin git@github.com:foo/bar-new.git`
  - `git push origin --force --all`
  - check size locally: `git gc && git count-objects -vH`
  - check size remotely: https://github.com/settings/repositories
- `cd ..`
- `rm -rf tmp-repo`

#### gitlab (same repo)
- https://docs.gitlab.com/ee/user/project/repository/reducing_the_repo_size_using_git.html
- `mkdir tmp-repo`
- `cd tmp-repo`
- option 1: same repo
  - `Settings` > `General` > `Advanced` > `Export project` > download `tar.gz` file into `tmp-repo`
  - `tar xzf 20*.tar.gz`
  - `git clone --bare --mirror project.bundle`
  - `cd project.git`
  - `git filter-repo --invert-paths --path path/to/exclude/`
  - `cp ./filter-repo/commit-map /tmp/commit-map-1`
  - copying the commit-map has to be done after *every* single command from git filter-repo (you need the `commit-map` files later)
  - `git remote remove origin`
  - `git remote add origin git@gitlab.com:foo/bar.git`
  - `Settings` > `Repository` > `Protected branches`/`Protected branches` > enable `Allowed to force push` to `main`/`master`
  - `git push origin --force 'refs/heads/*'`
  - `git push origin --force 'refs/tags/*'`
  - `git push origin --force 'refs/replace/*'`
  - `Settings` > `Repository` > `Protected branches`/`Protected branches` > disable `Allowed to force push` to `main`/`master`
  - `date` – wait 30 minutes (😱) – `date`
  - `Settings` > `Repository` > upload `/tmp/commit-map-X`
  - `date` – wait 5 minutes (😱) – `date`
  - check size locally: `git gc && git count-objects -vH`
  - check size remotely: `Settings` > `Usage Quotas`
- option 2: new repo
  - `git clone git@gitlab.com:foo/bar.git .`
  - `git filter-repo --invert-paths --path path/to/exclude/`
  - `git remote add origin git@gitlab.com:foo/bar-new.git`
  - `Settings` > `Repository` > `Protected branches`/`Protected branches` > enable `Allowed to force push` to `main`/`master` 
  - `git push origin --force --all`
  - `Settings` > `Repository` > `Protected branches`/`Protected branches` > disable `Allowed to force push` to `main`/`master`
  - check size locally: `git gc && git count-objects -vH`
  - check size remotely: `Settings` > `Usage Quotas`
- `cd ..`
- `rm -rf tmp-repo`

### git lfs

#### client installation
- ```sudo apt-get install git-lfs```

#### server installation
- gitea: the following is already default! only check..
- ```nano /etc/gitea/app.ini```
  - ```[server]```
  - ```LFS_START_SERVER = true```
  - ```[lfs]```
  - ```PATH = /home/gitea/data/lfs```

#### activate lfs in existing repo (with existing files, with no lfs)
- ```git lfs install```
- ```git lfs track "*.blend"```
- ```git lfs track "*.blend1"```
- ```git add .gitattributes```
- ```git commit -m "Added .gitattributes file/lfs."```
- ```git push```

#### working now is completely normal
- pushing indicates, that lfs objects are stored
- also gitea shows when clicking on the file, that this is a lfs file
- ```git add -A . && git commit -m "." && git push origin HEAD```