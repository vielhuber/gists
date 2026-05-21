# this is case insensitive
SELECT name, COUNT(id) as count FROM table GROUP BY name ORDER BY name ASC

# this is case sensitive
SELECT name, COUNT(id) as count FROM table GROUP BY CAST(name as BINARY) ORDER BY name ASC