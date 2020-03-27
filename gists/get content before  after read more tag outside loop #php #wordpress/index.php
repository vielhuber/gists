<?php
// with wordpress native functions
echo get_extended($p->post_content)['main'];
echo get_extended($p->post_content)['extended'];


// with own function (wordpress own function has problems with enabled p tags)
function wp_split_more($content, $type, $more_html = null)
{
    $return = [
        'before' => null,
        'after' => null
    ];

    // split up
    if (preg_match('/<!--more(.*?)?-->/', $content, $matches)) {
        list($return['before'], $return['after']) = explode($matches[0], $content, 2);
    } else {
        $return['before'] = $content;
        $return['after'] = '';
    }

    // clean up
    // remove gutenberg tags
    $return['before'] = str_replace('<!-- wp:paragraph -->', '', $return['before']);
    $return['before'] = str_replace('<!-- /wp:paragraph -->', '', $return['before']);
    $return['before'] = str_replace('<!-- wp:more -->', '', $return['before']);
    $return['after'] = str_replace('<!-- /wp:more -->', '', $return['after']);
    $return['after'] = str_replace('<!-- wp:paragraph -->', '', $return['after']);
    $return['after'] = str_replace('<!-- /wp:paragraph -->', '', $return['after']);
    foreach ($return as $return__key => $return__value) {
        // remove whitespace
        $return[$return__key] = trim(preg_replace('/^[\s]*(.*)[\s]*$/', '\\1', $return[$return__key]));
        // remove falsly opening p tag
        if (strpos($return[$return__key], '</p>') === 0) {
            $return[$return__key] = trim(substr($return[$return__key], strlen('</p>')));
        }
        // remove opening p tag
        if (strpos($return[$return__key], '<p>') === 0) {
            $return[$return__key] = trim(substr($return[$return__key], strlen('<p>')));
        }
        // remove closing p tag
        if (strrpos($return[$return__key], '<p>') === strlen($return[$return__key]) - strlen('<p>')) {
            $return[$return__key] = trim(
                substr($return[$return__key], 0, strlen($return[$return__key]) - strlen('<p>'))
            );
        }
        if (strrpos($return[$return__key], '</p>') === strlen($return[$return__key]) - strlen('</p>')) {
            $return[$return__key] = trim(
                substr($return[$return__key], 0, strlen($return[$return__key]) - strlen('</p>'))
            );
        }
    }

    // add more tag
    if ($more_html !== null && $return['after'] !== '') {
        $return['before'] = $return['before'] . '' . $more_html;
    }

    // add opening / closing p-tags
    foreach ($return as $return__key => $return__value) {
        $return[$return__key] =
            (strpos($return[$return__key], '<p>') !== 0 ? '<p>' : '') .
            $return[$return__key] .
            (strrpos($return[$return__key], '</p>') !== strlen($return[$return__key]) - mb_strlen('</p>')
                ? '</p>'
                : '');
    }
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