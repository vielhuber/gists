DB_host=host
DB_user=username
DB=database
DIR=directory
DB_pass=password

tbl_count=0
for t in $(mysql -NBA -h $DB_host -u $DB_user -p$DB_pass -D $DB -e 'show tables') 
do 
    echo "DUMPING TABLE: $DB.$t"
    mysqldump -h $DB_host -u $DB_user -p$DB_pass $DB $t > $DIR/$DB.$t.sql
    tbl_count=$(( tbl_count + 1 ))
done