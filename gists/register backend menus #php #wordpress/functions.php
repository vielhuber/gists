<?php
add_action('admin_menu', function()
{
    add_menu_page(
        'Downloadlinks',
        'Downloadlinks',
        'manage_options',
        'downloadlinks',
        function()
        {
            echo 'todo';
        },
        'dashicons-format-aside',
        6
    );
});