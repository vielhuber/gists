<?php
verifyDate('2015-01-01'); // true
function verifyDate($date) {
   return checkdate( explode('-',$date)[1], explode('-',$date)[2], explode('-',$date)[0] );
}
?>