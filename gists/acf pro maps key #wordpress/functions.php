<?php
// first enable "Geocoding", "Geolocation", "Maps JavaScript", "Places API" in the Google API Console
// then add this to the functions.php file
add_action('acf/init', function() {    
    acf_update_setting('google_api_key', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
});