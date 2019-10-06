mkdir foo && cd foo
seq -w 1 900 | xargs -n1 -I% sh -c 'dd if=/dev/urandom of=file.% bs=1024 count=1024'
cd .. && mkdir bar && cd bar
seq -w 1 900 | xargs -n1 -I% sh -c 'dd if=/dev/urandom of=file.% bs=1024 count=1024'
cd ..