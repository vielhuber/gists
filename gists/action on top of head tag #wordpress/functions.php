<?php
add_action('wp_head_top', function()
{
	echo '<script>alert('yo');</script>';
});