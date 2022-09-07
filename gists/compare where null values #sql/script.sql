-- problem
SELECT * FROM foo WHERE bar <> 'baz' -- rows missing, where bar is null!

-- solution
SELECT * FROM foo WHERE bar IS NULL OR bar <> 'baz'
SELECT * FROM foo WHERE COALESCE(bar,'') <> 'baz'
