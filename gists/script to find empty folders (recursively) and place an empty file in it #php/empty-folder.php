<?php
function EmptySubFolders($path) {
  $empty = true;
  foreach(glob($path.DIRECTORY_SEPARATOR."*") as $file) {
     if (is_dir($file)) {
        if (!EmptySubFolders($file)) {
          $empty = false;
        }
     }
     else {
       $empty = false;
     }
  }
  if($empty) {
    touch($path."/empty-folder");
  }
  return $empty;
}
EmptySubFolders('.');
?>