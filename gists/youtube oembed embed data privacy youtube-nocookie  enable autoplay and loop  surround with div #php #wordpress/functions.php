<?php
// surround with div
add_filter( 'embed_oembed_html', function($html, $url, $attr, $post_id) {
    return '<div class="video_container"><div class="video_container__inner">'.$html.'</div></div>';
}, 10, 4 ) ;

// enable additional youtube parameters
add_filter( 'embed_oembed_html', function ($html, $url, $attr, $post_ID)
{
    if( strpos($html, 'https://www.youtube') !== false )
    {
        if( strpos($url, '&') !== false )
        {
            $props = substr($url, strpos($url, '&'));
            $pos = strpos($html, '"', strpos($html, 'https://www.youtube'));
            $html = substr($html, 0, $pos) . '&amp;'.$props . substr($html, $pos);
        }
    }
    return $html;
}, 10, 4);

// youtube oembed data privacy enable
add_filter('embed_oembed_html', function($html, $url, $attr, $post_ID)
{
    if(preg_match('#https?://(www\.)?youtu#i', $url) )
    {
		return preg_replace(
			'#src=(["\'])(https?:)?//(www\.)?youtube\.com#i',
			'src=$1$2//$3youtube-nocookie.com',
			$html
		);
	}
	return $html;
}, 10, 4);