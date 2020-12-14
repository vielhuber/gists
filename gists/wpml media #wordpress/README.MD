#### tl;dr

- WPML Media deaktiviert lassen
- Bei Ersteinrichtung: WPML -> Einstellungen -> Media Translations alle Haken setzen und Start
- Nach Hinzufügen einer neuen Sprache: WPML -> Einstellungen -> Media Translations > Start
- Falls unterschiedliche Bilder pro Sprache realisiert werden sollen: WPML Media aktivieren
  - Beispiel: WooCommerce: Unterschiedliche Bilder pro Produkt sind realisierbar über WPML > Media Translations > Original suchen > Sprache wählen > “Use different file”

#### Empfehlung

- Außer bei Legacy-Projekten mit speziellen Bedürfnissen (unterschiedliche Bilder pro Sprache) immer alle Haken in den Optionen setzen.
- Die Neuzuweisung (wieder mit allen Haken) (Ausführen von "Start") sollte beim erstmaligen Installieren von WPML und nach dem Hinzufügen von weiteren Sprachen erfolgen.
- Das Plugin WPML Media ist nur notwendig wenn man unterschiedliche Bilder pro Sprache verwendet oder intensiv mit Alt-Texten, Beschreibungen oder Beschriftungen arbeitet.

#### Generell

- Anhänge werden wie Posts behandelt, haben also ein Original-Post und mehrere Übersetzungen als eigene Einträge in `wp_posts`, jeweils mit eigenen Einträgen in `wp_postmeta`.
- Die physischen Dateien selbst werden aber nicht dupliziert.

#### Plugin WPML Media

- Das Plugin bietet ein Interface um Alt-Text (aus `wp_postmeta`), Beschreibung und Beschriftung (aus `wp_posts`) übersichtlich zu aktualisieren.
- Das könnte man auch ohne dieses Plugin über die einzelnen Mediathekseinträge machen.
- Unterschiedliche Bilder wickelt das Plugin so ab, dass es eine zweite physische Datei (samt Zuschnitte) hochlädt und diese transparent in `_wp_attached_file` sowie `_wp_attachment_metadata` von `wp_postmeta` hinterlegt.

#### Einstellungen

- Die Einstellungen findet man unter WPML -> Einstellungen -> Media Translations.
- Diese Einstellung sind unabhängig vom Plugin WPML Media.
- Einstellungen für „Start“ (der Medien-Übersetzungen)
  - [x] Sprachinformationen für vorhandene Medien einstellen
    - Noch vor dem Start wird geprüft ob es Orphaned Attachments gibt. Das sind Attachments die gar keiner Sprache zugeordnet sind. Wahrscheinlich Attachments, die vor der Installation von WPML hinzugefügt wurden. Je nachdem ist dann „Sprachinformationen für vorhandene Medien einstellen“ auswählbar oder nicht.
  - [x] Vorhandene Medien in alle Sprachen übersetzen
    - Macht alle Attachments in allen Sprachen verfügbar indem es Einträge in `wp_posts`, sowie `_wp_attachment_metadata` und `_wp_attached_file` in `wp_postmeta` klont falls diese Einträge nicht schon vorhanden sind.
  - [x] Vorhandene Medien für übersetzten Inhalt duplizieren
    - Macht das gleiche wie die zweite Option aber nur für Attachments, die zu einem Post zugewiesen wurden und dann auch nur in die Sprachen, in die dieses Post übersetzt wurde.
  - [x] Die Artikelbilder für den übersetzten Inhalt duplizieren
    - Macht das gleiche wie die vorhergehende Option, aber nur für das „Beitragsbild“ (der generelle post-thumbnail).
  - So soll mit Medien für neue Inhalte umgegangen werden:
  - [x] Beim Hochladen von Medien in die Medienbibliothek diese in allen Sprachen verfügbar machen
    - Ist Option gesetzt werden hochgeladene Medien (egal ob über die Mediathek oder in einem Post) in alle Sprachen dupliziert.
    - Ist diese Option nicht gesetzt, sind Medien nur in Posts der hochgeladenen Sprache auswählbar.
    - Auf Datenbankebene wird nur ein Eintrag in `wp_posts` und `wp_icl_translations` erstellt.
    - Das betrifft nur neu über die Mediathek hochgeladene Medien.
  - [x] Medienanhänge für Übersetzungen duplizieren
  - [x] Artikelbilder für Übersetzungen duplizieren
    - Bestimmen ob diese Haken bei einem neuen Post *vorbelegt* ist. Posts erinnern sich an seine Einstellungen diesbezüglich, nach dem ersten Erstellen haben globale Änderungen keine Auswirkung mehr diesen Post.

