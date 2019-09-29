# variant 1 (using imagemagick and potrace)
convert -flatten in.png -trim in.pnm
potrace in.pnm --tight --color #0000CD -b svg -o out.svg
potrace in.pnm --tight --color #0000CD -b pdf -o out.pdf

# variant 2 (using inkscape)
inkscape in.png --export-pdf out.pdf

# variant3 (pixel based using imagemagick)
convert in.png out.svg
convert in.png out.pdf