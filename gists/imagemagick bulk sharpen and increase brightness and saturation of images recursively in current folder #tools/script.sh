find . -name "*.jpg" -execdir mogrify -format jpg -quality 100 -sharpen 0x0.7 -modulate 102,101,100 *.jpg {} \;