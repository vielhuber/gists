- tips for debugging: Plugin "Monkeyman Rewrite analyzer"

### solution 1

- works both with a nested or flat structure

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
// register
add_action('init', function() use($options) {
    register_post_type(
        $options['cpt']['name'],
        [
            'public' => true, 
            'rewrite' => [
                'slug' => $options['cpt']['slug'].'/%the_'.$options['tax']['name'].'%', // placeholder must not start with "dummy", otherwise the rewrite rules get stripped out
                'with_front' => false
            ],
            'has_archive' => false,
            'label' => $options['cpt']['label'],
        ]
    );
    register_taxonomy(
        $options['tax']['name'],
        $options['cpt']['name'],
        [
            'public' => true,
            'rewrite' => [
                'slug' => $options['cpt']['slug'],
                'with_front' => false,
                'hierarchical' => true
            ],
            'hierarchical' => true,
            'label' => $options['tax']['label'],
        ]
    );
});
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
// adjust post link
add_filter( 'post_type_link', function( $url, $post ) use($options) {
    if( isset($post->post_type) && $post->post_type == $options['cpt']['name'] ) {
        $terms = wp_get_object_terms( $post->ID, $options['tax']['name'] );
        if( !empty($terms) ) {
            $replacement = '';
            $parent_term = false;
            while (true) {
                $found = false;
                foreach ($terms as $key => $term) {
                    if ($term->parent == 0) {
                        $parent_term = $term->term_id;
                        $replacement = $term->slug;
                        unset($terms[$key]);
                        $found = true;
                        break;
                    }
                    if ($term->parent == $parent_term) {
                        $parent_term = $term->term_id;
                        $replacement .= '/' . $term->slug;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    break;
                }
            }
            return str_replace( '%the_'.$options['tax']['name'].'%', $replacement, $url);
        }
    }
    return $url;
}, 1, 2 );
// /dummy/foo/bar/ is always considered as taxonomy. if the last part is a page, change this to single
add_filter('request', function($query) use($options) {
    if (!empty($query[$options['tax']['name']]) && !is_admin()) {
        $slugs = explode('/', $query[$options['tax']['name']]);
        if (count($slugs) > 1) {
            $slug = array_pop($slugs);
            $post = get_page_by_path($slug, OBJECT, $options['cpt']['name']);
            if (!empty($post)) {
                $query = [
                    $options['cpt']['name'] => $slug,
                    'post_type' => $options['cpt']['name'],
                    'name' => $slug
                ];
            }
        }
    }
    return $query;
}, 10, 1);
```

- create a page with slug "dummy"

- create template files

  - `single-dummy.php` (https://tld.com/dummy/category/item)
  - `taxonomy-dummy-cat.php` (https://tld.com/dummy/category)
  - `archive-dummy.php` (https://tld.com/dummy) (only, if `'has_archive' => 'dummy'`; if you set `'has_archive' => false`, the static page is used instead)

- save permalinks

- wpml

  - make cpt and tax translatable (WPML > Einstellungen)
  - translate slugs for cpt and tax including the placeholder (WPML > Einstellungen > Verschiedene Slugs in verschiedenen Sprachen einstellen für Dummykategorie)
  - add posts, taxonomies and pages in other language

### solution 2

- create your custom router and catch all requests after a prefix (see https://gist.github.com/vielhuber/eecc6d44ed7c18e2066e)
