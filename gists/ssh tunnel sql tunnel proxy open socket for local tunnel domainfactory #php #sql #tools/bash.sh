# mysql via unix-socket (local 5001 goes to remote socket)
ssh -o UserKnownHostsFile=/dev/null -o TCPKeepAlive=yes -o StrictHostKeyChecking=no -i ~/.ssh/id_rsa -l ssh-username -TNL 5001:/var/lib/mysql/mysql.sock host.tld

# mysql via tunnel (local 5001 goes to remote 3306)
ssh -o UserKnownHostsFile=/dev/null -o TCPKeepAlive=yes -o StrictHostKeyChecking=no -i ~/.ssh/id_rsa -l ssh-username -TNL 5001:127.0.0.1:3306 host.tld

# then connect via localhost:5001 to mysql db