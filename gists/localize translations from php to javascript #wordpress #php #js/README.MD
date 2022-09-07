#### place this in head (before your js script)

```php
$translated_strings = [
    'lökäkäwfeökk',
    'ß043rüüpddlöäx',
    'ß043rü\' §2""""üpddlöäx',
    'Dies
ist eine neue Zeile',
    ['blog', 'slug'] // example with context
];
if (!empty($translated_strings)) {
    $translated_strings_json = [];
    foreach ($translated_strings as $translated_strings__value) {
        if (!is_array($translated_strings__value)) {
            $context = '';
            $orig = $translated_strings__value;
            $trans = __($translated_strings__value);
        } else {
            $context = $translated_strings__value[1];
            $orig = $translated_strings__value[0];
            $trans = _x($translated_strings__value[0], $translated_strings__value[1]);
        }
        $orig = str_replace("\r", '', $orig);
        $trans = str_replace("\r", '', $trans);
        // those chars must be escaped in a json encoded string
        $to_escape = ["\\", "\f", "\n", "\r", "\t", "\v", "\""];
        foreach ($to_escape as $to_escape__value) {
            $orig = addcslashes($orig, $to_escape__value);
            $trans = addcslashes($trans, $to_escape__value);
        }
        $translated_strings_json[$context][$orig] = $trans;
    }
    echo '<script data-type="translated-strings">';
    echo 'var translated_strings = JSON.parse(\'' .
        json_encode($translated_strings_json, JSON_HEX_APOS) .
        '\');';
    echo 'function __(string, context = \'\') { if( translated_strings[context][string] !== undefined ) { return translated_strings[context][string]; } return string; }';
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