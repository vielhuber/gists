# at installation, install contrib package
sudo apt-get install postgresql-contrib

# run this command once
CREATE EXTENSION IF NOT EXISTS pgcrypto;

# then you can use the extension
SELECT digest('foo', 'sha1')::text;