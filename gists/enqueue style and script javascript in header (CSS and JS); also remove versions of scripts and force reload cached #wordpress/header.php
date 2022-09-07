<?php
// css
wp_enqueue_style('style0',get_bloginfo('template_directory')."/style0.css");
wp_enqueue_style('style1',get_bloginfo('template_directory')."/style1.css", ['style0']);
wp_enqueue_style('style2',get_bloginfo('template_directory')."/style2.css", ['style0']);
wp_enqueue_style('print',get_bloginfo('template_directory').'/print.css', [], false, 'print'); // media="print"

// js
wp_enqueue_script('script1',get_bloginfo('template_directory')."/script1.js",['jquery']);
wp_enqueue_script('script0',get_bloginfo('template_directory')."/script0.js",['jquery'], false, true); // in footer
wp_enqueue_script('script0',get_bloginfo('template_directory')."/script0.js",[], false, true); // in footer without any dependency
wp_enqueue_script('jquery');

// alternatively put this in an action and call it in functions.php
function load_scripts() {
  // ...
}
add_action('wp_enqueue_scripts', 'load_scripts');

// remove automatically added wordpress version from script
function wp_remove_version($src)
{
    if(strpos($src, 'ver=')) { $src = remove_query_arg( 'ver', $src ); }
    return $src;
}
add_filter( 'style_loader_src', 'wp_remove_version', 9999 );
add_filter( 'script_loader_src', 'wp_remove_version', 9999 );

// reload on every request
function wp_modify_version($src, $handle)
{
    if(strpos($src, 'ver=') !== false)
    {
        $src = remove_query_arg('ver', $src);
    }
    $src = add_query_arg('ver', mt_rand(1000,9999), $src);
    return $src;
}
add_filter( 'style_loader_src', 'wp_modify_version', 9999 );
add_filter( 'script_loader_src', 'wp_modify_version', 9999 );

// modify version to timestamp of files (so files are cached until they are changed)
function wp_modify_version($src, $handle)
{
    if(strpos($src, 'ver=') !== false)
    {
        $src = remove_query_arg('ver', $src);
    }
    $src = add_query_arg('ver', filemtime(str_replace(site_url(),$_SERVER['DOCUMENT_ROOT'],$src)), $src);
    return $src;
}
add_filter( 'style_loader_src', 'wp_modify_version', 9999 );
add_filter( 'script_loader_src', 'wp_modify_version', 9999 );

// modify version due to version number of git
$git_version = 0;
exec('git rev-parse --short HEAD', $git_version);
$git_version = trim($git_version[0]);
function wp_modify_version($src)
{
    global $git_version;
    if(strpos($src, 'ver=') !== false)
    {
        $src = remove_query_arg('ver', $src);
    }
    $src = add_query_arg('ver', $git_version, $src);
    return $src;
}
add_filter( 'style_loader_src', 'wp_modify_version', 9999 );
add_filter( 'script_loader_src', 'wp_modify_version', 9999 );