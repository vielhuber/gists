// problem with this solution: random links like https://tld.com/some-random-string/blogpost also work (the content of https://tld.com/real-category-slug/blogpost is shown).
remove_action('template_redirect', 'redirect_canonical');

// solution
add_filter( 'redirect_canonical', function( $redirect_url ) {
    $url = 'http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if (trim($redirect_url, '/') !== trim($url, '/')) {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        nocache_headers();
    }
    return false; 
});