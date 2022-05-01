<?php
add_action('init', function () {
    $data = ['key' => 'book', 'slug' => 'books', 'label_singular' => 'Buch', 'label_plural' => 'Bücher'];
    $args = [
        'labels' => [
            'name' => $data['label_plural'],
            'singular_name' => $data['label_singular'],
            'menu_name' => $data['label_plural'],
            'name_admin_bar' => $data['label_singular'],
            'new_item' => 'Neues ' . $data['label_singular'],
            'edit_item' => $data['label_singular'] . ' editieren',
            'view_item' => $data['label_singular'] . ' ansehen',
            'all_items' => 'Alle ' . $data['label_plural'],
            'not_found' => 'Keine ' . $data['label_plural'] . ' gefunden'
        ],
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments']
    ];
    if (isset($data['slug']) && $data['slug'] != '') {
        $args['public'] = true;
        $args['publicly_queryable'] = true;
        $args['rewrite'] = ['slug' => $data['slug']];
    } else {
        $args['public'] = false;
        $args['publicly_queryable'] = false;
        $args['rewrite'] = null;
    }
    register_post_type($data['key'], $args);
});
