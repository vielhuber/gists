if (
  (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
   strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ||
  (!empty($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)
) {
	echo 'this is an ajax call';
}