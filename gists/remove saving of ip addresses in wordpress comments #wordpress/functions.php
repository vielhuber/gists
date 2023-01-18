<?php
add_filter('pre_comment_user_ip', function()
{
    return '127.0.0.1';
});