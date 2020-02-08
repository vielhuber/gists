#### place this in head (before your js script)

```php
$registered_strings = [
    'lökäkäwfeökk',
    'ß043rüüpddlöäx',
    'ß043rü\' §2""""üpddlöäx',
    'Dies
ist eine neue Zeile',
  	['blog', 'slug'] // example with context
];
if (!empty($registered_strings)) {
    $registered_strings_json = [];
    foreach ($registered_strings as $registered_strings__value) {
        if (!is_array($registered_strings__value)) {
            $context = '';
            $orig = $registered_strings__value;
            $trans = __($registered_strings__value);
        } else {
            $context = $registered_strings__value[1];
            $orig = $registered_strings__value[0];
            $trans = _x($registered_strings__value[0], $registered_strings__value[1]);
        }
        $orig = str_replace("\r", '', $orig);
        $trans = str_replace("\r", '', $trans);
        // those chars must be escaped in a json encoded string
        $to_escape = ["\\", "\f", "\n", "\r", "\t", "\v", "\""];
        foreach ($to_escape as $to_escape__value) {
            $orig = addcslashes($orig, $to_escape__value);
            $trans = addcslashes($trans, $to_escape__value);
        }
        $registered_strings_json[$context][$orig] = $trans;
    }
    echo '<script>';
    echo 'var registered_strings = JSON.parse(\'' .
        json_encode($registered_strings_json, JSON_HEX_APOS) .
        '\');';
    echo 'function __(string, context = \'\') { if( registered_strings[context][string] !== undefined ) { return registered_strings[context][string]; } return string; }';
    echo '</script>';
}
```

#### call translations from js

```js
console.log([
    __('lökäkäwfeökk'),
    __('ß043rüüpddlöäx'),
    __('ß043rü\' §2""""üpddlöäx'),
    __(`Dies
ist eine neue Zeile`),
    __('blog', 'slug')
]);
```

#### wp hook

```php
add_action('wp_head', function () {
        /*...*/
}, -1);
```