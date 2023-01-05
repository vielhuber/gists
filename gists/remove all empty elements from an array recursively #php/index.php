<?php
public static function arrayRemoveEmpty($array) {
	foreach($array as $key=>$value) {
		if(is_array($value)) {
			$array[$key] = arrayRemoveEmpty($array[$key]);
		}
		if(empty($array[$key]) && $array[$key] != '0') {
			unset($array[$key]);
		}
	}
	return $array;
}