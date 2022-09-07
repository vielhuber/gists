-- inner join
SELECT * FROM foo INNER JOIN bar ON foo.bar_id = bar.ID WHERE foo.col = 'test'
SELECT * FROM foo, bar WHERE foo.bar_id = bar.id WHERE foo.col = 'test' -- alternative syntax

-- left join
SELECT * FROM foo LEFT JOIN bar ON foo.bar_id = bar.ID WHERE foo.col = 'test'

-- full outer join
SELECT * FROM foo FULL OUTER JOIN bar ON foo.bar_id = bar.ID WHERE foo.col = 'test'