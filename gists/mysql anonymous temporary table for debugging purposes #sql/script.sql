SELECT * FROM (
	SELECT 'Huber' as name
	UNION ALL SELECT 'Hüber'
	UNION ALL SELECT 'Hvrastksa'
	UNION ALL SELECT 'Zimzick'
	UNION ALL SELECT 'Sauer'
	UNION ALL SELECT 'Simone'
	UNION ALL SELECT 'Sz'
	UNION ALL SELECT 'Schaller'
	UNION ALL SELECT 'Schzuzi'
	UNION ALL SELECT 'Stanislav'
	UNION ALL SELECT 'Stzaller'
) as t
ORDER BY name ASC