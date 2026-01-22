$timezone = 'Europe/Berlin';
date_default_timezone_set($timezone);  
setlocale(LC_TIME, 'de_DE', 'German_Germany');
if( $_SERVER['SERVER_ADMIN'] === 'david@close2.de' ) {
	setlocale(LC_TIME, 'de_DE.UTF-8', 'German_Germany'); // needed for wsl
}