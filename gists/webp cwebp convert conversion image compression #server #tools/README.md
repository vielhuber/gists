### installation

- ```sudo apt-get install webp```
- ```cwebp -version```
- ```dwebp -version```

### convert

- ```cwebp -q 80 image.png -o image.webp``` // jpg/png to webp
- ```dwebp image.webp -o image.png``` // webp to jpg/png

### bulk convert

- ```find . -iregex '.*\.\(jpg\|jpeg\|png\)$' -type f -exec cwebp -q 80 {} -o {}.webp \;```