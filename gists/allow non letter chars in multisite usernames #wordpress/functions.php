<?php
add_filter('wpmu_validate_user_signup', function($result) {
    $error_name = $result['errors']->get_error_message('user_name');
    if (
        !empty($error_name) &&
        $error_name == 'Benutzernamen dürfen nur kleingeschriebene Buchstaben (a-z) und Zahlen enthalten.' &&
        $result['user_name'] == $result['orig_username']
    ) {
        unset($result['errors']->errors['user_name']);
    }
    return $result;
});