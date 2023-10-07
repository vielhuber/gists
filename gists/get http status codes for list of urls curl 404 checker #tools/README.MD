#### in.txt

- you can export e.g. a list of all indexed urls via google search console (Indexierung > Seiten > Daten zu indexierten Seiten ansehen > 500 anzeigen > Exportieren)
- make sure the following file uses \n as line breaks (no \r\n)

```txt
https://close2.de/
https://close2.de/projekte/
https://close2.de/leistungen/
https://close2.de/foo/
```

#### script.sh

```sh
#!/bin/bash
while read LINE || [ -n "$LINE" ]; do
  curl --insecure -o /dev/null --silent --head --write-out "%{http_code} $LINE\n" "$LINE"
  # if you want to follow also redirects (to detect 404s), add "-L --max-redirs 500"
  curl -L --max-redirs 500 --insecure -o /dev/null --silent --head --write-out "%{http_code} $LINE\n" "$LINE"
  # if your site has basic auth
  curl -u "42:42" -L --max-redirs 500 --insecure -o /dev/null --silent --head --write-out "%{http_code} $LINE\n" "$LINE"
done < in.txt
```

#### run

```
chmod +x script.sh
./script.sh > out.txt
```

#### out.txt

```txt
200 https://close2.de/
200 https://close2.de/projekte/
200 https://close2.de/leistungen/
404 https://close2.de/foo/
```