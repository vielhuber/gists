# installation
npm install --global gulp-cli

# for new projects
npm init # create package.json
npm install --save-dev gulp # install and add gulp
npm install --save-dev babelify browserify gulp-connect vinyl-source-stream babel-preset-es2015 gulp-htmlmin gulp-sass gulp-autoprefixer gulp-sourcemaps gulp-clean-css gulp-rename gulp-uglify vinyl-buffer browser-sync # install additional packages

# for existing projects
npm install # installs everything in package.json

# place a gulpfile.js in your root directory and run the following command
gulp