<?php
// minimal version
define( 'SHORTINIT', true );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

// medium version (With lots of overhead)
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

// full version (including functions and 200 header)
define( 'SHORTINIT', true );
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/vielhuber/functions.php');
header('HTTP/1.1 200 OK');

// full
define('WP_USE_THEMES', false);
require($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');
header('HTTP/1.1 200 OK');

// full with skeleton
define('WP_USE_THEMES', false);
require($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');
header('HTTP/1.1 200 OK');
echo '<html>';
echo '<head>'; wp_head(); echo '</head>';
echo '<body>';
if( have_posts() ) {
    while( have_posts() ) {
        the_post();
        the_title();
        the_content();
    }
}
wp_footer();
echo '</body>';
echo '</html>';

// warning: some approaches do NOT WORK with the plugin All 404 Redirect to Homepage(!)

// functions.php
/* when loading wordpress externally, it sometimes happen that functions.php is included twice. we prevent this here */
if( !function_exists('prevent_multiple_execution') ) { function prevent_multiple_execution() {}

// ... content of functions.php

}

// functions.php
// this is a another approach (way better) to exclude some plugins on shortinit that cause undefined function errors */
// disable plugins on shortinit (to prevent undefined function errors)
if (defined('SHORTINIT') && SHORTINIT)
{
    add_filter('option_active_plugins', function($plugins)
    {
        $loadplugins = ['some-plugin-you-need'];
        foreach($plugins as $plugins__key => $plugins__value)
        {
            if (!in_array($plugins__value, $loadplugins)) {
                unset($plugins[$plugins__key]);
            }
        }
        return $plugins;
    });
}