### installation

`npm i -g npm-check-updates`

### update

`npm update -g npm-check-updates`

### remove

`npm uninstall -g npm-check-updates`

### installation (for legacy node versions)

`npm i -g npm-check-updates@16.14.20`

### fix conflicts with cuda alias

- `sudo nano ~/.bashrc`
- `# npm-check-updates`
- `alias ncu='$(npm prefix -g)/bin/ncu'`

### check

`npm-check-updates`

### update

- `npm-check-updates -u`
- `npm install`

### shorthand

`ncu`

### to update all version numbers (also those that are not needed)

- `ncu -u`
- `ncu --upgradeAll`