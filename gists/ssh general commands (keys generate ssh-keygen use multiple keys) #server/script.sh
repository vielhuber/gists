# basic
ssh-keygen -t rsa -C "david@close2.de"
cat ~/.ssh/id_rsa.pub

# more secure (RSA 4096)
ssh-keygen -t rsa -b 4096 -C "david@close2.de" -f ~/.ssh/id_rsa_4096
cat ~/.ssh/id_rsa_4096.pub

# use multiple keys on one client
nano ~/.ssh/config
IdentityFile ~/.ssh/id_rsa
IdentityFile ~/.ssh/id_rsa_4096

# use specific key on connect
ssh
   -o UserKnownHostsFile=/dev/null
   -o TCPKeepAlive=yes
   -o StrictHostKeyChecking=no
   -p 22
   -l ssh-w014ec4d
   -i ~/.ssh/id_rsa
   tld.com

# run command on connect
ssh tld.com -t \"echo 'rm /tmp/initfile; source ~/.bashrc; cd tld.com/; git status' > /tmp/initfile; bash --init-file /tmp/initfile\"\r",