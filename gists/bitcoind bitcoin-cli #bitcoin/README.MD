### installation of bitcoind
```sh
mkdir /tmp/btc
cd /tmp/btc
wget --no-check-certificate https://bitcoin.org/bin/bitcoin-core-22.0/bitcoin-22.0-x86_64-linux-gnu.tar.gz
tar xzf bitcoin-22.0-x86_64-linux-gnu.tar.gz
sudo install -m 0755 -o root -g root -t /usr/local/bin bitcoin-22.0/bin/*
```

### change data path
```sh
mkdir ~/.bitcoin
nano ~/.bitcoin/bitcoin.conf
datadir=/mnt/e
```

### enable pruning
```sh
mkdir ~/.bitcoin
nano ~/.bitcoin/bitcoin.conf
prune=1000
```

### enable txindex
- this is important when getting any transactions (not only those in our wallet)
- be aware: pruning and txindex=1 is not compatible at the same time(!)
```sh
mkdir ~/.bitcoin
nano ~/.bitcoin/bitcoin.conf
txindex=1
```

### start (download entire blockchain)
```sh
bitcoind -daemon
```

### stop
```sh
bitcoin-cli stop
```

### status
```sh
bitcoin-cli getblockchaininfo
```

### status
```sh
echo `bitcoin-cli getblockcount 2>&1`/`wget -O - http://blockchain.info/q/getblockcount 2>/dev/null`
tail -f ~/.bitcoin/debug.log
```

### get blockchain size on disk
```sh
du -sh ~/.bitcoin/blocks
```

### clear history (free up space)
```sh
bitcoin-cli stop
rm -rf ~/.bitcoin
```

### debug log
```sh
cat ~/.bitcoin/debug.log
tail -10 ~/.bitcoin/debug.log
```

### create a new wallet
```sh
bitcoin-cli createwallet "testwallet"
```

### get block information
```sh
bitcoin-cli getblock "00000000c937983704a73af28acdec37b049d214adbda81d7e2a3dd146f6ed09"
```

### get latest block
```sh
bitcoin-cli getblock $(bitcoin-cli getblockhash $(bitcoin-cli getblockcount))
```

### check if own transaction is included in last block
```sh
bitcoin-cli getblock $(bitcoin-cli getblockhash $(bitcoin-cli getblockcount)) | grep "<TRANSACTION_ID>"
```

### loop through latest blocks and calculate average block time
```sh
#!/bin/bash
#set -x
MODE_LAST_BLOCKS=
MODE_DATE="2014-02-15"

HEIGHT=$(bitcoin-cli getblockcount)
HASH=$(bitcoin-cli getblockhash "$HEIGHT")
COUNTER=$HEIGHT
LAST_TIME=0
LAST_HASH=0
LAST_HEIGHT=0
SUM=0
COUNT=0
TMP=

while [[ $COUNTER -ge 0 ]]
do
    echo "processing $COUNTER..."

    HASH=$(bitcoin-cli getblockhash $COUNTER)
    TIME=$(bitcoin-cli getblock $HASH | grep -Po '(?<="time": )[^,]*')
    TIME=$((TIME))
    date -d @$TIME

    if [[ -n $MODE_LAST_BLOCKS ]]; then
        if [[ $COUNTER < $((HEIGHT - MODE_LAST_BLOCKS)) ]]; then
            break
        fi
    fi
    if [[ -n $MODE_DATE ]]; then
        if [[ $(date -d @$TIME +"%Y-%m-%d") != $MODE_DATE ]]; then
            if [[ -n $TMP ]]; then
                if [[ $COUNTER < $TMP ]]; then break; fi
            fi

            ((COUNTER--))
            continue
        else
            # fast skip
            ((TMP = COUNTER - 10))
        fi
    fi

    if [[ LAST_TIME -ne 0 ]]; then
        ((DIFF = LAST_TIME - TIME))
        ((SUM = SUM + DIFF))
        ((COUNT++))
    fi
    LAST_TIME=$TIME
    LAST_HASH=$HASH
    LAST_HEIGHT=$COUNTER

	((COUNTER--))
done

if [[ $COUNT > 0 ]]; then
    echo ""
    echo $SUM
    echo $COUNT
    SEC=$(echo "scale=2 ; $SUM / $COUNT" | bc)
    MIN=$(echo "scale=2 ; $SEC / 60" | bc)
    echo $MIN
fi
```
