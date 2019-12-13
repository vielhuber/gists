<?php
// public url
get_bloginfo('url')
get_bloginfo('template_directory')
get_stylesheet_directory_uri() // use this for child themes
wp_upload_dir()['baseurl']
admin_url( 'admin-ajax.php' ) // ajax url

// public url without language
site_url()
   
// full path
get_home_path()
get_template_directory()
get_stylesheet_directory() // use this for child themes
wp_upload_dir()['basedir']
 
// relative path
parse_url(get_template_directory_uri(), PHP_URL_PATH)