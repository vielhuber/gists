# links

- https://astrid-guenther.de/vectortiles-und-openstreetmap/
- https://chatgpt.com/c/676380bd-d948-8013-ac11-36f872eb4c3d
- https://tools.geofabrik.de/calc&

# installation

```sh
## create main folder
mkdir openstreetmap
cd openstreetmap

## osmium
mkdir osmium
cd osmium
wget https://github.com/osmcode/osmium-tool/archive/refs/tags/v1.16.0.tar.gz
tar -xzf v1.16.0.tar.gz
cd osmium-tool-1.16.0
apt-get install libosmium2-dev libprotozero-dev nlohmann-json3-dev libboost-program-options-dev libbz2-dev zlib1g-dev liblz4-dev libexpat1-dev cmake pandoc
mkdir build
cd build
cmake ..
make
make install
cd ..
cd ..
rm -rf ./osmium/
exec env -i HOME=$HOME bash -l
osmium --version

## mbutil
git clone https://github.com/mapbox/mbutil.git
cd mbutil
python setup.py install
cd ..
rm -rf ./mbutil/

## tilemaker
apt install build-essential libboost-dev libboost-filesystem-dev libboost-program-options-dev libboost-system-dev lua5.1 liblua5.1-0-dev libshp-dev libsqlite3-dev rapidjson-dev
git clone https://github.com/systemed/tilemaker.git
cd tilemaker
make
make install
cd ..
rm -rf ./tilemaker
exec env -i HOME=$HOME bash -l
tilemaker --help
```

# usage

```sh
# settings
URL="https://download.geofabrik.de/europe/germany-latest.osm.pbf"
## bavaria (https://tools.geofabrik.de/calc/)
LAT_MIN=47.27 # bottom left breitengrad
LON_MIN=8.97 # bottom left längengrad
LAT_MAX=50.57 # top right breitengrad
LON_MAX=13.84 # top right längengrad

# download osm.pbf
wget -nc -O ./raw.osm.pbf "$URL"

# set bounding box
osmium extract --strategy=complete_ways --overwrite --bbox="$LON_MIN","$LAT_MIN","$LON_MAX","$LAT_MAX" --set-bounds ./raw.osm.pbf --output ./input.osm.pbf

# prepare tilemaker config + files
git clone https://github.com/systemed/tilemaker.git
sed -i -E 's|"compress": "(.+)"|"compress": "none"|' ./tilemaker/resources/config-openmaptiles.json ## modify config

# osm.pbf => pbf
rm -rf ./tiles/
tilemaker --input ./input.osm.pbf --output ./tiles --process ./tilemaker/resources/process-openmaptiles.lua --config ./tilemaker/resources/config-openmaptiles.json

# alternative: osm.pbf => mbtiles => pbf
#tilemaker ./input.osm.pbf --output ./tiles.mbtiles --process ./tilemaker/resources/process-openmaptiles.lua --config ./tilemaker/resources/config-openmaptiles.json
#mb-util ./tiles.mbtiles ./tiles --image_format=pbf

# copy boilerplate
wget -O ./index.html https://gist.githubusercontent.com/vielhuber/d6d023c0bcfb3d322272f2733e76315b/raw/index.html
wget -O ./fetch.php https://gist.githubusercontent.com/vielhuber/d6d023c0bcfb3d322272f2733e76315b/raw/fetch.php
sed -i -E 's/LAT_MIN: ([0-9]|\.)+/LAT_MIN: '"$LAT_MIN"'/' ./index.html
sed -i -E 's/LON_MIN: ([0-9]|\.)+/LON_MIN: '"$LON_MIN"'/' ./index.html
sed -i -E 's/LAT_MAX: ([0-9]|\.)+/LAT_MAX: '"$LAT_MAX"'/' ./index.html
sed -i -E 's/LON_MAX: ([0-9]|\.)+/LON_MAX: '"$LON_MAX"'/' ./index.html

# remove work files
rm -rf ./tilemaker/
rm -f ./input.osm.pbf
rm -f ./raw.osm.pbf
```
