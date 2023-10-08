### delete all revisions

```sql
DELETE a,b,c
FROM `wp_posts` a
LEFT JOIN `wp_term_relationships` b ON (a.ID = b.object_id)
LEFT JOIN `wp_postmeta` c ON (a.ID = c.post_id)
WHERE a.post_type = 'revision';
```

### delete all revisions except the latest 10

```sql
DELETE a,b,c
FROM `wp_posts` a
LEFT JOIN `wp_term_relationships` b ON (a.ID = b.object_id)
LEFT JOIN `wp_postmeta` c ON (a.ID = c.post_id)
WHERE a.post_type = 'revision'
AND a.ID NOT IN(SELECT ID FROM (SELECT ID FROM `wp_posts` WHERE post_type = 'revision' ORDER BY ID DESC LIMIT 10) rev);
```

### only keep 10 revisions (for future changes)

```php
// wp-config.php
define('WP_POST_REVISIONS', 10);
```