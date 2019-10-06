// variant 1
SELECT
	ID,
	post_title,		
	MAX(CASE WHEN pm.meta_key = 'tel' then pm.meta_value ELSE NULL END) as tel,
	MAX(CASE WHEN pm.meta_key = 'fax' then pm.meta_value ELSE NULL END) as fax,
	MAX(CASE WHEN pm.meta_key = 'email' then pm.meta_value ELSE NULL END) as email,
	(SELECT GROUP_CONCAT(object_id) FROM dh_term_relationships WHERE dh_term_relationships.object_id = p.ID) as cat
FROM
	wp_posts p
LEFT JOIN
	wp_postmeta pm
ON
	pm.post_id = p.ID
WHERE
	p.post_type = 'retailer'
	AND
	p.post_status = 'publish'
GROUP BY
	p.ID
	
// variant 2
SELECT
	ID,
	post_title,		
	p1.meta_value as tel,
	p2.meta_value as fax,
	p3.meta_value as email,
	(SELECT GROUP_CONCAT(object_id) FROM dh_term_relationships WHERE dh_term_relationships.object_id = p.ID) as cat
FROM
	wp_posts p
LEFT JOIN wp_postmeta p1 ON p1.post_id = p.ID AND p1.meta_key = 'tel'
LEFT JOIN wp_postmeta p2 ON p2.post_id = p.ID AND p2.meta_key = 'fax'
LEFT JOIN wp_postmeta p3 ON p3.post_id = p.ID AND p3.meta_key = 'email'
WHERE
	p.post_type = 'retailer'
	AND
	p.post_status = 'publish'
GROUP BY
	p.ID