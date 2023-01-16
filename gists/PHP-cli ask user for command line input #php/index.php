<?php
function ask($question, $answers = null) {
	echo $question.' ';
	$handle = fopen("php://stdin","r");
	$answer = fgets($handle);
	fclose($handle);
	$answer = trim($answer);
	if($answers != null) {
		if( !in_array($answer,$answers) ) {
			return ask($question, $answers);
		}
	}
	return $answer;
}
if( ask('are you an idiot? (y/n)',['y','n']) == 'y' ) {
  die();
}