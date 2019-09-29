## local => remote
```
rsync -rltDvze "ssh" /local/folder/ user@tld.com:/remote/folder
rsync -ave "ssh" /local/folder/ user@tld.com:/remote/folder
```
### omit the "/" after folder to create the folder remotely
```
rsync -ave "ssh" /local/folder user@tld.com:/remote/folder
```

## remote => local
```
rsync --delete -ahvzP --stats -e "ssh -i C:\Users\David\.ssh\id_rsa" user@tld.com:/remote/folder/ /local/folder
```

### without status (only summary)
```
rsync --delete -azh --stats -e "ssh -i C:\Users\David\.ssh\id_rsa" user@tld.com:/remote/folder/ /local/folder
```
### ignoring strict checks
```
rsync --delete -ahvzP --stats -e "ssh -o StrictHostKeyChecking=no -i C:\Users\David\.ssh\id_rsa" user@tld.com:/remote/folder/ /local/folder
```

## more options

-v: be verbose
--dry-run: don't copy in reality
--progess: shows progress
--stats: shows stats
--delete: deletes files in target that do not exist in source