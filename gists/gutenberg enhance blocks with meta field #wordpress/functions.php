/* script.js should be compiled with babel or https://babeljs.io/en/repl */
add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_script('custom-attrs', plugins_url('bundle.js', __FILE__), [
        'wp-blocks',
        'wp-components',
        'wp-compose',
        'wp-dom-ready',
        'wp-editor',
        'wp-element',
        'wp-hooks'
    ]);
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