# check all disks and find "boot" disk
fdisk -l
# repair that boot disk
fsck -fy /dev/sda2
# reboot via ssh
reboot