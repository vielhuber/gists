<?php
/* modern method with the help of openssl */
// encryption key (generated with hash('sha256', uniqid(mt_rand(), true)))
define('ENCRYPTION_KEY', '4736d52f85bdb63e46bf7d6d41bbd551af36e1bfb7c68164bf81e2400d291319');
function encrypt($string, $salt = null)
{
  if($salt === null) { $salt = hash('sha256', uniqid(mt_rand(), true)); }  // this is an unique salt per entry and directly stored within a password
  return base64_encode(openssl_encrypt($string, 'AES-256-CBC', ENCRYPTION_KEY, 0, str_pad(substr($salt, 0, 16), 16, '0', STR_PAD_LEFT))).':'.$salt;
}
function decrypt($string)
{
	$salt = explode(":",$string)[1]; $string = explode(":",$string)[0]; // read salt from entry
	return openssl_decrypt(base64_decode($string), 'AES-256-CBC', ENCRYPTION_KEY, 0, str_pad(substr($salt, 0, 16), 16, '0', STR_PAD_LEFT));
}

/* deprecated method with the help of mcrypt */
// encryption key (created e.g. with md5(uniqid(mt_rand(), true)))
define('ENCRYPTION_KEY', '69bdefe40ab7f1d9e3680f2fae6d35f6');
function encrypt($string, $salt = null) {
 if($salt === null) { $salt = md5(uniqid(mt_rand(), true)); } // this is an unique salt per entry and directly stored within a password
 return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(ENCRYPTION_KEY.$salt), $string, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)))).":".$salt;
}
function decrypt($string) {
 $salt = explode(":",$string)[1]; $string = explode(":",$string)[0]; // read salt from entry
 return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(ENCRYPTION_KEY.$salt), base64_decode($string), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

/* usage */
// encryption (hard, with individual one-time salt)
echo decrypt(encrypt('I like dogs.'));
// encryption (soft, good for searching in dbs)
echo decrypt(encrypt('I like dogs.','known_salt'));

/* if you want to reduce the length of the encrypted string, fix the salt and remove it from the key */
function encrypt($string) { return base64_encode(openssl_encrypt($string, 'AES-256-CBC', ENCRYPTION_KEY, 0, str_pad(substr(ENCRYPTION_KEY, 0, 16), 16, '0', STR_PAD_LEFT))); }
function decrypt($string) { return openssl_decrypt(base64_decode($string), 'AES-256-CBC', ENCRYPTION_KEY, 0, str_pad(substr(ENCRYPTION_KEY, 0, 16), 16, '0', STR_PAD_LEFT)); }