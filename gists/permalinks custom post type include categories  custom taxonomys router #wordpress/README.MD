- tips for debugging: Plugin "Monkeyman Rewrite analyzer"

### solution 1

- create your custom router and catch all requests after a prefix (see https://gist.github.com/vielhuber/eecc6d44ed7c18e2066e)

### solution 2
  
- disadvantage: https://tld.com/dummy/foobar/item also works

```php
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
```

### solution 3

- extends solution 2 with nested categories

```php
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
        $replacement = '';
        if($terms) {
            $parent_term = false;
            foreach ($terms as $term) {
                if ($parent_term === false) {
                    $parent_term = $term->term_id;
                    $replacement = $term->slug;
                }
                else if ($term->parent == $parent_term) {
                    $parent_term = $term->term_id;
                    $replacement.= '/' . $term->slug;
                }
            }
        }
        return str_replace( '%dummykategorie%' , $replacement, $url );
    }
    return $url;
}, 1, 2 );
add_filter('term_link', function($url, $term) {
    if( isset($term->taxonomy) && $term->taxonomy == 'dummykategorie' ){
        return str_replace( 'dummykategorie', 'dummy', $url );
    }
    return $url;
}, 10, 3);
// this catches all categories in between and "discards" them
function rewrite_tag() {
    add_rewrite_tag('%dummykategorie%', '(.+?)');
}
add_action('init', 'rewrite_tag', 10, 0);
```