add_action(
  'post_updated',
  function ($post_ID, $post_after, $post_before) {
    $post_before_status = get_post_status($post_before);
    $post_after_status = get_post_status($post_after);
    $post_before_url = get_permalink($post_before);
    $post_after_url = get_permalink($post_after);
    if ($post_before_url != $post_after_url) {
      /* do some actions */
    }
    if($post_before_status === 'draft' || $post_before_status === 'trash') {
      /* do some actions */
    }
  },
  10,
  3
);