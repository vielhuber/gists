<?php
/* wpml disable refresh icons */
add_action('admin_footer', function() {
    echo '<style>.otgs-ico-refresh:before { content: "\68"; }</style>';
});