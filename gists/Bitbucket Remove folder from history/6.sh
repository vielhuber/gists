cd ..
wget http://repo1.maven.org/maven2/com/madgag/bfg/1.12.15/bfg-1.12.15.jar
mkdir testrepo-clean
git clone --mirror git@bitbucket.org:vielhuber/testrepo.git testrepo-clean
java -jar bfg-1.12.15.jar --delete-folders foo testrepo-clean
cd testrepo-clean
git reflog expire --expire=now --all && git gc --prune=now --aggressive
git push
cd ..
rm -rf testrepo-clean.bfg-report
rm bfg-1.12.15.jar