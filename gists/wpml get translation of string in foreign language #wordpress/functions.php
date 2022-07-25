<?php
function get_wpml_translation($str, $lng)
{
  global $sitepress;
  $current_lang = $sitepress->get_current_language();
  $sitepress->switch_lang($lng);
  $translation = __($str, 'custom-domain');
  $sitepress->switch_lang($current_lang);
  return $translation;
}