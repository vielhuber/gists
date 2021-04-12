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
    if( @$_SERVER['SERVER_ADMIN'] === 'david@close2.de' || @$_SERVER['NAME'] === 'DAVID-DESKTOP' ) {
        $this->host = '...';
        $this->user = '...';
        $this->password = '...';
        $this->db = '...';
        $this->log_path = __DIR__.'/logs';
        $this->tmp_path = __DIR__.'/tmp';
    }
    elseif( strpos(@$_SERVER['HTTP_HOST'], 'close2dev') !== false ) {
        $this->host = '...';
        $this->user = '...';
        $this->password = '...';
        $this->db = '...';
        $this->log_path = __DIR__.'/logs';
        $this->tmp_path = __DIR__.'/tmp';
    }
    else {
        $this->host = '...';
        $this->user = '...';
        $this->password = '...';
        $this->db = '...';
        $this->log_path = '...';
        $this->tmp_path = '...';
    }
  }
}
