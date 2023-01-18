<?php    
function encrypt($string)
{
  $token = md5(uniqid(mt_rand(), true));
  file_put_contents('encryption/' . $token, $string);
  return $token;
}

function decrypt($token, $once = false)
{
  if (!file_exists('encryption/' . $token)) {
    return null;
  }
  $string = file_get_contents('encryption/' . $token);
  if ($once === true) {
    @unlink('encryption/' . $token);
  }
  return $string;
}