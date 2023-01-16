<?php
function ev_unregister_taxonomy(){
    register_taxonomy('post_tag', array());
}
add_action('init', 'ev_unregister_taxonomy');