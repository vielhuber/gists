[![GitHub Tag](https://img.shields.io/github/v/tag/vielhuber/gists)](https://github.com/vielhuber/gists/tags)
[![Code Style](https://img.shields.io/badge/code_style-psr--12-ff69b4.svg)](https://www.php-fig.org/psr/psr-12/)
[![License](https://img.shields.io/github/license/vielhuber/gists)](https://github.com/vielhuber/gists/blob/main/LICENSE.md)
[![Last Commit](https://img.shields.io/github/last-commit/vielhuber/gists)](https://github.com/vielhuber/gists/commits)

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
wget https://github.com/vielhuber/gists/archive/main.zip .
unzip main.zip -d .
cp -r ./gists-main/* .
cp .env.example .env
# edit your personal access token with the scope "gist" which can be obtained here:
# https://github.com/settings/tokens/new
nano .env
rm -rf gists-main gists README.MD main.zip .env.example
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
