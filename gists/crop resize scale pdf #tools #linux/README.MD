### crop

```sh
#!/usr/bin/env bash

# set this to point values (1pt = 25.4 mm)
cropLeft=0
cropRight=298
cropTop=421
cropBottom=0

# calculate ghostscript cropbox values
currentWidth=$(pdfinfo -box input.pdf | grep "Page size:" | awk '{print $3}')
currentHeight=$(pdfinfo -box input.pdf | grep "Page size:" | awk '{print $5}')
left=$cropLeft
bottom=$cropBottom
right=$(echo "$currentWidth - $cropRight" | bc)
top=$(echo "$currentHeight - $cropTop" | bc)

# do the cropping
gs \
    -o output.pdf \
    -sDEVICE=pdfwrite \
    -c "[/CropBox [$left $bottom $right $top]" \
    -c " /PAGES pdfmark" \
    -f input.pdf
```

### resize

- if you want to "remove" the cropbox (e.g. resize the cropped pdf back to a4), do the following

```sh
# resize to a4
gs \
    -q \
    -dNOPAUSE \
    -dBATCH \
    -sDEVICE=pdfwrite \
    -dDEVICEWIDTHPOINTS=595 \
    -dDEVICEHEIGHTPOINTS=842 \
    -dFIXEDMEDIA \
    -dPDFFitPage \
    -sOutputFile="output-tmp.pdf" \
    -c "<</EndPage {0 eq {[/CropBox [0 0 595 842] /PAGE pdfmark true}{false}ifelse}>> setpagedevice" \
    -f "output.pdf"

# scale up by factor 2.00
gs \
    -q \
    -dNOPAUSE \
    -dBATCH \
    -sDEVICE=pdfwrite \
    -dDEVICEWIDTHPOINTS=595 \
    -dDEVICEHEIGHTPOINTS=842 \
    -sOutputFile="output-scaled.pdf" \
    -c "<</BeginPage{2.00 2.00 scale 0 0 translate}>> setpagedevice" \
    -f "output-tmp.pdf"

# remove tmp files
rm output-tmp.pdf
```