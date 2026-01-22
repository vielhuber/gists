### new
```sh
curl -N -s https://vielhuber.de/sitemap_index.xml | grep -oP '<loc>\K[^<]*' | xargs -n1 curl -N -s | grep -oP '<loc>\K[^<]*' > urls.txt
```

### old

```sh
curl --silent some-sitemap.xml | htmlq --text loc >> links.txt
curl --silent some-other-sitemap.xml | htmlq --text loc >> links.txt
split -l 300 links.txt links_
wget -i links_aa -O /dev/null
```