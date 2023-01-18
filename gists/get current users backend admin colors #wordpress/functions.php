global $_wp_admin_css_colors;
$admin_color = get_user_option('admin_color');
$colors = $_wp_admin_css_colors[$admin_color]->colors;
print_r($colors);