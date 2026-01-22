<?php
/* custom filtering in wordpress backend */
add_action('restrict_manage_posts', function() {
    $type = (isset($_GET['post_type'])?($_GET['post_type']):('post'));

    // restrict to specific post type
    if( $type != 'custom_post_type' ) { return; }

    // example: dropdown filter custom taxonomy
    echo '<select name="custom_filter_location">';
        echo '<option value="">Spezielles Feld</option>';
            $current = (isset($_GET['custom_filter_location'])?($_GET['custom_filter_location']):(''));
            foreach(get_terms([
                'taxonomy' => 'custom_taxonomy',
                'hide_empty' => false,
            ]) as $terms__value) {
                echo '<option value="'.$terms__value->term_id.'" '.(($terms__value->term_id == $current)?(' selected="selected"'):('')).'>'.$terms__value->name.'</option>';
            }
    echo '</select>';

    // example: search for meta field
    echo '<input type="search" name="custom_filter_custom_field" value="'.(isset($_GET['custom_filter_custom_field'])?($_GET['custom_filter_custom_field']):('')).'" placeholder="Spezielles Feld" />';

});
add_filter('parse_query', function($query) {
    global $pagenow;
    $type = (isset($_GET['post_type'])?($_GET['post_type']):('post'));
    if( !is_admin() || $pagenow != 'edit.php' ) { return; }

    // restrict to specific post type
    if( $type != 'custom_post_type' ) { return; }

    // dropdown
    if( isset($_GET['custom_filter_location']) && $_GET['custom_filter_location'] != '' ) {
        $query->query_vars['tax_query'] = [
            [
                'taxonomy' => 'custom_taxonomy',
                'field' => 'term_id',
                'terms' => $_GET['custom_filter_location']
            ]
        ];
    }

    // search
    if( isset($_GET['custom_filter_custom_field']) && $_GET['custom_filter_custom_field'] != '' ) {
        $query->query_vars['meta_query'] = [
            [
                'key' => 'custom_field',
                'value' => $_GET['custom_filter_custom_field'],
                'compare' => 'LIKE'
            ]
        ];
    }
});

/* add a custom column */
$custom_field_post_type = 'posts';
$custom_field_post_type = 'contacts';
add_filter('manage_' . $custom_field_post_type . '_posts_columns', function ($defaults) {
    $defaults['custom_field'] = 'Spezielles Feld';
    // if you want to hide columns
    unset($defaults['title']);
    unset($defaults['date']);
    // if you want to order the fields, simply order the assoc array
    ksort($defaults);
    return $defaults;
});
add_action(
    'manage_' . $custom_field_post_type . '_posts_custom_column',
    function ($column_name, $post_id) {
        if ($column_name === 'custom_field') {
            echo get_field('foo', $post_id);
        }
    },
    10,
    2
);

/* remove columns in taxonomies */
add_filter('manage_edit-custom_taxonomy_columns', function ($defaults) {
  unset($defaults['posts']);
  return $defaults;
});
