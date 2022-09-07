locale -a
sudo locale-gen de_DE
sudo locale-gen de_DE.UTF-8
sudo update-locale 
sudo service postgresql start

# variant 1
su postgres
createdb test --encoding="UTF8" --lc-collate="de_DE.UTF-8" --lc-ctype="de_DE.UTF-8" --template=template0

# variant 2
sudo -u postgres psql
CREATE DATABASE "test" ENCODING 'UTF8' LC_COLLATE = 'de_DE.UTF-8' LC_CTYPE = 'de_DE.UTF-8' TEMPLATE template0;
\q