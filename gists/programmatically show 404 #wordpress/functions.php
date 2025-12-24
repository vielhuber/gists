add_action( 'wp', function( $query )
{
    if( 1==1 ) {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
      	nocache_headers();
    }
});
