mysql.exe -uroot -p1234 -s -N -e "SHOW DATABASES" |
  for /F "usebackq" %%D in (`findstr /V "information_schema performance_schema"`)
    do mysqldump %%D -uroot -p1234 > S:\Backup\MySQL\%%D.sql