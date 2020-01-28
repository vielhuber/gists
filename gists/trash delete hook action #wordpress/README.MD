#### methods
```php
wp_delete_post($post_id, $force_delete) // verschiebt in Papierkorb außer der ist deaktiviert/das Post ist bereits im Papierkorb oder $force_delete ist true
wp_trash_post() // verschiebt Post in Papierkorb; ist der deaktiviert, wird direkt gelöscht
```

#### hooks
- pre_trash_post - Filter. Ob ein Post getrasht werden soll.
- wp_trash_post - Action. Bevor ein Post in Trash verschoben wird.
- before_delete_post - Action. Wird ausgeführt, bevor post_meta gelöscht wird. Aber nicht, wenn ein Post in Trash verschoben wird.
- delete_post - Action. Nachdem Kommentare und post_meta bereits gelöscht wurden. Nicht, wenn ein Post in Trash verschoben wird.
- delete_attachment - Action. Bevor der Anhang gelöscht wird.
- tash_post - Action. Deprecated

#### prevent deletion

```php
function blank_restrict_deletion($postid) {
  if (1==1) { die('no permission'); }
}
add_action('before_delete_post', 'blank_restrict_deletion', 10, 1); // before it is directly deleted
add_action('wp_trash_post', 'blank_restrict_deletion', 10, 1); // before it is moved to trash
```
