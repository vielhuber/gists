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

# show running processes
ps aux
ps aux | grep 1337| grep -v grep # search for pid
ps aux | grep 1337 | grep -v grep | wc -l # see if process is running

# kill all processes of type
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

# append to file
sed -i '$ a\some text' file.txt # unix
sed -i '$ a\'$'\n'' some text' file.txt # universal
echo "some text" >> file.txt

# prepend to file
sed -i '1s;^;some text;' file.txt

# search replace multiple strings in file
sed -i -e 's/foo/bar/g' -e 's/gna/gnarr/g' -e 's/abc/cde/g' file.txt

# sed inplace editing
sed -i -e 's/foo/bar/' target.file # unix
sed -i'' -e 's/foo/bar/' target.file # unix
sed -i '' -e 's/foo/bar/' target.file # mac os

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

# copy contents of one folder to another folder (recursively)
cp -r /folder1/. folder2/

# copy folder1 to folder2
cp -r folder1 folder2/

# copy contents of subfolder in current folder
cp -r ./subfolder/. .

# copy contents of one folder to another folder (excluding one specific folder)
rsync -a --info=progress2 ~/source/ ~/target --exclude excludedfolder


# delete folder recursively
rm -rf folderName

# delete all files in folder recursively
rm -rf foldername/* foldername/.*

# get size of current folder
du -hs

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

# get general quotas
df -h

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

# show calendar
cal -3 -y

# find files by extension
find . -name '*.php'

# find files by extension (case insensitive)
find . -iname '*.php'

# find files by extensions
find . -iregex '.*\.\(jpg\|gif\|png\|jpeg\)$'
find . \( -iname '*.jpg' -o -iname '*.png' \)

# find files by name (and suppress permission denied errors)
find / -type f -name "authorized_keys" 2>/dev/null

# find files by name in current directory
find . -name "foo*"

# recursively files that contain text
grep --include=*.php -rnw "/full/path/" -e "your text"
grep --include=*.php -rnwl "/full/path/" -e "your text" # only show filenames

# find files (and exclude specific folder)
find . -name '*.js' -not -path './node_modules/*'
find . -type f | egrep -v "folder1|folder2"

# find files with extensions and copy to folder
find /source/folder -name '.otf' -o -name '.ttf' -exec cp {} /target/folder/ \;

# zip current directory
zip -r file.zip .

# zip directory without compression (only store)
zip -r -0 file.zip .

# zip directory with default compression
zip -r -6 file.zip .

# zip directory with best compression (most cpu usage)
zip -r -9 file.zip .

# zip folder
zip -r file.zip path/to/folder

# zip folder (and hide paths)
zip -j -r output.zip path/to/folder/

# zip multiple folders
zip -r output.zip folder1/ folder2/ folder3/

# zip file with password
zip --password SECRET output.zip input.txt

# zip file with date
zip -r "backup-$(date +"%Y-%m-%d").zip"

# zip file and exclude folders and files
zip -r file.zip . -x \*"vendor/"\* -x \*"node_modules/"\* -x \*".git/"\* -x \*"filename-in-any-folder"\* -x "explicit-filename-in-root-folder" -x "folder/explicit-filename"

# zip all files found with find (preserving directory structure)
find . -name 'foo' -print | zip file.zip -@

# zip folder with only certail filetype
zip -r file.zip path/to/folder/ -i '*.php' '*.html'

# zip folder with only certail filetype (case insensitive)
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


# set permissions (the correct way)
chmod 755 /path/to/folder # only for folder itself, not recursively for all folders AND files
chmod 644 /path/to/file
find /path/to/folder -type d -exec chmod 755 {} \; # then for all subfolders
find /path/to/folder -type f -exec chmod 644 {} \; # then for all files

# owner/user/group
ls -l /path/to/file # fetch user and group of file
chown -R username /path
chown -R username:group /path

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
df -h # in total
df -k . # for current folder
df -k /folder # for specific folder
du -d 1 -xh /folder 2>/dev/null | sort -h -r # show all big folders
find . -type f -printf "%s\t%p\n" | sort -n | tail -10 # show all big files
du -d 1 -xh . 2>/dev/null | sort -h -r # same as above only for current folder
ls -haltrS # show contents of folder sorted by size
du -sh folder/ # show size of folder

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

# recursively search and replace file contents
find . -type f -name "*.txt" -print0 | xargs -0 sed -i '' -e 's/foo/bar/g'

# show last entries (10 lines) of file
tail -10 path/to/file.log
tail -f path/to/file.log # live updates
tail -f path/to/file.log | grep "string to match" # live updates and filtering