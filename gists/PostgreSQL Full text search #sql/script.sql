CREATE INDEX persons_idx ON persons USING gin(to_tsvector('german', name));
SELECT * FROM persons WHERE to_tsvector('german', name) @@ plainto_tsquery('german', 'Vielhuber');

CREATE INDEX persons_idx ON persons USING gin(to_tsvector('german', (first_name || ' ' || last_name)));
SELECT * FROM persons WHERE to_tsvector('german', (first_name || ' ' || last_name)) @@ plainto_tsquery('german', 'David Vielhuber');

# you can also add wildcards to have a more mature search
SELECT * FROM persons WHERE to_tsvector('german', (first_name || ' ' || last_name)) @@ to_tsquery('german', 'Dav:* & Vie:*');

# remove 'german' for general word searching
SELECT * FROM persons WHERE to_tsvector(first_name || ' ' || last_name) @@ to_tsquery('Dav:* & Vie:*');