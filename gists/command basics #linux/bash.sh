# multiple commands
- A; B    # run A and then B, regardless of success of A
- A && B  # run B if and only if A succeeded
- A || B  # run B if and only if A failed
- A &     # run A in background
- { A && B; } || { C && D; }      # run A and B if A succeeded; if A or B failed, run C and D if C succeeded

# autorun scripts
- /etc/profile (systemwide, always run)
- ~/.bash_profile => ~/.bash_login => ~/.profile (personal, run first found on login shells; that means if you login on local machine or via ssh)
- ~/.bashrc (run for interactive non login shells; that means if you are already logged in and open a terminal window)
- ~/.bash_logout (run on logout)

# . and ..: name-inode maps
- .: referring to the directory itself
- ..: referring to the parent directory
- its good practice to always use ./file or ./folder/ instead of file and folder/

# clear console
Ctrl+L
cls
clear

# show history of commands
history

# show path of program
which node

# run bash script inline
echo $(ls)

# show running processes
ps aux
ps aux | grep 1337| grep -v grep # search for pid
ps aux | grep 1337 | grep -v grep | wc -l # see if process is running

# kill all processes of type / name
killall -KILL php

# search history of commands
history | grep command-name

# show lines in nano
nano -c file

# root
su # permanently get root (su = switch user, if an username is omitted, you are switching to root; you have to provide the password of the root user)
sudo command # do a command with root privileges (you have to enter the password of the current user which has root privileges, once for 15 minutes)
sudo su # runs a new shell as root (first sudo asks for your password and if you have root privileges runs su as a super-user)

# cd and enter folder
mkdir ~/folder && cd "$_"

# clear file
> file.txt
echo "" > file.txt

# replace file
echo "foo" > file.txt

# append to file
sed -i '$ a\some text' file.txt # unix
sed -i '$ a\'$'\n'' some text' file.txt # universal
echo "some text" >> file.txt

# prepend to file
sed -i '1s;^;some text;' file.txt

# search replace multiple strings in file
sed -i -e 's/foo/bar/g' -e 's/gna/gnarr/g' -e 's/abc/cde/g' file.txt

# sed inplace editing
sed -i -e 's/foo/bar/g' target.file # unix
sed -i'' -e 's/foo/bar/g' target.file # unix
sed -i '' -e 's/foo/bar/g' target.file # mac os
sed -i '' -e 's/escaped\.dot\.and\.[(]brackets[)]/bar/g' target.file # escape normally with "\", but "(" needs to be surrounded with "[]"

# sed new line (unix/mac)
sed -e 's/ /\'$'\n/g' # universal
sed -e 's/ /\n/g' # unix
sed -e 's/ /\\\n/g' # mac os

# add to PATH
   
  # variant 1
  sudo nano /etc/environment
  # add it (e.g. change PATH="/path1:/path2" to PATH="/path1:/path2:/path3" 
  source /etc/environment && export PATH
  
  # variant 2
  sudo nano ~/.bashrc
  # add it (e.g. change PATH="/path1:/path2" to PATH="/path1:/path2:/path3" 
  source ~/.bashrc && export PATH
  
  # variant 3 (only works for files, not folders)
  sudo ln -s /source/path/to/foobar /usr/local/bin/foobar

# list all files in folder (in [h]uman readable format, list [a]ll, [l]ist details, [tr] order by time)
ls -haltr

# merge / concat all files in folder
cat * > merged-file

# print lines that contain text
grep 'foo' file

# remove n chars from every line
cut -c11- file > file2 # remove 10 chars

# copy file
cp file1 file2

# copy contents of one folder to another folder (recursively)
cp -r /folder1/. folder2/

# copy folder1 to folder2 (-T is needed, if folder2 exists already)
cp -r -T ./folder1 ./folder2/

# copy contents of subfolder in current folder
cp -r ./subfolder/. .

# copy contents of current folder to subfolder
rsync -Rr . ./subfolder/

# copy contents of one folder to another folder (excluding one specific folder)
rsync -a --info=progress2 ~/source/ ~/target --exclude excludedfolder

