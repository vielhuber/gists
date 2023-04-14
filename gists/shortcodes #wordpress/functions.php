// [foobar]
add_shortcode('foobar', function() {
    return 'foo and bar';
});

// [barbaz foo="bar"]
add_shortcode('barbaz', function($atts) {
    $parsed = shortcode_atts([
        'foo' => 'default1',
        'bar' => 'default2',
    ], $atts);
    return 'foo: '.$parsed['foo'].' - bar: '.$parsed['bar'];
});
