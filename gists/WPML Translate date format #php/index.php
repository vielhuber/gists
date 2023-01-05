<?php
// usage before
get_the_date();
// same as this (look into Settings > General
get_the_date('F j, Y');
// now use this (or whatever domain you are using) and translate the string "F j, Y" with poedit/loco translate
get_the_date(__('F j, Y', 'text-domain'));
// even better: in functions.php
add_filter('option_date_format', function($format) {
    if($format == 'F j, Y') {
        $format = __('F j, Y', 'text-domain');
    }
    return $format;
});