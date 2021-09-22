<?php
public function foos() {

  $relation = $this->hasMany('App\Bar');
  
  return $relation; // default behaviour
  
  // modify the query builder
  $relation->where('foo','bar');
  return $relation;

  // modify the raw query
  $relation->getQuery()
        ->join('orders', 'order_lines.order_id', '=', 'orders.id')
        ->select('orders.*')
        ->groupBy('orders.id');
  return $relation;
  
  // inspect / debug the raw sql
  print_r($relation->toSql());die();
  
  // modify exisiting query
  $query = $relation->getQuery();
	foreach((array)$query->wheres as $query__key=>$query__value) {
	  // do something with those parts
    // e.g. unset( $query->wheres[$query__key] );
	}
	$query->wheres = array_values($query->wheres);

	// modify existing bindings
	$bindings = $relation->getBindings();
	if( !empty($bindings) ) {
  	foreach($bindings as $bindings__key=>$bindings__value) {
      // do something with those args
  	}
  	array_values($bindings);
  	$relation->setBindings($bindings);
	}
        
}

// to get eager loading working with custom relationships, you also have to modify the eager loading query, because eager loading is pushed afterwards onto it
ClaimAsset
    ::with([
        'custom_relationship' => function($query) {
            $bindings = $query->getBindings();
            if(!empty($bindings)) {
                foreach($bindings as $bindings__key=>$bindings__value) {
                    // todo... e.g.: $bindings[$bindings__key] = $bindings__value+1;
                }
            }
            $query->setBindings($bindings);
        }
    ]);