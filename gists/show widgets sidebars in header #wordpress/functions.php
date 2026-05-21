add_action('wp_head', function() {
    foreach(['widget1','widget2','widget3'] as $widget)
    {
        if ( is_active_sidebar( $widget ) )
        {
            dynamic_sidebar( $widget );
        }
    }
});