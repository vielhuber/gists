### installation of bitcoind
```sh
mkdir /tmp/btc
cd /tmp/btc
wget --no-check-certificate https://bitcoin.org/bin/bitcoin-core-22.0/bitcoin-22.0-x86_64-linux-gnu.tar.gz
tar xzf bitcoin-22.0-x86_64-linux-gnu.tar.gz
sudo install -m 0755 -o root -g root -t /usr/local/bin bitcoin-22.0/bin/*
```

### start (download entire blockchain)
```sh
bitcoind -daemon
```

### status
```sh
bitcoin-cli getblockchaininfo
```

### status
```sh
echo `bitcoin-cli getblockcount 2>&1`/`wget -O - http://blockchain.info/q/getblockcount 2>/dev/null`
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

### loop through latest 10 blocks


### stop
```sh
bitcoin-cli stop
```