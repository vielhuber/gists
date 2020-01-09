<?php
$result = collect([]);
$parents = Person::find(42)->getParents();
if( !empty($parents) )
{
  foreach($parents as $parents__value)
  {
    $addresses = $parents__value->getAddresses();
    if( !empty($addresses) )
    {
      foreach($addresses as $addresses__value)
      {
        $result->push($addresses__value->getName());
      }
    }
  }
}
__d($result);