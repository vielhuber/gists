<?php
private function replaceAttributes($html)
{
  $dom = new \DOMDocument();
  $dom->loadHTML($html);
  $xpath = new \DOMXPath( $dom );
  foreach(['src','style','href','data-src','data-style','data-href'] as $attribute__key)
  {
    foreach( $xpath->query('//*[@'.$attribute__key.']') as $element )
    {
      $attribute__value = $element->getAttribute($attribute__key);
      if( strpos($attribute__value, 'foo') === false ) { continue; }
      $attribute__value = str_replace('foo','bar',$attribute__value);
      $element->setAttribute($attribute__key,$attribute__value);
    }
  }
  $html = $dom->saveHTML();
  return $html;
}