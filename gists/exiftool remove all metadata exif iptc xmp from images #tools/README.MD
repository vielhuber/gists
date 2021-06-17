### installation
```sh
sudo apt-get install libimage-exiftool-perl
```

### view data
```sh
exiftool image.jpg
exiftool -exif:all
exiftool -iptc:all
exiftool -xmp:all
```

### single
```sh
exiftool -overwrite_original -all= image.jpg
```

### batch recursively
```sh
exiftool -overwrite_original -r -all= .
```