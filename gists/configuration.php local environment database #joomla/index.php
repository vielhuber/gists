<?php
class JConfig {
  ...
	public $host = null;
	public $user = null;
	public $password = null;
	public $db = null;
  ...

  public function __construct() {
    if(in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', "::1"])) {
  	//if( strpos($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"], ".dev") === false ) {
  		$this->host = "...";
  		$this->user = "...";
  		$this->password = "...";
  		$this->db = "...";
  	}
  	else {
  		$this->host = "...";
  		$this->user = "...";
  		$this->password = "...";
  		$this->db = "...";
  	}
  }
}
