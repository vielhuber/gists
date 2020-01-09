<?php
public function __call($method, $arguments) {
    if( strpos($method, 'get') === 0 ) {
      $return = $this->{snake_case(substr($method,3))};
      if( __nx($return) ) {
          return __empty();
      }
      return $return;
    }
    return parent::__call($method, $arguments);
}