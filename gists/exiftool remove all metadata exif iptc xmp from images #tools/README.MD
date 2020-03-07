### installation
```sh
sudo apt-get install libimage-exiftool-perl
```

### view data
```sh
exiftool image.jpg
```

### single
```sh
exiftool -overwrite_original -all= image.jpg
```

### batch recursively
```sh
exiftool -overwrite_original -r -all= .
```