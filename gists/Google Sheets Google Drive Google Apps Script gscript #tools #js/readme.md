#### vertical array
```
={1;2}
```

#### horizontal array
```
={1\2}
=MTRANS({1;2})
```

#### conditional formatting for neighbour cells
- Bedingte Formatierung für A2:F anlegen
- Benutzerdefinierte Formel ist
- ```=$F2="erledigt"```

#### custom function
- Tools > Skripteditor > ```function FOO(cell) { return cell+'bar'; }```
- In cell: ```=FOO()```
- Datei > Tabelleneinstellungen > Berechnung > Neuberechnung: Bei Änderung und minütlich

#### current unix timestamp (for a unique number)
```
=((JETZT()-DATUM(1970;1;1)+ZEIT(6;0;0))*86400))
```

#### current month
```
=WENN(LÄNGE(MONAT(HEUTE()))<2;"0";"")&MONAT(HEUTE())&"/"&JAHR(HEUTE())
```

#### future months: 10/2018, 11/2018, 12/2018, 01/2019, ...
```
=WENN(LÄNGE(MONAT(EDATUM(HEUTE();(ZEILE(A2)-1))))<2;"0";"")&MONAT(EDATUM(HEUTE();(ZEILE(A2)-1)))&"/"&JAHR(EDATUM(HEUTE();(ZEILE(A2)-1)))
```

#### auto date ranges (F1 = start date, F2 = days in future)
```
=ARRAYFORMULA(WENN((DATWERT($F1)-1+ZEILE(A1:A))>HEUTE()+$F2;"";DATWERT($F1)-1+ZEILE(A1:A)))
=UNIQUE(ARRAYFORMULA(WENN((DATWERT($F1)-1+ZEILE(B1:B))>HEUTE()+$F2;"";ISOWEEKNUM(DATWERT($F1)-1+ZEILE(B1:B))&"/"&JAHR(DATWERT($F1)-1+ZEILE(B1:B)))))
=UNIQUE(ARRAYFORMULA(WENN((DATWERT($F1)-1+ZEILE(C1:C))>HEUTE()+$F2;"";JAHR(DATWERT($F1)-1+ZEILE(C1:C)))))
```

#### and/or multiplication of truth
```
=WENN(UND(ODER(A1="ja";A1="nein");C1="foo");"foo";"bar")
=WENN((((A1="ja")+(A1="nein"))*(C1="foo"));"foo";"bar")
```

#### data validation conditions
```
=(WENN(B1="bar";ODER(A1="ja";A1="nein");A1="nein"))
```

#### string concatenation
```
="FOO"&" "&"BAR"
=CONCAT("FOO"; " "; "BAR") // use this in arrayformula!
=VERKETTEN("FOO";" ";"BAR")
```

#### concat with new line
```
="FOO"&CHAR(10)&"BAR"
```

#### use dynamic sheet names
```
=INDIRECT("DYNAMIC_TABLE_NAME!"&B10);
```

#### integer to column names
```
=REGEXEXTRACT(ADDRESS(ROW(); COLUMN()); "[A-Z]+")
```

#### sverweis to the left
```
=SVERWEIS(D2;{$B$1:$B;$A$1:$A};2;FALSCH)
```

#### load csv
```
=IMPORTDATA("https://www.tld.com/path/to/file.csv");
```

#### import
```
=IMPORTRANGE("SHEETID";"Tabellenblatt1!A2:M")
```

#### query (without import)
```
=QUERY( SHEETNAME!A2:F )
=QUERY( SHEETNAME!A2:F;"SELECT Col1 WHERE Col2 != ''" )
```

#### query: you can also use letters
```
=QUERY( SHEETNAME!A2:F;"SELECT A WHERE B != ''" )
```

#### query (and import)
```
=QUERY( IMPORTRANGE("SHEETID";"Tabellenblatt1!A2:M"); "SELECT Col2 SUM(Col5) WHERE Col2 != '' GROUP BY Col2" )
```

#### query without title
```
=QUERY( QUERY( ...; "SELECT Col2, SUM(Col5) WHERE Col2 != '' GROUP BY Col2" ); "SELECT * OFFSET 1" )
=QUERY( ...; "SELECT Col2, SUM(Col5) WHERE Col2 != '' GROUP BY Col2 LABEL SUM(Col5) ''" )
=QUERY( ...; "SELECT Col2, SUM(Col5), 'FOO' WHERE Col2 != '' GROUP BY Col2 LABEL SUM(Col5) '', 'FOO' ''" )
=QUERY( ...; "SELECT ' ', Col2, '  ', '   ' WHERE Col2 IS NOT NULL LABEL ' ' '', '  ' '', '   ' ''" )
```

#### query and dates
```
=QUERY( ...; "SELECT Col1 WHERE Col1 >= date '2018-01-01'")
```

#### query like and not like
```
=QUERY( ...; "SELECT Col1 WHERE Col2 LIKE '%foo%' AND NOT(Col3) LIKE '%bar%' )
```

#### dynamic query
```
=QUERY( ...; "SELECT Col1 WHERE Col2 = '" & $D$1 & "'")
```

#### query and group concat data
```
=JOIN(", "; QUERY( IMPORTRANGE("...","..."); "SELECT Col1"));
```

