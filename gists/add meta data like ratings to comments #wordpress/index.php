<?php
// add comment
$comment_id = wp_new_comment([
  'comment_post_ID' => 1337,
  'comment_author' => 'Alice',
  'comment_author_email' => 'alice@bob.com',
  'comment_author_url' => 'https://tld.com',
  'comment_content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr',
  'comment_type' => '',
  'comment_parent' => 0,
  'user_id' => null
], true);
if (is_wp_error($comment_id)) { die(); }
// add meta data
add_comment_meta($comment_id, 'comment_field1', 'foo');
add_comment_meta($comment_id, 'comment_field2', 'bar');
add_comment_meta($comment_id, 'comment_field3', 'baz');