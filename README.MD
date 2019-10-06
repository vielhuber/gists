# 📝 gists 📝

this is a synced repo of all public github gists.

the two main purposes are backup and activity signals on the main github account.

you can use this script also for your own purposes.

### installation

```bash
mkdir gists
cd gists
# make a fresh repo on github and clone it
git clone https://github.com/foo/bar .
# fetch the sync script
wget https://github.com/vielhuber/gists/archive/master.zip .
unzip master.zip -d .
cp -r ./gists-master/* .
cp .env.example .env
# edit your personal access token with the scope "gist" which can be obtained here:
# https://github.com/settings/tokens/new
nano .env
rm -rf gists-master gists README.MD master.zip .env.example
composer install
```

### usage (manually or via cron)

```bash
git pull
php _sync.php
git add -A .
git commit -m "last update on `date +'%Y-%m-%d'`"
git push origin HEAD
```
