- change references in php code from 'name_of_old_post_type' to 'name_of_new_post_type'
- run sql query
```sql
UPDATE
	`wp_posts`
SET 
    `post_type` = REPLACE(`post_type`,'name_of_old_post_type','name_of_new_post_type'),
    `guid` = REPLACE(`guid`,'name_of_old_post_type','name_of_new_post_type')
WHERE
	`post_type` = 'name_of_old_post_type'
```

- warning:
  - this breaks wpml translation connections (posts must be reconnected again)
  - Intuitive CPO must be set again