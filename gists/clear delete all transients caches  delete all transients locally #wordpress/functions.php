<?php
if (
    @$_SERVER['SERVER_ADMIN'] === 'david@close2.de' ||
    strpos(@$_SERVER['HTTP_HOST'], 'close2dev') !== false
) {
    $wpdb->query(
        $wpdb->prepare(
            'DELETE FROM ' . $wpdb->prefix . 'options WHERE option_name LIKE %s OR option_name LIKE %s',
            '_transient_%',
            '_site_transient_%'
        )
    );
}