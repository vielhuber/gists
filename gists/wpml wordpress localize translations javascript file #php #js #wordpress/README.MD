```php
wp_register_script( 'some_handle', 'path/to/myscript.js' );
$translation_array = [
	'some_string' => __( 'Some string to translate', 'plugin-domain' ),
]
wp_localize_script( 'some_handle', 'object_name', $translation_array );
wp_enqueue_script( 'some_handle' );
```

```js
alert( object_name.some_string);
```