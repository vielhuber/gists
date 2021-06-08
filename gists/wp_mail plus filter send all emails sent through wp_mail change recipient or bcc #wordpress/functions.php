<?php
// basic usage
wp_mail(
    'foo@bar.com',
    'The subject',
    'The <strong>html</strong> content',
    ['Content-Type: text/html; charset=UTF-8'],
  	[
    	wp_upload_dir()['basedir'].'/uploads/file1.zip',
        wp_upload_dir()['basedir'].'/uploads/file2.zip',
    ]
);
  
// change recipient on dev
if (!is_production() && isset($_SERVER['SERVER_ADMIN']) && $_SERVER['SERVER_ADMIN'] != '') {
    add_filter( 'wp_mail',function($data) {
        $data['to'] = $_SERVER['SERVER_ADMIN'];
        return $data;
    });
}

// always send bcc
add_filter( 'wp_mail',function($data) {
    $data['headers'] .= "BCC: foo@bar.com \r\n";
    return $data;
});