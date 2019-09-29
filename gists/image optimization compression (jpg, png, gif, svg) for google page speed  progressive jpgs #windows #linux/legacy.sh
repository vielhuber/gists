# important: save this file with EOL unix/osx format (in notepad++)
# then run it with: "bash optimize.sh C:\Users\David\Downloads\uploads"

#!/bin/bash
#$1='C:\Users\David\Downloads\uploads';
find $1 -name '*.jpg' -type f -exec jpegoptim --strip-all -m85 -o -p {} \;
find $1 -name '*.jpeg' -type f -exec jpegoptim --strip-all -m85 -o -p {} \;
find $1 -name '*.png' -type f -exec pngout {} \;
find $1 -name '*.gif' -type f -exec gifsicle -force -o7 {} \;
#find $1 -name '*.jpg' -type f -exec jpegtran -verbose -optimize -progressive -copy none -outfile {} {} \;
#find $1 -name '*.png' -type f -exec optipng -o2 {} \;

# use this on the command line like this
find . -name '*.jpg' -type f -exec jpegoptim --strip-all -m85 -o -p {} \;
find . -name '*.png' -type f -exec pngout {} \;
find . '*.jpg' -type f -exec jpegtran -verbose -optimize -progressive -copy none -outfile {} {} \;

# mac/linux: add "\" before ;
find ~/path/to/folder/ -name '*.jpg' -type f -exec jpegoptim --strip-all -m85 -o -p {} \;

# imagemagick: resize images to max width/height
find . -name '*.jpg' -type f -exec convert {} -resize 900x900\> {} \;



# svg compression
npm install -g svgo
svgo input.svg –o output.svg
# compress folder recursively and overwrite
svgo -r -f path/to/folder/
# inline styles
svgo input.svg –o output.svg --enable=inlineStyles  --config '{ "plugins": [ { "inlineStyles": { "onlyMatchedOnce": false } }] }' --pretty
# set base color to #000000 (dompdf has problems here)
find . -type f -name "*.svg" -print0 | xargs -0 sed -i '' -e 's/<svg xmlns/<svg fill="#000000" xmlns/g'

# alternative: https://github.com/scour-project/scour)
# first install python
pip install scour
scour -i input.svg -o output.svg
scour -i input.svg -o output.svg --enable-viewboxing --enable-id-stripping --enable-comment-stripping --shorten-ids --indent=none
