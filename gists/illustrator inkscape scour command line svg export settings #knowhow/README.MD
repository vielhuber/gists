## illustrator

- Stil: **Inline-Format**
- Schrift: **In Konturen umwandeln**
- Bilder: **Einbetten**
- Objekt-IDs: **Minimal**
- Dezimalstellen: **2**
- Minifizieren: **An**
- Responsiv: **An**
- Zeichenflächen verwenden: **Je nach Anwendungsfall**

## inkscape

- Anzahl der signifikanten Stellen für Koordinaten: **5**
- Farbwerte kürzen: **Aus**
- CSS-Attribute in XML-Attribute umwandeln: **An**
- Gruppen zusammenklappen: **An**
- Gruppen für ähnlicheAttribut erstellen: **An**
- Editor-Daten erhalten: **Aus**
- Unreferenzierte Definitionen erhalten: **Aus**
- Renderer-Fehler umgehen: **An**
- XML-Deklaration entfernen: **Aus**
- Metadaten entfernen: **An**
- Kommentare entfernen: **An**
- Rasterbilder einbetten: **An**
- Viewbox aktivieren: **An**

## command line

inkscape uses [Scour](https://github.com/scour-project/scour) under the hood.

```bash
scour -i input.svg -o output.svg

    --set-precision=5
    --disable-simplify-colors
    --create-groups
    --renderer-workaround

    --remove-descriptive-elements
    --enable-comment-stripping
    --enable-viewboxing

    --indent=space
    --nindent=1

    --enable-id-stripping
```