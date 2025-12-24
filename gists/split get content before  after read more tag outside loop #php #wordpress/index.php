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
    } elseif (preg_match('/<span id=".+"><\/span>/', $content, $matches)) {
        list($return['before'], $return['after']) = explode($matches[0], $content, 2);
    } else {
        $return['before'] = $content;
        $return['after'] = '';
    }

    // clean up
    // remove gutenberg tags
    foreach (['before', 'after'] as $g1__value) {
        foreach (['/', ''] as $g2__value) {
            foreach (['wp:paragraph', 'wp:more', 'wp:html', 'wp:tadv/classic-paragraph'] as $g3__value) {
                $return[$g1__value] = str_replace(
                    '<!-- ' . $g2__value . '' . $g3__value . ' -->',
                    '',
                    $return[$g1__value]
                );
            }
        }
    }

    foreach ($return as $return__key => $return__value) {
        // remove whitespace
        $return[$return__key] = trim(preg_replace('/^[\s]*(.*)[\s]*$/', '\\1', $return[$return__key]));
        // remove all opening tags
        foreach (['<p></p>', '<p>', '</p>'] as $tags__value) {
            if (mb_strpos($return[$return__key], $tags__value) === 0) {
                $return[$return__key] = trim(mb_substr($return[$return__key], mb_strlen($tags__value)));
            }
        }
        // remove all closing tags
        foreach (['<p></p>', '<p>', '</p>'] as $tags__value) {
            if (
                mb_strrpos($return[$return__key], $tags__value) ===
                mb_strlen($return[$return__key]) - mb_strlen($tags__value)
            ) {
                $return[$return__key] = trim(
                    mb_substr($return[$return__key], 0, mb_strlen($return[$return__key]) - mb_strlen($tags__value))
                );
            }
        }
    }

    // add more tag
    if ($more_html !== null && $return['after'] !== '') {
        $return['before'] = $return['before'] . '' . $more_html;
    }

    // add opening / closing p-tags
    foreach ($return as $return__key => $return__value) {
        if ($return[$return__key] == '') {
            continue;
        }
        $return[$return__key] =
            (mb_strpos($return[$return__key], '<p') !== 0 ? '<p>' : '') .
            $return[$return__key] .
            (mb_strrpos($return[$return__key], '</p>') !== mb_strlen($return[$return__key]) - mb_strlen('</p>')
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
  }
echo '</div>';