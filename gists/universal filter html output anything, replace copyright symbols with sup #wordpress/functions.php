<?php
/* filter anything */
/* use after_setup_theme instead of wp_head to also include header */
add_action('after_setup_theme', function() {
    ob_start(function($html) {
        $html = str_replace('®','<sup>®</sup>',$html);
        $html = str_replace("©","<sup>©</sup>",$html);
        return $html; 
    });
});
add_action('shutdown', function() {
    ob_end_flush();
});