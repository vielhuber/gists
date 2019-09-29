<?php
/* automatically set parent categories */
function auto_save_to_parent_categories($post_id, $taxonomy)
{
    $terms = wp_get_post_terms($post_id, $taxonomy);
    if(!empty($terms) && !is_wp_error($terms))
    {
        foreach($terms as $term)
        {
            while($term->parent != 0 && !has_term($term->parent, $taxonomy, $post_id))
            {
                wp_set_post_terms($post_id, [$term->parent], $taxonomy, true);
                $term = get_term($term->parent, $taxonomy);
            }
        }
    }
}

add_action('save_post', function($post_id, $post)
{
    // exclude post types
    if(!in_array($post->post_type, ['product']))
    {
        return $post_id;
    }
    // choose here your desired taxonomies (category is the standard one)
    foreach(['product_cat'] as $taxonomy)
    {
        auto_save_to_parent_categories($post_id, $taxonomy);
    }
}, 10, 2);

/* you also can do this afterwards (once) */
if( 1==0 )
{
    add_filter('wp_enqueue_scripts', function($query)
    {
        $offset = 0;
        if( isset($_GET['offset']) && $_GET['offset'] != '' )
        {
            $offset = $_GET['offset'];
        }
        $posts = get_posts([
            'posts_per_page' => 500,
            'offset' => ($offset * 500),
            'post_type' => 'product',
            'post_status' => 'publish',
            'suppress_filters' => false
        ]);
        foreach( $posts as $posts__value)
        {
            auto_save_to_parent_categories($posts__value->ID, 'product_cat');
        }
        if( !empty($posts) )
        {
            $url = 'http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            if( strpos($url, '?offset') !== false )
            {
                $url = substr($url, 0, strpos($url, '?offset'));
            }
            $url .= '?offset='.($offset+1);
            echo '<meta http-equiv="refresh" content="0; url=\''.$url.'\'">';
        }
    },5);    
}

/* preserve the category ordering */
add_filter('wp_terms_checklist_args', function($args, $post_id)
{
    if (isset($args['taxonomy']))
    {
        $args['checked_ontop'] = false;
    }
    return $args;
}, 10, 2);