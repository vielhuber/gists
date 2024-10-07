## local => remote
```
rsync -rltDvze "ssh" /local/folder/ user@tld.com:/remote/folder
rsync -ave "ssh" /local/folder/ user@tld.com:/remote/folder
```
#### omit the "/" after folder to create the folder remotely
```
rsync -ave "ssh" /local/folder user@tld.com:/remote/folder
```

## remote => local
```
rsync --delete -ahvzP --stats -e "ssh" user@tld.com:/remote/folder/ /local/folder
```

#### without status (only summary)
```
rsync --delete -azh --stats -e "ssh" user@tld.com:/remote/folder/ /local/folder
```
#### ignoring strict checks using custom id_rsa
```
rsync --delete -ahvzP --stats -e "ssh -o StrictHostKeyChecking=no -i ~/.ssh/id_rsa" user@tld.com:/remote/folder/ /local/folder
```

## local => local
```
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