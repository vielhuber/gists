CR = carriage return (\r)
LF = line feed (\n)

# windows
this is a bash scriptCRLF
this is a bash scriptCRLF
this is a bash script

# mac
this is a bash scriptCR
this is a bash scriptCR
this is a bash script

# linux
this is a bash scriptLF
this is a bash scriptLF
this is a bash script

# convert one file from windows to linux
tr -d "\r" < bash.sh > bash-new.sh

# convert one file from mac to linux
tr "\r" "\n" < bash.sh > bash-new.sh

# recursively convert all files from windows to linux
find . -type f -exec grep -qIP '\r\n' {} ';' -exec perl -pi -e 's/\r\n/\n/g' {} '+'