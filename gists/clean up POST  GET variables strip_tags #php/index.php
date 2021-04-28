<?php
// variant 1
foreach($_POST as $key=>$value) { if(is_string($value)) { $_POST[$key] = trim(strip_tags($value)); } }
foreach($_GET as $key=>$value) { if(is_string($value)) { $_GET[$key] = trim(strip_tags($value)); } }

// variant 2
foreach($_GET as $key=>$value)
{
  $_GET[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}
foreach($_POST as $key=>$value)
{
  $_POST[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}