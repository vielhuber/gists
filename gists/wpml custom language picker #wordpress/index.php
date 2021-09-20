<?php
if( function_exists('icl_get_languages') ) {
  $languages = icl_get_languages('skip_missing=0');
  if(!empty($languages)) {
    foreach($languages as $languages__value) {
      echo $languages__value['code'];
      echo $languages__value['active'];
      echo $languages__value['url'];
      echo $languages__value['native_name'];
    }
  }
}