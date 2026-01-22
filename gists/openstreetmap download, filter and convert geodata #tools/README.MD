### installation
```sh
sudo apt install osmctools
```

### script to download data
```sh
#!/bin/bash
rm -rf ./data/
mkdir ./data
wget -O ./data/input.osm.pbf https://download.geofabrik.de/europe/germany/bayern-latest.osm.pbf
osmconvert ./data/input.osm.pbf -o=./data/input.o5m
osmfilter ./data/input.o5m --keep="addr:postcode= and addr:city= and addr:street=" --ignore-dependencies -o=./data/input-filtered.osm
osmconvert ./data/input-filtered.osm --csv="addr:postcode addr:city addr:street" --csv-headline -o=./data/output.csv
sort -u ./data/output.csv -o ./data/output.csv
# problem: data is not complete, see https://help.openstreetmap.org/questions/48541/get-complete-lat-lon-city-streetname-and-housenumber-for-germany-with-osmfilterosmconvert/48542)
```