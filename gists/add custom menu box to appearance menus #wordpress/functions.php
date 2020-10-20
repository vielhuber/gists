<?php
add_filter(
    'nav_menu_meta_box_object',
    function ($object) {
        add_meta_box(
            'custom-menu-metabox',
            __('Language picker', 'my-plugin'),
            function () {
                global $nav_menu_selected_id;
                echo '
                    <div id="my-plugin-slug-div">
                    <div id="tabs-panel-my-plugin-slug-all" class="tabs-panel tabs-panel-active">
                    <ul id="my-plugin-slug-checklist-pop" class="categorychecklist form-no-clear">
                    ' .
                    walk_nav_menu_tree(
                        array_map('wp_setup_nav_menu_item', [
                            (object) [
                                'ID' => 1,
                                'object_id' => 1,
                                'type_label' => '',
                                'title' => __('All languages', 'my-plugin'),
                                'url' => '#foo',
                                'type' => 'custom',
                                'object' => 'my-plugin-slug-slug',
                                'db_id' => 0,
                                'menu_item_parent' => 0,
                                'post_parent' => 0,
                                'target' => '',
                                'attr_title' => '',
                                'description' => '',
                                'classes' => [],
                                'xfn' => ''
                            ],
                            (object) [
                                'ID' => 1,
                                'object_id' => 1,
                                'type_label' => '',
                                'title' => __('Hide active language', 'my-plugin'),
                                'url' => '#bar',
                                'type' => 'custom',
                                'object' => 'my-plugin-slug-slug',
                                'db_id' => 0,
                                'menu_item_parent' => 0,
                                'post_parent' => 0,
                                'target' => '',
                                'attr_title' => '',
                                'description' => '',
                                'classes' => [],
                                'xfn' => ''
                            ]
                        ]),
                        0,
                        (object) ['walker' => new \Walker_Nav_Menu_Checklist(false)]
                    ) .
                    '
                    </ul>
                    <p class="button-controls">
                        <span class="add-to-menu">
                            <input type="submit" ' .
                    wp_nav_menu_disabled_check($nav_menu_selected_id, false) .
                    ' class="button-secondary submit-add-to-menu right" value="' .
                    __('Add to Menu', 'my-plugin') .
                    '" name="add-my-plugin-slug-menu-item" id="submit-my-plugin-slug-div" />
                            <span class="spinner"></span>
                        </span>
                    </p>
                    </div>
                    </div>
                ';
            },
            'nav-menus',
            'side',
            'default'
        );
        return $object;
    },
    10,
    1
);