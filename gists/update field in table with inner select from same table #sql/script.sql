// not possible
UPDATE table
SET A =
(
    SELECT B
    FROM table
    WHERE C = 'foo'
)

// possible
UPDATE table
SET A =
(
    SELECT B
    FROM (SELECT * FROM table) AS t
    WHERE C = 'foo'
)
