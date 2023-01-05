## installation

# install phantomjs
download https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-windows.zip
unzip to C:\Program Files (x86)\phantomjs-2.1.1-windows
put in path: C:\Program Files (x86)\phantomjs-2.1.1-windows\bin

# install casperjs
run cmd as administrator
npm install -g casperjs
put this in path: C:\Program Files\nodejs\node_modules\casperjs\bin

# check versions
phantomjs --version
casperjs --version

# run file
casperjs index.js