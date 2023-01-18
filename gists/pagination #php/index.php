<?php
// get modules / parts
$modules = ["foo","bar","baz","moo","hoo","loo","koo"];
// the following line would fetch joomla modules
//$modules = JModuleHelper::getModules('position-2');

// global paging args
$paging = [
	"show" => true,
	"count" => count($modules),
	"limit" => 2,
	"cur" => 1,
	"link" => '//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
	"query" => "pcur"
];

// hide paging under certain circumstances
if(1==0) {
	$paging["show"] = false;
}

// determine current page based on get param
if( isset($_GET[$paging["query"]]) && $_GET[$paging["query"]] != "" && is_numeric($_GET[$paging["query"]]) && $_GET[$paging["query"]] >= 0 ) {
	$paging["cur"] = $_GET[$paging["query"]];
}

// generate base link
$parse_url_args = [];
$parse_url = parse_url($args["link"]);
if(isset($parse_url['query']) && $parse_url['query'] != '') {
	parse_str($parse_url['query'], $parse_url_args);
	if( array_key_exists($args['query'], $parse_url_args) ) {
		unset($parse_url_args[$args['query']]);
	}
}
$parse_url_args[$args['query']] = '';
if( strpos($args['link'],'?') !== false ) { $args['link'] = substr($args['link'], 0, strpos($args['link'],'?')); }
$args['link'] .= '?'.http_build_query($parse_url_args);

// show modules
foreach($modules as $module__key=>$module__value) {
	if($paging["show"] === true) {
		if( ($module__key+1) < ((($paging["cur"]-1)*$paging["limit"])+1) ) { continue; }
		if( ($module__key+1) > ($paging["cur"]*$paging["limit"]) ) { continue; }
	}
  
  echo $module__value;
  // the following line would render a joomla module
  //echo JModuleHelper::renderModule($module__value, ['style' => 'none']);
}

// show pagination
if($paging["show"] === true) {
	echo '<div class="paging_container">';
		echo '<ol>';
			if( $paging["cur"] > 1 ) {
				echo '<li><a href="'.$paging["link"].($paging["cur"]-1).'">&lt;</a></li>';
			}
			for($paging__index = 1; $paging__index <= ceil($paging["count"]/$paging["limit"]); $paging__index++) {
				echo '<li>';
					if( $paging__index==$paging["cur"] ) {
						echo '<span>'.$paging__index.'</span>';
					}
					else {
						echo '<a href="'.$paging["link"].$paging__index.'">'.$paging__index.'</a>';
					}
				echo '</li>';
			}
			if( $paging["cur"] < ceil($paging["count"]/$paging["limit"]) ) {
				echo '<li><a href="'.$paging["link"].($paging["cur"]+1).'">&gt;</a></li>';
			}
		echo '</ol>';
	echo '</div>';
}