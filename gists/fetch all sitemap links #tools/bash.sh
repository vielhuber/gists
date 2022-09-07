curl --silent some-sitemap.xml | htmlq --text loc >> links.txt
curl --silent some-other-sitemap.xml | htmlq --text loc >> links.txt
split -l 300 links.txt links_
wget -i links_aa -O /dev/null