<?php
add_action('restrict_manage_posts', function() {
    $type = (isset($_GET['post_type'])?($_GET['post_type']):('post'));
    if( $type != 'custom_post_type' ) { return; }
    echo '<a style="line-height:30px;" href="https://test.de" target="_blank">Custom Link</a>';
});