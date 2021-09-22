<?php
/* Main menu: Pass description parameters to dom */
function be_header_menu_desc( $item_output, $item, $depth, $args ) {	 
	if( $args->theme_location == 'main-menu' &&! $depth && $item->description ) {

		// remove ugly quotes wp adds automatically
		$item->description = str_replace('&#8220;','',$item->description);
		$item->description = str_replace('&#8220;','',$item->description);
		$item->description = str_replace('“','',$item->description);
		$item->description = str_replace('“','',$item->description);
        $item->description = str_replace('″','',$item->description);

		$item_output = str_replace( 'href="', $item->description.' href="', $item_output );
	}		
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'be_header_menu_desc', 10, 4 );