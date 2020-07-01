# install via msi installer
https://yarnpkg.com/latest.msi

# updating yarn
yarn self-update

# creates package.json (same syntax as npm)
yarn init

# add a new package (or simply edit package.json)
yarn add [package-name]
yarn add [package]@[version-or-tag]

# update all packages
yarn upgrade

# upgrade specific package
yarn upgrade gulp@4.0

# see why a dependency is installed
yarn why jest

# remove package
yarn remove gulp

# clean as much junk as possible
yarn clean

# install all packages from package.json
yarn install

# install specific package
yarn install vivus

# install specific package and save if to package.json
yarn install vivus --save

# install specific package and save if to package.json (development area)
yarn install vivus --save-dev

# use pnp
yarn install --use-pnp
## you have to put that in the package.json also:
"installConfig": {
    "pnp": true
}

# clear cache
yarn cache clean