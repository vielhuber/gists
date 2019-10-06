<?php
/*
...
*/

  public function sortByMany($args)
  {
      return $this->sort(function($a,$b) use ($args) {
          $position = [true => -1, false => 1];
          $order = true;
          foreach($args as $args__value)
          {
              $order = ($a[$args__value[0]] < $b[$args__value[0]]);
              if( $args__value[1] === 'desc' )
              {
                  $order = !$order;
              }
              if ($a[$args__value[0]] !== $b[$args__value[0]]) {
                  return $position[$order];
              }
          }
          return $position[$order];
      });
  }

/*
...
*/