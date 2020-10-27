<?php
/**
 * Plugin Name: pluginname
 * Plugin URI: https://github.com/vielhuber/pluginname
 * Description: Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
 * Version: 1.0.0
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


// uninstall hook (not recommended, does not work when deleting options, instead create an "uninstall.php" file)
/*
register_uninstall_hook(__FILE__, 'my_plugin_uninstall'); // warning: anonymous functions don't work here
function my_plugin_uninstall() {
    delete_option('my_plugin_settings')
}
*/

// localization
// first create languages/my-plugin-de_DE.po/.mo
add_action('plugins_loaded', function () {
  load_plugin_textdomain('my-plugin', false, dirname(plugin_basename(__FILE__)) . '/languages/');
});

// your code (like in functions.php)
/* ... */
add_action('after_setup_theme', function () {
	echo __('String', 'my-plugin');
});

// run migrations on plugin update
add_action('after_setup_theme', function () {
    if( !is_admin() && !in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']) ) {
        return;
    }
    $version_prev = get_option('my-plugin_plugin_version');
    $version_next = get_file_data(__FILE__, ['Version' => 'Version'], false)['Version'];
    if ($version_prev === false || $version_prev === null || $version_prev === '') {
        $version_prev = $version_next;
    }
    // debug
    //$version_prev = '4.9.5';
    if ($version_next === $version_prev) {
        return;
    }
    $migrations = [
        '4.9.6' => function () {
            // running update 4.9.6
        },
        '4.9.7' => function () {
            // running update 4.9.7
        }
        /* ... */
    ];
    foreach ($migrations as $migrations__key => $migrations__value) {
        if (
            intval(str_replace('.', '', $migrations__key)) > intval(str_replace('.', '', $version_prev)) &&
            intval(str_replace('.', '', $migrations__key)) <= intval(str_replace('.', '', $version_next))
        ) {
            $migrations__value();
        }
    }
    update_option('my-plugin_plugin_version', $version_next);
});
