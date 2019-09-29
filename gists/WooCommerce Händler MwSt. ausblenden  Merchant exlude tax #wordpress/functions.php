<?php
/* exclude tax on certain user roles */
/* to determine if a user is a merchant, the groups plugin (https://wordpress.org/plugins/groups/) is used */
function override_tax_display_setting() {
	$is_a_member = false;
	if ( is_user_logged_in() && $group = Groups_Group::read_by_name('Händler') ) {
		$is_a_member = Groups_User_Group::read( get_current_user_id() , $group->group_id );
	}
	if ( $is_a_member ) {	
       return "excl";
	}
	else {
 	   return "incl";
    }
}
add_filter('pre_option_woocommerce_tax_display_shop', 'override_tax_display_setting');
add_filter('pre_option_woocommerce_tax_display_cart', 'override_tax_display_setting');