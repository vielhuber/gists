<?php
$static_search_config = [
  // here as a cache system "WP Fastest Cache" is used
	"path" => $_SERVER['DOCUMENT_ROOT']."/wp-content/cache/all",
	"target" => "#container",
];
function static_search_scan_cached_file($file) {
	global $static_search_config;
	$query = $_GET["q"];

	if( !file_exists($file) ) { return null; }
	
	$content = file_get_contents($file);
	$dom = new DOMDocument();
	$dom->loadHTML('<?xml encoding="utf-8" ?>'.$content);

	$target_raw = $dom->saveHTML($dom->getElementById(str_replace("#","",$static_search_config["target"])));
	$target = strip_tags($target_raw);

	if( strlen($query) <= 3 ) { return null; }

	if(strpos(mb_strtolower($target),mb_strtolower($query)) === false) { return null; }

	if( function_exists('pll_current_language') ) {
		$lang = $dom->getElementsByTagName('html')->item(0)->getAttribute('lang');
		$lang = explode("-",$lang)[0];
		if( $lang != pll_current_language() ) { return null; }
	}

	$result = [];

	// get target
	$result["content"] = $target;
	$result["content"] = static_search_highlight_string($result["content"], $query, true);
	
	// get url
	$result["url"] = "";
	$metas = $dom->getElementsByTagName('meta');
	for($i = 0; $i < $metas->length; $i++) {
		$meta = $metas->item($i);
		if($meta->getAttribute('name') == 'current_url') {
			$result["url"] = $meta->getAttribute('content');
		}
	}

	// get title
	$result["title"] = "";
	$title = $dom->getElementsByTagName("title");
	if($title->length > 0){
		$result["title"] = $title->item(0)->nodeValue;
	}
	$result["title"] = str_replace(" – PAGE NAME","",$result["title"]);

	// get first image
	$result["image"] = "";
	$image_pos = null;
	$image_jpg = strpos($target_raw,".jpg");
	$image_png = strpos($target_raw,".png");
	if($image_jpg !== false && $image_png !== false) { $image_pos = min($image_jpg, $image_png); }
	else if($image_jpg !== false) { $image_pos = $image_jpg; }
	else if($image_png !== false) { $image_pos = $image_png; }
	if($image_pos !== null) {
		$image_pos_begin_1 = strrpos(substr($target_raw, 0, $image_pos), '"')+1;
		$image_pos_begin_2 = strrpos(substr($target_raw, 0, $image_pos), "'")+1;
		if($image_pos_begin_1 > $image_pos_begin_2) {
		    $image_pos_begin = $image_pos_begin_1; $delimiter = '"';
		}
		else {
		    $image_pos_begin = $image_pos_begin_2; $delimiter = "'";
		}
		$image_pos_end = strpos($target_raw, $delimiter, $image_pos);
		$result["image"] = substr($target_raw, $image_pos_begin, $image_pos_end-$image_pos_begin);
		list($width, $height) = getimagesize($result["image"]);
		if( $width > 250 || $height > 150 ) { $result["background_size"] = "contain"; }
		else { $result["background_size"] = "auto"; }
	}

	return $result;

}
function static_search_highlight_string($string, $query, $strip = false, $strip_length = 500) {

	if( $strip === true ) {

		// get all query begin positions in spot
		$lastPos = 0;
		$positions = array();
		while( ($lastPos = stripos($string, $query, $lastPos)) !== false ) {
			$positions[] = $lastPos;
			$lastPos = $lastPos + strlen($query);
		}

		// strip away parts
		$placeholder = "♥";
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
function static_search_get_cached_files($dir) {
	global $static_search_config;
	if( !is_dir( $dir ) ) { return []; }
	$results = [];
    $files = scandir($dir);
    foreach($files as $key=>$value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
        	if( strpos($path,".html") !== false ) {
	            $results[] = $path;
        	}
        }
        else if($value != "." && $value != "..") {
            $results = array_merge($results, static_search_get_cached_files($path));
        }
    }
    return $results;
}
function static_search_generate() {
	global $static_search_config;

	$output = "";

	// get recursively all cached files
	$cache = static_search_get_cached_files($static_search_config["path"]);

	$results = [];
	foreach($cache as $file) {
		$result = static_search_scan_cached_file($file);
		if($result !== null) {
			$results[] = $result;
		}
	}

	$output .= '<h2>'.pll__('Suchergebnisse für ').'&bdquo;'.strip_tags($_GET["q"]).'&ldquo;'.'</h2>';
	if(empty($results)) {
		$output .= '<div class="content">'.pll__('Keine Suchergebnisse vorhanden!').'</div>';
	}
	else {
		$output .= '<ul>';
		foreach($results as $result) {
			$output .= '<li>';
					$output .= '<div class="l">';
					if( $result["image"] !== null ) {
						$output .= '<div class="image" style="background-size:'.$result["background_size"].';background-image:url(\''.$result["image"].'\');">';
						$output .= '</div>';
					}
					$output .= '</div>';
					$output .= '<div class="r">';
						$output .= '<h3>'.$result["title"].'</h3>';
						$output .= '<div class="content">'.$result["content"].'</div>';
						$output .= '<a class="more" href="'.$result["url"].'">';
							$output .= pll__('mehr erfahren');
						$output .= '</a>';
					$output .= '</div>';
			$output .= '</li>';
		}
		$output .= '</ul>';
	}

	return $output;
}
function static_search() {
	echo static_search_generate();
}
function static_search_shortcode($atts){
	$return = static_search_generate();
	return $return;
}
add_shortcode('static_search', 'static_search_shortcode' );
function static_search_add_current_url() {
	echo '<meta name="current_url" content="'.'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" />';
}
add_action('wp_head', 'static_search_add_current_url');

