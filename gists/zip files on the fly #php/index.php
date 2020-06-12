$tmpfile = tempnam("tmp", "zip");
$zip = new ZipArchive();
$zip->open($tmpfile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

$files = [[$_SERVER['DOCUMENT_ROOT'].'/.../foo.txt','foo.txt'],[$_SERVER['DOCUMENT_ROOT'].'/.../bar.txt','bar.txt']];
foreach($files as $files__value) {
  $zip->addFile(($_SERVER['DOCUMENT_ROOT'].'/.../'.$files__value[0]), $files__value[1]);
}

$zip->close();
header('Content-Type: application/zip');
header('Content-Length: ' . filesize($tmpfile));
header('Content-Disposition: attachment; filename="file.zip"');
readfile($tmpfile);
unlink($tmpfile); 
die();