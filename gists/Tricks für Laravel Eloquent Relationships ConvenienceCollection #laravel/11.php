<?php
/* ... */
use App\Helpers\ConvenienceCollection;    
/* ... */
class ConvenienceModel extends Model {
  /* ... */
  public function newCollection(array $models = [])
  {
     return new ConvenienceCollection($models);
  }
}