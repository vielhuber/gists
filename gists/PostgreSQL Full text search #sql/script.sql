CREATE INDEX persons_idx ON persons USING gin(to_tsvector('german', name));
SELECT * FROM persons WHERE to_tsvector('german', name) @@ plainto_tsquery('german', 'Vielhuber');

CREATE INDEX persons_idx ON persons USING gin(to_tsvector('german', (first_name || ' ' || last_name)));
SELECT * FROM persons WHERE to_tsvector('german', (first_name || ' ' || last_name)) @@ plainto_tsquery('german', 'David Vielhuber');

# this matches also!
SELECT * FROM persons WHERE to_tsvector('german', (first_name || ' ' || last_name)) @@ to_tsquery('german', 'Dav:* & Vie:*');