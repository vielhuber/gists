<?php
// using the settings api
$opts = [
    'title' => 'My Plugin',
    'slug' => 'my_plugin',
    'permission' => 'manage_options',
    'fields' => [
        [
            'title' => 'Example #1',
            'id' => 'my_plugin_example_1',
            'html' => function () {
                echo '<input type="text" name="my_plugin_example_1" value="' .
                    get_option('my_plugin_example_1') .
                    '">';
            }
        ],
        [
            'title' => 'Example #2',
            'id' => 'my_plugin_example_2',
            'html' => function () {
                echo '<input type="text" name="my_plugin_example_2" value="' .
                    get_option('my_plugin_example_2') .
                    '">';
            }
        ]
    ]
];
add_action('admin_menu', function () use ($opts) {
    add_submenu_page(
        'options-general.php',
        $opts['title'],
        $opts['title'],
        $opts['permission'],
        $opts['slug'],
        function () use ($opts) {
            echo '<form method="POST" action="options.php">';
            settings_fields($opts['slug']);
            do_settings_sections($opts['slug']);
            submit_button();
            echo '</form>';
        },
        null
    );
});
add_action('admin_init', function () use ($opts) {
    add_settings_section($opts['slug'] . '-section', $opts['title'], '', $opts['slug']);
    foreach ($opts['fields'] as $fields__value) {
        add_settings_field(
            $fields__value['id'],
            $fields__value['title'],
            $fields__value['html'],
            $opts['slug'],
            $opts['slug'] . '-section'
        );
        register_setting($opts['slug'], $fields__value['id']);
    }
});