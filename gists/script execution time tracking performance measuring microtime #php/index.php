<?php
function lb($message = '') {
	if(!isset($GLOBALS['performance'])) { $GLOBALS['performance'] = []; }
	$GLOBALS['performance'][] = ['time' => microtime(true), 'message' => $message];
}
function le() {
	echo 'script '.$GLOBALS['performance'][count($GLOBALS['performance'])-1]['message'].' execution time: '.number_format((microtime(true)-$GLOBALS['performance'][count($GLOBALS['performance'])-1]['time']),5). ' seconds'.PHP_EOL;
	unset($GLOBALS['performance'][count($GLOBALS['performance'])-1]);
	$GLOBALS['performance'] = array_values($GLOBALS['performance']);
}

lb('task');
for($i = 0; $i < 10000; $i++) {
  lb('childtask');
  for($y = 0; $y < 100; $y++) { }
  le();
}
le();
