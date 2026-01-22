<?php
add_action('admin_menu', function() {
    add_menu_page(
        'Foo',
        'Foo',
        'delete_users',
        'FOO',
        function() {}, // empty page
        'dashicons-chart-pie',
        6
    );
    add_submenu_page(
        'FOO',
        'Bar',
        '✍️ Bar',
        'delete_users',
        'FOO_BAR',
        function() {
            echo '...';
        },
    );
  	// to remove first item
  	remove_submenu_page('FOO', 'FOO');
});