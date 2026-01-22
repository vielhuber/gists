<?php
if( !is_admin() && $pagenow != 'wp-login.php' && pll_current_language() == 'en' )
{
    wp_redirect(site_url().'/de/');
    die();
}