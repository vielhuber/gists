<?php
$version = mt_rand(1000,9999); // random
$version = filemtime($_SERVER['DOCUMENT_ROOT'].'/path/to/file'); // last change time of file
$version = 0; exec('git rev-parse --short HEAD', $version); $version = trim($version[0]); // last git commit hash
?>

<link rel="stylesheet" type="text/css" href="style.css?ver=<?php echo $version; ?>" />
<script type="text/javascript" src="script.js?ver=<?php echo $version; ?>"></script>
<img alt="" src="file.jpg?ver=<?php echo $version; ?>" />