<?php
class JConfig {
  ...
    public $host = null;
    public $user = null;
    public $password = null;
    public $db = null;
    public $log_path = null;
    public $tmp_path = null;
  ...

  public function __construct() {
    if( @$_SERVER['SERVER_ADMIN'] === 'david@vielhuber.de' || @$_SERVER['NAME'] === 'DAVID-DESKTOP' ) {
        $this->debug = true;
        $this->host = '...';
        $this->user = '...';
        $this->password = '...';
        $this->db = '...';
        $this->log_path = __DIR__.'/logs';
        $this->tmp_path = __DIR__.'/tmp';
    }
    else {
      	$this->debug = false;
        $this->host = '...';
        $this->user = '...';
        $this->password = '...';
        $this->db = '...';
        $this->log_path = '...';
        $this->tmp_path = '...';
    }
  }
}
