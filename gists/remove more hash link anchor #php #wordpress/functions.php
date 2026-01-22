/* remove hash tag from readmore */
add_filter('the_content_more_link', function ($link) {
    $offset = strpos($link, '#more-');
    if ($offset) {
        $end = strpos($link, '"', $offset);
    }
    if ($end) {
        $link = substr_replace($link, '', $offset, $end - $offset);
    }
    return $link;
});

/* fully remove readmore link */
add_filter('the_content_more_link', function () {
    return '';
});
