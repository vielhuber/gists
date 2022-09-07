<?php
function getEvents() {
  if(...) { return collect([]); }
  return Model::where('id',1);
}
if( $this->getEvents()->count() > 0 ) {
  $this->getEvents()->where('name','foo');
}