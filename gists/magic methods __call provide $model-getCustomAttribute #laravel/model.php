<?php
public function __call($method, $arguments) {
  if( strpos($method, 'get') === 0 ) {
      return $this->{snake_case(substr($method,3))};
  }
  return parent::__call($method, $arguments);
}

$model->getCustomAttribute() // $model->custom_attribute