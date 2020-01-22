# best practice: linux
nano ~/.pgpass
*:5432:*:username:password
chmod 0600 ~/.pgpass

# best practice: windows
edit %APPDATA%\postgresql\pgpass.conf
*:5432:*:username:password

# linux
PGPASSWORD="password" pg_dump --no-owner -h host -p port -U username database > file.sql

# windows
PGPASSWORD=password&& pg_dump --no-owner -h host -p port -U username database > file.sql

# alternative
pg_dump --no-owner --dbname=postgresql://username:password@host:port/database > file.sql

# restore
psql --set ON_ERROR_STOP=on -U postgres -d database -1 -f file.sql
pg_restore --no-privileges --no-owner -U postgres -d database --clean file.sql # only works for special dumps

# backup exluding table
pg_dump --no-owner -h 127.0.0.1 -p 5432 -U username --exclude-table=foo database > tmp.sql

# backup including table
pg_dump --no-owner -h 127.0.0.1 -p 5432 -U username --table=foo database > tmp.sql

# backup and restore
PGPASSWORD=password && pg_dump --no-owner -h 127.0.0.1 -p 5432 -U username database > tmp.sql
psql -U postgres -d database -c "drop schema public cascade; create schema public;"
psql --set ON_ERROR_STOP=on -U postgres -d database -1 -f tmp.sql
rm tmp.sql

# if you need to remove unintentionally backuped owners afterwards
sed -i.bak '/OWNER TO specialowner/d' input.sql