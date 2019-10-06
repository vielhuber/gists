<?php
$birth_date = '1986-09-16';
$age = floor((time() - strtotime($birth_date)) / 31556926); // average number of seconds in a year (avoids leap year problem);