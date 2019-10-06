<?php
function themeslug_remove_hentry( $classes ) {
    $classes = array_diff( $classes, array( 'hentry' ) );
    return $classes;
}
add_filter( 'post_class','themeslug_remove_hentry' );