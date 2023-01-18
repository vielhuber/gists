### check before
```sh
identify -verbose example.jpg | grep "Interlace" # "Interlace: JPEG" means "progressive"
```

### convert single
```sh
convert example.jpg -interlace none example.jpg
```

### check after
```sh
identify -verbose example.jpg # "Interlace: None" means "non-progressive"
```

### bulk convert
```sh
find . -name '*.jpg' -type f -exec convert {} -interlace none {} \;
```