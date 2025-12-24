ssh -M -S my-ctrl-socket -fnNT -L 50000:localhost:3306 username@host
ssh -S my-ctrl-socket -O check username@host
ssh -S my-ctrl-socket -O exit username@host