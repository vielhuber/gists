current-menu-item auch bei nicht tatsächlich aktiven Navigationspunkten setzen
function blank_highlight_nav($classes, $item, $args) {
 
    // only certain menu
    if ($args->theme_location != 'header') {
        return $classes;
    }
 
    global $post;
  
    if ((is_singular('job') && $item->title == 'Karriere') || ($post->post_parent && get_the_title($post->post_parent) == 'Karriere' && $item->title == 'Karriere')) {
        $classes[] = 'current-menu-item';
    }
    if (is_singular('post') && $item->title == 'Blog') {
        $classes[] = 'current-menu-item';
    }
  
    return array_unique($classes);
 
}
add_filter('nav_menu_css_class', 'blank_highlight_nav', 10, 3);

//Erfordert, dass $class_names = join(' ', apply_filters('nav_menu_css_class', $item->classes, $item, $args)); vor dem verwenden in einem Custom Walker eingesetzt wird.
//current-menu-ancestor wird nur gesetzt, wenn der Nachkomme auch im Menü hinterlegt ist. Nicht wenn es schlicht eine Seite darunter ist.
