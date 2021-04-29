<?php
add_filter('acf/load_field/name=field_name', function($field) {
     
    // variant 1
    $field['default_value'] = 'FOO';

    // variant 2 (does not work anymore)
    // use get_post_meta instead of get_field to avoid conflicts
    global $post;
    if( get_post_meta($post->ID, 'field_name', true) == '' ) {
        $field['value'] = 'FOO';
    }

    // if field should be disabled
    $field['disabled'] = 1;
    
    return $field; 
    
});