- tips for debugging: Plugin "Monkeyman Rewrite analyzer"

### solution 1
  
- add to `functions.php`:
```php
$options = [
    'cpt' => [
        'label' => 'Dummy',
        'name' => 'dummy',
        'slug' => 'dummy'
    ],
    'tax' => [
        'label' => 'Dummykategorie',
        'name' => 'dummy-cat'
    ]
];
register_post_type(
    $options['cpt']['name'],
    [
        'public' => true, 
        'rewrite' => [ 'slug' => $options['cpt']['slug'].'/%'.$options['tax']['name'].'%', 'with_front' => false ],
        'has_archive' => false,
        'label' => $options['cpt']['label']
    ]
);
register_taxonomy(
    $options['tax']['name'],
    $options['cpt']['name'],
    [
        'public' => true,
        'rewrite' => [ 'slug' => $options['cpt']['slug'], 'with_front' => false ],
        'hierarchical' => true,
        'label' => $options['tax']['label']
    ]
);
add_filter( 'post_type_link', function( $url, $post ) use($options) {
    if( isset($post->post_type) && $post->post_type == $options['cpt']['name'] ){
        $terms = wp_get_object_terms( $post->ID, $options['tax']['name'] );
        if( $terms ){
            return str_replace( '%'.$options['tax']['name'].'%' , $terms[0]->slug , $url );
        }
    }
    return $url;
}, 1, 2 );
add_filter('term_link', function($url, $term) use($options) {
    if( isset($term->taxonomy) && $term->taxonomy == $options['tax']['name'] ){
        return str_replace( $options['tax']['name'], $options['cpt']['slug'], $url );
    }
    return $url;
}, 10, 3);
// always set default category
add_action( 'save_post', function( $post_id ) use ($options) {
    $terms = wp_get_post_terms( $post_id, $options['tax']['name']);
    if (empty($terms)) {
        $terms = get_terms( $options['tax']['name'], ['hide_empty' => false] );
        if( !empty($terms) ) {
            wp_set_post_terms( $post_id, $terms[0]->term_id, $options['tax']['name'] );
        }
    }
} );
```

- create template files

  - `archive-dummy.php` (https://tld.com/dummy) (only, if `'has_archive' => 'dummy'`; if you set `'has_archive' => false`, the static page is used instead)
  - `taxonomy-dummy-cat.php` (https://tld.com/dummy/category)
  - `single-dummy.php` (https://tld.com/dummy/category/item)

- save permalinks

- create a page with slug "dummy"

- wpml

  - make cpt and tax translatable (WPML > Einstellungen)
  - translate slugs for cpt and tax (WPML > Einstellungen > Verschiedene Slugs in verschiedenen Sprachen einstellen für Dummykategorie)
  - add posts, taxonomies and pages in other language
  
- disadvantage: https://tld.com/dummy/foobar/item also works

### solution 2

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

- disadvantage: term links are not nested

### solution 3

- create your custom router and catch all requests after a prefix (see https://gist.github.com/vielhuber/eecc6d44ed7c18e2066e)
