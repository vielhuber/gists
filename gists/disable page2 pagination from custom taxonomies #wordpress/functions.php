<?php
function remove_pagination_from_taxonomies( $query )
{
	if( is_tax() )
	{
		$query->set( 'posts_per_page', '999999' );
	}
}
add_action( 'pre_get_posts', 'remove_pagination_from_taxonomies' );