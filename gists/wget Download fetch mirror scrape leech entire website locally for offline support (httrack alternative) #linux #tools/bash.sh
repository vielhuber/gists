# primary
wget --mirror -p --html-extension --convert-links http://www.test.de

# alternative
wget -r --no-parent http://www.test.de

# advanced
wget --page-requisites --span-hosts --convert-links --adjust-extension --wait 1 --recursive --level 1 https://www.test.de

# alternative
httrack "https://www.test.de" --path "." --verbose "+*.test.de/*" 

# mirror single page
rm -rf "./output" && httrack "https://www.test.de/subpage/" -O "./output" "+*.test.de/*" --verbose --ext-depth=0 --depth=3 # increase depth to 2,3,4,... if files are missing