--SELECT to_tsquery('german', 'The & Fat & Rats');

--DROP INDEX IF EXISTS jo;

--DROP TABLE IF EXISTS foo;

CREATE TABLE IF EXISTS foo (
  bar text,
	baz text
);

INSERT INTO foo (bar, baz) VALUES 
  ('a', 'b'),
  ('c', 'd');
	
CREATE INDEX jo ON foo USING gin (to_tsvector('german', bar));

SET enable_seqscan = OFF;

EXPLAIN ANALYZE SELECT * FROM
    foo
WHERE
    --bar like '%Test%'
	--baz like '%oooooooooooo%'
	to_tsvector('german', bar) @@ to_tsquery('german', 'e')
    --to_tsvector('german', baz) @@ to_tsquery('german', 'f')
