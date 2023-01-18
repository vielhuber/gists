<?php
require_once(__DIR__.'/api/api.php');
require_once(__DIR__.'/api/helpers.php');

drive_download("folder/images.zip","images.zip");
drive_delete("folder/dies-ist-ein-test.xlsx");
drive_upload("dies-ist-ein-test.xlsx","folder/dies-ist-ein-test.xlsx");