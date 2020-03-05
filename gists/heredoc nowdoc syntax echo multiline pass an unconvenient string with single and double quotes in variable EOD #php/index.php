<?php
$string = 'this is \'very\' unconvenient, "dude"!';

$string = "this is 'very' unconvenient, \"dude\"!";

// heredoc

$string = <<<EOD
this is 'very' unconvenient, "dude"!
EOD;

echo <<<EOD
this is outputted directly!
EOD;

// nowdoc (recommended)

$string = <<<'EOD'
this is 'very' unconvenient, "dude"!
EOD;

echo <<<'EOD'
this is outputted directly!
EOD;