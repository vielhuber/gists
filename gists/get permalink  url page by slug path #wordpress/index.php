<?php
// basic
get_permalink(get_page_by_path('your-slug'));

// wpml
function blank_wpml_get_permalink_by_path($path, $lang = null, $post_type = 'page') {
    $page = get_page_by_path($path, 'OBJECT', $post_type);
    if (!$page) return false;
    $translated_object_id = apply_filters('wpml_object_id', $page->ID, $post_type, true, $lang);
    return get_permalink($translated_object_id);
}