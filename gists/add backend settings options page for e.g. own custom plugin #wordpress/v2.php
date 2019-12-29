<?php
// using custom code
add_action('admin_menu', function () {
    add_menu_page(
        'My Plugin',
        'My Plugin',
        'manage_options',
        'my-plugin',
        function () {
            ?>
            <style>
                .my-plugin__label-wrapper {
                    display: flex;
                    align-items: flex-start;
                    align-content: flex-start;
                }
                .my-plugin__label {
                    line-height: 2;
                    flex: 0 1 10%;
                }
                .my-plugin__input {
                    flex: 0 1 90%;
                }
            </style>
            <script>
                console.log('OK');
            </script>
            <?php
            echo '<div class="my-plugin wrap">';
            echo '<h1 class="my-plugin__title">My Plugin</h1>';
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                $settings = @$_POST['my_plugin'];
                update_option('my_plugin_settings', $settings);
                echo '<div class="my-plugin__notice notice notice-success is-dismissible"><p>Erfolgreich editiert</p></div>';
            }
            $settings = get_option('my_plugin_settings');
            echo '<form class="my-plugin__form" method="post" action="' .
                admin_url('admin.php?page=my-plugin') .
                '">';
            echo '<ul class="my-plugin__fields">';
            echo '<li class="my-plugin__field">';
            echo '<label class="my-plugin__label-wrapper">';
            echo '<span class="my-plugin__label">Example #1</span>';
            echo '<input class="my-plugin__input" type="text" name="my_plugin[example_1]" value="' .
                $settings['example_1'] .
                '" />';
            echo '</label>';
            echo '</li>';
            echo '<li class="my-plugin__field">';
            echo '<label class="my-plugin__label-wrapper">';
            echo '<span class="my-plugin__label">Example #2</span>';
            echo '<input class="my-plugin__input" type="text" name="my_plugin[example_2]" value="' .
                $settings['example_2'] .
                '" />';
            echo '</label>';
            echo '</li>';
            echo '</ul>';
            echo '<input class="my-plugin__submit button button-primary" name="submit" value="Speichern" type="submit" />';
            echo '</form>';
            echo '</div>';
        },
        'dashicons-admin-site',
        100
    );
});