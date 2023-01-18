### notes
if a custom function like is_front_page() is not working in functions.php, it's because the hook is too early.
go down step by step to find the first hook that works.

### add
```php
// hook
add_action('...', function () { });
// filter
add_filter('...', function () { });
```

### hooks (in proper order)
- muplugins_loaded
- registered_taxonomy
- registered_post_type
- plugins_loaded
- sanitize_comment_cookies
- setup_theme
- unload_textdomain
- load_textdomain
- after_setup_theme
- auth_cookie_malformed
- auth_cookie_valid
- set_current_user
- init
- widgets_init
- register_sidebar
- wp_register_sidebar_widget
- wp_loaded
- parse_request
- send_headers
- parse_tax_query
- parse_query
- pre_get_posts
- posts_selection
- wp
- template_redirect
- wp_default_scripts
- wp_default_styles
- admin_bar_init
- add_admin_bar_menus
- get_header
- wp_head
- wp_enqueue_scripts
- wp_print_styles
- wp_print_scripts
- get_sidebar
- dynamic_sidebar_before
- dynamic_sidebar
- pre_get_search_form
- loop_start
- the_post
- loop_end
- parse_comment_query
- pre_get_comments
- wp_meta
- dynamic_sidebar_after
- get_template_part_content
- add_option
- added_option
- set_transient__transient_is_multi_author
- setted_transient
- get_footer
- wp_footer
- wp_print_footer_scripts
- admin_bar_menu
- wp_before_admin_bar_render
- wp_after_admin_bar_render