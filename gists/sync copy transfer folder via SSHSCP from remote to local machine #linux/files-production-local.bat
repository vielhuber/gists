# copy from remote to local
scp -r -i "%UserProfile%\.ssh\id_rsa" username@host.de:/path/remotefolder/local.file /path/local.file
scp -r -i "%UserProfile%\.ssh\id_rsa" username@host.de:/path/remotefolder/* /path/localfolder
scp -r -i "%UserProfile%\.ssh\id_rsa" username@host.de:/path/remotefolder /path

# copy from local to remote
scp -r -i "%UserProfile%\.ssh\id_rsa" /path/local.file username@host.de:/path/remotefolder/local.file
scp -r -i "%UserProfile%\.ssh\id_rsa" /path/localfolder/* username@host.de:/path/remotefolder
scp -r -i "%UserProfile%\.ssh\id_rsa" /path username@host.de:/path

# ignore key checks
scp -o UserKnownHostsFile=/dev/null -o TCPKeepAlive=yes -o StrictHostKeyChecking=no