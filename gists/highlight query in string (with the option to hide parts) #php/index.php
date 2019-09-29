<?php
echo highlightString("this is a search string","is");
function highlightString($string, $query, $strip = false, $strip_length = 500) {

	if( $strip === true ) {

		// get all query begin positions in spot
		$lastPos = 0;
		$positions = array();
		while( ($lastPos = stripos($string, $query, $lastPos)) !== false ) {
			$positions[] = $lastPos;
			$lastPos = $lastPos + strlen($query);
		}

		// strip away parts
		$placeholder = md5("♥");
		for($i = 0; $i < mb_strlen($string); $i++) {
			$strip_now = true;
			foreach($positions as $p) {
				if( $i >= $p-$strip_length && $i <= $p+mb_strlen($query)+$strip_length ) {
					$strip_now = false;
				}
			}
			if($strip_now === true) {
				$string = mb_substr($string,0,$i-1).$placeholder.mb_substr($string,$i);
			}
		}
		while(mb_strpos($string,($placeholder.$placeholder)) !== false) {
			$string = str_replace(($placeholder.$placeholder),$placeholder,$string);
		}
		$string = str_replace($placeholder," ... ",$string);

		if( mb_strlen($string) > $strip_length ) {
			$string = mb_substr($string, 0, $strip_length)." ...";
		}

	}

	// again: get all query begin positions in spot
	$lastPos = 0;
	$positions = array();
	while( ($lastPos = stripos($string, $query, $lastPos)) !== false ) {
		$positions[] = $lastPos;
		$lastPos = $lastPos + strlen($query);
	}

	// wrap span element around them
	$wrap_begin = '<strong class="highlight">';
	$wrap_end = '</strong>';
	for($x = 0; $x < count($positions); $x++) {
		$string = substr($string, 0, $positions[$x]).$wrap_begin.substr($string, $positions[$x], strlen($query)).$wrap_end.substr($string, $positions[$x]+strlen($query));
		// shift other positions
		for($y = $x+1; $y < count($positions); $y++) {
			$positions[$y] = $positions[$y]+strlen($wrap_begin)+strlen($wrap_end);
		}
	}

	return $string;

}
?>