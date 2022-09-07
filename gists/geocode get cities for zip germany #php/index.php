function getCitiesForZip($zip) {
  $cities = [];
  $filename = $_SERVER['DOCUMENT_ROOT'].'/geocode/zuordnung_plz_ort.csv';
  if( !file_exists($filename) || filemtime($filename) < strtotime('now - 1 month') ) {
    file_put_contents($filename, file_get_contents('https://www.suche-postleitzahl.org/download_files/public/zuordnung_plz_ort.csv'));
  }
  $content = file_get_contents($filename);
  $content = explode(PHP_EOL, $content);
  foreach($content as $content__value) {
    $parts = explode(',',$content__value);
    if( $parts[2] != $zip ) {
      continue;
    }
    $cities[] = $parts[1];
  }
  $cities = array_unique($cities);
  return $cities;
}