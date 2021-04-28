<?php
// returns 'en'
apply_filters( 'wpml_current_language', NULL );

// returns 'en'
global $sitepress;
$lang = $sitepress->get_current_language();

// returns 'en' (deprecated, does also not work when you switched languages programmatically)
if(defined('ICL_LANGUAGE_CODE')) { 
  echo ICL_LANGUAGE_CODE;
} 
  
// returns 'en_US'
$lng = '';
foreach(apply_filters( 'wpml_active_languages', null ) as $languages__value) {
  if ($languages__value['active']) { $lng = $languages__value['default_locale']; break; }
}
echo $lng;