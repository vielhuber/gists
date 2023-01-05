<?php
$string = "374DE37";
$string = preg_replace("/[^0-9]/", '', $string);
echo $string;