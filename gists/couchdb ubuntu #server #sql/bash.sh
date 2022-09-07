# for debian 8 (jessie), run this:
echo "deb https://apache.bintray.com/couchdb-deb jessie main" | sudo tee -a /etc/apt/sources.list
sudo apt-get install curl
curl -L https://couchdb.apache.org/repo/bintray-pubkey.asc | sudo apt-key add -
sudo apt-get update

sudo apt-get install couchdb
- standalone
- bind_address: 0.0.0.0
- user admin password: "admin"

sudo service couchdb restart  

open port 5984 in firewall

http://IP:5984/_utils

Configuration > CORS > Enable CORS > All domains (*)

Datenbank anlegen