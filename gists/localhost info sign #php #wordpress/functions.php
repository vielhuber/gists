<?php
if(isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', "::1"])){
	function localhost_info_sign(){
		echo '<div class="localhost" style="box-sizing: border-box;position: fixed;background-color: red;width: 20px;height: 20px;bottom: 0;left: 0;pointer-events: none;z-index: 40000;text-align: center;line-height: 20px;font-size: 10px;color: #fff;padding: 0;margin: 0;">L</div>';
    }
    add_action('wp_footer', 'localhost_info_sign');
    add_action('admin_footer', 'localhost_info_sign');
}