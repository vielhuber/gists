<?php

  // Set headers
  header("Cache-Control: public");
  header("Content-Description: File Transfer");
  header("Content-Disposition: attachment; filename=batch-file-".rand(10000000000000000,99999999999999999).".bat");
  header("Content-Type: application/bat");
  header("Content-Transfer-Encoding: ASCII");
    
  // Read the file from disk
  ?>
	 
  @Echo off
  echo.
  echo.
  echo.
  echo      Script wird geöffnet...
  START "C:\Program Files (x86)\Adobe\Acrobat Reader DC\Reader\AcroRd32.exe" "C:\...\abc.pdf"
  EXIT

<?php ?>