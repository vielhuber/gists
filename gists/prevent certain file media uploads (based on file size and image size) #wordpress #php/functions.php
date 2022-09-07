<?php
/* prevent certain uploads */
add_filter('wp_handle_upload_prefilter', function ($file) {
    if (@$file['type'] == '' || @$file['size'] == '' || @$file['tmp_name'] == '') {
        return $file;
    }
    if (in_array($file['type'], ['image/jpeg', 'image/png'])) {
        $limit_size = 1;
        $limit_dim = 2048;
        list($width, $height) = getimagesize($file['tmp_name']);
        if (($file['size'] / 1024 / 1024) > $limit_size) {
            $file['error'] = 'Die Dateigröße darf nicht größer als ' . $limit_size . ' MB sein.';
            return $file;
        }
        if ($width > $limit_dim || $height > $limit_dim) {
            $file['error'] = 'Die Bildgröße darf nicht breiter oder höher als ' . $limit_dim . 'px sein.';
            return $file;
        }
    }
    return $file;
});