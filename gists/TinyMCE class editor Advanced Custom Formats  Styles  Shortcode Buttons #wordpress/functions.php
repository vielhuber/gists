<?php 
add_action('admin_head', function()
{
    // check user permissions
    if( !current_user_can('edit_posts') && !current_user_can('edit_pages') )
    {
        return;
    }
    // check if editor is enabled
    if( get_user_option( 'rich_editing' ) == 'true' )
    {
        add_filter( 'mce_external_plugins', function($plugin_array)
        {
            $plugin_array['mce_buttons'] = get_stylesheet_directory_uri().'/mce-button.js';
            return $plugin_array;
        });
    }
});
add_filter('mce_buttons', function($buttons)
{
    array_push( $buttons, 'mce_button_1' );
    array_push( $buttons, 'mce_button_2' );
    return $buttons;
});