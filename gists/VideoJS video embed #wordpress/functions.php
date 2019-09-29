<?php
function video_embed_shortcode($atts) {
  $atts = shortcode_atts( array(
  	'src' => '',
  	'autoplay' => 'false',
  	'preload' => 'auto',
  	'controls' => 'true'
  ), $atts );
  
  $return = "";
  $return .= '
  	<div class="video-js-container">
  		<div class="video">
  			<video
  				class="video-js vjs-default-skin"
  			  	'.(($atts["controls"] == 'true')?('controls'):('')).'
  			  	'.(($atts["autoplay"] == 'true')?('autoplay'):('')).'
  			  	preload="'.$atts["preload"].'"
  			  	width="auto"
  			  	height="auto"
  			  	data-setup=\'{"example_option":true}\'
  		  	>
  ';
  $return .= '<source src="'.$atts["src"].'.mp4" type=\'video/mp4\' />';
  $return .= '<source src="'.$atts["src"].'.webm" type=\'video/webm\' />';
  // ogg is disabled
  // $return .= '<source src="'.$atts["src"].'.ogv" type=\'video/ogg\' />';
  $return .= '
  			</video>
  		</div>
  	</div>
  ';
  return $return;
}
add_shortcode( 'video_embed', 'video_embed_shortcode' );

// example usage
// [video_embed src="https://s3.eu-central-1.amazonaws.com/businesscommunity/squeeze_videos/existenzgruender/Squeeze-Video_Existenzgruender_mit_Anzug" autoplay="true" preload="true" controls="true"]
?>