function userDefinedSort(&$arr, $extra1, $extra2) {
    usort($arr, function($a, $b) use ($extra1, $extra2) {
		// $extra1 / $extra2 are available here
		if( $a == $b ) { return 0; }
		return ($a < $b) ? -1 : 1;
    });
}