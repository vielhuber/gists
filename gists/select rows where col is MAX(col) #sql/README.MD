#### table

```
id  home  datetime     player   resource
---|-----|------------|--------|---------
1  | 10  | 04/03/2009 | john   | 399 
2  | 11  | 04/03/2009 | juliet | 244
5  | 12  | 04/03/2009 | borat  | 555
3  | 10  | 03/03/2009 | john   | 300
4  | 11  | 03/03/2009 | juliet | 200
6  | 12  | 03/03/2009 | borat  | 500
7  | 13  | 24/12/2008 | borat  | 600
8  | 13  | 01/01/2009 | borat  | 700
```

#### desired output

```
id  home  datetime     player   resource 
---|-----|------------|--------|---------
1  | 10  | 04/03/2009 | john   | 399
2  | 11  | 04/03/2009 | juliet | 244
5  | 12  | 04/03/2009 | borat  | 555
8  | 13  | 01/01/2009 | borat  | 700
```

#### query

```
SELECT * FROM table
INNER JOIN (
  SELECT home, MAX(datetime) AS max_datetime
  FROM table
  GROUP BY home
) as grouped
ON table.home = grouped.home 
AND table.datetime = grouped.max_datetime
```