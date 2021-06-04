<?php
$zoom = 5000;
$address = 'Auenstraße 6, 80469 München';
//$address = '48.127660,11.575380'; // lat/lng is also possible but without an address card
$lng = 'de';

$src = 'https://www.google.com/maps/embed?pb='.
'!1m18'.
    '!1m12'.
        '!1m3'.
            '!1d'.$zoom.
            '!2d0'.
            '!3d0'.
        '!2m3'.
            '!1f0'.
            '!2f0'.
            '!3f0'.
        '!3m2'.
            '!1i1024'.
            '!2i768'.
        '!4f13.1'.
        '!3m3'.
            '!1m2'.
            '!1s0'.
            '!2s'.rawurlencode($address).
        '!5e0'.
        '!3m2'.
            '!1s'.$lng.
            '!2s'.$lng.
        '!4v'.time().'000'.
        '!5m2'.
            '!1s'.$lng.
            '!2s'.$lng;

echo '<iframe src="'.$src.'" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';