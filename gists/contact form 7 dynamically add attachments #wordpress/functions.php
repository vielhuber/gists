<?php
add_action('wpcf7_before_send_mail', function wpcf7_add_attachment($cf7) {
    $id = $cf7->id();
    if(in_array($id, [1337])) {
        $submission = \WPCF7_Submission::get_instance();
        $post_data = $submission->get_posted_data();
        if (!empty($post_data) && !empty($post_data['download_id'])) {
            $download_id = $post_data['download_id'];
            // generate absolute url from id
            $attachment_path = $_SERVER['DOCUMENT_ROOT'].'/test.pdf';
            $mail = $cf7->prop('mail');
            $mail['attachments'] .= $attachment_path;
            $cf7->set_properties(['mail' => $mail]);
        }
    }
});