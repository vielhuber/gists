/* this is generally not needed, but you can do it this way: */
add_filter('script_loader_tag', function($tag, $handle)
{
    $tag = str_replace(' src', ' async="async" src', $tag);
    return $tag;
}, 10, 2);