#### query and join multiple columns
```
=JOIN(" "; QUERY({ Sheet1!A:B, Sheet2!C:D }, "SELECT Col1, Col3 WHERE Col2 = Col4")
=QUERY(Sheet1!A:B, "SELECT Col1 WHERE Col2 = Col4")&" "&QUERY(Sheet1!C:D, "SELECT Col3 WHERE Col2 = Col4")
```

#### query column from external sheet and add a prefix string
```
=ARRAYFORMULA(
	QUERY(IMPORTRANGE("...";"INPUT!A2:A"); "SELECT 'PREFIX: ' WHERE Col1 <> '' LABEL 'PREFIX: ' ''")
    &
    QUERY(IMPORTRANGE("...";"INPUT!A2:A"); "SELECT Col1 Where Col1 <> ''")
)
```

#### another way to filter results
```
=FILTER( SHEET!A2:A; SHEET!B2:B="foo" )
```

#### hide #NV or #NA 
```
=WENNFEHLER( ..., "" );
```

### count rows that are equal
```
A B
1 0
1 1
0 0
0 1
=ANZAHL2(WENNFEHLER(FILTER(A2:A;A2:A=B2:B))) // 2
```

#### combine queries
```
=SORT(
{
IMPORTRANGE("SHEETID";"Tabellenblatt1!A2:F");
IMPORTRANGE("SHEETID";"Tabellenblatt1!A2:F")
};1;WAHR)
```

#### combine data
```
=SORT(
{
QUERY( IMPORTRANGE("SHEETID";"Tabellenblatt1!A2:F"); "SELECT Col1, Col2, Col3, Col4 WHERE Col1 IS NOT NULL'" );
QUERY( IMPORTRANGE("SHEETID";"Tabellenblatt1!A2:F"); "SELECT Col1, Col2, Col3, Col4 WHERE Col1 IS NOT NULL" )
};1;WAHR)
```

#### combine data where some queries return null
```
=QUERY(({
WENNFEHLER(QUERY( IMPORTRANGE("SHEETID";"Tabellenblatt1!A2:F"); "SELECT Col1, Col2, Col3, Col4 WHERE Col1 IS NOT NULL'" );MTRANS({"";"";"";""}));
WENNFEHLER(QUERY( IMPORTRANGE("SHEETID";"Tabellenblatt1!A2:F"); "SELECT Col1, Col2, Col3, Col4 WHERE Col1 IS NOT NULL'" );MTRANS({"";"";"";""}));
WENNFEHLER(QUERY( IMPORTRANGE("SHEETID";"Tabellenblatt1!A2:F"); "SELECT Col1, Col2, Col3, Col4 WHERE Col1 IS NOT NULL'" );MTRANS({"";"";"";""}));
WENNFEHLER(QUERY( IMPORTRANGE("SHEETID";"Tabellenblatt1!A2:F"); "SELECT Col1, Col2, Col3, Col4 WHERE Col1 IS NOT NULL'" );MTRANS({"";"";"";""}))
}); "SELECT Col1, Col2, Col3, Col4 WHERE Col1 <> '' ORDER BY Col1")
```

#### arrayformula: enhance formula to entire column (don't use this with queries / importranges / indirect because it does NOT work!)
```
=CONCAT(A1;"TEST"); // formula before
=ARRAYFORMULA(CONCAT(A1:A;"TEST") // formula after
=ARRAYFORMULA(A1:A&"TEST")
```

#### arrayformula trick: place them in a fixed first row to always view the formula
```
=ARRAYFORMULA(WENN(ZEILE(A:A)=1;"Überschrift";WENN(ISTLEER(A:A);"";CONCAT(A:A;"TEST"))))
```

#### arrayformula with and/or
##### before
```
=ARRAYFORMULA(WENN(UND(B2:B="baz";ODER(A2:A="foo";A2:A="bar"));"baz";"gnarr"))
```
##### after
```
=ARRAYFORMULA(WENN((B2:B="baz")*((A2:A="foo")+(A2:A="bar")));"baz";"gnarr"))
```

#### arrayformula with sum
##### before
```
=ARRAYFORMULA(WENN(ZEILE(J:J)=1;"foo";WENN(ISTLEER(G:G);"";SUM(G:G;I:I)))
```
##### after
```
=ARRAYFORMULA(WENN(ZEILE(J:J)=1;"foo";WENN(ISTLEER(G:G);"";G:G+H:H+I:I)))
```

#### arrayformula with sverweis
##### before
```
SVERWEIS(B2:B;'_LOGIC'!A1:B;{2}*VORZEICHEN(ZEILE(E2:E));FALSCH)
```
##### after
```
ARRAYFORMULA(SVERWEIS(B2:B;'_LOGIC'!A1:B;{2}*VORZEICHEN(ZEILE(E2:E));FALSCH))
```

#### convert duration in hours (04:30:00 is in C1)
```
=(((MINUTE(C1))+(STUNDE(C1)*60))/60)
```

#### calendar week (KALENDERWOCHE(A1;2) is WRONG because of US definition)
```
=KÜRZEN((A1-DATUM(JAHR(A1-REST(A1-2;7)+3);1;REST(A1-2;7)-9))/7)
=KALENDERWOCHE(A1;21))
=ISOWEEKNUM(A1)
```

#### image in cell
```
=IMAGE("https://vielhuber.de/wp-content/themes/vielhuber/_assets/about.jpg";1)
```

#### visualization of hex color
```
SPARKLINE(1;{"charttype"\"bar";"color1"\A1})
```