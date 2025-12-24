## copy from remote to local

```sh
scp -r -i "%UserProfile%\.ssh\id_rsa" username@host.de:/path/remotefolder/remote.file /path/localfolder/
scp -r -i "%UserProfile%\.ssh\id_rsa" username@host.de:/path/remotefolder/* /path/localfolder
scp -r -i "%UserProfile%\.ssh\id_rsa" username@host.de:/path/remotefolder /path/localfolder
```

## copy from local to remote

```sh
scp -r -i "%UserProfile%\.ssh\id_rsa" /path/local.file username@host.de:/path/remotefolder/remote.file
scp -r -i "%UserProfile%\.ssh\id_rsa" /path/localfolder/* username@host.de:/path/remotefolder
scp -r -i "%UserProfile%\.ssh\id_rsa" /path username@host.de:/path
```

## ignore key checks

```sh
scp -o UserKnownHostsFile=/dev/null -o TCPKeepAlive=yes -o StrictHostKeyChecking=no
```

## prevent override and copy from windows

```sh
mkdir -p /var/www/test
sudo find /var/www/test -exec sudo chattr +i {} +
scp -P 22 -i ~/.ssh/id_rsa -r username@host.de:/D:/path/to/folder/ /var/www/test
sudo find /var/www/test -exec sudo chattr -i {} +
```