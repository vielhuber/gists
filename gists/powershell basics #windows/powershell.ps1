# show big files
gci -r| sort -descending -property length | select -first 10 name, length