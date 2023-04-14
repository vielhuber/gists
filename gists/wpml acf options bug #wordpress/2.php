<?php
add_action( 'admin_init', function()
{
    if( isset($_GET['page']) && $_GET['page'] === 'acf-options' && !isset($_GET['lang']) && defined('ICL_LANGUAGE_CODE') )
    {
        wp_redirect( get_admin_url() . 'admin.php?page=' . $_GET['page'] . '&lang=' . ICL_LANGUAGE_CODE );
    }
});