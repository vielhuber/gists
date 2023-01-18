#!/bin/bash
HEIGHT=$(bitcoin-cli getblockcount)
COUNTER=0
FILE="time.txt"
echo "id,time" > $FILE
while [[ $COUNTER -le $HEIGHT ]]
do
    HASH=$(bitcoin-cli getblockhash $COUNTER)
    TIME=$(bitcoin-cli getblock $HASH | grep -Po '(?<="time": )[^,]*')
    TIME=$((TIME))
    DATE=$(date -d @$TIME +"%Y-%m-%d %H:%M:%S")
    echo "$COUNTER,$DATE" >> $FILE
    ((COUNTER++))
done