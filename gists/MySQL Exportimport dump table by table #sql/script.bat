REM fetch
plink -ssh username@host -i "%UserProfile%\.ssh\putty_id_rsa.ppk" "./dump/script.sh"
plink -ssh username@host -i "%UserProfile%\.ssh\putty_id_rsa.ppk" "cat ~/dump/dump.zip" > "dump.zip"

REM unzip
mkdir dump
mv dump.zip dump
cd dump
unzip dump.zip

REM delete current db
cd ..
mysql -u root -p"root" -e "drop database `dbname`; create database `dbname`;"

REM restore
cd dump
for /r %%i in (*) do "../mysql.exe" -u root -p"root" dbname --default-character-set=utf8 < %%i

REM clean up
cd ..
plink -ssh username@host -i "%UserProfile%\.ssh\putty_id_rsa.ppk" "rm ~/dump/dump.zip"
cd dump
del *.sql
del dump.zip
cd ..
rmdir dump