<?php
add_filter('acf/load_field/name=field_name', function($field) {
    global $post;
    
    // variant 1 (use get_post_meta instead of get_field to avoid conflicts)
    if( get_post_meta($post->ID, 'field_name', true) == '' ) {
        $field['value'] = 'FOO';
    }
    
    // variant 2
    $field['default_value'] = 'FOO';
    
    return $field;          
});