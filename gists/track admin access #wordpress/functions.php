<?php
/* track admin access */
add_action('admin_init', function () {
    $log =
        date('Y-m-d H:i:s') .
        "\t" .
        'http' .
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 's' : '') .
        '://' .
        $_SERVER['HTTP_HOST'] .
        $_SERVER['REQUEST_URI'] .
        "\t" .
        $_SERVER['REMOTE_ADDR'] .
        "\t" .
        wp_get_current_user()->user_email .
        PHP_EOL;
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/wp-content/admin.log', $log, FILE_APPEND);
});