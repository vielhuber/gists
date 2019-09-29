# also install globally
npm install --global babel-cli
# install locally
npm install babel-cli
# install needed plugin
npm install --save-dev babel-preset-es2015-ie
# convert
npx babel in.js --presets es2015-ie --out-file out.js