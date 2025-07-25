## notes
- Empfehlung: **utf8mb4 + utf8mb4_unicode_ci**
- Ein Character Set ist der Zeichenvorrat für alle Daten in der Datenbank.
  - utf8: Entspricht utf8mb3 (später wird utf8mb3 auf mb4 gemappt)
  - utf8mb4: Für jeden Charakter werden 4 Bytes reserviert. Nur dann passen auch Emojis rein.
- Es gibt komplexere Emojis, die manchmal nicht gehen (😀 vs. ❤️)
- Eine Kollation regelt die Sortierregeln dieses Zeichenvorrats bei der Benutzung von ORDER BY
- Es gibt Kollations für die Datenbank, Tabelle und Spalten (die Collation für die Spalten sind entscheidend, alles andere hat nur Auswirkung auf die Neuanlegung von Spalten bzw. Tabellen)
- Eine sehr weit verbreitete und übliche Kombination ist utf8_unicode_ci, utf8 und utf_general_ci (das verwenden wir bei allen Projekten)
- utf_general_ci ist ein vereinfachter Standard, der nicht so viele Ressourcen braucht; dies ist heutzutage aber nicht mehr relevant
- Will man eine spezielle deutsche Sortierreihenfolge (z.B. https://www.arbeiten-im-sekretariat.de/blog/2015/08/04/din-5007-ablage/#Ae_wird_zu_AE), gibt es zwei Möglichkeiten
  - Man konvertiert die Datenbank/Tabellen/Spalten in das Character Set "latin1" und der Collation "latin1_german2_ci" (nicht empfohlen, da latin1 weniger Zeichen als UTF-8 hat)
  - Man modifiziert an den gewünschten Stellen das SQL Query auf ```SELECT * FROM table ORDER BY CONVERT(col USING latin1) COLLATE latin1_german2_ci ASC```.
  - Um Sch und Sz nach S zu sortieren, nutzt man beispielsweise ```SELECT * FROM table ORDER BY CONVERT(REPLACE(REPLACE(col, 'Sch','Szzzch'), 'St','Szzzt') USING latin1) COLLATE latin1_german2_ci ASC```.

### show all charsets and collations
```sql
SELECT
    S.SCHEMA_NAME AS "Database name",
    S.DEFAULT_CHARACTER_SET_NAME AS "Database charset",
    S.DEFAULT_COLLATION_NAME AS "Database collation",
    T.TABLE_NAME AS "Table name",
    CCSA.CHARACTER_SET_NAME AS "Table charset",
    T.TABLE_COLLATION AS "Table collation"
FROM
    INFORMATION_SCHEMA.SCHEMATA S
JOIN
    INFORMATION_SCHEMA.TABLES T ON S.SCHEMA_NAME = T.TABLE_SCHEMA
JOIN
    INFORMATION_SCHEMA.COLLATION_CHARACTER_SET_APPLICABILITY CCSA
    ON T.TABLE_COLLATION = CCSA.COLLATION_NAME
WHERE
    S.SCHEMA_NAME = 'db_name'
ORDER BY
    T.TABLE_NAME;
```

### convert a database (without tables and columns)
```sql
ALTER DATABASE database_name CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
```

### convert a table (not columns)
```sql
ALTER TABLE table_name COLLATE utf8mb4_unicode_ci;
```

### convert a table and columns
```sql
ALTER TABLE table_name CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### convert all tables (without columns)
```sql
SELECT CONCAT("ALTER TABLE ", TABLE_NAME," COLLATE utf8mb4_unicode_ci;") AS ExecuteTheString
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA="database_name"
AND TABLE_TYPE="BASE TABLE";
```

### convert all (database, tables and columns)
```sql
ALTER DATABASE database_name CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

SELECT CONCAT("ALTER TABLE ", TABLE_NAME," CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;") AS `Execute these strings!`
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA="database_name"
AND TABLE_TYPE="BASE TABLE"
ORDER BY TABLE_NAME ASC;

# disable NO_ZERO_IN_DATE / NO_ZERO_DATE that produces errors (gets reset after restart)
SET sql_mode = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
# run the above commands
# ...
```