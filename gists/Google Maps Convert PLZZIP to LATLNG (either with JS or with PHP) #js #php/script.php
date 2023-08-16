<?php
// use here a server side api key
$key = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
$address = urlencode('Baumannstraße 23, 94036 Passau, Deutschland');
$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$key;
$resp_json = file_get_contents($url);
$resp = json_decode($resp_json, true);
if($resp['status'] == 'OK'){
    if (
        (@$resp['results'][0]['geometry']['location']['lat']) != '' &&
        (@$resp['results'][0]['geometry']['location']['lng']) != ''
        // if you need further accuracy (to street level), add also this
        /*
        && !empty(@$resp['results'][0]['address_components'])
        && !empty(
            array_filter($resp['results'][0]['address_components'], function ($a) {
                return __x(@$a['types']) && in_array('street_number', $a['types']);
            })
        )
        */
    ) {
        $lat = $resp['results'][0]['geometry']['location']['lat'];
        $lng = $resp['results'][0]['geometry']['location']['lng'];
    }
}
echo $lat.' '.$lng;