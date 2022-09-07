// WordPress: Wrap div around automatically oembedded youtube videos
add_filter( 'embed_oembed_html', 'custom_oembed_filter', 10, 4 ) ;
function custom_oembed_filter($html, $url, $attr, $post_ID) {
    $return = '<div class="video-container"><div>'.$html.'</div></div>';
    return $return;
}