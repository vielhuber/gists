#!/bin/bash

CURRENT=$(df / | grep / | awk '{ print $5}' | sed 's/%//g')
THRESHOLD=80
if [ "$CURRENT" -gt "$THRESHOLD" ] ; then
    mail -s 'Project XY: Disk Space Alert' email1@tld.com, email2@tld.com, email3@tld.com << EOF
Your root partition remaining free space is critically low. Used: $CURRENT%
EOF
fi
