cd ~/dump/

for x in `mysql --skip-column-names -h 127.0.0.1 --port 3307 -u username -ppass dbname -e 'show tables;'`; do
     mysql5dump -h 127.0.0.1 --port 3307 -u username -ppass dbname $x > "$x.sql"
done

zip -R dump.zip '*.sql'

rm *.sql