add_action( 'wp', function( $query )
{
    if( is_post_type_archive( 'custom' ) && get_query_var('paged') ) {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
    }
});
