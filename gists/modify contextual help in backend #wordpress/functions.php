add_action('admin_head', function() {
    $current_screen = get_current_screen();
    $current_screen->remove_help_tabs();
    $current_screen->add_help_tab([
        'id' => 'special_characters_help_tab',
        'title' => 'Sonderzeichen',
        'content' => '<h3>Sonderzeichen für copy & paste</h3><p>(©, –, Œ, š, č, ř, ç, ë</p></br>'
    ]);
    $current_screen->set_help_sidebar('');
});
