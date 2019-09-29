<?php
function se_comment_moderation_recipients( $emails, $comment_id ) {
    $emails[] = 'custom@tld.com';
    return $emails;
}
add_filter( 'comment_moderation_recipients', 'se_comment_moderation_recipients', 11, 2 );
add_filter( 'comment_notification_recipients', 'se_comment_moderation_recipients', 11, 2 );