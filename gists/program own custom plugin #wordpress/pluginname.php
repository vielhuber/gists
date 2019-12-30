<?php
/**
 * Plugin Name: pluginname
 * Plugin URI: https://github.com/vielhuber/pluginname
 * Description: Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
 * Version: 1.0
 * Author: David Vielhuber
 * Author URI: https://vielhuber.de
 * License: free
 */
  
// install hook
register_activation_hook(__FILE__, function() {
    add_option(
        'my_plugin_settings',
        '...'
    );
});


// uninstall hook
register_uninstall_hook(__FILE__, 'my_plugin_uninstall'); // warning: anonymous functions don't work here
function my_plugin_uninstall() {
    delete_option('my_plugin_settings')
}

// your code (like in functions.php)
/* ... */
