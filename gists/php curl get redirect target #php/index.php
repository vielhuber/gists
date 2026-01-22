<?php
function get_redirect_final_target($url)
{
    $ch = curl_init($url);
  	// if you need htaccess htpasswd
	curl_setopt($ch, CURLOPT_USERPWD, 'username:password');
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
  	// follow redirects
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
  	// set referer on redirect
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_exec($ch);
    $target = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    if ($target) {
        return $target;
    }
    return false;
}