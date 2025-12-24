<?php
if(isset($_POST["upload_file"]) && $_POST["upload_file"] != "") {
	if(isset($_FILES['file']) && $_FILES['file']['name'] != null) {
		$extension = strtolower(end(explode(".", $_FILES['file']['name'])));
		$allowed_extension = array(
			"gif" => array("image/gif"),
			"jpg" => array("image/jpeg", "image/jpg", "image/pjpeg"),
			"png" => array("image/x-png", "image/png"),
          	"pdf" => array("application/pdf")
		);
		if(
			array_key_exists($extension, $allowed_extension)
			&&
			in_array($_FILES['file']['type'], $allowed_extension[$extension])
			&&
			($_FILES['file']["size"] < (4000*1024))
			&&
			$_FILES['file']["error"] == 0
		) {
			move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/.../".md5("foo").".".$extension);
		}
		else {
			echo "Es ist ein Fehler aufgetreten";
		}
	}  
}
?>