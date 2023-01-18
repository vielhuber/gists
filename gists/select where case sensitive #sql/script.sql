-- mysql is NOT case sensitive
SELECT * FROM table WHERE col = 'foo'; -- finds also 'FOO'
SELECT * FROM table WHERE BINARY col = 'foo'; -- does not find 'FOO'

-- sqlite is case sensitive by default

-- postgres is case sensitive by default