# delete folder recursively
rm -rf folderName

# delete all files in folder recursively
rm -rf foldername/* foldername/.*

# delete all files and folders in current folder
find ./ -mindepth 1 -delete # best approach
rm -rf ./{*,.*} # productes ugly warnings about "." and ".."

# get size of current folder
du -hs

# rename/move folder/file
mv folder_old folder_new
mv file_old file_new

# move all elements in folder one level up (including dotfiles)
cd folder
mv subfolder/{.[!.],}* .

# move all elements in folder one level up
cd folder
mv subfolder/* subfolder/.[^.]* .

# move all elements from current folder to target folder
shopt -s dotglob # match hidden files
cd folder
mv * /another/folder/

# move all elements in current folder to subfolder
mkdir subfolder
shopt -s extglob dotglob
mv !(subfolder) subfolder
shopt -u dotglob

# reverse order of all files in current folder
for i in *; do mv "$i" "old-$i"; done; ls --color=never -v | tac | sed -e 's/^old-//' | paste <(ls --color=never -v) - | sed -e 's/^/mv /' | bash

# pipe to clipboard
sudo apt-get install xclip
echo "foo" | xclip
cat ~/.ssh/id_rsa.pub | xclip

# rename umlauts in files
sudo apt-get install detox
detox -nrv -s utf_8 /path/to/folder

# reboot
reboot
shutdown -r now
/sbin/reboot

# shutdown
shutdown -h now

# show current directory path
pwd

# show current user
whoami

# switch user
su -s /bin/bash customuser

# show calendar
cal -3 -y

# find files by extension
find . -name '*.php'

# find files by extension (case insensitive)
find . -iname '*.php'

# find folder
find . -type d -name 'foo'

# find files by extensions
find . -iregex '.*\.\(jpg\|gif\|png\|jpeg\)$'
find . \( -iname '*.jpg' -o -iname '*.png' \)

# find files by name (and suppress permission denied errors)
find / -type f -name "authorized_keys" 2>/dev/null

# find files and folders by name in current directory
find . -name "foo*"
find . -name ".git"

# find all hidden files in current directory
find . -name ".*" -print

# recursively files that contain text
grep --include=*.php -rnw "/full/path/" -e "your text"
grep --include=*.php -rnwl "/full/path/" -e "your text" # only show filenames
grep --include=*.php --exclude-dir="node_modules" -rnw "/full/path/" -e "your text" # exclude folder

# find files (and exclude specific folder)
find . -name '*.js' -not -path './node_modules/*'
find . -type f | egrep -v "folder1|folder2"

# find files with extensions and copy to folder
find /source/folder -name '.otf' -o -name '.ttf' -exec cp {} /target/folder/ \;

# find files that changed in the last hour
find . -newermt '1 hour ago' -type f -print

# find last changed files
find . -type f -printf '%TY-%Tm-%Td %TH:%TM: %Tz %p\n'| sort -n | tail -n10

# zip current directory
zip -r file.zip .

# zip specific file
zip file.zip file.txt

# zip directory without compression (only store)
zip -r -0 file.zip .

# zip directory with default compression
zip -r -6 file.zip .

# zip directory with best compression (most cpu usage)
zip -r -9 file.zip .

# zip folder
zip -r file.zip path/to/folder/

# zip folder (and hide paths)
zip -j -r output.zip path/to/folder/

# zip multiple folders
zip -r output.zip folder1/ folder2/ folder3/

# zip file with password
zip --password SECRET output.zip input.txt

# zip file with date
zip -r "backup-$(date +"%Y-%m-%d").zip"

# zip file and exclude folders and files
zip -r file.zip . -x \*"vendor/"\* -x \*"node_modules/"\* -x \*".git/"\* -x \*"wp-content/uploads/"\* -x \*"wp-content/cache/"\*
zip -r file.zip . -x \*"filename-in-any-folder"\* -x "explicit-filename-in-root-folder" -x "folder/explicit-filename"

# zip and log errors (files that are not readable)
zip -r file.zip . &>> file.zip.log
cat file.zip.log # full log
grep "zip warning" file.zip.log # error log

# zip all files found with find (preserving directory structure)
find . -name 'foo' -print | zip file.zip -@

# zip folder with only certain filetype
zip -r file.zip path/to/folder/ -i '*.php' '*.html'

# zip folder with only certain filetype (case insensitive)
find . \( -iname '*.jpg' -o -iname '*.png' \) -print | zip file.zip -@

# delete file with shifted date (for rotation)
rm -f "backup-$(date --date="6 months ago" +"%Y-%m-%d").zip"

# unzip file
unzip output.zip -d /path/to/folder

# unzip file in current folder
unzip output.zip -d .; rm -f output.zip

# unzip specific subfolder
unzip output.zip 'subfolder/to/extract/*' -d .

# unzip quietly and update files/folders if exists
unzip -uq output.zip -d /path/to/folder

# tar compress folder
tar -cf output.tar /path/to/folder # quiet and no compression
tar -czvf output.tar.gz /path/to/folder
tar -czvf output.tar.gz /path/to/folder1 /path/to/folder2

# untar uncompress file
tar -xf output.tar
tar -xzvf output.tar.gz
tar -xzvf output.tar.gz -C /path/to/target
tar -xvjf output.tar.bz2

# show permissions
ls -l file
stat -c "%a %n" file
ls -ld folder
stat -c "%a %n" folder

# set permissions
- chmod u=rwx,g=rwx,o=rwx file
- chmod 777 file
- chmod o+rwx file # add rwx rights to others group
- chmod +x file # add execution rights to all groups (same as chmod a+x file)

# allow script to be run as root from another user
- EDITOR=nano sudo -E visudo
- customuser ALL=(ALL) NOPASSWD: /path/to/script.sh

# file permissions explained
- Files and folders belong to a user (he is the owner).
- Files and folders are assigned to a group.
- The owner does not necessarily have to be part of the group.
- All users that are not owners or belong to the assigned group are treated with the others class.
- It is checked in descending order if a user is the user/owner, then if it belongs to the group, otherwise it is others.
- Only the owner and root (super user) are allowed to the change the permission of a file or directory.
- Only root (super user) is allowed to change the ownership (user/group) a file or directory (Exception: The owner of a file can change the group ownership of that file if the user is member of the new group)

ABCDEFGHIJ 
A: file type (- file, d dir, i link)
B: file permission of owner/user (r = read, - = no read)
C: file permission of owner/user (w = write, - = no write)
D: file permission of owner/user (e = execute, - = no execute)
E: file permission of group (r = read, - = no read)
F: file permission of group (w = write, - = no write)
G: file permission of group (e = execute, - = no execute)
H: file permission of other users (r = read, - = no read)
I: file permission of other users (w = write, - = no write)
J: file permission of other users (e = execute, - = no execute)

# setuid / setgid / sticky bit
- the first bit in octal notation is often omitted ("0")
- be aware: chmod 0755 does not clear the first bit (on linux); fix: add a double zero!
- setuid (4/s)
  - files with this bit can be executed with the privileges of the file\'s owner (must be used carefully only in spoecial cases)
- setgid (2/s)
  - files with this bit can be executed with the privileges of the file\'s group (must be used carefully only in spoecial cases)
  - folders with this bit have the property, that all newly created files and folders within this folder inherit the group from that directory (and not the group of the creator as it is by default)
- sticky bit (1/t)
  - folders with this bit have the property, that all files or folders inside this folder can only be moved or deleted by the owner of this directory (and not by other users that have access)

# convert permission in human readable format to octal format
- r = 4
- w = 2
- x = 1
- - = 0
- (B+C+D)(E+F+G)(H+I+J)
- example: 770 <=> -rwerwe---

# owner/user/group
ls -l /path/to/file # fetch user and group of file
chown -R username /path # change owner
chown -R username:group /path # change owner and group
chown -R username: /path # change owner and set group to users login group
chown -R :group /path # change group
chgrp -R group /path # change group

# reset permissions for /var/www (the correct way)
chown -R root:root /var/www
chmod 00755 /var
chmod 00755 /var/www # only for folder itself, not recursively for all folders AND files
find /var/www -type d -exec chmod 00755 {} \; # then for all subfolders
find /var/www -type f -exec chmod 00644 {} \; # then for all files

# create a symlink
ln -s /path/to/folder /path/to/symlink

# create (or update if exists) a symlink
ln -sf /path/to/folder /path/to/symlink

# remove a symlink (used without trailing slash!)
rm /path/to/symlink


# append to file
echo 'string to append' >> path/to/file.txt

# prepend to file
echo -e "string to prepend\n$(cat path/to/file.txt)" > path/to/file.txt

# clear font cache
sudo fc-cache -f -v

# disk space
du -sh folder/ # show size of folder in human readable format
du -sh . --exclude .git --exclude node_modules # exclude some subfolders
df . # show in which device a folder is located
df -h # in total
df -k . # for current folder
df -k /folder # for specific folder
du -d 1 -xh /folder 2>/dev/null | sort -h -r | head -10 # show all big folders
find . -type f -printf "%s\t%p\n" | sort -n | tail -10 # show all big files
du -d 1 -xh . 2>/dev/null | sort -h -r | head -10 # same as above only for current folder
ls -haltrS # show contents of folder sorted by size
find . -type f -newermt '1 month ago' -exec du -ch {} + | grep total$ # sum of filesize found with find (files newer than 1 month)
find . -type f -newermt '1 month ago' -exec du -cb {} + | grep total$ | cut -f1 | paste -sd+ - | bc # more accurate
find . -name "node_modules" -type d -prune -exec du -ch {} + | grep total$ # find all node_modules folders sorted by size
ncdu # install before with "sudo apt-get install ncdu"
ncdu --exclude /mnt

# count
find . -type f | wc -l # count number of files in current folder
find . -type d | wc -l # count number of folders in current folder
find . -type d -empty | wc -l # count number of empty folders in current folder
find . -type f | egrep -v ".git|node_modules" | wc -l # count number of files in current folder and exclude some subfolders
grep -o -i string file | wc -l # count occurence of string in file

# count all files and all lines of code in folder recusively #linux
find . -name '*.php' | xargs wc -l
find . -name '*.*' -not -path './node_modules/*' | xargs wc -l

# find and delete
find . -name "foo" -delete # delete files with name "foo"
find . -type d -empty -delete # delete empty folders
find . -name "node_modules" -type d -prune -exec rm -rf {} \; # delete all folders recursively with name
find /tmp -type f -atime +10 -delete # clean up tmp directory (delete all files older than 10 days)

# recursively search and replace file contents
find . -type f -name "*.txt" -print0 | xargs -0 sed -i -e 's/foo/bar/g' # linux
find . -type f -name "*" -print0 | xargs -0 sed -i -e 's/foo/bar/g' -e 's/gna/gnarr/g' -e 's/abc/cde/g' # in all files and multiple replacements (case sensitive)
find . -type f -name "*.txt" -print0 | xargs -0 sed -i '' -e 's/foo/bar/g' # mac
find . -type f -name "*.php" -print0 | xargs -0 sed -i -e '/\/\* @BEGINSTRIP \*\//,/\/\* @ENDSTRIP \*\//d' # strip all content between /* @BEGINSTRIP */ and /* @ENDSTRIP */ inside all php files

# recursively search and replace files and directory names
find . -type d -name "*" -print0 | xargs -0 rename 's/foo/bar/g' {} # this must be done first!
find . -type f -name "*" -print0 | xargs -0 rename 's/foo/bar/g' {} # this afterwards

# show last entries (10 lines) of file
tail -10 path/to/file.log
tail -f path/to/file.log # live updates
tail -f -n 30 path/to/file.log # live updates (with last 30 lines)
tail -f path/to/file.log | grep "string to match" # live updates and filtering

# ip / networking
ip
ip route show
ip address show
ip -4 address show
ip -color address show
ip -6 address show
ip -6 route show
ip -stats -human link show