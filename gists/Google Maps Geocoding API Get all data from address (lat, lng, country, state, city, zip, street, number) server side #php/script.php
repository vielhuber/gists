<?php
function getGeocodingDataFromAddress($address)
{
    $max_tries = 5;
    $key = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';

    $return = [
        'lat' => null,
        'lng' => null,
        'country' => null,
        'state' => null,
        'city' => null,
        'zip' => null,
        'street' => null,
        'number' => null
    ];

    if ($address == '') {
        return $return;
    }

    $url =
        'https://maps.googleapis.com/maps/api/geocode/json?address=' .
        urlencode($address) .
        '&key=' .
        $key;
    $status = '';
    $resp = [];
    $tries = 0;
    while ($status !== 'OK' && $tries <= $max_tries) {
        if ($tries >= 1) {
            sleep(1);
        }
        $resp = json_decode(file_get_contents($url), true);
        $status = @$resp['status'];
        $tries++;
    }
    if (empty($resp)) {
        return $return;
    }

    if (@$resp['results'][0]['geometry']['location']['lat'] != '') {
        $return['lat'] = $resp['results'][0]['geometry']['location']['lat'];
    }
    if (@$resp['results'][0]['geometry']['location']['lng'] != '') {
        $return['lng'] = $resp['results'][0]['geometry']['location']['lng'];
    }

    if (
        @$resp['results'][0]['address_components'] != '' &&
            !empty(@$resp['results'][0]['address_components'])
    ) {
        foreach (@$resp['results'][0]['address_components'] as $address_components__value) {
            if (@$address_components__value['types'][0] === 'country') {
                $return['country'] = $address_components__value['short_name'];
            }
            if (@$address_components__value['types'][0] === 'administrative_area_level_1') {
                $return['state'] = $address_components__value['long_name'];
            }
            if (@$address_components__value['types'][0] === 'locality') {
                $return['city'] = $address_components__value['long_name'];
            }
            if (@$address_components__value['types'][0] === 'postal_code') {
                $return['zip'] = $address_components__value['short_name'];
            }
            if (@$address_components__value['types'][0] === 'route') {
                $return['street'] = $address_components__value['long_name'];
            }
            if (@$address_components__value['types'][0] === 'street_number') {
                $return['number'] = $address_components__value['short_name'];
            }
        }
    }

    // if city is not null and zip is null, make a reverse geocoding call with lat lng and try to fetch the zip of the center
    if (
        $return['lat'] !== null &&
        $return['lng'] !== null &&
        $return['city'] !== null &&
        $return['zip'] === null
    ) {
        $url =
            'https://maps.googleapis.com/maps/api/geocode/json?latlng=' .
            urlencode($return['lat'] . ',' . $return['lng']) .
            '&key=' .
            $key;
        $status = '';
        $resp = [];
        $tries = 0;
        while ($status !== 'OK' && $tries <= $max_tries) {
            if ($tries >= 1) {
                sleep(1);
            }
            $resp = json_decode(file_get_contents($url), true);
            $status = @$resp['status'];
            $tries++;
        }
    }
    if (
        @$resp['results'][0]['address_components'] != '' &&
            !empty(@$resp['results'][0]['address_components'])
    ) {
        foreach (@$resp['results'][0]['address_components'] as $address_components__value) {
            if (@$address_components__value['types'][0] === 'postal_code') {
                $return['zip'] = $address_components__value['short_name'];
            }
        }
    }

  return $return;
}
