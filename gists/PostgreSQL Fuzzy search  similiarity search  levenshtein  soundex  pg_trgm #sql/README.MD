### pg_trgm
```sql
CREATE EXTENSION IF NOT EXISTS pg_trgm;
SELECT set_limit(0.8); --sets the similiarity level (between 0 and 1)
SELECT * FROM tbl WHERE name % 'Your Name';
```

### soundex
```sql
SELECT * FROM tbl WHERE DIFFERENCE(name, 'Your Name') = 4;
```

### levenshtein
```sql
CREATE EXTENSION IF NOT EXISTS fuzzystrmatch;
SELECT * FROM tbl WHERE LEVENSHTEIN(name, 'Your Name') <= 2;
SELECT * FROM tbl WHERE LEVENSHTEIN(name, 'Your Name') <= (LENGTH('Your Name')*(1-0.8)); // where 0.8 is the "error rate" in percent
```

### always useful (in combination with the above)
```sql
SELECT * FROM tbl WHERE
REGEXP_REPLACE(LOWER(TRIM(name)), '\W+', '', 'g') =
REGEXP_REPLACE(LOWER(TRIM('Your Name')), '\W+', '', 'g');
```