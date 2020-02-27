add_action(
  'post_updated',
  function ($post_ID, $post_after, $post_before) {
    if (get_the_permalink($post_before) != get_the_permalink($post_after)) {
      $url_before = get_the_permalink($post_before);
      $url_after = get_the_permalink($post_after);
      /* do some actions */
    }
  },
  10,
  3
);