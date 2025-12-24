rm -f storage/framework/sessions/*

# if rm fails due to too many files
cd storage/framework/sessions/
for i in * ; do rm -f $i ; done