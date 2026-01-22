<?php
/* embed iptc tags from copyright */

// hook when updating a copyright
add_action( 'attachment_updated', function($attachment_id, $post_after, $post_before)
{
    updateCopyright($attachment_id, $post_after->post_excerpt);
}, 10, 3 );

// hook for all existing images (only run this once)
if( 1==0 ) {
add_action('admin_init', function () {
    $attachments = get_posts([
        'post_type' => 'attachment',
        'posts_per_page' => -1
    ]);
    foreach($attachments as $attachments__value) {
        updateCopyright($attachments__value->ID, $attachments__value->post_excerpt, true);
    }
    die();
});
}

// helper function
function updateCopyright($attachment_id, $copyright, $output = false) {
    $extension = wp_check_filetype(wp_get_attachment_url($attachment_id))['ext'];
    if( !in_array($extension, ['jpg', 'jpeg']) ) {
        return;
    }
    $paths = [];
    foreach(get_intermediate_image_sizes() as $sizes__value) {
        $image = wp_get_attachment_image_src($attachment_id, $sizes__value);
        $path = str_replace(wp_upload_dir()['baseurl'], wp_upload_dir()['basedir'], $image[0]);
        $paths[] = $path;
    }
    $paths = array_unique($paths);
    foreach($paths as $paths__value) {
        if( !file_exists($paths__value) ) { continue; }
        if( $copyright == '' ) { $copyright = null; }
        __iptc_write($paths__value, ['2#116' => $copyright]);
        if( $output === true ) {
            echo $paths__value.': '.$copyright.'<br/>';
        }
    }
}

// show iptc tag on attachment detail
add_filter( 'attachment_fields_to_edit', function( $form_fields, $post ) {
    $extension = wp_check_filetype(wp_get_attachment_url($post->ID))['ext'];
    if( !in_array($extension, ['jpg', 'jpeg']) ) {
        return;
    }
    $image = wp_get_attachment_image_src($post->ID, $sizes__value);
    $path = str_replace(wp_upload_dir()['baseurl'], wp_upload_dir()['basedir'], $image[0]);
    $html = '';
    $html .= '
        <style>
        .compat-field-iptc_info input[name^="attachments["][name$="iptc_info]"] { display:none; }
        .compat-field-iptc_info .help { margin-top:6px; }
        </style>
    ';
    $iptc = __iptc_read($path);
    if(!empty($iptc)) {
        foreach($iptc as $iptc__key=>$iptc__value) {
            $html .= '<span style="color:red">'.__iptc_keyword($iptc__key).' ('.$iptc__key.'): '.$iptc__value.'<br/>';
        }
    }
    else {
        $html .= '&ndash;';
    }
    $form_fields['iptc_info'] = [
        'label' => 'IPTC-Tags',
        'helps' => $html,
        'value' => ''
    ];
    return $form_fields;
}, null, 2 );
