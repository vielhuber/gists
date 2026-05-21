# before
"scripts": {
  "purge": "purgecss --css input.css --content index.html --out /purged/"
},
npm run foo

# after
./node_modules/.sbin/purgecss --css input.css --content index.html --out /purged/

# another method
./node_modules/purgecss/bin/purgecss --css input.css --content index.html --out /purged/

