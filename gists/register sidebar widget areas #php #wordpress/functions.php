<?php
add_action('widgets_init', function()
{
 	foreach(['footer-1-new','footer-2-new','footer-3-new','footer-4-new'] as $widget)
 	{
		register_sidebar([
			'id'            => $widget,
			'name'          => __($widget, 'theme_domain'),
			'description'   => '',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>'
		]);
	}
});