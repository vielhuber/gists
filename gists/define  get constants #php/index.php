<?php
define('KEY','value'); // key should be uppercase
echo KEY;

function contants_are_global() {
  echo KEY; 
}
contants_are_global();