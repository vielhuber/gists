<?php
if (
    @$_SERVER['SERVER_ADMIN'] === 'david@vielhuber.de' ||
    strpos(@$_SERVER['HTTP_HOST'], 'vielhuber') !== false
) {
    $wpdb->query(
        $wpdb->prepare(
            'DELETE FROM ' . $wpdb->prefix . 'options WHERE option_name LIKE %s OR option_name LIKE %s',
            '_transient_%',
            '_site_transient_%'
        )
    );
}