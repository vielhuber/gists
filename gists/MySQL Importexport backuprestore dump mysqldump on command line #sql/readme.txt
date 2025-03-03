// export
mysqldump -h localhost --port 3306 -u username -p"password" --routines database > dump.sql

// import
mysql -h localhost --port 3306 -u username -p"XXX" --default-character-set=utf8 database < dump.sql

// import with progress
pv dump.sql | mysql -h localhost --port 3306 -u username -p"XXX" --default-character-set=utf8 database

// note when using passwords with "$": escape passwords needed
mysql -p "ugly\$password"

// on windows, these tools can be found in
cd C:\Program Files\MySQL\MySQL Server 5.6\bin

// options of mysql
--force: force import (ignore/skip errors)
--default-character-set: always choose "utf8mb4"

// options of mysqldump
--no-tablespaces: don't include tablespaces
--skip-add-locks: don't surround statements with locks
--skip-add-drop-table: don't add drop table statements
--skip-comments: don't include comments
--no-create-info: only data (no schema)
--no-data: only schema (no data)
--extended-insert=false: one insert statement per line
--disable-keys=false: don't surround statements with disable keys
--quick: useful for dumping large tables
--all-databases: dump all databases
--lock-all-tables: locks all tables at once. good when "too many open files" error appears
--set-gtid-purged=OFF: set this if the source database is part of a replication system
--ignore-table=dbname.tblname: set this if you want to exclude a certain table
--single-transaction: set this, if you don't have full access to lock tables
--routines: export procedures and functions (this is false by default)
--triggers: export triggers (this is true by default)
--skip-triggers: don't include triggers
--default-character-set: always choose "utf8mb4"

// exclude data from specific table (but get schema)
  // option 1 (preferred)
  mysqldump --no-data --skip-triggers dbname > dump.sql
  mysqldump --no-create-info --ignore-table=dbname.tblname dbname >> dump.sql
  // option 2 (not good)
  mysqldump --ignore-table=dbname.tblname dbname > dump.sql
  mysqldump --no-data dbname tblname >> dump.sql

// restore single database from big file dumped with --all-databases
// download https://github.com/kedarvj/mysqldumpsplitter
sh mysqldumpsplitter.sh --source backup.sql --extract DB --match_str database-name

// suppress warning "Warning: Using a password on the command line interface can be insecure."
file_put_contents('my.cnf','[client]'.PHP_EOL.'user = root'.PHP_EOL.'password = root'.PHP_EOL.'host = localhost');
exec('mysqldump --defaults-extra-file=myo.cnf --port 3306 database > dump.sql');
exec('mysql --defaults-extra-file=myo.cnf --default-character-set=utf8 database < dump.sql');
unlink('my.cnf');

// since mysql 5.7/8.0.21 accessing the information_schema.files table now requires the process privilege.
// most providers don't have this option available. This results in the error message:
// Error: 'Access denied; you need (at least one of) the PROCESS privilege(s) for this operation' when trying to dump tablespaces
// to prevent that, add
--no-tablespaces

// if errors with "NO_AUTO_CREATE_USER" appears, simply replace all occurences of that string with "" and reimport

// speed up even more
https://serverfault.com/a/568465/442998
https://dba.stackexchange.com/a/83385/188169