<?php
function div_open($atts) {
   extract(shortcode_atts(array(
      'class' => 'box'
   ), $atts));
	return '<div class="'. $class . '">';
}
add_shortcode('div', 'div_open');
function div_close() {
  return '</div>';
}
add_shortcode('_div', 'div_close');