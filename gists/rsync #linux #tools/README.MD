## remote => local

#### basic usage

```sh
rsync --delete -ahvzP --stats -e "ssh" user@tld.com:/remote/folder/ /local/folder
```

#### without status (only summary)

```sh
rsync --delete -azh --stats -e "ssh" user@tld.com:/remote/folder/ /local/folder
```
#### ignoring strict checks using custom id_rsa

```sh
rsync --delete -ahvzP --stats -e "ssh -o StrictHostKeyChecking=no -i ~/.ssh/id_rsa" user@tld.com:/remote/folder/ /local/folder
```

#### with windows mount

```sh
mkdir /path/to/local/mount
mount -t cifs //192.168.0.2/subfolder /path/to/local/mount -o username='FOO',password='BAR',domain='DOMAIN'
rsync --delete -ahvzP --stats /path/to/local/mount/some/path/on/remote/ /some//path/on/local
umount /path/to/local/mount
```

## local => remote

#### basic usage

```sh
rsync -rltDvze "ssh" /local/folder/ user@tld.com:/remote/folder
rsync -ave "ssh" /local/folder/ user@tld.com:/remote/folder
```
#### omit the "/" after folder to create the folder remotely

```sh
rsync -ave "ssh" /local/folder user@tld.com:/remote/folder
```

## local => local

#### basic usage

```sh
rsync -ah --progress /local/source/ /local/target
```

## more options

- `--no-perms --no-owner --no-group`: don't sync file permissions (this is quite important)
- `--verbose`: be verbose
- `--dry-run`: don't copy in reality
- `--progress`: shows progress (per file)
- `--info=progress2 --no-inc-recursive`: shows overall progress
- `--stats`: shows stats
- `--delete`: deletes files in target that do not exist in source
- `--exclude '*.jpg' --exclude '*.mp4'`: exclude (multiple) filetypes
- `--max-age=100`: syncs only files that are newer than 100 days