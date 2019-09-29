<?php
// public path
if( has_post_thumbnail(get_the_ID()) ) {
	echo '<div style="background-image:url(\''.wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ).'\')"></div>';
}

// full path
get_attached_file( get_post_thumbnail_id(get_the_ID()) )