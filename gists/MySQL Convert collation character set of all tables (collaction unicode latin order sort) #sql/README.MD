## notes
- Empfehlung: utf8mb4 + utf8_unicode_ci
- Ein Character Set ist der Zeichenvorrat für alle Daten in der Datenbank.
  - utf8: Entspricht utf8mb3 (später wird utf8mb3 auf mb4 gemappt)
  - utf8mb4: Für jeden Charakter werden 4 Bytes reserviert. Nur dann passen auch Emojis rein.
- Eine Kollation regelt die Sortierregeln dieses Zeichenvorrats bei der Benutzung von ORDER BY
- Es gibt Kollations für die Datenbank, Tabelle und Spalten (die Collation für die Spalten sind entscheidend, alles andere hat nur Auswirkung auf die Neuanlegung von Spalten bzw. Tabellen)
- Eine sehr weit verbreitete und übliche Kombination ist utf8_unicode_ci, utf8 und utf_general_ci (das verwenden wir bei allen Projekten)
- utf_general_ci ist ein vereinfachter Standard, der nicht so viele Ressourcen braucht; dies ist heutzutage aber nicht mehr relevant
- Will man eine spezielle deutsche Sortierreihenfolge (z.B. https://www.arbeiten-im-sekretariat.de/blog/2015/08/04/din-5007-ablage/#Ae_wird_zu_AE), gibt es zwei Möglichkeiten
  - Man konvertiert die Datenbank/Tabellen/Spalten in das Character Set "latin1" und der Collation "latin1_german2_ci" (nicht empfohlen, da latin1 weniger Zeichen als UTF-8 hat)
  - Man modifiziert an den gewünschten Stellen das SQL Query auf ```SELECT * FROM table ORDER BY CONVERT(col USING latin1) COLLATE latin1_german2_ci ASC```.
  - Um Sch und Sz nach S zu sortieren, nutzt man beispielsweise ```SELECT * FROM table ORDER BY CONVERT(REPLACE(REPLACE(col, 'Sch','Szzzch'), 'St','Szzzt') USING latin1) COLLATE latin1_german2_ci ASC```.

### to convert a database (without tables and columns)
```sql
ALTER DATABASE database_name CHARACTER SET = utf8 COLLATE = utf8_general_ci;
```

### to convert a table (not columns)
```sql
ALTER TABLE tablename COLLATE utf8_general_ci
```

### to convert a table and columns
```sql
ALTER TABLE tablename CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci
```

### to convert all tables (without columns)
```sql
SELECT CONCAT("ALTER TABLE ", TABLE_NAME," COLLATE utf8_general_ci;") AS ExecuteTheString
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA="dbname"
AND TABLE_TYPE="BASE TABLE"
```

### to convert all tables and columns
```sql
SELECT CONCAT("ALTER TABLE ", TABLE_NAME," CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;") AS ExecuteTheString
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA="dbname"
AND TABLE_TYPE="BASE TABLE"
```