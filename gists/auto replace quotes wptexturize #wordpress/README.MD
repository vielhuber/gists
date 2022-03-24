- `wptexturize()` is automatically applied to `the_content()` (in `wp-includes/default-filters.php`)
- this magic function (besides several other things) replaces "" with „“
- if you read values from acf, the_content filter is not applied (so if you want to have the same behaviour, replace `get_field('test')` with `apply_filters('the_content', get_field('test'))`)
- if you want to disable this behaviour (and stop `wptexturize()` from not running at all), add: `add_filter( 'run_wptexturize', '__return_false' );`
- if you want to instead modify the quote replacement behaviour, apply another filter:
```php
add_filter( 'the_content', function($content) {
    $content = str_replace(['&#8222;', '&bdquo;', '„'], '»', $content);
    $content = str_replace(['&#8220;', '&ldquo;', '“'], '«', $content);
    $content = str_replace(['&#8218;', '&sbquo;', '‚'], '›', $content);
    $content = str_replace(['&#8216;', '&lsquo;', '‘'], '‹', $content);
    return $content;
}, PHP_INT_MAX);
```
