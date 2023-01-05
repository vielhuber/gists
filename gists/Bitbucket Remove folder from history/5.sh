echo /foo/ >> .gitignore
git rm -rf --cached foo/
git add -A .
git commit -m "removed /foo/ from git history"
git push origin master