<?php
// with wordpress native functions
echo get_extended($p->post_content)['main'];
echo get_extended($p->post_content)['extended'];


// with own function (wordpress own function has problems with enabled p tags)
function wp_split_more($content, $type, $more_html = null) {

    $return = [
        'before' => null,
        'after' => null
    ];

    // split up
    if ( preg_match('/<!--more(.*?)?-->/', $content, $matches) ) {
        list($return['before'], $return['after']) = explode($matches[0], $content, 2);
    }
    else {
        $return['before'] = $content;
        $return['after'] = '';
    }

    // clean up
    // remove gutenberg tags
    $return['before'] = str_replace('<!-- wp:paragraph -->','',$return['before']);
    $return['before'] = str_replace('<!-- /wp:paragraph -->','',$return['before']);
    $return['before'] = str_replace('<!-- wp:more -->','',$return['before']);
    $return['after'] = str_replace('<!-- /wp:more -->','',$return['after']);
    foreach($return as $key=>$value) {
        // remove whitespace
        $return[$key] = trim(preg_replace('/^[\s]*(.*)[\s]*$/', '\\1', $return[$key]));
        // remove falsly opening p tag
        if( strpos($return[$key], '</p>') === 0 ) { $return[$key] = trim(substr($return[$key], strlen('</p>'))); }
        // remove opening p tag
        if( strpos($return[$key], '<p>') === 0 ) { $return[$key] = trim(substr($return[$key], strlen('<p>'))); }
        // remove closing p tag
        if( strrpos($return[$key], '<p>') === strlen($return[$key])-strlen('<p>') ) { $return[$key] = trim(substr($return[$key], 0, strlen($return[$key])-strlen('<p>'))); }
        if( strrpos($return[$key], '</p>') === strlen($return[$key])-strlen('</p>') ) { $return[$key] = trim(substr($return[$key], 0, strlen($return[$key])-strlen('</p>'))); }
    }

    // add more tag
    if( $more_html !== null && $return['after'] !== '' ) {
        $return['before'] = $return['before'].''.$more_html; 
    }

    // add opening / closing p-tags
    $return['before'] = (($return['before'][0] != '<')?('<p>'):('')).$return['before'].(($return['before'][strlen($return['before'])-1] != '>')?('</p>'):(''));
    $return['after'] = (($return['after'][0] != '<')?('<p>'):('')).$return['after'].(($return['after'][strlen($return['after'])-1] != '>')?('</p>'):(''));    
    return $return[$type];
    
}

// example usage
echo '<div class="content">';
  echo '<div class="before">';
  	echo wp_split_more(get_post_field('post_content', get_the_ID()), 'before', '<a href="'.get_permalink(get_the_ID()).'" class="more">&gt;&gt;&gt;</a>');
  echo '</div>';
  if( wp_split_more(get_post_field('post_content', get_the_ID()), 'after') !== null && wp_split_more(get_post_field('post_content', get_the_ID()), 'after') != "" ) {
  	echo '<div class="after">';
  		echo wp_split_more(get_post_field('post_content', get_the_ID()), 'after');
  	echo '</div>';
echo '</div>';
}
?>