### Medienanhänge (Checkboxen bei einem Post)
- Wenn „Beim Hochladen von Medien in die Medienbibliothek diese in allen Sprachen verfügbar machen“ aktiviert ist, dann sind diese Optionen eigentlich irrelevant, weil die Attachment-Posts dann schon in allen Sprachen vorhanden sind. Könnte aber noch relevant für alte Posts sein.
- [x] Medienanhänge für Übersetzungen duplizieren
- [x] Artikelbilder für Übersetzungen duplizieren
- Wenn man ein Post dupliziert, dann werden die Anhänge in die andere Sprache kopiert, egal was an Checkboxen gesetzt ist.
- Dafür muss das Attachment aber auch zu diesem Post hochgeladen werden.
- Vorher über die Mediathek hochgeladene Bilder werden nicht dupliziert (werden aber im Post angezeigt).
- Wenn die Checkbox in der Originalsprache gesetzt ist, und man ein neue Übersetzung erstellt (nicht dupliziert), diese dann speichert, dann werden alle Medien *die zum Original hochgeladen wurden* in diese Sprache übertragen.
- Die Checkboxen des übersetzten Posts sind nicht relevant.
- Ich kann mir keinen Einsatzzweck vorstellen wo das in dieser Inkonsistenz Sinn macht.
- Momentan scheint mir nur die Checkbox „Beim Hochladen von Medien in die Medienbibliothek diese in allen Sprachen verfügbar machen“ sinnvoll zu sein, den Rest würde ich der Vollständigkeit halber auch setzen, relevant ist er dann nicht mehr.

### Start

- Legt eventuell noch fehlende Datenbankeinträge (in Abhängigkeit der gewählten Einstellungen) an
- Soll ausgeführt werden nach Neuinstallation, nach Hinzufügen einer neuen Sprache und bei Bedarf auch von Zeit zu Zeit

### Alt-Text und Beschreibung
- Alt-Text wird als `_wp_attachment_image_alt` in `wp_postmeta` zur jeweiligen Übersetzung abgespeichert. Die Duplizierung fasst das nicht an.
- Beschreibung wird als post_excerpt in `wp_posts` hinterlegt. Nur wenn man die Option „Beim Hochladen von Medien in die Medienbibliothek diese in allen Sprachen verfügbar machen“ nicht gesetzt hat und später „Vorhandene Medien in alle Sprachen übersetzen“ ausführt wird diese mit dem Bild dupliziert. Werden Medien schon beim Hochladen dupliziert, ist die Beschreibung pro Übersetzung einmalig, weil diese erst nach dem Hochladen geändert werden kann und diese Änderung erfolgt auf Übersetzungsebene (pro Eintrag in `wp_posts`). Späteres Ausführen von „Start“ egal mit welchen gesetzten Optionen fasst post_excerpt nicht an.

### Wechselwirkung mit anderen Plugins
- Crop Thumbnails
  - Das Plugin setzt beim dem zugeschnittenen Bild in `wp_postmeta` den weiteren Eintrage cpt_last_cropping_data im Array von `_wp_attachment_metadata`, der wohl aber rein informativ ist. Die eigentliche Veränderung erfolgt an der Datei selbst.
  - Dadurch, dass auch bei Verwendung von WPML nur eine physische Datei vorliegt, wirkt sich der Zuschnitt auf alle Sprachen aus. Weil `_wp_attachment_metadata` entweder beim Upload (bei gesetzter Option „Beim Hochladen von Medien in die Medienbibliothek diese in allen Sprachen verfügbar machen“) oder beim „Start“ (bei gesetzter Option „Vorhandene Medien in alle Sprachen übersetzen“) nur einmalig dupliziert wird, kommt es bezüglich dieses Eintrags zu einer Asynchronität zwischen den einzelnen Posts pro Sprache, die sich aber nicht auswirken dürfte.
- Enable Media Replace
  - Wenn man die Datei tatsächlich ersetzt, also den Namen beibehält, dann hat es den Effekt als würde man die Datei in allen Sprachen ersetzen.
  - Verwendet man einen neuen Namen wirkt es wie unterschiedliche Bilder pro Sprache. Die alte Datei bleibt erhalten und wird in der Übersetzung dieses Attachments weiterhin verwendet.
  - Einbettungen wurden (bei einem begrenzten Test) auch nur in der Sprache aktualisiert, in der das Bild ersetzt wurde. WPML Media zeigt fortan für diese Bild unterschiedliche Bilder in den Sprachen.
  - Das bedeutet: Es darf NIE die 2. Option ausgewählt werden, da man sonst Chaos in unterschiedlichen Sprachen erhält
- WPML
  - Das Plugin WPML Media führt dazu, dass sofern ein Beitrag in einer Quellsprache in eine Zielsprache dupliziert wird, alle Meta-Felder nicht übernommen werden
  - Da Attachments auch ohne WPML Media unterschiedliche Alt-Tags pro Sprache haben können, verzichten wir deshalb auf dessen Einsatz