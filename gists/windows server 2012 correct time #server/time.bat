w32tm /config /manualpeerlist:"0.pool.ntp.org 1.pool.ntp.org 2.pool.ntp.org",0x8 /syncfromflags:MANUAL
w32tm /config /update
net stop w32time
net start w32time
w32tm /resync /nowait