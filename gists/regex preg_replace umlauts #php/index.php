<?php
$str = 'Dies ist ein Test älüpüpoßßßéok';
echo preg_replace('/[^A-Za-zäÄöÖüÜß\- ]/','', $str); // not working (é is not removed)
echo preg_replace('/[^A-Za-zäÄöÖüÜß\- ]/u','', $str); // working