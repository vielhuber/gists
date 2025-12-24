<?php
$instagram_username = 'elonmusk';
$instagram_source = file_get_contents('https://www.instagram.com/'.$instagram_username.'/');
$instagram_data = explode('window._sharedData = ', $instagram_source);
$instagram_json = explode(';</script>', $instagram_data[1]); 
$instagram_array = json_decode($instagram_json[0], true);
$instagram_media = $instagram_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
if(!empty($instagram_media))
{
  echo '<ul>';
  foreach($instagram_media as $instagram_media__value)
  {
    echo '<li>';
    echo '<a href="https://www.instagram.com/p/'.$instagram_media__value['code'].'/" target="_blank">';
    echo '<img src="'.$instagram_media__value['display_src'].'" alt="" width="'.$instagram_media__value['dimensions']['width'].'" height="'.$instagram_media__value['dimensions']['height'].'" />';
    echo '</a>';
    echo '</li>';
  }
  echo '</ul>';
}