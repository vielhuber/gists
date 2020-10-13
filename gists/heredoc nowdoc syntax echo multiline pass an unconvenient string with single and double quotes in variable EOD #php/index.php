<?php  
$string = 'this is \'very\' unconvenient, "dude"!';

$string = "this is 'very' unconvenient, \"dude\"!";

// heredoc (parses variables)

$string = <<<EOD
this is 'very' unconvenient, "dude"!
EOD;

echo <<<EOD
this is outputted directly!
EOD;

// nowdoc (does not parse variables)

$string = <<<'EOD'
this is 'very' unconvenient, "dude"!
EOD;

echo <<<'EOD'
this is outputted directly!
EOD;

// note this is also working

$string = <<<'MONKEYS'
this is 'very' unconvenient, "dude"!
MONKEYS;