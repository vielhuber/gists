add_action('init', function () {
    register_post_type('book', [
        'labels' => [
            'name' => 'Bücher',
            'singular_name' => 'Buch',
            'menu_name' => 'Bücher',
            'name_admin_bar' => 'Buch',
            'new_item' => 'Neues Buch',
            'edit_item' => 'Buch editieren',
            'view_item' => 'Buch ansehen',
            'all_items' => 'Alle Bücher',
            'not_found' => 'Keine Bücher gefunden'
        ],
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'book'],
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments']
    ]);
});