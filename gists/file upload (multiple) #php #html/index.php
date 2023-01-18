<?php
if(isset($_POST["upload_files"]) && $_POST["upload_files"] != "") {

	if( $_FILES['files']['name'][0] !== "" ) {
		for($i = 0; $i < count($_FILES['files']['name']); $i++ ) {
            $extension = explode('.', $_FILES['files']['name'][$i]);
            $extension = end($extension);
            $extension = strtolower($extension);
			$allowed_extension = [
				'gif' => ['image/gif'],
				'jpg' => ['image/jpeg', 'image/jpg', 'image/pjpeg'],
				'png' => ['image/x-png', 'image/png'],
				'doc' => ['application/msword'],
				'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
				'xls' => ['application/vnd.ms-excel'],
				'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
				'zip' => ['application/zip','application/x-compressed-zip','application/octet-stream'],
				'pdf' => ['application/pdf']
			];
			if(
				array_key_exists($extension, $allowed_extension)
				&&
				in_array($_FILES['files']['type'][$i], $allowed_extension[$extension])
				&&
				($_FILES['files']["size"][$i] < (4000*1024))
				&&
				$_FILES['files']["error"][$i] == 0
			) {
				move_uploaded_file($_FILES['files']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT']."/.../".md5("foo").".".$extension);
			}
			else {
				echo "Es ist ein Fehler aufgetreten";
			}
		}
	}
 
}
?>