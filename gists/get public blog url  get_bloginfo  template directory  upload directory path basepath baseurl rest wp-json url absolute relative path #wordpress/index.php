<?php
// public urls
get_bloginfo('url')
get_bloginfo('template_directory')
get_template_directory_uri()
get_stylesheet_directory_uri() // use this for child themes
wp_upload_dir()['baseurl']
admin_url( 'admin-ajax.php' ) // ajax url
rest_url('v1/foo/bar') // rest url
rest_url('v1/foo/bar?lang='.ICL_LANGUAGE_CODE) // rest url with wpml
wp_lostpassword_url() // reset password url
content_url() // wp-content

// public urls without language
site_url()
   
// full paths
get_home_path()
get_template_directory()
get_stylesheet_directory() // use this for child themes
wp_upload_dir()['basedir']
WP_CONTENT_DIR // wp-content
get_attached_file($attachment_id) // absolute path for attachment
 
// relative paths
parse_url(get_template_directory_uri(), PHP_URL_PATH)