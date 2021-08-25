#### in.txt

- you can export e.g. a list of all indexed urls via google search console ("Abdeckung")
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
while read LINE; do
  curl -o /dev/null --silent --head --write-out "%{http_code} $LINE\n" "$LINE"
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