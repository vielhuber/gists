<?php
add_action('init', function()
{
  register_nav_menus([
    'main-menu' => __('Main Menu', 'theme_domain'),
    'sub-menu' => __('Sub Menu', 'theme_domain')
  ]);
  
  // alternative
  register_nav_menu('main-menu', __( 'Main Menu', 'theme_domain' ) );
  register_nav_menu('sub-menu', __( 'Sub Menu', 'theme_domain' ) );
});