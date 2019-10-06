$tmpfile = tempnam("tmp", "zip");
$zip = new ZipArchive();
$zip->open($tmpfile, ZipArchive::OVERWRITE);

foreach($files as $f) {
  $zip->addFile(($_SERVER['DOCUMENT_ROOT'].'/.../'.$file->filename.'.'.$file->filetype), $file->name.'.'.$file->filetype);
}

$zip->close();
header('Content-Type: application/zip');
header('Content-Length: ' . filesize($tmpfile));
header('Content-Disposition: attachment; filename="file.zip"');
readfile($tmpfile);
unlink($tmpfile); 
die();