<?php
function getGeocodingDataFromAddress($address)
{
    $max_tries = 5;
    $key = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $country_code = 'DE';

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
        '&key=' . $key .
        '&region=' . $country_code .
        '&language=' . $country_code;
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

    foreach (@$resp['results'] as $results__value) {
        if (@$results__value['geometry']['location']['lat'] != '' && $return['lat'] === null) {
            $return['lat'] = $results__value['geometry']['location']['lat'];
        }
        if (@$results__value['geometry']['location']['lng'] != '' && $return['lng'] === null) {
            $return['lng'] = $results__value['geometry']['location']['lng'];
        }

        if (
            @$results__value['address_components'] != '' &&
            !empty(@$results__value['address_components'])
        ) {
            foreach (@$results__value['address_components'] as $address_components__value) {
                if (@$address_components__value['types'][0] === 'country' && $return['country'] === null) {
                    $return['country'] = $address_components__value['short_name'];
                }
                if (@$address_components__value['types'][0] === 'administrative_area_level_1' && $return['state'] === null) {
                    $return['state'] = $address_components__value['long_name'];
                }
                if (@$address_components__value['types'][0] === 'locality' && $return['city'] === null) {
                    $return['city'] = $address_components__value['long_name'];
                }
                if (@$address_components__value['types'][0] === 'postal_code' && $return['zip'] === null) {
                    $return['zip'] = $address_components__value['short_name'];
                }
                if (@$address_components__value['types'][0] === 'route' && $return['street'] === null) {
                    $return['street'] = $address_components__value['long_name'];
                }
                if (@$address_components__value['types'][0] === 'street_number' && $return['number'] === null) {
                    $return['number'] = $address_components__value['short_name'];
                }
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
            '&key=' . $key .
            '&region=' . $country_code .
			'&language=' . $country_code;
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
        foreach (@$resp['results'] as $results__value) {
            if (
                @$results__value['address_components'] != '' &&
                !empty(@$results__value['address_components'])
            ) {
                foreach (@$results__value['address_components'] as $address_components__value) {
                    if (@$address_components__value['types'][0] === 'postal_code' && $return['zip'] === null) {
                        $return['zip'] = $address_components__value['short_name'];
                    }
                }
            }
        }
    }

    return $return;
}
print_r(getGeocodingDataFromAddress('Deutschland'));
print_r(getGeocodingDataFromAddress('Baumannstraße 23, 94036 Passau, Deutschland')); // use this ordering if possible
print_r(getGeocodingDataFromAddress('94036')); // this is currently NOT easily possible!
print_r(getGeocodingDataFromAddress('Passau'));
print_r(getGeocodingDataFromAddress('Irland'));
