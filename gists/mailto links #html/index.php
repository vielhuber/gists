<?php
$to = ''; // leave empty if this should only open a new email

$subject = '';
$subject .= 'Test… M33 äöüßßß'; // must be escaped (formerly, this must NOT be escaped due to an outlook bug, which is fixed now)

$body = '';
$body .= 'Sehen Sie sich folgenden Link an:'.PHP_EOL.PHP_EOL.'https://test.de'; // must be escaped

echo '<a href="mailto:'.$to.'?subject='.rawurlencode($subject).'&amp;body='.rawurlencode($body).'">E-Mail senden</a>';