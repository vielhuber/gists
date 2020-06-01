<?php
// an alternative to this is to use the default wordpress behaviour: categories inside a custom taxonomy show its handle inside the url

// https://tld.com/dummy => archive-dummy.php
// https://tld.com/dummy/category => taxonomy-dummykategorie.php
// https://tld.com/dummy/category/item => single-dummy.php

register_post_type(
    'dummy',
    [
        'public' => true, 
        'label' => 'dummy',
        'rewrite' => [ 'slug' => 'dummy/%dummykategorie%', 'with_front' => false ],
        'has_archive' => 'dummy',
    ]
);
register_taxonomy(
    'dummykategorie',
    'dummy', // name of the custom post type
    [
        'public' => true,
        'label' => 'dummykategorie',
        'rewrite' => [ 'slug' => 'dummykategorie', 'with_front' => false ],
        'hierarchical' => true
    ]
);
add_filter( 'post_type_link', function( $url, $post ) {
    if( isset($post->post_type) && $post->post_type == 'dummy' ){
        $terms = wp_get_object_terms( $post->ID, 'dummykategorie' );
        if( $terms ){
            return str_replace( '%dummykategorie%' , $terms[0]->slug , $url );
        }
    }
    return $url;
}, 1, 2 );
add_filter('term_link', function($url, $term) {
    if( isset($term->taxonomy) && $term->taxonomy == 'dummykategorie' ){
        return str_replace( 'dummykategorie', 'dummy', $url );
    }
    return $url;
}, 10, 3);

// save permalinks
// create a page with slug "dummy"