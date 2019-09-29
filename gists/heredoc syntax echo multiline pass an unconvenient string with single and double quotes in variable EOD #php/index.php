<?php
$string = 'this is \'very\' unconvenient, "dude"!';

$string = "this is 'very' unconvenient, \"dude\"!";

$string = <<<EOD
this is 'very' unconvenient, "dude"!
EOD;

echo <<<EOD
this is outputted directly!
EOD;