<?php
function drive_download($source,$target, $echo = true) {
  global $service;
  $file_id = drive_get_file_id($source);
  $content = $service->files->get($file_id, array('alt' => 'media'));
  file_put_contents(__DIR__.'/../'.$target,$content);
  if( $echo ) { echo "successfully downloaded file ".$source.".\n"; }
}

function drive_get_file_id($filename) {
  global $service;

  if( substr_count($filename, "/") === 0 ) {
    $filename = $filename;
    $folder_id = drive_get_folder_id();
  }
  else {
    $folder_id = explode("/",$filename);
    $filename = $folder_id[count($folder_id)-1];
    unset($folder_id[count($folder_id)-1]);
    $folder_id = implode("/",$folder_id);
    $folder_id = drive_get_folder_id($folder_id);
  }
  $results = $service->files->listFiles(array(
    'q' => "mimeType != 'application/vnd.google-apps.folder' and name='".$filename."' and '".$folder_id."' in parents",
    'fields' => "nextPageToken, files(id, name)"
  ));
  if (count($results->getFiles()) == 0) { return null; }
  else {
  foreach ($results->getFiles() as $file) {
    return $file->getId();
  }
  }
  return null;
}

function drive_get_folder_id($name = null) {
  $cur_id = 'root';
  if($name === null || $name == "" || $name == "/") {
      
  }
  else if(substr_count($name, "/") >= 1) {
    while(1) {
      $first = explode("/",$name)[0];
      $cur_id = drive_get_folder_id_rec($first, $cur_id);
      if( substr_count($name, "/") === 0 ) { break; }
      $name = substr($name, strpos($name, "/")+1);
    }
  }
  else {
      $cur_id = drive_get_folder_id_rec($name, $cur_id);
  }
  return $cur_id;
}
function drive_get_folder_id_rec($name, $parent_id = 'root') {
  global $service;
  $q = "mimeType = 'application/vnd.google-apps.folder' and name = '".$name."' and '".$parent_id."' in parents";
  $results = $service->files->listFiles(array(
    'q' => $q,
    'fields' => "nextPageToken, files(id, name)"
  ));
  if (count($results->getFiles()) == 0) { echo "cannot find folder ".$name."\n"; die(); return null; }
  else {
  foreach ($results->getFiles() as $file) {
    return $file->getId();
  }
  }
  return null;
}

function drive_upload($source, $target, $echo = true) {
  global $service;

  $target_filename = substr($target, strrpos($target,"/")+1);
  $target_folder = substr($target, 0, strrpos($target,"/"));

  drive_delete($target, false);
  $file = new Google_Service_Drive_DriveFile();
  $file->setName($target_filename);
  $file->setParents([drive_get_folder_id($target_folder)]);

  $result = $service->files->create($file, array(
    'data' => file_get_contents(__DIR__.'/../'.$source),
    'mimeType' => 'application/octet-stream',
    'uploadType' => 'media'
  ));
  if( $echo ) { echo "successfully uploaded file ".$source.".\n"; } 
}

function drive_delete($filename, $echo = true) {
  $file_id = drive_get_file_id($filename);
  global $service;
  try {
    $service->files->delete($file_id);
    if( $echo ) { echo "successfully deleted ".$filename.".\n"; }
    return true;
  }
  catch (Exception $e) {
  	if( $echo ) { echo "failed to delete ".$filename.".\n"; }
    return false;
  }
}