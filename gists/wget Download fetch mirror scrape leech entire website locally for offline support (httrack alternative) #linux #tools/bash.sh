# primary
wget --mirror -p --html-extension --convert-links http://www.test.de

# alternative
wget -r --no-parent http://www.test.de

# advanced
wget --page-requisites --span-hosts --convert-links --adjust-extension --wait 1 --recursive --level 1 https://www.test.de

# alternative
httrack "https://www.test.de" --path "." --verbose "+*.test.de/*" 

# mirror single page
httrack "https://www.test.de/subpage/" -O "./output" "+*.test.de/*" --verbose --ext-depth=0 --depth=3 # increase depth to 2,3,4,... if files are missing

# download only html and multiple pages
httrack "https://www.test.de/subpage1/" "https://www.test.de/subpage2/" -O "./output" "+*.test.de/*" -* +mime:text/html --verbose --ext-depth=0 --depth=3

# only js files and no images
httrack "https://www.test.de/subpage/" -O "./output" "+*.test.de/*" +*.js -*.png -*.gif -*.jpg -*.jpeg -*.svg -*.pdf --verbose --ext-depth=0 --depth=3