// recursively convert svgs to pngs

// with svgexport (best results)
find . -name '*.svg' -type f -exec svgexport {} "{}".png 300: \;

// with rsvg
find . -name '*.svg' -type f -exec rsvg-convert --width 300 --height 300 --keep-aspect-ratio --output "{}".png {} \;

// with inkscape
find . -name '*.svg' -type f -exec inkscape -z -e "{}".png -w 300 -h 300 {} \;

// with imagemagick
find . -name '*.svg' -type f -exec convert -background none -density 2400 -size 300x300 {} "{}".png \;