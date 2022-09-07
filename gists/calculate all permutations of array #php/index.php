<?php
function permute($items, $perms = [], &$ret = []) {
   if(empty($items))
   {
       $ret[] = $perms;
   }
   else
   {
       for($i = count($items) - 1; $i >= 0; --$i)
       {
           $newitems = $items;
           $newperms = $perms;
           list($foo) = array_splice($newitems, $i, 1);
           array_unshift($newperms, $foo);
           permute($newitems, $newperms,$ret);
       }
   }
   return $ret;
}
var_dump(permute(['foo','bar','baz']));