<?php
// using custom code
add_action('admin_menu', function () {
    $menu = add_menu_page(
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
            $message = '';
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                $settings = @$_POST['my_plugin'];
                update_option('my_plugin_settings', $settings);
                $message = '<div class="my-plugin__notice notice notice-success is-dismissible"><p>Erfolgreich editiert</p></div>';
            }
            $settings = get_option('my_plugin_settings');
            echo '<div class="my-plugin wrap">';
            echo '<form class="my-plugin__form" method="post" action="' . admin_url('admin.php?page=my-plugin') . '">';
            echo '<h1 class="my-plugin__title">My Plugin</h1>';
            echo $message;
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
  	// if you want to add external css/js files
  	add_action('admin_print_styles-' . $menu, function () {
    	wp_enqueue_style('my-plugin-css', plugins_url('my-plugin.css', __FILE__));
  	});
  	add_action('admin_print_scripts-' . $menu, function () {
	    wp_enqueue_script('my-plugin-js', plugins_url('my-plugin.js', __FILE__));
  	});  
  	// if you want to add a special class to the body
    add_filter('admin_body_class', function ($classes) {
        $classes .= ' gtbabel-wrapper';
        return $classes;
    });
});