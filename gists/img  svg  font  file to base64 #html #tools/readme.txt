# file to base64
base64 -w 0 input.file > input.txt

# base64 to file
base64 -d input.txt > input.file

# base64 do not contain ANY mime types. so you common prefix it with to know which data it is
data:image/svg+xml;base64,
data:image/jpeg;base64,
data:image/png;base64,
data:image/gif;base64,
data:font/ttf;base64,
data:application/pdf;base64,