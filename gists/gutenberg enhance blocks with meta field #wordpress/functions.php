add_action('enqueue_block_editor_assets', function () {
  	// main script
    wp_enqueue_script('custom-attrs', plugins_url('bundle.js', __FILE__), [
        'wp-blocks',
        'wp-components',
        'wp-compose',
        'wp-dom-ready',
        'wp-editor',
        'wp-element',
        'wp-hooks',
        'wp-i18n'
    ]);
  	// pass data from php
    wp_localize_script('custom-attrs', 'custom_attrs_data', [
	   'foo' => 'bar'
    ]);
  	// localization
  	wp_set_script_translations(
      	'custom-attrs',
      	'textdomain',
      	plugin_dir_path(__FILE__) . 'languages'
    );
});

/* do something with it in the frontend (surround the block with the attribute) */
add_filter( 'render_block', function( $block_content, $block ) {
    if( is_admin() || in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']) ) { return $block_content; }
    global $post;
    if( @$block['attrs']['attr1'] != '' ) {
        $block_content = '<div data-attr1="'.$block['attrs']['attr1'].'">'.$block_content.'</div>';
    }
    return $block_content;
}, 10, 2 );