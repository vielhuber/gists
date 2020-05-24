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
              	check_admin_referer('my-plugin-submit'); // check nonce
                $settings = @$_POST['my_plugin'];
              	$settings = stripslashes_deep($settings); // remove slashes
              	// always sanitize, escape, validate here, otherwise your plugin will be rejected!
                $settings = __array_map_deep($settings, function ($settings__value) {
                  return sanitize_textarea_field($settings__value);
                });
              	// ...
                update_option('my_plugin_settings', $settings);
                $message = '<div class="my-plugin__notice notice notice-success is-dismissible"><p>Erfolgreich editiert</p></div>';
            }
            $settings = get_option('my_plugin_settings');
            echo '<div class="my-plugin wrap">';
            echo '<form class="my-plugin__form" method="post" action="' . admin_url('admin.php?page=my-plugin') . '">';
          	wp_nonce_field('my-plugin-submit'); // setup nonce
            echo '<h1 class="my-plugin__title">My Plugin</h1>';
            echo $message;
            echo '<ul class="my-plugin__fields">';
            echo '<li class="my-plugin__field">';
            echo '<label class="my-plugin__label-wrapper">';
            echo '<span class="my-plugin__label">Example #1</span>';
            echo '<input class="my-plugin__input" type="text" name="my_plugin[example_1]" value="' .
                esc_attr($settings['example_1']) .
                '" />';
            echo '</label>';
            echo '</li>';
            echo '<li class="my-plugin__field">';
            echo '<label class="my-plugin__label-wrapper">';
            echo '<span class="my-plugin__label">Example #2</span>';
            echo '<input class="my-plugin__input" type="text" name="my_plugin[example_2]" value="' .
                esc_attr($settings['example_2']) .
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
  
  	/* if you want to add external css/js files */
  	add_action('admin_print_styles-' . $menu, function () {
    	wp_enqueue_style('my-plugin-css', plugins_url('my-plugin.css', __FILE__));
  	});
  	add_action('admin_print_scripts-' . $menu, function () {
	    wp_enqueue_script('my-plugin-js', plugins_url('my-plugin.js', __FILE__));
  	});  
  
  	/* if you want to add a special class to the body */
    add_filter('admin_body_class', function ($classes) {
        if (@$_GET['page'] == 'my-plugin') {
          $classes .= ' my-plugin-wrapper';
        }
        return $classes;
    });
  
    /* if you want to add submenus */
    // the first line modifies the name of the first (auto created) submenu entry
    add_submenu_page('my-plugin', 'My Plugin First', 'My Plugin First', 'manage_options', 'my-plugin');
  	// this adds the submenu entry
    $submenu = add_submenu_page('my-plugin', 'My Plugin Second', 'My Plugin Second', 'manage_options', 'my-plugin-second', function () { echo 'FOO'; });
    // the above scripts/styles don't apply to any submenus; uncomment them and apply it to all (sub)menus instead
    $menus = [];
    $menus[] = $menu;
    $menus[] = $submenu;
    foreach ($menus as $menus__value) {
      add_action('admin_print_styles-' . $menus__value, function () {
        wp_enqueue_style('gtbabel-css', plugins_url('gtbabel.css', __FILE__));
      });
      add_action('admin_print_scripts-' . $menus__value, function () {
        wp_enqueue_script('gtbabel-js', plugins_url('gtbabel.js', __FILE__));
      });
    }
});
// add gutenberg sidebar metabox
add_action('add_meta_boxes', function () {
  add_meta_box(
    'plugin-box-1',
    'Plugin box 1',
    function ($post) {
      echo $post->ID;
    },
    ['post','page'],
    'side',
    'high'
  );
});
// add menu item (with icon) to top bar
add_action(
  'admin_bar_menu',
  function ($admin_bar) {
    $admin_bar->add_menu([
      'id' => 'my-plugin-item',
      'parent' => null,
      'group' => null,
      'title' => '<span class="ab-icon"></span>' . __('My Plugin Item', 'gtbabel-plugin'),
      'href' => admin_url('admin.php?page=my-plugin'),
      'meta' => ['target' => '_blank']
    ]);
  },
  500
);
add_action(
  'admin_head',
  function () {
    ?>
    <style>
    /* add icon */
    #wpadminbar #wp-admin-bar-my-plugin-item .ab-icon:before { content: "\f306"; top: 3px; }
    </style>
    <script>
    /* reflect url changes in gutenberg */
    document.addEventListener('DOMContentLoaded', function() {
        if( wp !== undefined && wp.data !== undefined ) {
            if( window.location.href.indexOf('post-new.php') > -1 || window.location.href.indexOf('post.php') > -1 ) {
                let prev_status = wp.data.select('core/editor').getEditedPostAttribute('status'),
                    prev_permalink = wp.data.select('core/editor').getPermalink(),
                    ready = false;
                wp.data.subscribe(function () {
                    let isSavingPost = wp.data.select('core/editor').isSavingPost(),
                        isAutosavingPost = wp.data.select('core/editor').isAutosavingPost();
                    if (isSavingPost && !isAutosavingPost && ready === false) {
                        let cur_status = wp.data.select('core/editor').getEditedPostAttribute('status'),
                            cur_permalink = wp.data.select('core/editor').getPermalink();
                        let skip = false;
                        if( prev_status === cur_status && prev_permalink === cur_permalink ) { skip = true; }
                        prev_status = cur_status;
                        prev_permalink = cur_permalink;
                        if( skip === true ) { return; }
                        ready = true;
                    }
                    else if(!isSavingPost && !isAutosavingPost && ready === true) {
                        ready = false;
                        fetch(window.location.href).then(v=>v.text()).catch(v=>v).then(data => {
                            let dom = new DOMParser().parseFromString(data, 'text/html').querySelector('#wp-admin-bar-my-plugin-item');
                            if( dom !== null ) {
                                document.querySelector('#wp-admin-bar-my-plugin-item').innerHTML = dom.innerHTML;
                            }
                        }); 
                    }
                });
            }
        }
    });
    /* open media library and pick file */
    document.addEventListener('DOMContentLoaded', function() {
      document.addEventListener('click', e => {
          let el = e.target.closest('.file-upload');
          if (el) {
              let image_frame;
              if (image_frame) {
                  image_frame.open();
              }
              image_frame = wp.media({
                  title: 'Select Media',
                  multiple: false,
                  button: { text: 'Insert' },
                  library: {
                      type: 'image'
                  }
              });
              image_frame.on('close', function () {
                  image_frame
                      .state()
                      .get('selection')
                      .forEach(attachment => {
                          console.log(attachment.attributes.url);
                      });
              });
              image_frame.open();
              e.preventDefault();
          }
      });
    });
    </script>
    <?php
  },
  100
);