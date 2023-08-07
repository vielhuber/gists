<?php
// basic usage
wp_mail(
    'foo@bar.com', // use ['foo@bar.com','bar@baz.com'] for multiple recipients
    'The subject',
    'The <strong>html</strong> content',
    ['Content-Type: text/html; charset=UTF-8'], // use ['Content-Type: text/html; charset=UTF-8', 'Cc: foo1@bar.com', 'Bcc: foo2@bar.com', 'Bcc: foo3@bar.com'] to send via cc/bcc
  	[
    	'custom-filename1.zip' => wp_upload_dir()['basedir'].'/uploads/file1.zip',
        'custom-filename2.zip' => wp_upload_dir()['basedir'].'/uploads/file2.zip',
    ]
);

// OBSOLETE:
// change attachment names
// in the past not natively possible: https://core.trac.wordpress.org/ticket/28407
// use this trick:
// before
wp_mail('...', '...', '...', ['Content-Type: /html; charset=UTF-8'], [ sys_get_temp_dir().'/'.md5(uniqid(mt_rand(), true)).'.pdf' ]);
// after
@mkdir( sys_get_temp_dir().'/'.md5(uniqid(mt_rand(), true)) );
wp_mail('...', '...', '...', ['Content-Type: text/html; charset=UTF-8'], [ sys_get_temp_dir().'/'.md5(uniqid(mt_rand(), true)).'/My-custom-name.pdf' ]);
  
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